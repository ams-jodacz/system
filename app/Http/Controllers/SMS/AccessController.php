<?php
namespace App\Http\Controllers\SMS;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\SMS\Access as Access;
use App\Models\SMS\Group as Group;
use Request;
use Input;
use Controller;

class AccessController extends Controller {
	protected $page_module = 9;
	protected $page_id = 23;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.sms_access.sms_access',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Access::find($id)){
			return view('content.sms_access.modal.access_info',array('access_info' => Access::find($id)));
		}
		if (Input::has('classType')){
			switch(Input::get('classType')){
				case 'group':
					if (Input::has('sms_server_id')){
						$sms_server_id = Input::get('sms_server_id');
						$access = Access::where(
							array(
								'sms_server_id' => $sms_server_id,
							)
						)->get(array('sms_prefix_group_id'));
						$group_names = Group::whereNotIn('sms_prefix_group_id',$access->toArray())->get();
						$data = array();
						foreach ($group_names as $group_name) {
							$data[] = array(
								'id' => $group_name->sms_prefix_group_id,
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
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'addAccess':
						if (Request::isMethod('post') && Input::has('access')){
							$access_details = json_decode(Input::get('access'),TRUE);
							$access = Access::where(
								array(
									'sms_server_id' => $access_details['sms_server_id'],
									'sms_prefix_group_id' => $access_details['sms_prefix_group_id']
								)
							)->get();
							if (count($access) > 0){
								return json_encode(array('msg'=>'Unable to add access, Please try again later!'));
							}
							else{
								$access = new Access;
								$access->sms_server_id = $access_details['sms_server_id'];
								$access->sms_prefix_group_id = $access_details['sms_prefix_group_id'];
								if ($access->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Added Access!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Access!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.stations.stations_form');
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (Access::find($id)){
				$access = Access::find($id);
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
				$model_name = 'App\Models\SMS\Access';
				$data = array(
					'sms_server.server_name',
					'sms_prefix_group.group_name',
					'sms_access_id',
				);
				$join = array(
					'sms_server,sms_server.sms_server_id,=,sms_access.sms_server_id,inner',
					'sms_prefix_group,sms_prefix_group.sms_prefix_group_id,=,sms_access.sms_prefix_group_id,inner',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$join);
				return json_encode($response);
			}
		}
	}
}
