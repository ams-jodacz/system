<?php
namespace App\Http\Controllers\SMS;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\SMS\Group as Group;
use Request;
use Input;
use Controller;

class GroupController extends Controller {
	protected $page_module = 9;
	protected $page_id = 21;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.sms_group.sms_group',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!Group::find($id)){
			return view('common.invalid_modal',array('msg' => 'Unable to find group!'));
		}
		return view('content.sms_group.modal.sms_group_info',array('group_info' => Group::find($id)));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('group_name')){
							$group_name = Input::get('group_name');
							$group = Group::where(array('group_name' => $group_name))->get();
							if (count($group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addGroup':
						if (Request::isMethod('post') && Input::has('group')){
							$group_detail = json_decode(Input::get('group'),TRUE);
							$group = Group::where(
								array(
									'group_name' => $group_detail['group_name'],
								)
							)->get();
							if (count($group) > 0){
								return json_encode(array('msg'=>'Unable to add group, Please try again later!'));
							}
							else{
								$group = new Group;
								$group->fill($group_detail);
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
		return view('content.sms_group.sms_group_form');
	}

	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('group_name')){
							$group_name = Input::get('group_name');
							$server = Group::where(array('group_name' => $group_name))->where('sms_prefix_group_id','<>',$id)->get();
							if (count($server) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'updateGroup':
						if (Request::isMethod('post') && Input::has('group')){
							$group_detail = json_decode(Input::get('group'),TRUE);
							$group = Group::where(
								array(
									'group_name' => $group_detail['group_name'],
								)
							)->where(
								'sms_prefix_group_id','<>',$id
							)->get();
							if (count($group) > 0){
								return json_encode(array('msg'=>'Unable to update group, Please try again later!'));
							}
							else{
								$group = Group::find($id);
								$group->fill($group_detail);
								if ($group->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Updated Group!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Update Group!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		$group_data = Group::find($id);
		return view('content.sms_group.sms_group_form',array('group_data'=>$group_data));
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (Group::find($id)){
				$group = Group::find($id);
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
				$model_name = 'App\Models\SMS\Group';
				$data = array(
					'group_name',
					'sms_prefix_group_id',
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
