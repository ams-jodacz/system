<?php
namespace App\Http\Controllers\SMS;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\SMS\Prefix as Prefix;
use Request;
use Input;
use Controller;

class PrefixController extends Controller {
	protected $page_module = 9;
	protected $page_id = 22;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.sms_prefix.sms_prefix',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!Prefix::find($id)){
			return view('common.invalid_modal',array('msg' => 'Unable to find prefix!'));
		}
		return view('content.sms_prefix.modal.sms_prefix_info',array('prefix_info' => Prefix::find($id)));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('prefix') && Input::has('sms_prefix_group_id')){
							$sms_prefix_group_id = Input::get('sms_prefix_group_id');
							$prefix = Input::get('prefix');
							$group = Prefix::where(
								array(
									'sms_prefix_group_id' => $sms_prefix_group_id,
									'prefix' => $prefix,
								)
							)->get();
							if (count($group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addPrefix':
						if (Request::isMethod('post') && Input::has('prefix')){
							$prefix_detail = json_decode(Input::get('prefix'),TRUE);
							$prefix = Prefix::where(
								array(
									'sms_prefix_group_id' => $prefix_detail['sms_prefix_group_id'],
									'prefix' => $prefix_detail['prefix'],
								)
							)->get();
							if (count($prefix) > 0){
								return json_encode(array('msg'=>'Unable to add prefix, Please try again later!'));
							}
							else{
								$prefix = new Prefix;
								$prefix->fill($prefix_detail);
								if ($prefix->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Added Prefix!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Prefix!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.sms_prefix.sms_prefix_form');
	}

	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('prefix') && Input::has('sms_prefix_group_id')){
							$sms_prefix_group_id = Input::get('sms_prefix_group_id');
							$prefix = Input::get('prefix');
							$group = Prefix::where(
								array(
									'sms_prefix_group_id' => $sms_prefix_group_id,
									'prefix' => $prefix,
								)
							)->where('sms_prefix_id','<>',$id)->get();
							if (count($group) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'updatePrefix':
						if (Request::isMethod('post') && Input::has('prefix')){
							$prefix_detail = json_decode(Input::get('prefix'),TRUE);
							$prefix = Prefix::where(
								array(
									'sms_prefix_group_id' => $prefix_detail['sms_prefix_group_id'],
									'prefix' => $prefix_detail['prefix'],
								)
							)->where(
								'sms_prefix_id','<>',$id
							)->get();
							if (count($prefix) > 0){
								return json_encode(array('msg'=>'Unable to update prefix, Please try again later!'));
							}
							else{
								$prefix = Prefix::find($id);
								$prefix->fill($prefix_detail);
								if ($prefix->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Updated Prefix!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Update Prefix!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		$prefix_data = Prefix::find($id);
		return view('content.sms_prefix.sms_prefix_form',array('prefix_data'=>$prefix_data));
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (Prefix::find($id)){
				$prefix = Prefix::find($id);
				if ($prefix->delete()){
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
				$model_name = 'App\Models\SMS\Prefix';
				$data = array(
					'sms_prefix_group.group_name',
					'prefix',
					'sms_prefix_id',
				);
				$join = array(
					'sms_prefix_group,sms_prefix_group.sms_prefix_group_id,=,sms_prefix_list.sms_prefix_group_id,inner',
				);
				$start = Input::get('start');
				$length = Input::get('length');
				$search = Input::get('search');
				$order = Input::get('order');
				$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$join);
				return json_encode($response);
			}
		}
	}
}
