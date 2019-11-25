<?php
namespace App\Http\Controllers\Member;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Members\Member as Member;
use App\Models\Members\MemberInformation as MemberInformation;
use App\Models\Members\Recipient as Recipient;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use Request;
use Input;
use Controller;

class MemberController extends Controller {
	protected $page_module = 4;
	protected $page_id = 6;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.member.member',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Member::find($id)){
			return view('content.member.modal.member_info',array('member_info' => Member::find($id)));
		}
		if (Input::has('actionType')){
			switch(Input::get('actionType')){
				case 'class':
					if (Input::has('class_id')){
						$class_id = Input::get('class_id');
						$groups = ClassificationGroup::where(
							array(
								'class_id' => $class_id,
							)
						)->get();
						$data = array();
						foreach ($groups as $group) {
							$data[] = array(
								'id' => $group->class_group_id,
								'text' => $group->group_name
							);
						}
						return json_encode($data);
					}
					break;
				case 'recipient':
					if (Input::has('id')){
						if (Input::has('recipient_info')){
							$id = Input::get('id');
							$recipient_info = json_decode(Input::get('recipient_info'));
							$recipient_info->recipient_id = $id;
							return view('content.member.form.member_recipient_form',array('recipient_data' => $recipient_info));
						}
						else{
							return view('content.member.form.member_recipient_form');
						}
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
					case 'addMember':
						if (Request::isMethod('post') && Input::has('member') && Input::has('recipients')){
							$member_detail = json_decode(Input::get('member'),TRUE);
							$recipient_list = json_decode(Input::get('recipients'),TRUE);
							$member = Member::where(
								array(
									'id_number' => $member_detail['id_number'],
								)
							)->get();
							if (count($member) > 0){
								return json_encode(array('msg'=>'Unable to add member, Please try again later!'));
							}
							else{
								$member = new Member;
								$member->fill($member_detail);
								if ($member->save()){
									$member_information = new MemberInformation;
									$member_information->fill($member_detail);
									if ($member->memberInformation()->save($member_information)){
										if (count($recipient_list) > 0){
											$recipients = array();
											foreach ($recipient_list as $recipient) {
												$rs = new Recipient;
												$rs->fill(json_decode($recipient,true));
												$recipients[] = $rs;
											}
											if ($member->recipients()->saveMany($recipients)){
												return json_encode(array('status'=>'true','msg'=>'Successfully Added Member!'));
											}
											$member->member_information()->delete();
										}
										else{
											return json_encode(array('status'=>'true','msg'=>'Successfully Added Member!'));
										}
									}
									$member->delete();
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Member!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.member.member_form');
	}

	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkID':
						if (Input::has('id_number')){
							$id_number = Input::get('id_number');
							$member = Member::where(array('id_number' => $id_number))->where('member_id','<>',$id)->get();
							if (count($member) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'updateMember':
						if (Request::isMethod('post') && Input::has('member') && Input::has('recipients')){
							$member_detail = json_decode(Input::get('member'),TRUE);
							$recipient_list = json_decode(Input::get('recipients'),TRUE);
							$member = Member::where(
								array(
									'id_number' => $member_detail['id_number'],
								)
							)->where(
								'member_id','<>',$id
							)->get();
							if (count($member) > 0){
								return json_encode(array('msg'=>'Unable to update member, Please try again later!'));
							}
							else{
								$member = Member::find($id);
								$member->fill($member_detail);
								if ($member->save()){
									$member->memberInformation->fill($member_detail);
									if ($member->memberInformation->save()){
										$member->recipients()->delete();
										if (count($recipient_list) > 0){
											$recipients = array();
											foreach ($recipient_list as $recipient) {
												$rs = new Recipient;
												$rs->fill(json_decode($recipient,true));
												$recipients[] = $rs;
											}
											if ($member->recipients()->saveMany($recipients)){
												return json_encode(array('status'=>'true','msg'=>'Successfully Updated Member!'));
											}
										}
										else{
											return json_encode(array('status'=>'true','msg'=>'Successfully Updated Member!'));
										}
									}
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Update Member!'));
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		$member_data = Member::find($id);
		return view('content.member.member_form',array('member_data'=>$member_data));
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (Member::find($id)){
				$member = Member::find($id);
				if ($member->recipients()->delete() && $member->memberInformation()->delete() && $member->delete()){
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
				$model_name = 'App\Models\Members\Member';
				$data = array(
					'id_number',
					'id_number',
					'member_information.first_name',
					'member_information.middle_name',
					'member_information.last_name',
					'member_information.contact_number',
					'classification.classification_name',
					'classification_group.group_name',
					'active_status',
					'members.member_id',
				);
				$joins = array(
					'member_information,member_information.member_id,=,members.member_id,inner',
					'classification_group,classification_group.class_group_id,=,members.class_group_id,inner',
					'classification,classification.class_id,=,classification_group.class_id,inner',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$joins);
				if (count($response['data']) > 0){
					foreach($response['data'] as &$response_data){
						if (file_exists('images/'.$response_data->id_number.'.jpg')){
							$response_data->profile_image = $response_data->id_number.'.jpg';
						}
						else{
							$response_data->profile_image = 'gender.jpg';
						}
					}
				}
				return json_encode($response);
			}
		}
	}
}
