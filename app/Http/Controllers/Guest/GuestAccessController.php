<?php
namespace App\Http\Controllers\Guest;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Guests\GuestAccess as GuestAccess;
use App\Models\Guests\GuestGroup as GuestGroup;
use App\Models\Stations\StationGroup as StationGroup;
use Request;
use Input;
use Controller;

class GuestAccessController extends Controller {
    protected $page_module = 5;
	protected $page_id = 11;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.guest_access.guest_access',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (GuestAccess::find($id)){
			return view('content.guest_access.modal.guest_access_info',array('guest_access_info' => GuestAccess::find($id)));
		}
		if (Input::has('classType')){
			$classType = Input::get('classType');
			switch ($classType) {
				case 'group':
					if (Input::has('station_group_id')){
						$station_group_id = Input::get('station_group_id');
						$guest_access = GuestAccess::where('station_group_id','=',$station_group_id)->get(array('guest_group_id'));
						$group_names = GuestGroup::whereNotIn('guest_group_id',$guest_access->toArray())->get();
						$data = array();
						foreach ($group_names as $group_name) {
							$data[] = array(
								'id' => $group_name->guest_group_id,
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
					case 'addGuestAccess':
						if (Request::isMethod('post') && Input::has('access')){
							$data = json_decode(Input::get('access'),TRUE);
							$guest_access = new GuestAccess;
							$guest_access->fill($data);
							if ($guest_access->save()){
								return json_encode(array('status'=>'true','msg'=>'Successfully Added Guest Access!'));
							}
							return json_encode(array('status'=>'false','msg'=>'Unable To Add Guest Access!'));
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
			if (GuestAccess::find($id)){
				$guest_access = GuestAccess::find($id);
				if ($guest_access->delete()){
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
				$model_name = 'App\Models\Guests\GuestAccess';
				$data = array(
					'station_group.group_name',
					'guest_tag_group.group_name',
					'access_id',
				);
				$joins = array(
					'station_group,station_group.station_group_id,=,guest_station_access.station_group_id,inner',
					'guest_tag_group,guest_tag_group.guest_group_id,=,guest_station_access.guest_group_id,inner',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$joins);
				if (count($response['data']) > 0){
					foreach ($response['data'] as $data) {
						$access = GuestAccess::find($data->access_id);
						$data->station_group_name = $access->station->group_name;
					}
				}
				return json_encode($response);
			}
		}
	}
	
}

