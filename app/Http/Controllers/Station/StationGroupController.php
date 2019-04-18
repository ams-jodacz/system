<?php
namespace App\Http\Controllers\Station;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Stations\StationGroup as StationGroup;
use App\Models\Stations\Station as Station;
use Request;
use Input;
use Controller;

class StationGroupController extends Controller {
	protected $page_module = 2;
	protected $page_id = 8;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.stations_group.stations_group',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!StationGroup::find($id)){
			return view('common.invalid_modal',array('msg' => 'Unable to find Station Group!'));
		}
		return view('content.stations_group.modal.station_group_info',array('station_group_info' => StationGroup::find($id)));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('group_name')){
							$group_name = Input::get('group_name');
							$station_group = StationGroup::where(array('group_name' => $group_name))->get();
							if (count($station_group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addStationGroup':
						if (Request::isMethod('post') && Input::has('stationGroup')){
							$start_group_detail = json_decode(Input::get('stationGroup'),TRUE);
							$station_group = StationGroup::where(
								array(
									'group_name' => $start_group_detail['group_name'],
								)
							)->get();
							if (count($station_group) > 0){
								return json_encode(array('msg'=>'Unable to add station group, Please try again later!'));
							}
							else{
								$station_group = new StationGroup;
								$station_group->fill($start_group_detail);
								if ($station_group->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Added Station Group!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Station Group!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.stations_group.stations_group_form');
	}

	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('group_name')){
							$group_name = Input::get('group_name');
							$station_group = StationGroup::where(array('group_name' => $group_name))->where('station_group_id','<>',$id)->get();
							if (count($station_group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'updateStationGroup':
						if (Request::isMethod('post') && Input::has('stationGroup')){
							$station_group_detail = json_decode(Input::get('stationGroup'),TRUE);
							$station_group = StationGroup::where(
								array(
									'group_name' => $station_group_detail['group_name'],
								)
							)->where(
								'station_group_id','<>',$id
							)->get();
							if (count($station_group) > 0){
								return json_encode(array('msg'=>'Unable to update station group, Please try again later!'));
							}
							else{
								$station_group = StationGroup::find($id);
								$station_group->fill($station_group_detail);
								if ($station_group->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Updated Station Group!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Update Station Group!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		$station_group_data = StationGroup::find($id);
		return view('content.stations_group.stations_group_form',array('station_group_data'=>$station_group_data));
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (StationGroup::find($id)){
				$station_group = StationGroup::find($id);
				if ($station_group->delete()){
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
				$model_name = 'App\Models\Stations\StationGroup';
				$data = array(
					'group_name',
					'station_group_id',
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
