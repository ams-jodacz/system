<?php
namespace App\Http\Controllers;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Group as Group;
use Request;
use Input;

class GroupController extends Controller {
    protected $page_module = 1;
	protected $page_id = 2;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.group.group',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!Group::find($id)){
			$this->diplayError(404);
		}
		return view('content.group.modal.group_info',array('group_info' => Group::find($id)));
	}
	
	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax())
		{
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkGroupName':
						if (Input::has('group_name')){
							$group = Group::where(array('group_name' => Input::get('group_name')))->get();
							if (count($group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addGroup':
						if (Request::isMethod('post') && Input::has('group_name') && Input::has('data')){
							$data = json_decode(Input::get('data'),TRUE);
							$group_name = Input::get('group_name');
							$group = Group::where(array('group_name' => $group_name))->get();
							if (count($group) > 0 || count($data) == 0){
								return json_encode(array('msg'=>'Unable to add group, Please try again later!'));
							}
							else{
								$group = new Group();
								$group->group_name = $group_name;
								if ($group->save()){
									//$group_id = $group->group_id;
									$permissions = array();
									foreach($data as $permission_data){
										$permissions[] = new Permission($permission_data);
									}
									if ($group->permission()->saveMany($permissions)){
										return json_encode(array('status'=>'true','msg'=>'Successfully Added Group!'));
									}
									else{
										$group->delete();
										return json_encode(array('status'=>'false','msg'=>'Unable To Add Group!'));
									}
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Group!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.group.form.group_form');
	}
	
	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (!Group::find($id)){
			$this->diplayError(404);
		}
		if (Request::ajax())
		{
			if (!Input::has('actionType')){
				$this->diplayError();
			}
			switch(Input::get('actionType')){
				case 'checkGroupName':
					if (Input::has('group_name')){
						$group = Group::where(array('group_name' => Input::get('group_name')))->where('group_id','<>',$id)->get();
						if (count($group) > 0){
							return 'false';
						}
					}
					return 'true';
					break;
				case 'updateGroup':
					if (Request::isMethod('post') && Input::has('data') && Input::has('group_name')){
						$data = json_decode(Input::get('data'),TRUE);
						$group_name = Input::get('group_name');
						if (!Group::find($id)){
							return json_encode(array('msg'=>'Unable to update, Please try again later!'));
						}
						else{
							$group = Group::find($id);
							$group->group_name = $group_name;
							$group->save();
							$prevData = $group->permission;
							$group->permission()->delete();
							$permissions = array();
							foreach($data as $permission_data){
								$permissions[] = new Permission($permission_data);
							}
							if ($group->permission()->saveMany($permissions)){
								return json_encode(array('status'=>'true','msg'=>'Successfully Updated Group!'));
							}
							else{
								$group->permission()->saveMany($prevData);
								return json_encode(array('status'=>'false','msg'=>'Unable To Update Group!'));
							}
							return json_encode(array('status'=>'false','msg'=>'Unable To Update Group!'));
							
						}
					}
					return json_encode(array('status'=>'false','msg'=>'Unable To Update Group!'));
					break;
			}
		}
		return view('content.group.form.group_form',array('group_data' => Group::find($id)));
	}
	
	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (!Group::find($id)){
			$this->diplayError(404);
		}
		if (Request::ajax())
		{
			$response['status'] = false;
			$group = Group::find($id);

			if (count($group->user) > 0){
				return json_encode($response);
			}
			
			if (count(User::where('remove_status','<>','Active')->where('group_id',$id)->get())>0){
				return json_encode($response);
			}
			if ($group->permission()->delete() && $group->delete()){
				$response['status'] = true;
			}
			return json_encode($response);
		}
	}
	
}
