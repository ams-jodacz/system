<?php
namespace App\Http\Controllers\Messaging;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Members\Member as Member;
use App\Models\Classification\Classification as Classification;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use App\Models\SMS\DateExcemption as DateExcemption;
use Carbon\Carbon as Carbon;
use Request;
use Input;
use Controller;

class DateExcemptionController extends Controller {
	protected $page_module = 10;
	protected $page_id = 27;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.messaging_date_excemption.messaging_date_excemption',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (DateExcemption::find($id)){
			return view('content.messaging_date_excemption.modal.date_excemption_info',array(
				'recipients' => $this->recipientStringConversion($id),
				'date_excemption_info' => DateExcemption::find($id)
			));
		}
		if (Input::has('classType')){
			switch(Input::get('classType')){
				case 'group':
					if (Input::has('class_id')){
						$class_id = Input::get('class_id');
						$group_names = ClassificationGroup::where('class_id',$class_id)->get();
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
				case 'member':
					if (Input::has('class_id') && Input::has('class_group_id')){
						$class_group_id = Input::get('class_group_id');
						$members = Member::where('class_group_id',$class_group_id)->get();
						$data = array();
						foreach ($members as $member) {
							$data[] = array(
								'id' => $member->member_id,
								'text' => $member->memberInformation->first_name.' '.$member->memberInformation->middle_name.' '.$member->memberInformation->last_name,
							);
						}
						return json_encode($data);
					}
					break;
			}
		}
		return view('common.invalid_modal',array('msg' => 'Unable to find Notification!'));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'addDateExcemption':
						if (Request::isMethod('post') && Input::has('info')){
							$info_detail = json_decode(Input::get('info'),TRUE);
							$date_excemption = new DateExcemption;
							$date_excemption->fill($info_detail);
							$date_excemption->start_date_time = Carbon::createFromFormat('M d,Y h:i A',$info_detail['start_date_time']);
							$date_excemption->end_date_time = Carbon::createFromFormat('M d,Y h:i A',$info_detail['end_date_time']);
							if ($date_excemption->save()){
								return json_encode(array('status'=>true,'msg'=>'Successfully Added Excemption Date!'));
							}
							return json_encode(array('status'=>false,'msg'=>'Unable To Add Excemption Date!'));
						}
						return json_encode(array('status'=>false,'msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.messaging_date_excemption.messaging_date_excemption_form');
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (DateExcemption::find($id)){
				$late_absent = DateExcemption::find($id);
				if ($late_absent->delete()){
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
				$model_name = 'App\Models\SMS\DateExcemption';
				$data = array(
					'class_id',
					'start_date_time',
					'end_date_time',
					'sms_date_excemption_id',
					'class_group_id',
					'member_id',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search);
				foreach ($response['data'] as &$data) {
					$data->recipients = $this->recipientStringConversion($data->sms_date_excemption_id);
					$data->start_date_time = Carbon::createFromFormat('Y-m-d H:i:s',$data->start_date_time)->format('M d,y h:i A');
					$data->end_date_time = Carbon::createFromFormat('Y-m-d H:i:s',$data->end_date_time)->format('M d,y h:i A');
				}
				return json_encode($response);
			}
		}
	}

	private function recipientStringConversion($id){
		$message = '';
		$data = DateExcemption::find($id);
		if ($data->class_id != null && $data->class_group_id != null && $data->member_id != null ){
			$member = Member::find($data->member_id);
		 	$message = $member->memberInformation->first_name.' '.$member->memberInformation->middle_name.' '.$member->memberInformation->last_name;
		}
		else if ($data->class_id != null && $data->class_group_id != null ){
			$classification_group = ClassificationGroup::find($data->class_group_id);
			$message = 'Send to all '.$classification_group->group_name.' Group Members';
		}
		else if ($data->class_id != null ){
			$classification = Classification::find($data->class_id);
			$message = 'Send to all '.$classification->classification_name.' Classification Members';
		}
		else{
			$message = 'Send to All';
		}
		return $message;
	}
}
