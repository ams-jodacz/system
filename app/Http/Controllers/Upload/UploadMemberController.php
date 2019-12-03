<?php
namespace App\Http\Controllers\Upload;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Access\StationAccess as StationAccess;
use App\Models\Members\Member as Member;
use App\Models\Members\MemberInformation as MemberInformation;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use App\Models\Prism\PrismViews as PrismViews;
use App\Models\Tags\Tag as Tag;
use Request;
use Input;
use Controller;
use Carbon\Carbon as Carbon;
use DB;

class UploadMemberController extends Controller {
	protected $page_module = 8;
	protected $page_id = 19;

	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		$term_list = PrismViews::getTermList();
		$sem_list = PrismViews::getSemList();
		return view('content.upload_member.upload_member',array(
			'action_value' => $action_value,
			'term_list' => $term_list,
			'sem_list' => $sem_list,
		));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (StationAccess::find($id)){
			return view('content.access.modal.access_info',array('access_info' => StationAccess::find($id)));
		}
		if (Input::has('classType')){
			switch(Input::get('classType')){
				case 'group':
					if (Input::has('class_id')){
						$class_id = Input::get('class_id');
						$group_names = ClassificationGroup::where(
							array(
								'class_id' => $class_id,
							)
						)->get();
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
							if ($member->memberInformation != null){
								$data[] = array(
									'id' => $member->member_id,
									'text' => $member->memberInformation->first_name.' '.$member->memberInformation->middle_name.' '.$member->memberInformation->last_name,
								);
							}
						}
						return json_encode($data);
					}
					break;
			}
		}
		return view('common.invalid_modal',array('msg' => 'Unable to find data!'));
	}

	public function add(){
		set_time_limit(0);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		$this->checkPageAction($this->page_id,Action::$View);
		if (Request::ajax()){
			if (Input::hasFile('uploaded_file') && Input::has('class_id') && Input::has('class_group_id')){
				$class_group_id = Input::get('class_group_id');
				$file = Input::file('uploaded_file');
				$path = $file->getRealPath();			
				$datas = array_map('str_getcsv', file($path));
				foreach ($datas as $data) {
					if (count($data) >= 6){
						$empty_status = true;
						foreach ($data as $info) {
							if ($info != ''){
								$empty_status = false;
							}
						}
						if ($empty_status)
							continue;
						$member = Member::where(
							array(
								'id_number' => $data[0],
							)
						)->first();
						if (empty($member) || is_null($member)){
							$member = new Member;
							$member->id_number = $data[0];
						}
						$member->class_group_id = $class_group_id;
						if ($member->memberInformation == null){
							$memberInformation = new MemberInformation;
							$memberInformation->first_name = $data[1];
							$memberInformation->middle_name = $data[2];
							$memberInformation->last_name = $data[3];
							$memberInformation->contact_number = $data[4];
							$memberInformation->email = $data[5];
							if ($member->save()){
								if ($member->memberInformation()->save($memberInformation)){
									if (count($data) >= 7){
										$new_tag = new Tag;
										$new_tag->id_number = $member->id_number;
										$new_tag->tag = strtoupper($data[6]);
										$new_tag->save();
									}
									continue;
								}
								$member->delete();
							}
						}
						else{
							$member->memberInformation->first_name = $data[1];
							$member->memberInformation->middle_name = $data[2];
							$member->memberInformation->last_name = $data[3];
							$member->memberInformation->contact_number = $data[4];
							$member->memberInformation->email = $data[5];
							if ($member->save()){
								if ($member->memberInformation->save()){
									if (count($data) >= 7){
										$member_tag_list = Tag::where('id_number',$member->id_number)->get();
										$new_tag = new Tag;
										if (count($member_tag_list) > 0){
											$new_tag = Tag::where('id_number',$member->id_number)->first();
										}
										$new_tag->id_number = $member->id_number;
										$new_tag->tag = strtoupper($data[6]);
										$new_tag->save();
									}
									continue;
								}
							}
						}
					}
				}
				return 'true';
			}
			return 'false';
		}
		return view('content.upload_member.upload_member',array('action_value'=>$action_value));
	}

	public function verify(){
		set_time_limit(0);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		$this->checkPageAction($this->page_id,Action::$View);
		if (Request::ajax()){
			if (Input::hasFile('verify_file')){
				$file = Input::file('verify_file');
				$path = $file->getRealPath();
				$datas = array_map('str_getcsv', file($path));
				foreach ($datas as $data) {
					if (count($data) >= 2){
						$member = Member::where(
							array(
								'id_number' => trim($data[0]),
							)
						)->first();
						if (empty($member) || is_null($member)){
							continue;
						}
						$member_tag_list = Tag::where('id_number',$member->id_number)->get();
						$new_tag = new Tag;
						if (count($member_tag_list) > 0){
							$new_tag = Tag::where('id_number',$member->id_number)->first();
						}
						$new_tag->id_number = $member->id_number;
						$new_tag->tag = strtoupper(trim($data[1]));
						$new_tag->save();
					}
				}
				return 'true';
			}
			return 'false';
		}
		return view('content.upload_member.upload_member',array('action_value'=>$action_value));
	}

	public function sync(){
		set_time_limit(0);
		if (Input::has('grad_term_id') && Input::has('dest_class_id')){
			$classification = Input::get('dest_class_id');
			$term = Input::get('grad_term_id');
			$datas = PrismViews::getOfficialK12List($term);

			$student_group_list_raw = ClassificationGroup::where('class_id',$classification)->select(array('group_name','class_group_id'))->get();
			$student_group_list = array();
			$class_group_id_list = array();

			foreach ($student_group_list_raw as $value) {
				$student_group_list[trim($value->group_name)] = $value->class_group_id;
				$class_group_id_list[] = $value->class_group_id;
			}

			Member::whereIn('class_group_id',$class_group_id_list)->update(array('active_status'=>false));

			foreach ($datas as $data) {
				$member = Member::where(
					array(
						'id_number' => $data->StudentNo,
					)
				)->first();
				if (empty($member) || is_null($member)){
					$member = new Member;
					$member->id_number = $data->StudentNo;
				}

				if (isset($student_group_list[$data->SectionName])){
					$member->class_group_id = $student_group_list[$data->SectionName];
				}
				else{
					$new_group = new ClassificationGroup();
					$new_group->class_id = $classification;
					$new_group->group_name = $data->SectionName;
					if ($new_group->save()){
						$member->class_group_id = $new_group->class_group_id;
						$student_group_list[$new_group->group_name] = $new_group->class_group_id;
					}
				}
				$member->active_status = true;

				if ($member->memberInformation == null){
					$memberInformation = new MemberInformation;
					$memberInformation->first_name = empty($data->firstname)?'':$data->firstname;
					$memberInformation->middle_name = empty($data->middleinitial)?'':$data->middleinitial;
					$memberInformation->last_name = empty($data->lastname)?'':$data->lastname;
					// $memberInformation->contact_number = $data->MobileNo;
					// $memberInformation->email = $data->Email;
					if ($member->save()){
						if ($member->memberInformation()->save($memberInformation)){
							continue;
						}
						$member->delete();
					}
				}
				else{
					$member->memberInformation->first_name = empty($data->firstname)?'':$data->firstname;
					$member->memberInformation->middle_name = empty($data->middleinitial)?'':$data->middleinitial;
					$member->memberInformation->last_name = empty($data->lastname)?'':$data->lastname;
					// $member->memberInformation->contact_number = $data->MobileNo;
					// $member->memberInformation->email = $data->Email;
					if ($member->save()){
						if ($member->memberInformation->save()){
							continue;
						}
					}
				}
			}
			return 'true';
		}
		else if (Input::has('term_id') && Input::has('dest_class_id')){
			$classification = Input::get('dest_class_id');
			$term_id = Input::get('term_id');
			$datas = PrismViews::getOfficialK12List($term_id);

			$student_group_list_raw = ClassificationGroup::where('class_id',$classification)->select(array('group_name','class_group_id'))->get();
			$student_group_list = array();
			$class_group_id_list = array();

			foreach ($student_group_list_raw as $value) {
				$student_group_list[trim($value->group_name)] = $value->class_group_id;
				$class_group_id_list[] = $value->class_group_id;
			}

			Member::whereIn('class_group_id',$class_group_id_list)->update(array('active_status'=>false));

			foreach ($datas as $data) {
				$member = Member::where(
					array(
						'id_number' => $data->StudentNo,
					)
				)->first();
				if (empty($member) || is_null($member)){
					$member = new Member;
					$member->id_number = $data->StudentNo;
				}

				if (isset($student_group_list[$data->SectionName])){
					$member->class_group_id = $student_group_list[$data->SectionName];
				}
				else{
					$new_group = new ClassificationGroup();
					$new_group->class_id = $classification;
					$new_group->group_name = $data->SectionName;
					if ($new_group->save()){
						$member->class_group_id = $new_group->class_group_id;
						$student_group_list[$new_group->group_name] = $new_group->class_group_id;
					}
				}
				$member->active_status = true;

				if ($member->memberInformation == null){
					$memberInformation = new MemberInformation;
					$memberInformation->first_name = empty($data->firstname)?'':$data->firstname;
					$memberInformation->middle_name = empty($data->middleinitial)?'':$data->middleinitial;
					$memberInformation->last_name = empty($data->lastname)?'':$data->lastname;
					// $memberInformation->contact_number = $data->MobileNo;
					// $memberInformation->email = $data->Email;
					if ($member->save()){
						if ($member->memberInformation()->save($memberInformation)){
							continue;
						}
						$member->delete();
					}
				}
				else{
					$member->memberInformation->first_name = $data->firstname;
					$member->memberInformation->middle_name = $data->middleinitial;
					$member->memberInformation->last_name = $data->lastname;
					// $member->memberInformation->contact_number = $data->MobileNo;
					// $member->memberInformation->email = $data->Email;
					if ($member->save()){
						if ($member->memberInformation->save()){
							continue;
						}
					}
				}
			}
			return 'true';
		}
		return 'false';
	}

	public function transfer(){
		if (Input::has('from_group_id') && Input::has('to_group_id') && Input::has('members')){
			$from_group_id = Input::get('from_group_id');
			$to_group_id = Input::get('to_group_id');
			$member = Input::get('members');


			if ($member == 'null'){
				Member::where('class_group_id',$from_group_id)->update(array('class_group_id' => $to_group_id));
			}
			else{
				$members = explode(',',$member);
				Member::whereIn('member_id',$members)->update(array('class_group_id' => $to_group_id));
			}
			return 'true';
		}
		return 'false';
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


