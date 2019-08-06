<?php
namespace App\Http\Controllers\SMS;
use App\Models\ACL\Action as Action;
use App\Models\ACL\Permission as Permission;
use App\Models\SMS\Server as Server;
use Request;
use Input;
use Controller;

class ServerController extends Controller {
	protected $page_module = 9;
	protected $page_id = 20;

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function index(){
		$this->checkPageAction($this->page_id,Action::$View);
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.sms_server.sms_server',array('action_value'=>$action_value));
	}

	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (!Server::find($id)){
			return view('common.invalid_modal',array('msg' => 'Unable to find Server!'));
		}
		return view('content.sms_server.modal.sms_server_info',array('sms_server_info' => Server::find($id)));
	}

	public function add(){
		$this->checkPageAction($this->page_id,Action::$Add);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('server_name')){
							$server_name = Input::get('server_name');
							$server = Server::where(array('server_name' => $server_name))->get();
							if (count($server) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'checkIP':
						if (Input::has('ip')){
							$ip = Input::get('ip');
							$server = Server::where(array('ip' => $ip))->get();
							if (count($server) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'addServer':
						if (Request::isMethod('post') && Input::has('server')){
							$server_detail = json_decode(Input::get('server'),TRUE);
							$server = Server::where(
								array(
									'server_name' => $server_detail['server_name'],
								)
							)->get();
							if (count($server) > 0){
								return json_encode(array('msg'=>'Unable to add server, Please try again later!'));
							}

							$server = Server::where(
								array(
									'ip' => $server_detail['ip'],
								)
							)->get();
							if (count($server) > 0){
								return json_encode(array('msg'=>'Unable to add server, Please try again later!'));
							}

							else{
								$server = new Server;
								$server->fill($server_detail);
								if ($server->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Added Server!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Add Server!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		return view('content.sms_server.sms_server_form');
	}

	public function edit($id){
		$this->checkPageAction($this->page_id,Action::$Edit);
		if (Request::ajax()){
			if (Input::has('actionType')){
				switch(Input::get('actionType')){
					case 'checkName':
						if (Input::has('server_name')){
							$server_name = Input::get('server_name');
							$server = Server::where(array('server_name' => $server_name))->where('sms_server_id','<>',$id)->get();
							if (count($server) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'checkIP':
						if (Input::has('ip')){
							$ip = Input::get('ip');
							$server = Server::where(array('ip' => $ip))->where('sms_server_id','<>',$id)->get();
							if (count($server) > 0){
								return 'false';
							}
						}
						return 'true';
						break;
					case 'updateServer':
						if (Request::isMethod('post') && Input::has('server')){
							$server_detail = json_decode(Input::get('server'),TRUE);
							$server = Server::where(
								array(
									'server_name' => $server_detail['server_name'],
								)
							)->where(
								'sms_server_id','<>',$id
							)->get();
							if (count($server) > 0){
								return json_encode(array('msg'=>'Unable to update server, Please try again later!'));
							}
							$server = Server::where(
								array(
									'ip' => $server_detail['ip'],
								)
							)->where(
								'sms_server_id','<>',$id
							)->get();
							if (count($server) > 0){
								return json_encode(array('msg'=>'Unable to update server, Please try again later!'));
							}
							else{
								$server = Server::find($id);
								$server->fill($server_detail);
								if ($server->save()){
									return json_encode(array('status'=>'true','msg'=>'Successfully Updated Server!'));
								}
								return json_encode(array('status'=>'false','msg'=>'Unable To Update Server!'));
								
							}
						}
						return json_encode(array('status'=>'false','msg'=>'Invalid Request!'));
						break;
				}
			}
		}
		$server_data = Server::find($id);
		return view('content.sms_server.sms_server_form',array('server_data'=>$server_data));
	}

	public function delete($id){
		$this->checkPageAction($this->page_id,Action::$Delete);
		if (Request::ajax()){
			if (Server::find($id)){
				$server = Server::find($id);
				if ($server->delete()){
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
				$model_name = 'App\Models\SMS\Server';
				$data = array(
					'server_name',
					'ip',
					'username',
					'password',
					'sms_server_id',
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
