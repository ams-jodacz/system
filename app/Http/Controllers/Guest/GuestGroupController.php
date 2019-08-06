<?php
namespace App\Http\Controllers\Guest;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Guests\GuestGroup as GuestGroup;
use Request;
use Input;
use Controller;

class GuestGroupController extends Controller {
    protected $page_module = 5;
	protected $page_id = 10;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.guest_group.guest_group',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!GuestGroup::find($id)){
			$this->diplayError(404);
		}
		return view('content.guest_group.modal.guest_group_info',array('guest_group_info' => GuestGroup::find($id)));
	}
	
	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax())
		{
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('group_name')){
							$group = GuestGroup::where(array('group_name' => Input::get('group_name')))->get();
							if (count($group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addGuestGroup':
						if (Request::isMethod('post') && Input::has('guestGroup')){
							$data = json_decode(Input::get('guestGroup'),TRUE);
							$group = GuestGroup::where(
								array(
									'group_name' => $data['group_name']
								)
							)->get();
							if (count($group) > 0 || count($data) == 0){
								return json_encode(array('msg'=>'Unable to add group, Please try again later!'));
							}
							else{
								$group = new GuestGroup();
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
		return view('content.guest_group.guest_group_form');
	}
	
	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (!GuestGroup::find($id)){
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
						$group = GuestGroup::where(
							array(
								'group_name' => Input::get('group_name')
							)
						)
					->where('guest_group_id','<>',$id)->get();
						if (count($group) > 0){
							return 'false';
						}
					}
					return 'true';
					break;
				case 'updateGuestGroup':
					if (Request::isMethod('post') && Input::has('guestGroup')){
						$guest_group_data = json_decode(Input::get('guestGroup'),TRUE);
						$guest_group = GuestGroup::where(
							array(
								'group_name' => $guest_group_data['group_name'],
							)
						)->where(
							'guest_group_id','<>',$id
						)->get();
						if (count($guest_group) > 0){
							return json_encode(array('msg'=>'Unable to update group, Please try again later!'));
						}
						else{
							$guest_group = GuestGroup::find($id);
							$guest_group->fill($guest_group_data);
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
		return view('content.guest_group.guest_group_form',array('guest_group_data' => GuestGroup::find($id)));
	}
	
	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (GuestGroup::find($id)){
				$guest_group = GuestGroup::find($id);
				if ($guest_group->delete()){
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
				$model_name = 'App\Models\Guests\GuestGroup';
				$data = array(
					'group_name',
					'guest_group_id',
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
