<?php
namespace App\Http\Controllers\Monitor;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Members\Member as Member;
use Carbon\Carbon as Carbon;
use Request;
use Input;
use Controller;

class MonitorAttendanceController extends Controller {
    protected $page_module = 7;
	protected $page_id = 18;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.monitor_attendance.monitor_attendance',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Member::find($id)){
			return view('content.member.modal.member_info',array('member_info' => Member::find($id)));
		}
		return view('common.invalid_modal',array('msg' => 'Unable to find data!'));
	}

	public function data(){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Request::ajax())
		{
			if (Input::has('draw') && Input::get('draw')){
				$model_name = 'App\Models\Attendance\AttendanceTimelog';
				$data = array(
					'attendance_group.group_name',
					'attendance_station.name',
					'members.id_number',
					'status',
					'date_time',
					'members.member_id',
					'member_information.first_name',
					'member_information.middle_name',
					'member_information.last_name',
				);
				$joins = array(
					'members,members.id_number,=,attendance_time_logs.id_number,inner',
					'member_information,member_information.member_id,=,members.member_id,inner',
					'attendance_station,attendance_station.attendance_station_id,=,attendance_time_logs.attendance_station_id,inner',
					'attendance_group,attendance_group.attendance_group_id,=,attendance_station.attendance_group_id,inner',
				);
				$where = array();
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				// $order = Input::get('order');
				$order = array(
					array(
						'column' => '4',
						'dir' => 'desc'
					)
				);
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$joins,$where);
				foreach ($response['data'] as &$data) {
					$member = Member::find($data->member_id);
					if (!empty($member) && $member != null){
						$data->full_name = $member->memberInformation->first_name.' '.$member->memberInformation->middle_name.' '.$member->memberInformation->last_name;
					}
					else{
						$data->full_name = 'Unregistered Member!';
					}
					$data->date_time = Carbon::createFromFormat('Y-m-d H:i:s',$data->date_time)->format('m-d-y h:i:s a');
					if (file_exists('images/'.$data->id_number.'.jpg')){
						$data->image = $data->id_number.'.jpg';
					}
					else{
						$data->image = 'avatar.png';
					}
				}
				return json_encode($response);
			}
		}
	}
	
}

