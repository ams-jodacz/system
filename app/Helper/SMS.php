<?php 
namespace App\Helper;
use App\Models\SMS\Prefix as Prefix;


class SMS {
	private static $port = 81;
	public static function sendSMS($number,$message){
		$valid = false;
		$prefix = '';
		$number = trim($number);
		$number = str_replace('-', '', $number);
		$regex_list = array(
			'/\+63[0-9]{10}/',
			'/63[0-9]{10}/',
			'/0[0-9]{10}/',
			'/^9[0-9]{9}/',
		);

		$regex_starter = array(
			3,
			2,
			1,
			0,
		);

		$regex_adder = array(
			'',
			'+',
			'',
			'0',
		);

		for($i=0;$i<count($regex_list);$i++){
			if (preg_match($regex_list[$i], $number)) {
			    $prefix = substr($number,$regex_starter[$i],3);
			    $number = $regex_adder[$i].$number;
			    $valid = true;
			}
		}

		if (!$valid){
			return false;
		}


		$prefix_handler = Prefix::where('prefix',$prefix)->first();
		if ($prefix_handler == null || empty($prefix_handler)){
			return false;
		}

		$access = $prefix_handler->group->access;

		foreach($access as $info) {
			$server = $info->server;
			$ip = $server->ip;
			$user = $server->username;
			$password = $server->password;
			// $message = str_replace(' ', '%20', $message);
			$url = $ip.':'.SMS::$port.'/sendmsg?user='.$user.'&passwd='.$password.'&cat=1&priority=3&to='.$number.'&text='.rawurlencode($message);
	        $ch = curl_init();

	        curl_setopt($ch, CURLOPT_URL, $url); 
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	        $output = curl_exec($ch);
	        curl_close($ch);
		}
	}
}
