<?php
namespace App\Http\Controllers\Messaging;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Members\Member as Member;
use App\Models\Classification\Classification as Classification;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use App\Models\SMS\Holiday as Holiday;
use Carbon\Carbon as Carbon;
use Request;
use Input;
use Controller;

class HolidayController extends Controller {
	protected $page_module = 10;
	protected $page_id = 29;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.messaging_holiday.messaging_holiday',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Holiday::find($id)){
			return view('content.messaging_holiday.modal.holiday_info',array(
				'holiday' => Holiday::find($id),
			));
		}
		return view('common.invalid_modal',array('msg' => 'Unable to find information!'));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'addHoliday':
						if (Request::isMethod('post') && Input::has('info')){
							$info_detail = json_decode(Input::get('info'),TRUE);
							$date = new Holiday;
							$date->fill($info_detail);
							$date->date = Carbon::createFromFormat('M d',$info_detail['date']);
							if ($date->save()){
								return json_encode(array('status'=>true,'msg'=>'Successfully Added Holiday Date!'));
							}
							return json_encode(array('status'=>false,'msg'=>'Unable To Add Holiday Date!'));
						}
						return json_encode(array('status'=>false,'msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.messaging_holiday.messaging_holiday_form');
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (Holiday::find($id)){
				$holiday = Holiday::find($id);
				if ($holiday->delete()){
					return json_encode(array('status'=>true));
				}
			}
			return json_encode(array('status'=>false));
		}
	}

	public function data(){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Request::ajax())
		{
			if (Input::has('draw') && Input::get('draw')){
				$model_name = 'App\Models\SMS\Holiday';
				$data = array(
					'name',
					'date',
					'description',
					'holiday_id',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search);
				foreach ($response['data'] as &$data) {
					$data->date = Carbon::createFromFormat('Y-m-d',$data->date)->format('M d');
				}
				return json_encode($response);
			}
		}
	}
}
