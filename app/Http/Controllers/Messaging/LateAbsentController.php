<?php
namespace App\Http\Controllers\Messaging;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Members\Member as Member;
use App\Models\Classification\Classification as Classification;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use App\Models\SMS\LateAbsent as LateAbsent;
use Carbon\Carbon as Carbon;
use Request;
use Input;
use Controller;

class LateAbsentController extends Controller {
	protected $page_module = 10;
	protected $page_id = 26;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.messaging_late_absent.messaging_late_absent',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (LateAbsent::find($id)){
			return view('content.messaging_late_absent.modal.late_absent_info',array(
				'recipients' => $this->recipientStringConversion($id),
				'late_absent_info' => LateAbsent::find($id)
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
					case 'addLateAbsent':
						if (Request::isMethod('post') && Input::has('info')){
							$info_detail = json_decode(Input::get('info'),TRUE);
							$late_absent = new LateAbsent;
							$late_absent->fill($info_detail);
							$late_absent->late_time = Carbon::createFromFormat('h:i A',$info_detail['late_time'])->format('H:i:s');
							$late_absent->absent_time = Carbon::createFromFormat('h:i A',$info_detail['absent_time'])->format('H:i:s');
							if ($late_absent->save()){
								return json_encode(array('status'=>true,'msg'=>'Successfully Added Notification Message!'));
							}
							return json_encode(array('status'=>false,'msg'=>'Unable To Add Notification Message!'));
						}
						return json_encode(array('status'=>false,'msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.messaging_late_absent.messaging_late_absent_form');
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (LateAbsent::find($id)){
				$late_absent = LateAbsent::find($id);
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
				$model_name = 'App\Models\SMS\LateAbsent';
				$data = array(
					'class_id',
					'description',
					'late_message',
					'absent_message',
					'late_time',
					'absent_time',
					'sms_la_id',
					'class_group_id',
					'member_id',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search);
				foreach ($response['data'] as &$data) {
					$data->late_time = Carbon::createFromFormat('H:i:s',$data->late_time)->format('h:i A');
					$data->absent_time = Carbon::createFromFormat('H:i:s',$data->absent_time)->format('h:i A');
					$data->recipients = $this->recipientStringConversion($data->sms_la_id);
				}
				return json_encode($response);
			}
		}
	}

	private function recipientStringConversion($id){
		$message = '';
		$data = LateAbsent::find($id);
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
