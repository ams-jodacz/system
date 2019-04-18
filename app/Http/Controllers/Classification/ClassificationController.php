<?php
namespace App\Http\Controllers\Classification;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\Classification\Classification as Classification;
use Request;
use Input;
use Controller;

class ClassificationController extends Controller {
	protected $page_module = 3;
	protected $page_id = 4;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.classification.classification',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!Classification::find($id)){
			return view('common.invalid_modal',array('msg' => 'Unable to find Classification!'));
		}
		return view('content.classification.modal.classification_info',array('classification_info' => Classification::find($id)));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('classification_name')){
							$classification_name = Input::get('classification_name');
							$classification = Classification::where(array('classification_name' => $classification_name))->get();
							if (count($classification) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addClassification':
						if (Request::isMethod('post') && Input::has('classification')){
							$classification_detail = json_decode(Input::get('classification'),TRUE);
							$classification = Classification::where(
								array(
									'classification_name' => $classification_detail['classification_name'],
								)
							)->get();
							if (count($classification) > 0){
								return json_encode(array('msg'=>'Unable to add classification, Please try again later!'));
							}
							else{
								$classification = new Classification;
								$classification->fill($classification_detail);
								if ($classification->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Added Classification!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Classification!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.classification.classification_form');
	}

	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('classification_name')){
							$classification_name = Input::get('classification_name');
							$classification = Classification::where(array('classification_name' => $classification_name))->where('class_id','<>',$id)->get();
							if (count($classification) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'updateClassification':
						if (Request::isMethod('post') && Input::has('classification')){
							$classification_detail = json_decode(Input::get('classification'),TRUE);
							$classification = Classification::where(
								array(
									'classification_name' => $classification_detail['classification_name'],
								)
							)->where(
								'class_id','<>',$id
							)->get();
							if (count($classification) > 0){
								return json_encode(array('msg'=>'Unable to update classification, Please try again later!'));
							}
							else{
								$classification = Classification::find($id);
								$classification->fill($classification_detail);
								if ($classification->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Updated Classification!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Update Classification!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		$classification_data = Classification::find($id);
		return view('content.classification.classification_form',array('classification_data'=>$classification_data));
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (Classification::find($id)){
				$classification = Classification::find($id);
				if ($classification->delete()){
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
				$model_name = 'App\Models\Classification\Classification';
				$data = array(
					'classification_name',
					'class_id',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search);
				return json_encode($response);
			}
		}
	}
}
