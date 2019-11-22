<?php
namespace App\Http\Controllers\Station;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Access\StationAccess as StationAccess;
use App\Models\Stations\Station as Station;
use App\Models\Stations\StationGroup as StationGroup;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use Request;
use Input;
use Controller;

class StationAccessController extends Controller {
	protected $page_module = 2;
	protected $page_id = 7;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.access.access',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (StationAccess::find($id)){
			return view('content.access.modal.access_info',array('access_info' => StationAccess::find($id)));
		}
		if (Input::has('classType')){
			switch(Input::get('classType')){
				case 'classification':
					if (Input::has('station_group_id') && Input::has('class_id')){
						$station_group_id = Input::get('station_group_id');
						$class_id = Input::get('class_id');
						$access = StationAccess::where(
							array(
								'station_group_id' => $station_group_id,
							)
						)->get(array('class_group_id'));
						$group_names = ClassificationGroup::where(
							array(
								'class_id' => $class_id,
							)
						)->whereNotIn('class_group_id',$access->toArray())->get();
						$data = array();
						foreach ($group_names as $group_name) {
							$data[] = array(
								'id' => $group_name->class_group_id,
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
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'addAccess':
						if (Request::isMethod('post') && Input::has('access')){
							$access_details = json_decode(Input::get('access'),TRUE);
							if ($access_details['class_group_id'] == ''){
								$classification_group_list = ClassificationGroup::where('class_id',$access_details['class_id'])->get();
								foreach($classification_group_list as $class_group){
									$access = StationAccess::where(
										array(
											'station_group_id' => $access_details['station_group_id'],
											'class_group_id' => $class_group->class_group_id
										)
									)->get();

									if (count($access) == 0){
										$access = new StationAccess;
										$access->station_group_id = $access_details['station_group_id'];
										$access->class_group_id = $class_group->class_group_id;
										if ($access->save()){

										}
									}
								}
								return json_encode(array('status'=>'true','msg'=>'Successfully Added Access!'));
							}
							else{
								$access = StationAccess::where(
									array(
										'station_group_id' => $access_details['station_group_id'],
										'class_group_id' => $access_details['class_group_id']
									)
								)->get();
								
								if (count($access) > 0){
									return json_encode(array('msg'=>'Unable to add access, Please try again later!'));
								}
								else{
									$access = new StationAccess;
									$access->station_group_id = $access_details['station_group_id'];
									$access->class_group_id = $access_details['class_group_id'];
									if ($access->save()){
										return json_encode(array('status'=>'true','msg'=>'Successfully Added Access!'));
									}
								}
							}
							return json_encode(array('status'=>'false','msg'=>'Unable To Add Access!'));
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.stations.stations_form');
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (StationAccess::find($id)){
				$station = StationAccess::find($id);
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
				$model_name = 'App\Models\Access\StationAccess';
				$data = array(
					'station_group.group_name',
					'classification.classification_name',
					'classification_group.group_name',
					'access_id',
				);
				$joins = array(
					'classification_group,classification_group.class_group_id,=,station_access.class_group_id,inner',
					'classification,classification.class_id,=,classification_group.class_id,inner',
					'station_group,station_group.station_group_id,=,station_access.station_group_id,inner',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$joins);
				if (count($response['data']) > 0){
					foreach ($response['data'] as $data) {
						$station = StationAccess::find($data->access_id);
						$data->station_group_name = $station->station->group_name;
					}
				}
				return json_encode($response);
			}
		}
	}
}
