<?php
namespace App\Http\Controllers\Attendance;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Attendance\AttendanceGroup as AttendanceGroup;
use Request;
use Input;
use Controller;

class AttendanceGroupController extends Controller {
    protected $page_module = 6;
	protected $page_id = 12;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.attendance_group.attendance_group',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!AttendanceGroup::find($id)){
			$this->diplayError(404);
		}
		return view('content.attendance_group.modal.attendance_group_info',array('attendance_group_info' => AttendanceGroup::find($id)));
	}
	
	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax())
		{
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('group_name')){
							$group_name = Input::get('group_name');
							$group = AttendanceGroup::where(
								array(
									'group_name' => $group_name
								)
							)->get();
							if (count($group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addAttendanceGroup':
						if (Request::isMethod('post') && Input::has('attendanceGroup')){
							$data = json_decode(Input::get('attendanceGroup'),TRUE);
							$group = AttendanceGroup::where(
								array(
									'group_name' => $data['group_name']
								)
							)->get();
							if (count($group) > 0 || count($data) == 0){
								return json_encode(array('msg'=>'Unable to add group, Please try again later!'));
							}
							else{
								$group = new AttendanceGroup();
								$group->fill($data);
								if ($group->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Added Group!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Group!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.attendance_group.attendance_group_form');
	}
	
	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (!AttendanceGroup::find($id)){
			$this->diplayError(404);
		}
		if (Request::ajax())
		{
			if (!Input::has('actionType')){
				$this->diplayError();
			}
			switch(Input::get('actionType')){
				case 'checkName':
					if (Input::has('group_name')){
						$group = AttendanceGroup::where(
							array(
								'group_name' => Input::get('group_name')
							)
						)
					->where('attendance_group_id','<>',$id)->get();
						if (count($group) > 0){
							return 'false';
						}
					}
					return 'true';
					break;
				case 'updateAttendanceGroup':
					if (Request::isMethod('post') && Input::has('attendanceGroup')){
						$data = json_decode(Input::get('attendanceGroup'),TRUE);
						$guest_group = AttendanceGroup::where(
							array(
								'group_name' => $data['group_name'],
							)
						)->where(
							'attendance_group_id','<>',$id
						)->get();
						if (count($guest_group) > 0){
							return json_encode(array('msg'=>'Unable to update group, Please try again later!'));
						}
						else{
							$guest_group = AttendanceGroup::find($id);
							$guest_group->fill($data);
							if ($guest_group->save()){
								return json_encode(array('status'=>'true','msg'=>'Successfully Updated Group!'));
							}
							return json_encode(array('status'=>'false','msg'=>'Unable To Update Group!'));
							
						}
					}
					return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
					break;
			}
		}
		return view('content.attendance_group.attendance_group_form',array('attendance_group_data' => AttendanceGroup::find($id)));
	}
	
	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (AttendanceGroup::find($id)){
				$group = AttendanceGroup::find($id);
				if ($group->delete()){
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
				$model_name = 'App\Models\Attendance\AttendanceGroup';
				$data = array(
					'group_name',
					'attendance_group_id',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search);
				return json_encode($response);
			}
		}
	}
	
}
