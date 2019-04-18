<?php
namespace App\Http\Controllers\Messaging;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Classification\Classification as Classification;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use App\Models\Members\Member as Member;
use App\Models\SMS\DirectMessageLog as DirectMessageLog;
use App\Helper\SMS as SMS;
use Carbon\Carbon as Carbon;
use Request;
use Input;
use Controller;

class DirectMessageController extends Controller {
	protected $page_module = 10;
	protected $page_id = 24;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.messaging_direct.messaging_direct',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
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
		return view('common.invalid_modal',array('msg' => 'Unable to find data!'));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'send':
						if (Input::has('info')){
							$info = json_decode(Input::get('info'),true);
							$log = new DirectMessageLog;
							$log->message = $info['message'];
							$log->send_date_time = Carbon::now();
							if (!$info['all']){
								$data = array('class_id','class_group_id','member_id');
								foreach ($data as $data_key) {
									if ($info[$data_key] == '' || empty($info[$data_key]))
										continue;
									$log->$data_key = $info[$data_key];
								}
							}
							if ($log->save()){
								$members = array();
								if (!$info['all']){
									if (!empty($log->class_id) && !empty($log->class_group_id) && !empty($log->member_id)){
										if (Member::find($log->member_id)){
											$members = Member::with('memberInformation')->where('member_id',$log->member_id)->get()->toArray();
										}
									}
									else if (!empty($log->class_id) && !empty($log->class_group_id)){
										$members = Member::with('memberInformation')->where('class_group_id',$log->class_group_id)->get();
										if (count($members) > 0){
											$members = $members->toArray();
										}
									}
									else if (!empty($log->class_id)){
										$class_group = ClassificationGroup::where('class_id',$log->class_id)->get();
										foreach ($class_group as $group ) {
											$members = array_merge($members,$group->member()->with('memberInformation')->get()->toArray());
										}
									}
								}
								else{
									$members = Member::with('memberInformation')->get();
									if (count($members) > 0){
										$members = $members->toArray();
									}
								}

								foreach ($members as $member) {
									// print_r($member);
									if (isset($member['member_information']['contact_number']) && $member['member_information']['contact_number'] != ''){
										$number = $member['member_information']['contact_number'];
										if ($number == '')
											continue;
										$pos = strpos($number, '/');
										if ($pos === false) {
											SMS::sendSMS($number,$log->message);
										}
										else{
										    $numbers = explode('/', $number);
										    foreach ($numbers as $number) {
										    	SMS::sendSMS($number,$log->message);
										    }
										}
									}
								}
								
								return json_encode(array('status'=>'true','msg'=>'Done Sending!'));
							}
							return json_encode(array('status'=>'false','msg'=>'Unable to send message!'));
						}
						break;
				}
			}
		}
		return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
	}
}
