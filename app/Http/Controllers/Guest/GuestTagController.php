<?php
namespace App\Http\Controllers\Guest;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Guests\GuestTag as GuestTag;
use Request;
use Input;
use Controller;

class GuestTagController extends Controller {
    protected $page_module = 5;
	protected $page_id = 9;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.guest_tag.guest_tag',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!GuestTag::find($id)){
			$this->diplayError(404);
		}
		return view('content.guest_tag.modal.guest_tag_info',array('guest_tag_info' => GuestTag::find($id)));
	}
	
	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax())
		{
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('tag_name') && Input::has('guest_group_id')){
							$tag_name = Input::get('tag_name');
							$guest_group_id = Input::get('guest_group_id');
							$group = GuestTag::where(
								array(
									'tag_name' => $tag_name,
									'guest_group_id' => $guest_group_id,
								)
							)
							->get();
							if (count($group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'checkIDNumber':
						if (Input::has('id_number') && Input::has('guest_group_id')){
							$id_number = Input::get('id_number');
							$guest_group_id = Input::get('guest_group_id');
							$group = GuestTag::where(
								array(
									'id_number' => $id_number,
									// 'guest_group_id' => $guest_group_id,
								)
							)
							->get();
							if (count($group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addGuestTag':
						if (Request::isMethod('post') && Input::has('guestTag')){
							$data = json_decode(Input::get('guestTag'),TRUE);
							//TAG NAME
							$guest_tag = GuestTag::where(
								array(
									'guest_group_id' => $data['guest_group_id'],
									'tag_name' => $data['tag_name'],
								)
							)->get();
							if (count($guest_tag) > 0 || count($data) == 0){
								return json_encode(array('msg'=>'Unable to add tag, Please try again later!'));
							}
							//ID NUMBER
							$guest_tag = GuestTag::where(
								array(
									// 'guest_group_id' => $data['guest_group_id'],
									'id_number' => $data['id_number'],
								)
							)->get();
							if (count($guest_tag) > 0 || count($data) == 0){
								return json_encode(array('msg'=>'Unable to add tag, Please try again later!'));
							}
							else{
								$guest_tag = new GuestTag();
								$guest_tag->fill($data);
								if ($guest_tag->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Added Tag!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Tag!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.guest_tag.guest_tag_form');
	}
	
	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (!GuestTag::find($id)){
			$this->diplayError(404);
		}
		if (Request::ajax())
		{
			if (!Input::has('actionType')){
				$this->diplayError();
			}
			switch(Input::get('actionType')){
				case 'checkName':
					if (Input::has('tag_name') && Input::has('guest_group_id')){
						$tag_name = Input::get('tag_name');
						$guest_group_id = Input::get('guest_group_id');
						$group = GuestTag::where(
							array(
								'tag_name' => $tag_name,
								'guest_group_id' => $guest_group_id,
							)
						)
						->where('tag_id','<>',$id)->get();
						if (count($group) > 0){
							return 'false';
						}
					}
					return 'true';
					break;
				case 'checkIDNumber':
					if (Input::has('id_number') && Input::has('guest_group_id')){
						$id_number = Input::get('id_number');
						$guest_group_id = Input::get('guest_group_id');
						$group = GuestTag::where(
							array(
								'id_number' => $id_number,
								// 'guest_group_id' => $guest_group_id,
							)
						)
						->where('tag_id','<>',$id)->get();
						if (count($group) > 0){
							return 'false';
						}
					}
					return 'true';
					break;
				case 'updateGuestTag':
					if (Request::isMethod('post') && Input::has('guestTag')){
						$data = json_decode(Input::get('guestTag'),TRUE);
						//TAG NAME
						$guest_tag = GuestTag::where(
							array(
								'guest_group_id' => $data['guest_group_id'],
								'tag_name' => $data['tag_name'],
							)
						)
						->where('tag_id','<>',$id)->get();
						if (count($guest_tag) > 0 || count($data) == 0){
							return json_encode(array('msg'=>'Unable to update tag, Please try again later!'));
						}
						//ID NUMBER
						$guest_tag = GuestTag::where(
							array(
								// 'guest_group_id' => $data['guest_group_id'],
								'id_number' => $data['id_number'],
							)
						)
						->where('tag_id','<>',$id)->get();
						if (count($guest_tag) > 0 || count($data) == 0){
							return json_encode(array('msg'=>'Unable to update tag, Please try again later!'));
						}
						else{
							$guest_tag = GuestTag::find($id);
							$guest_tag->fill($data);
							if ($guest_tag->save()){
								return json_encode(array('status'=>'true','msg'=>'Successfully Updated Tag!'));
							}
							return json_encode(array('status'=>'false','msg'=>'Unable To Update Tag!'));
							
						}
					}
					return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
					break;
			}
		}
		return view('content.guest_tag.guest_tag_form',array('guest_tag_data' => GuestTag::find($id)));
	}
	
	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (GuestTag::find($id)){
				$guest_tag = GuestTag::find($id);
				if ($guest_tag->delete()){
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
				$model_name = 'App\Models\Guests\GuestTag';
				$data = array(
					'guest_tag_group.group_name',
					'id_number',
					'tag_name',
					'tag_id',
				);
				$joins = array(
					'guest_tag_group,guest_tag_group.guest_group_id,=,guest_tags.guest_group_id,inner',
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
