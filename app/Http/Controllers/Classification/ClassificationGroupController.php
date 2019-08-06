<?php
namespace App\Http\Controllers\Classification;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Classification\Classification as Classification;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use Request;
use Input;
use Controller;

class ClassificationGroupController extends Controller {
	protected $page_module = 3;
	protected $page_id = 5;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.classification_group.classification_group',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!ClassificationGroup::find($id)){
			return view('common.invalid_modal',array('msg' => 'Unable to find Classification Group!'));
		}
		return view('content.classification_group.modal.classification_group_info',array('classification_group_info' => ClassificationGroup::find($id)));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('group_name') && Input::has('class_id')){
							$group_name = Input::get('group_name');
							$class_id = Input::get('class_id');
							$classification = ClassificationGroup::where(
								array(
									'group_name' => $group_name,
									'class_id' => $class_id
								)
							)->get();
							if (count($classification) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addClassificationGroup':
						if (Request::isMethod('post') && Input::has('classificationGroup')){
							$classification_group_detail = json_decode(Input::get('classificationGroup'),TRUE);
							$classification_group = ClassificationGroup::where(
								array(
									'group_name' => $classification_group_detail['group_name'],
									'class_id' => $classification_group_detail['class_id'],
								)
							)->get();
							if (count($classification_group) > 0){
								return json_encode(array('msg'=>'Unable to add classification group, Please try again later!'));
							}
							else{
								$classification_group = new ClassificationGroup;
								$classification_group->fill($classification_group_detail);
								if ($classification_group->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Added Classification Group!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Classification Group!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.classification_group.classification_group_form');
	}

	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('group_name') && Input::has('class_id')){
							$group_name = Input::get('group_name');
							$class_id = Input::get('class_id');
							$classification_group = ClassificationGroup::where(
								array(
									'group_name' => $group_name,
									'class_id' => $class_id
								)
							)->where('class_group_id','<>',$id)->get();
							if (count($classification_group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'updateClassificationGroup':
						if (Request::isMethod('post') && Input::has('classificationGroup')){
							$classification_group_detail = json_decode(Input::get('classificationGroup'),TRUE);
							$classificationGroup = ClassificationGroup::where(
								array(
									'group_name' => $classification_group_detail['group_name'],
									'class_id' => $classification_group_detail['class_id'],
								)
							)->where(
								'class_group_id','<>',$id
							)->get();
							if (count($classificationGroup) > 0){
								return json_encode(array('msg'=>'Unable to update classification group, Please try again later!'));
							}
							else{
								$classificationGroup = ClassificationGroup::find($id);
								$classificationGroup->fill($classification_group_detail);
								if ($classificationGroup->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Updated Classification Group!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Update Classification Group!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		$classification_group_data = ClassificationGroup::find($id);
		return view('content.classification_group.classification_group_form',array('classification_group_data'=>$classification_group_data));
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (ClassificationGroup::find($id)){
				$classification_group = ClassificationGroup::find($id);
				if ($classification_group->delete()){
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
				$model_name = 'App\Models\Classification\ClassificationGroup';
				$data = array(
					'group_name',
					'classification.classification_name',
					'class_group_id',
				);
				$joins = array(
					'classification,classification.class_id,=,classification_group.class_id,inner'
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$joins);
				return json_encode($response);
			}
		}
	}
}
