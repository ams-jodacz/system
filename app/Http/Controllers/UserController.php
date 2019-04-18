<?php
namespace App\Http\Controllers;
use App\Models\ACL\User as User;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\Action as Action;
use Request;
use Input;
use Hash;

class UserController extends Controller {
	protected $layout = 'main';
        
	protected $page_module = 1;
	protected $page_id = 1;

	public function __construct(){
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.users.users',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!User::find($id) || User::find($id)->remove_status == 'Active'){
			$this->diplayError(404);
		}
		return view('content.users.modal.user_profile',array('user_info' => User::find($id)));
	}
	
	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkUsername':
						if (Input::has('username')){
							$user = User::where(array('username' => Input::get('username')))->where('remove_status','<>','Active')->get();
							if (count($user) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addUser':
						if (Request::isMethod('post') && Input::has('user') && Input::has('userinfo')){
							$user_detail = json_decode(Input::get('user'),TRUE);
							$userInfo = json_decode(Input::get('userinfo'),TRUE);
							$user = User::where(array('username' => $user_detail['username']))->where('remove_status','<>','Active')->get();
							if (count($user) > 0){
								return json_encode(array('msg'=>'Unable to add user, Please try again later!'));
							}
							else{
								$user = new User;
								$user->fill($user_detail);
								$user->password = Hash::make(User::$DefaultPassword);
								if ($user->save()){
									$userInfo['user_id'] = $user->user_id;
									if ($user->userinfo()->insert($userInfo)){
										return json_encode(array('status'=>'true','msg'=>'Successfully Added User!'));
									}
									else{
										$user->delete();
										return json_encode(array('status'=>'false','msg'=>'Unable To Add User!'));
									}
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add User!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.users.form.user_form');
	}
	
	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (!User::find($id) || User::find($id)->remove_status == 'Active'){
			$this->diplayError(404);
		}
		if (Request::ajax())
		{
			if (!Input::has('actionType')){
				$this->diplayError();
			}
			$responce = array();
			switch(Input::get('actionType')){
				case 'status':
					$responce['status'] = false;
					if (User::updateStatus($id)){
						$responce['status'] = true;
					}
					return json_encode($responce);
					break;
				case 'resetPwd':
					$responce['msg'] = 'Failed in reseting password!';
					if (User::resetPassword($id)){
						$responce['msg'] = 'Successfully reset password!';
					}
					return json_encode($responce);
					break;
				case 'updateUser':
					if (Request::isMethod('post') && Input::has('user') && Input::has('userinfo')){
						if (!User::find($id)){
							return json_encode(array('msg'=>'Unable to find user, Please try again later!'));
						}
						else{
							$user_detail = json_decode(Input::get('user'),TRUE);
							$userInfo = json_decode(Input::get('userinfo'),TRUE);
							
							$user = User::find($id);
							$prevData = $user->toArray();
							$user->fill($user_detail);
							if ($user->save()){
								$user->userinfo->fill($userInfo);
								if ($user->userinfo->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Updated User!'));
								}
								else{
									$user->fill($prevData);
									$user->save();
									return json_encode(array('status'=>'false','msg'=>'Unable To Update User!'));
								}
							}
							return json_encode(array('status'=>'false','msg'=>'Unable To Update User!'));
							
						}
					}
					break;
			}
		}
		return view('content.users.form.user_form',array('user_data' => User::find($id)));
	}
	
	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (!User::find($id) || User::find($id)->remove_status == 'Active'){
			$this->diplayError(404);
		}
		if (Request::ajax())
		{
			$user = User::find($id);
			$response['status'] = false;
			$user->remove_status = 'Active';
			if ($user->save()){
				$response['status'] = true;
			}
			return json_encode($response);
		}
		return json_encode(array('status'=>false));
	}
	
}
