<?php
namespace App\Http\Controllers\Guest;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Guests\GuestAccess as GuestAccess;
use App\Models\Guests\GuestTag as GuestTag;
use App\Models\Guests\GuestGroup as GuestGroup;
use App\Models\Guests\Guest as Guest;
use Carbon\Carbon as Carbon;
use Request;
use Input;
use Controller;

class GuestAddController extends Controller {
    protected $page_module = 5;
	protected $page_id = 15;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.guest.guest',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Guest::find($id)){
			return view('content.guest.modal.guest_log_info',array('guest_log_info' => Guest::find($id)));
		}
		if (Input::has('classType')){
			$classType = Input::get('classType');
			switch ($classType) {
				case 'tags':
					if (Input::has('guest_group_id')){
						$guest_group_id = Input::get('guest_group_id');
						$guest = Guest::where('return_date_time','=',null)->get(array('tag_id'));
						$guest_tags = GuestTag::where('guest_group_id',$guest_group_id)->whereNotIn('tag_id',$guest->toArray())->get();
						$data = array();
						foreach ($guest_tags as $guest_tag) {
							$data[] = array(
								'id' => $guest_tag->tag_id,
								'text' => $guest_tag->tag_name
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
					case 'addGuest':
						if (Request::isMethod('post') && Input::has('guest')){
							$data = json_decode(Input::get('guest'),TRUE);
							$guest = new Guest;
							$guest->fill($data);
							$guest->borrow_date_time = Carbon::now();
							if ($guest->save()){
								return json_encode(array('status'=>'true','msg'=>'Successfully Added Guest!'));
							}
							return json_encode(array('status'=>'false','msg'=>'Unable To Add Guest!'));
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('common.invalid_modal',array('msg' => 'Unable to find data!'));
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Guest::find($id)){
				$guest = Guest::find($id);
				$guest->return_date_time = Carbon::now();
				if ($guest->save()){
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
				$model_name = 'App\Models\Guests\Guest';
				$data = array(
					'guest_tags.id_number',
					'guest_tags.tag_name',
					'users',
					'reason',
					'items',
					'id',
				);
				$joins = array(
					'guest_tags,guest_tags.tag_id,=,guest_logs.tag_id,inner',
				);
				$where = array();
				$where['return_date_time'] = null;
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$joins,$where);
				return json_encode($response);
			}
		}
	}
	
}

