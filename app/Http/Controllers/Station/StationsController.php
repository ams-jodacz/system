<?php
namespace App\Http\Controllers\Station;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Stations\Station as Station;
use App\Models\Stations\StationGroup as StationGroup;
use Request;
use Input;
use Controller;

class StationsController extends Controller {
	protected $page_module = 2;
	protected $page_id = 3;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.stations.stations',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!Station::find($id)){
			return view('common.invalid_modal',array('msg' => 'Unable to find Station!'));
		}
		return view('content.stations.modal.station_info',array('station_info' => Station::find($id)));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('station_name') && Input::has('station_group_id')){
							$station_name = Input::get('station_name');
							$station_group_id = Input::get('station_group_id');
							$station = Station::where(
								array(
									'name' => $station_name,
									'station_group_id' => $station_group_id
								)
							)->get();
							if (count($station) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'checkIP':
						if (Input::has('station_ip')){
							$station_ip = Input::get('station_ip');
							if (!filter_var($station_ip, FILTER_VALIDATE_IP)){
								return 'false';
							}
							$station = Station::where(array('ip' => $station_ip))->get();
							if (count($station) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addStation':
						if (Request::isMethod('post') && Input::has('station')){
							$station_detail = json_decode(Input::get('station'),TRUE);
							$station = Station::where(
								array(
									'name' => $station_detail['name'],
									'station_group_id' => $station_detail['station_group_id']
								)
							)->get();
							if (count($station) > 0){
								return json_encode(array('msg'=>'Unable to add station, Please try again later!'));
							}
							$station = Station::where(
								array(
									// 'name' => $station_detail['name'],
									'ip' => $station_detail['ip']
								)
							)->get();
							if (count($station) > 0){
								return json_encode(array('msg'=>'Unable to add station, Please try again later!'));
							}
							else{
								$station = new Station;
								$station->fill($station_detail);
								if ($station->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Added Station!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Station!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.stations.stations_form');
	}

	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('station_name')){
							$station_name = Input::get('station_name');
							$station = Station::where(array('name' => $station_name))->where('station_id','<>',$id)->get();
							if (count($station) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'checkIP':
						if (Input::has('station_ip')){
							$station_ip = Input::get('station_ip');
							if (!filter_var($station_ip, FILTER_VALIDATE_IP)){
								return 'false';
							}
							$station = Station::where(array('ip' => $station_ip))->where('station_id','<>',$id)->get();
							if (count($station) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'updateStation':
						if (Request::isMethod('post') && Input::has('station')){
							$station_detail = json_decode(Input::get('station'),TRUE);
							//station name
							$station = Station::where(
								array(
									'name' => $station_detail['name'],
									'station_group_id' => $station_detail['station_group_id']
								)
							)->where(
								'station_id','<>',$id
							)->get();
							if (count($station) > 0){
								return json_encode(array('msg'=>'Unable to update station, Please try again later!'));
							}
							//station ip
							$station = Station::where(
								array(
									'ip' => $station_detail['ip'],
								)
							)->where(
								'station_id','<>',$id
							)->get();
							if (count($station) > 0){
								return json_encode(array('msg'=>'Unable to update station, Please try again later!'));
							}
							else{
								$station = Station::find($id);
								$station->fill($station_detail);
								if ($station->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Updated Station!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Update Station!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		$station_data = Station::find($id);
		return view('content.stations.stations_form',array('station_data'=>$station_data));
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (Station::find($id)){
				$station = Station::find($id);
				if ($station->delete()){
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
				$model_name = 'App\Models\Stations\Station';
				$data = array(
					'name',
					'ip',
					'station_group.group_name',
					'description',
					'status',
					'enable_status',
					'station_id',
				);
				$joins = array(
					'station_group,station_group.station_group_id,=,stations.station_group_id,inner',
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
