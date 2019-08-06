<?php
	date_default_timezone_set('Asia/Manila');
	set_time_limit (0);
	$servername = "localhost";
	$username = "root";
	// $password = "";
	$password = "sanbeda2015//";
	// $dbname = "san_beda";
	$dbname = "db_ams";

	$date = new DateTime;

	$minute = $date->format('i');
	$minute_excess = $minute%5;
	$minute = $minute - $minute_excess;
	$date = $date->setTime($date->format('H'),$minute);

	echo $date->format('m-d-Y h:i a');

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql =	"SELECT * FROM `holiday` WHERE DATE_FORMAT(`date`,'%m%d') = '{$date->format('md')}'";
	if ($result = $conn->query($sql)){
		if ($result->num_rows != 0){
			die('Holiday');
		}
	}

	$excempted_members = array();
	$members = array();
	//SELECT * FROM sms_date_excemption WHERE $date BETWEEN start_date_time and end_date_time
	$sql = "SELECT * FROM sms_date_excemption WHERE '{$date->format('Y-m-d H:i')}:00' BETWEEN start_date_time and end_date_time";
	if ($result = $conn->query($sql)){
		if ($result->num_rows != 0){
			// echo 'Excemption';
			// die();
			while($row = $result->fetch_assoc()) {
				$members = getMembers($row['class_id'],$row['class_group_id'],$row['member_id']);
				foreach ($members as $member) {
					$excempted_members[] = $member['id_number'];
				}
			}
		}
	}

	$added_members = arraY();
	//SELECT * FROM sms_date_excemption WHERE $date BETWEEN start_date_time and end_date_time
	$sql = "SELECT * FROM sms_blast LEFT JOIN sms_blast_occurance ON sms_blast.sms_blast_id = sms_blast_occurance.sms_blast_id WHERE sms_blast.occurance!=0 OR sms_blast.send_date_time = '{$date->format('Y-m-d H:i')}:00'";
	if ($result = $conn->query($sql)){
		if ($result->num_rows != 0){
		 	echo '<pre>';
		    while($row = $result->fetch_assoc()) {
		    	if ($row['occurance'] != 0){
		    		$minute = $row['minute'];
		    		$hour = $row['hour'];
		    		if($minute != $date->format('i') || $hour != $date->format('H')){
		    			continue;
		    		}
			    	if ($row['day_of_month'] != '*'  && $row['month'] != '*'  && $row['day_of_week'] == '*'){
			    		if ($row['day_of_month'] == $date->format('d')  && $row['month'] == $date->format('m')){
			    			$members = getMembers($row['class_id'],$row['class_group_id'],$row['member_id']);
			    		}
			    	}
			    	else if ($row['day_of_month'] != '*'  && $row['month'] == '*'  && $row['day_of_week'] == '*'){
			    		if ($row['day_of_month'] == $date->format('d')){
			    			$members = getMembers($row['class_id'],$row['class_group_id'],$row['member_id']);
			    		}
			    	}
			    	else if ($row['day_of_month'] == '*'  && $row['month'] == '*'  && $row['day_of_week'] != '*'){
						if ($row['day_of_week'] == $date->format('w')){
			    			$members = getMembers($row['class_id'],$row['class_group_id'],$row['member_id']);
			    		}
			    	}
			    	else if ($row['day_of_month'] == '*'  && $row['month'] == '*'  && $row['day_of_week'] == '*'){
		    			$members = getMembers($row['class_id'],$row['class_group_id'],$row['member_id']);
			    	}
		    	}
		    	else{
		    		$members = getMembers($row['class_id'],$row['class_group_id'],$row['member_id']);
		    	}

		    	if (count($members) > 0){
		    		$message = $row['message'];
		    		foreach ($members as $member) {
		    			if (in_array($member['id_number'], $excempted_members)){
		    				continue;
		    			}
		    			$number = $member['contact_number'];
		    			if ($number != ''){
		    				$pos = strpos($number, '/');
							if ($pos === false) {
								echo $number.' ';
								sendMessage($number,$message);
								echo '<br/>';
							}
							else{
							    $numbers = explode('/', $number);
							    foreach ($numbers as $number) {
							    	echo $number.' ';
							    	sendMessage($number,$message);
							    	echo '<br/>';
							    }
							}
		    			}
		    		}
		    	}
		    }
		}
	}
	return;

	function sendMessage($number,$message){
		$valid = false;
		$number = trim($number);
		$number = str_replace('-', '', $number);
		$prefix = '';
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

		$servers = getServers($prefix);
		foreach ($servers as $server) {
			$ip = $server['ip'];
			$user = $server['username'];
			$password = $server['password'];
			// $message = str_replace(' ', '%20', $message);
			$url = $ip.':81/sendmsg?user='.$user.'&passwd='.$password.'&cat=1&priority=3&to='.$number.'&text='.rawurlencode($message);

			echo $url;
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url); 
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
	        $output = curl_exec($ch); 
	        curl_close($ch);
		}

        return true;
	}

	function getServers($prefix){
		$servers = array();
		$conn = $GLOBALS['conn'];
		$sql = 'SELECT * FROM sms_prefix_list INNER JOIN sms_prefix_group ON sms_prefix_list.sms_prefix_group_id = sms_prefix_group.sms_prefix_group_id INNER JOIN sms_access ON sms_prefix_group.sms_prefix_group_id = sms_access.sms_prefix_group_id INNER JOIN sms_server ON sms_server.sms_server_id = sms_access.sms_server_id WHERE sms_prefix_list.prefix='.$prefix;
		if ($result = $conn->query($sql)){
			if ($result->num_rows != 0){
				while($row = $result->fetch_assoc()) {
					$servers[] = $row;
				}
			}
		}
		return $servers;
	}

	//GET MEMBERS
	function getMembers($class_id,$class_group_id,$member_id){
		$conn = $GLOBALS['conn'];
		$member = array();
		if (!is_null($class_id) && !is_null($class_group_id) && !is_null($member_id)){
			$sql = 'SELECT * FROM members INNER JOIN member_information ON members.member_id = member_information.member_id WHERE members.member_id='.$member_id;
			if ($result = $conn->query($sql)){
				if ($result->num_rows != 0){
					while($row = $result->fetch_assoc()) {
						$member[] = $row;
					}
				}
			}
		}
		else if (!is_null($class_id) && !is_null($class_group_id) && is_null($member_id)){
			$sql = 'SELECT * FROM members INNER JOIN member_information ON members.member_id = member_information.member_id WHERE members.class_group_id='.$class_group_id;
			if ($result = $conn->query($sql)){
				if ($result->num_rows != 0){
					while($row = $result->fetch_assoc()) {
						$member[] = $row;
					}
				}
			}
		}
		else if (!is_null($class_id) && is_null($class_group_id) && is_null($member_id)){
			$sql = 'SELECT * FROM members INNER JOIN member_information ON members.member_id = member_information.member_id INNER JOIN classification_group ON members.class_group_id = classification_group.class_group_id WHERE classification_group.class_id='.$class_id;
			if ($result = $conn->query($sql)){
				if ($result->num_rows != 0){
					while($row = $result->fetch_assoc()) {
						$member[] = $row;
					}
				}
			}
		}
		else if (is_null($class_id) && is_null($class_group_id) && is_null($member_id)){
			$sql = 'SELECT * FROM members INNER JOIN member_information ON members.member_id = member_information.member_id';
			if ($result = $conn->query($sql)){
				if ($result->num_rows != 0){
					while($row = $result->fetch_assoc()) {
						$member[] = $row;
					}
				}
			}
		}
		return $member;
	}
?>