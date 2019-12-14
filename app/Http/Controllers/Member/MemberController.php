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
use URL;
use Carbon\Carbon as Carbon;

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
					case 'uploadImage':
						if (Input::hasFile('file') && Member::find($id)){
							if (Input::file('file')->isValid()){
								$file = Input::file('file');
								$extension = $file->getClientOriginalExtension();
								if ($extension != 'jpg'){
									return json_encode(array('status'=>false,'msg'=>'Invalid File Type!'));
								}

								$member_info = Member::find($id);
								$file_path = realpath("images");

								if (file_exists('images/'.$member_info->id_number.'.jpg')){
									unlink('images/'.$member_info->id_number.'.jpg');
								}

								if ($file->move($file_path,$member_info->id_number.'.'.$extension)){
									$current_date = Carbon::now()->timestamp;
									$image_loc = URL::to('images/'.$member_info->id_number.'.'.$extension.'?date='.$current_date);
									return json_encode(array('status'=>true,'image_loc'=>$image_loc,'msg'=>'Successfully Uploaded Image!'));
								}
							}
							return json_encode(array('status'=>false,'msg'=>'Unexpected error, Please try again later!'));
						}
						return json_encode(array('status'=>false,'msg'=>'Unexpected error, Please try again later!'));
						break;
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
					case 'purgeData':
						if (Member::find($id)){
							$member = Member::find($id);
							if ($member->tag()->delete()){
								return json_encode(array('status'=>'true'));
							}
						}
						return json_encode(array('status'=>'false'));
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

		if (file_exists('images/'.$member_data->id_number.'.jpg')){
			$member_data->profile_image = $member_data->id_number.'.jpg';
		}
		else{
			$member_data->profile_image = 'gender.jpg';
		}
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
			$action_type = Input::has('type')?Input::get('type'):'';

			$start = Input::has('start')?Input::get('start'):0;
			$length = Input::has('length')?Input::get('length'):10;
			$search = Input::has('search')?Input::get('search'):array();
			$order = Input::has('order')?Input::get('order'):array();
			$selected_id = Input::has('selected_id')?Input::get('selected_id'):'';
			$page = Input::has('page')?Input::get('page'):1;

			switch($action_type){
				case 'group_list':
					$select = array(
						'group_name',
						'class_group_id'
					);

					$model = ClassificationGroup::select($select);

					if (isset($search) && !empty($search)){
						$new_search = $search;
						$model = $model->where(function($q) use ($new_search,$select){
							$q->where($select[0],'like',$new_search.'%');
						});
					}
					

					$start = $length * ($page-1);
					$model = $model->skip($start)->take($length+1);

					$model = $model->orderBy($select[0],'ASC');

					if ($selected_id != ''){
						$model = $model->where($select[count($select) - 1],$selected_id);
					}

					$data = $model->get();
					$more = false;
					if (count($data) > $length){
						$more = true;
						unset($data[count($data)-1]);
					}

					foreach($data as &$info){
						$info->id = empty($info->class_group_id)?'Unknown':$info->class_group_id;
						unset($info->class_group_id);

						$info->text = empty($info->group_name)?'Unknown':$info->group_name;
						unset($info->group_name);
					}

					return json_encode(array(
						'results' => $data,
						'more' => $more,
					));

					break;
				default:

					$select = array(
						'members.id_number',
						'members.id_number',
						'member_information.first_name',
						'member_information.middle_name',
						'member_information.last_name',
						'member_information.contact_number',
						'classification.classification_name',
						'classification_group.group_name',
						'active_status',
						'members.member_id',
						'tags.tag',
					);

					$model = Member::select($select)
						->leftJoin('tags','tags.id_number','=','members.id_number')
						->join('member_information','member_information.member_id','=','members.member_id')
						->join('classification_group','classification_group.class_group_id','=','members.class_group_id')
						->join('classification','classification.class_id','=','classification_group.class_id');

					if (isset($search) && isset($search['value']) && !empty($search['value'])){
						$new_search = $search['value'];
						$model = $model->where(function($q) use ($new_search,$select){
							$q->where($select[0],'like',$new_search.'%')
								->orWhere($select[2],'like',$new_search.'%')
								->orWhere($select[3],'like',$new_search.'%')
								->orWhere($select[4],'like',$new_search.'%')
								->orWhere($select[5],'like',$new_search.'%')
								->orWhere($select[6],'like',$new_search.'%')
								->orWhere($select[7],'like',$new_search.'%')
								->orWhere($select[9],'like',$new_search.'%');
						});
					}

					$model = $model->skip($start)->take($length+1);
					if (count($order) > 0){
						foreach($order as $sort){
							$model = $model->orderBy($select[$sort['column']],$sort['dir']);
						}
					}

					$status_filter = Input::has('status_filter')?Input::get('status_filter'):'';
					if ($status_filter != ''){
						$model = $model->where('active_status',$status_filter);
					}

					$group_filter = Input::has('group_filter')?Input::get('group_filter'):'';
					if ($group_filter != ''){
						$model = $model->where('classification_group.class_group_id',$group_filter);
					}

					$data = $model->get();
					$total = $length+$start;
					if (count($data) > $length){
						$total += 1;
						unset($data[count($data)-1]);
					}

					foreach($data as &$info){
						if (file_exists('images/'.$info->id_number.'.jpg')){
							$info->profile_image = $info->id_number.'.jpg';
						}
						else{
							$info->profile_image = 'gender.jpg';
						}
					}

					return json_encode(array(
						'data' => $data,
						'recordsTotal' => $total,
						'recordsFiltered' => $total,
					));

					break;
			}
		}
	}
}
