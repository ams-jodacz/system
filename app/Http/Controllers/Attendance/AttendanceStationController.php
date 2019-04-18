<?php
namespace App\Http\Controllers\Attendance;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Attendance\AttendanceStation as AttendanceStation;
use Request;
use Input;
use Controller;

class AttendanceStationController extends Controller {
    protected $page_module = 6;
	protected $page_id = 13;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.attendance_station.attendance_station',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!AttendanceStation::find($id)){
			$this->diplayError(404);
		}
		return view('content.attendance_station.modal.attendance_station_info',array('attendance_station_info' => AttendanceStation::find($id)));
	}
	
	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax())
		{
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('name') && Input::has('attendance_group_id')){
							$name = Input::get('name');
							$attendance_group_id = Input::get('attendance_group_id');
							$station = AttendanceStation::where(
								array(
									'name' => $name,
									'attendance_group_id' => $attendance_group_id,
								)
							)->get();
							if (count($station) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'checkIP':
						if (Input::has('ip')){
							$ip = Input::get('ip');
							$station = AttendanceStation::where(
								array(
									'ip' => $ip,
								)
							)->get();
							if (count($station) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addAttendanceStation':
						if (Request::isMethod('post') && Input::has('attendanceStation')){
							$data = json_decode(Input::get('attendanceStation'),TRUE);
							//Station Name
							$station = AttendanceStation::where(
								array(
									'name' => $data['name'],
									'attendance_group_id' => $data['attendance_group_id'],
								)
							)->get();
							if (count($station) > 0 || count($data) == 0){
								return json_encode(array('msg'=>'Unable to add station, Please try again later!'));
							}
							//Station IP
							$station = AttendanceStation::where(
								array(
									'ip' => $data['ip']
								)
							)->get();
							if (count($station) > 0 || count($data) == 0){
								return json_encode(array('msg'=>'Unable to add station, Please try again later!'));
							}
							else{
								$station = new AttendanceStation();
								$station->fill($data);
								if ($station->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Added Station!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Station!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.attendance_station.attendance_station_form');
	}
	
	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (!AttendanceStation::find($id)){
			$this->diplayError(404);
		}
		if (Request::ajax())
		{
			if (!Input::has('actionType')){
				$this->diplayError();
			}
			switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('name') && Input::has('attendance_group_id')){
							$name = Input::get('name');
							$attendance_group_id = Input::get('attendance_group_id');
							$station = AttendanceStation::where(
								array(
									'name' => $name,
									'attendance_group_id' => $attendance_group_id,
								)
							)->where('attendance_station_id','<>',$id)->get();
							if (count($station) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'checkIP':
						if (Input::has('ip')){
							$ip = Input::get('ip');
							$station = AttendanceStation::where(
								array(
									'ip' => $ip,
								)
							)->where('attendance_station_id','<>',$id)->get();
							if (count($station) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'updateAttendanceStation':
						if (Request::isMethod('post') && Input::has('attendanceStation')){
							$data = json_decode(Input::get('attendanceStation'),TRUE);
							//Station Name
							$station = AttendanceStation::where(
								array(
									'name' => $data['name'],
									'attendance_group_id' => $data['attendance_group_id'],
								)
							)->where('attendance_station_id','<>',$id)->get();
							if (count($station) > 0 || count($data) == 0){
								return json_encode(array('msg'=>'Unable to update station, Please try again later!'));
							}
							//Station IP
							$station = AttendanceStation::where(
								array(
									'ip' => $data['ip']
								)
							)->where('attendance_station_id','<>',$id)->get();
							if (count($station) > 0 || count($data) == 0){
								return json_encode(array('msg'=>'Unable to update station, Please try again later!'));
							}
							else{
								$station = AttendanceStation::find($id);
								$station->fill($data);
								if ($station->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Updated Station!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Update Station!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
			}
		}
		return view('content.attendance_station.attendance_station_form',array('station_data' => AttendanceStation::find($id)));
	}
	
	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (AttendanceStation::find($id)){
				$station = AttendanceStation::find($id);
				if ($station->delete()){
					return json_encode(array('status'=>'true'));
				}
			}
			return json_encode(array('status'=>'false'));
		}
	}

	public function data(){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Request::ajax())
		{
			if (Input::has('draw') && Input::get('draw')){
				$model_name = 'App\Models\Attendance\AttendanceStation';
				$data = array(
					'name',
					'ip',
					'attendance_group.group_name',
					'description',
					'enable_status',
					'attendance_station_id',
				);
				$joins = array(
					'attendance_group,attendance_group.attendance_group_id,=,attendance_station.attendance_group_id,inner',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$joins);
				return json_encode($response);
			}
		}
	}
	
}
