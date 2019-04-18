<?php
namespace App\Http\Controllers\Monitor;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Stations\Station as Station;
use Carbon\Carbon as Carbon;
use Request;
use Input;
use Controller;

class StationController extends Controller {
    protected $page_module = 7;
	protected $page_id = 16;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.monitor_controller.monitor_controller',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Station::find($id)){
			return view('content.stations.modal.station_info',array('station_info' => Station::find($id)));
		}
		return view('common.invalid_modal',array('msg' => 'Unable to find data!'));
	}

	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Station::find($id)){
			$station = Station::find($id);
			if ($station->station_status){
				$station->restart_status = true;
				if ($station->save()){
					return json_encode(array('status'=>'true'));
				}
			}
		}
		return json_encode(array('status'=>'false'));
	}

	public function data(){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Request::ajax())
		{
			if (Input::has('draw') && Input::get('draw')){
				$model_name = 'App\Models\Stations\Station';
				$data = array(
					'station_group.group_name',
					'name',
					'station_status',
					'restart_status',
					'station_id',
				);
				$joins = array(
					'station_group,station_group.station_group_id,=,stations.station_group_id,inner',
				);
				$where = array();
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

