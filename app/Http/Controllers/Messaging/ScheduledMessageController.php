<?php
namespace App\Http\Controllers\Messaging;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Members\Member as Member;
use App\Models\Classification\Classification as Classification;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use App\Models\SMS\Blast as Blast;
use App\Models\SMS\BlastOccurance as BlastOccurance;
use Carbon\Carbon as Carbon;
use Request;
use Input;
use Controller;

class ScheduledMessageController extends Controller {
	protected $page_module = 10;
	protected $page_id = 25;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.messaging_scheduled.messaging_scheduled',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Blast::find($id)){
			return view('content.messaging_scheduled.modal.schedule_message_info',array(
				'recipients' => $this->recipientStringConversion($id),
				'send_details' => $this->sendDetailStringConversion($id),
				'blast_info' => Blast::find($id)
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
						// $class_id = Input::get('class_id');
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
		return view('common.invalid_modal',array('msg' => 'Unable to find Member!'));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkID':
						if (Input::has('id_number')){
							$id_number = Input::get('id_number');
							$member = Member::where(array('id_number' => $id_number))->get();
							if (count($member) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addSchedule':
						if (Request::isMethod('post') && Input::has('info')){
							$info_detail = json_decode(Input::get('info'),TRUE);
							$occurance_info = array();
							if (isset($info_detail['occurance_info'])){
								$occurance_info = $info_detail['occurance_info'];
							}
							else{
								$info_detail['send_date_time'] = Carbon::createFromFormat('m/d/Y g:i A',$info_detail['send_date_time'])->format('Y-m-d H:i:s');
							}
							$blast = new Blast;
							$blast->fill($info_detail);
							if ($blast->save()){
								if ($info_detail['occurance']){
									$blast_occurance = new BlastOccurance;
									$blast_occurance->fill($occurance_info);
									if ($blast->occurance()->save($blast_occurance)){
										return json_encode(array('status'=>'true','msg'=>'Successfully Added Scheduled Message!'));
									}
									$blast->delete();
								}
								return json_encode(array('status'=>'true','msg'=>'Successfully Added Scheduled Message!'));
							}
							return json_encode(array('status'=>'false','msg'=>'Unable To Add Scheduled Message!'));
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.messaging_scheduled.messaging_scheduled_form');
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (Blast::find($id)){
				$blast = Blast::find($id);
				if (!empty($blast->occurance)){
					if ($blast->occurance()->delete() && $blast->delete()){
						return json_encode(array('status'=>true));
					}
				}
				else if ($blast->delete()){
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
				$model_name = 'App\Models\SMS\Blast';
				$data = array(
					'class_id',
					'class_group_id',
					'message',
					'sms_blast_id',
					'member_id',
					'occurance',
					'send_date_time',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search);
				foreach ($response['data'] as &$data) {
					$data->recipients = $this->recipientStringConversion($data->sms_blast_id);
					$data->send_details = $this->sendDetailStringConversion($data->sms_blast_id);
				}
				return json_encode($response);
			}
		}
	}

	private function sendDetailStringConversion($id){
		$data = Blast::find($id);
		$message = '';
		if ($data->occurance){
			$blast_occurance = BlastOccurance::where('sms_blast_id',$data->sms_blast_id)->first();
			$time = Carbon::createFromFormat('H:i',$blast_occurance->hour.':'.$blast_occurance->minute)->format('h:i a');
			//yearly
			if ($blast_occurance->day_of_month != '*' && $blast_occurance->month != '*' && $blast_occurance->day_of_week == '*'){
				$year = Carbon::now();
				$year->month($blast_occurance->month)->day($blast_occurance->day_of_month);
				$message = 'Yearly, Every '.$year->format('d').' of '.$year->format('F').' at '.$time;
			}
			//monthly
			else if ($blast_occurance->day_of_month != '*' && $blast_occurance->month == '*' && $blast_occurance->day_of_week == '*'){
				$monly_date = $blast_occurance->day_of_month;
				$message = 'Monthly, Every '.$monly_date.' of the month at '.$time;
			}
			//weekly
			else if ($blast_occurance->day_of_month == '*' && $blast_occurance->month == '*' && $blast_occurance->day_of_week != '*'){
				$weekly_list = array(
	                'Sunday',
	                'Monday',
	                'Tuesday',
	                'Wednesday',
	                'Thursday',
	                'Friday',
	                'Saturday',
	            );
				$message = 'Weekly, Every '.$weekly_list[$blast_occurance->day_of_week].' at '.$time;
			}
			//everyday
			else{
				$message = 'Everyday '.$time;
			}
		}
		else{
			$message = Carbon::createFromFormat('Y-m-d H:i:s',$data->send_date_time)->format('M d,Y g:i A');
		}
		return $message;
	}

	private function recipientStringConversion($id){
		$message = '';
		$data = Blast::find($id);
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
