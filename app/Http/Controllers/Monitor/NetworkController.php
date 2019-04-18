<?php
namespace App\Http\Controllers\Monitor;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Attendance\AttendanceStation as AttendanceStation;
use App\Models\Stations\Station as Station;
use App\Models\SMS\Server as Server;
use Carbon\Carbon as Carbon;
use Request;
use Input;
use Controller;

class NetworkController extends Controller {
    protected $page_module = 7;
	protected $page_id = 28;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.monitor_network.monitor_network',array('action_value'=>$action_value));
	}

	public function data(){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Request::ajax())
		{
			if (Input::has('draw') && Input::get('draw')){
				$datas = array();

				$stations = Station::all();
				foreach ($stations as $station) {
					$datas[] = array(
						'name' 		=>	$station->stationGroup->group_name.' - '.$station->name,
						'ip' 		=>	$station->ip,
						'status'	=>	'Down',
					);
				}

				$attendances = AttendanceStation::all();
				foreach ($attendances as $attendance) {
					$datas[] = array(
						'name' 		=>	$attendance->group->group_name.' - '.$attendance->name,
						'ip' 		=>	$attendance->ip,
						'status'	=>	'Down',
					);
				}

				$sms_servers = Server::all();
				foreach ($sms_servers as $sms_server) {
					$datas[] = array(
						'name' 		=>	$sms_server->server_name,
						'ip' 		=>	$sms_server->ip,
						'status'	=>	'Down',
					);
				}

				foreach ($datas as &$data) {
					$ip = $data['ip'];
			    	$str = "ping -c 2 {$ip}";
					$pingresult = exec($str, $outcome, $status);
					if ($status == 0) {
						$data['status'] = 'Up';
					}
				}

				$response['recordsTotal'] = count($datas);
				$response['recordsFiltered'] = count($datas);
				$response['data'] = $datas;
				return json_encode($response);
			}
		}
	}
	
}

