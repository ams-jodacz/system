<?php
namespace App\Http\Controllers\Attendance;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Attendance\AttendanceAccess as AttendanceAccess;
use App\Models\Attendance\AttendanceGroup as AttendanceGroup;
use App\Models\Attendance\AttendanceStation as AttendanceStation;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use Request;
use Input;
use Controller;

class AttendanceAccessController extends Controller {
    protected $page_module = 6;
	protected $page_id = 14;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.attendance_access.attendance_access',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (AttendanceAccess::find($id)){
			return view('content.attendance_access.modal.access_info',array('attendance_access_info' => AttendanceAccess::find($id)));
		}
		if (Input::has('classType')){
			$classType = Input::get('classType');
			switch ($classType) {
				case 'group':
					if (Input::has('attendance_group_id') && Input::has('class_id')){
						$attendance_group_id = Input::get('attendance_group_id');
						$class_id = Input::get('class_id');
						$access = AttendanceAccess::where('attendance_group_id','=',$attendance_group_id)->get(array('class_group_id'));
						$group_names = ClassificationGroup::where('class_id','=',$class_id)->whereNotIn('class_group_id',$access->toArray())->get();
						$data = array();
						foreach ($group_names as $group_name) {
							$data[] = array(
								'id' => $group_name->class_group_id,
								'text' => $group_name->group_name
							);
						}
						return json_encode($data);
					}
					break;
			}
		}
		return view('common.invalid_modal',array('msg' => 'Unable to find data!'));
	}
	
	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax())
		{
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'addAccess':
						if (Request::isMethod('post') && Input::has('access')){
							$data = json_decode(Input::get('access'),TRUE);
							$access = new AttendanceAccess;
							$access->fill($data);
							if ($access->save()){
								return json_encode(array('status'=>'true','msg'=>'Successfully Added Access!'));
							}
							return json_encode(array('status'=>'false','msg'=>'Unable To Add Access!'));
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.guest_group.guest_group_form');
	}
	
	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (AttendanceAccess::find($id)){
				$access = AttendanceAccess::find($id);
				if ($access->delete()){
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
				$model_name = 'App\Models\Attendance\AttendanceAccess';
				$data = array(
					'classification.classification_name',
					'classification_group.group_name',
					'attendance_group.group_name',
					'access_id',
					'classification_group.class_group_id',
				);
				$joins = array(
					'attendance_group,attendance_group.attendance_group_id,=,attendance_access.attendance_group_id,inner',
					'classification_group,classification_group.class_group_id,=,attendance_access.class_group_id,inner',
					'classification,classification.class_id,=,classification_group.class_id,inner',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$joins);
				if (count($response['data']) > 0){
					foreach ($response['data'] as $data) {
						$class = ClassificationGroup::find($data->class_group_id);
						$data->class_group_name = $class->group_name;
						unset($data->class_group_id);
					}
				}
				return json_encode($response);
			}
		}
	}
	
}

