<?php 
namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\ACL\User as User;
use App\Models\ACL\Permission as Permission;
use App;

abstract class Controller extends BaseController {
	use DispatchesCommands, ValidatesRequests;
	
	protected $page_module = 0;
	
	protected function checkModule(){
		if ($this->page_module){
			if (User::checkUserModule($this->page_module)){
				return;
			}
		}
		$this->diplayError();
	}
	
	protected function checkPage($page_id){
		if ($this->page_module){
			$this->checkModule();
			if (User::checkUserPages($this->page_module,$page_id)){
				return;
			}
		}
		$this->diplayError();
	}
	
	protected function checkPageAction($page_id,$action){
		$this->checkModule();
		$this->checkPage($page_id);
		if (Permission::getPageAction($this->page_module,$page_id)&$action){
			return;
		}
		$this->diplayError();
	}
	
	protected function diplayError($error = 403,$msg = 'Unauthorized action.'){
		App::abort($error, $msg);
	}
	
	protected function filterData($model_name,$data,$start,$length,$order,$search,$joins = array(),$where = array(),$where_raw = ''){
		$response = array();
		$length += 1;
		if ($where_raw == ''){
			if (empty($joins)){
				if ($search['value'] == ''){
					// $response['recordsTotal'] = $model_name::where($where)->count();
					if (isset($order[0]['column'])){
						$response['data'] = $model_name::orderBy($data[$order[0]['column']],$order[0]['dir'])
								->where($where)
								->take($length)
								->skip($start)
								->get();
					}
					else{
						$response['data'] = $model_name::where($where)
								->take($length)
								->skip($start)
								->get();
					}
				}
				else{
					// $response['recordsTotal'] = $model_name::where(function($query) use ($data,$search){
					// 			foreach($data as $column) {
					// 				$query->orWhere($column, 'like', "%{$search['value']}%");
					// 			}
					// 		})
					// 		->where($where)
					// 		->count();
					if (isset($order[0]['column'])){
						$response['data'] = $model_name::where(function($query) use ($data,$search){
									foreach($data as $column) {
										$query->orWhere($column, 'like', "%{$search['value']}%");
									}
								})
								->where($where)
								->orderBy($data[$order[0]['column']],$order[0]['dir'])
								->take($length)
								->skip($start)
								->get();
					}
					else{
						$response['data'] = $model_name::where(function($query) use ($data,$search){
									foreach($data as $column) {
										$query->orWhere($column, 'like', "%{$search['value']}%");
									}
								})
								->where($where)
								->take($length)
								->skip($start)
								->get();
					}
				}
			}
			else{
				$model = null;
				foreach($joins as $join){
					$split_join = explode(',',$join);
					if ($model == null)
						$model = $model_name::join($split_join[0],$split_join[1],$split_join[2],$split_join[3],$split_join[4]);
					else
						$model->join($split_join[0],$split_join[1],$split_join[2],$split_join[3],$split_join[4]);
				}
				if ($search['value'] == ''){
					// $response['recordsTotal'] = $model->where($where)
					// 		->count();
					if (isset($order[0]['column'])){
						$response['data'] = $model->orderBy($data[$order[0]['column']],$order[0]['dir'])
								->where($where)
								->take($length)
								->skip($start)
								->select($data)
								->get();
					}
					else{
						$response['data'] = $model->where($where)
								->take($length)
								->skip($start)
								->select($data)
								->get();
					}
				}
				else{
					// $response['recordsTotal'] = $model->where(function($query) use ($data,$search){
					// 			foreach($data as $column) {
					// 				$query->orWhere($column, 'like', "%{$search['value']}%");
					// 			}
					// 		})
					// 		->where($where)
					// 		->count();
					if (isset($order[0]['column'])){
						$response['data'] = $model->where(function($query) use ($data,$search){
									foreach($data as $column) {
										$query->orWhere($column, 'like', "%{$search['value']}%");
									}
								})
								->where($where)
								->orderBy($data[$order[0]['column']],$order[0]['dir'])
								->take($length)
								->skip($start)
								->select($data)
								->get();
					}
					else{
						$response['data'] = $model->where(function($query) use ($data,$search){
									foreach($data as $column) {
										$query->orWhere($column, 'like', "%{$search['value']}%");
									}
								})
								->where($where)
								->take($length)
								->skip($start)
								->select($data)
								->get();
					}
				}
			}
		}
		else{
			if (empty($joins)){
				if ($search['value'] == ''){
					// $response['recordsTotal'] = $model_name::where($where)->whereRaw($where_raw)->count();
					if (isset($order[0]['column'])){
						$response['data'] = $model_name::orderBy($data[$order[0]['column']],$order[0]['dir'])
								->where($where)
								->whereRaw($where_raw)
								->take($length)
								->skip($start)
								->get();
					}
					else{
						$response['data'] = $model_name::where($where)
								->whereRaw($where_raw)
								->take($length)
								->skip($start)
								->get();
					}
				}
				else{
					// $response['recordsTotal'] = $model_name::where(function($query) use ($data,$search){
					// 			foreach($data as $column) {
					// 				$query->orWhere($column, 'like', "%{$search['value']}%");
					// 			}
					// 		})
					// 		->where($where)
					// 		->whereRaw($where_raw)
					// 		->count();
					if (isset($order[0]['column'])){
						$response['data'] = $model_name::where(function($query) use ($data,$search){
									foreach($data as $column) {
										$query->orWhere($column, 'like', "%{$search['value']}%");
									}
								})
								->where($where)
								->whereRaw($where_raw)
								->orderBy($data[$order[0]['column']],$order[0]['dir'])
								->take($length)
								->skip($start)
								->get();
					}
					else{
						$response['data'] = $model_name::where(function($query) use ($data,$search){
									foreach($data as $column) {
										$query->orWhere($column, 'like', "%{$search['value']}%");
									}
								})
								->where($where)
								->whereRaw($where_raw)
								->take($length)
								->skip($start)
								->get();
					}
				}
			}
			else{
				$model = null;
				foreach($joins as $join){
					$split_join = explode(',',$join);
					if ($model == null)
						$model = $model_name::join($split_join[0],$split_join[1],$split_join[2],$split_join[3],$split_join[4]);
					else
						$model->join($split_join[0],$split_join[1],$split_join[2],$split_join[3],$split_join[4]);
				}
				if ($search['value'] == ''){
					// $response['recordsTotal'] = $model->where($where)
					// 		->whereRaw($where_raw)
					// 		->count();
					if (isset($order[0]['column'])){
						$response['data'] = $model->orderBy($data[$order[0]['column']],$order[0]['dir'])
								->where($where)
								->whereRaw($where_raw)
								->take($length)
								->skip($start)
								->select($data)
								->get();
					}
					else{
						$response['data'] = $model->where($where)
								->whereRaw($where_raw)
								->take($length)
								->skip($start)
								->select($data)
								->get();
					}
				}
				else{
					// $response['recordsTotal'] = $model->where(function($query) use ($data,$search){
					// 			foreach($data as $column) {
					// 				$query->orWhere($column, 'like', "%{$search['value']}%");
					// 			}
					// 		})
					// 		->where($where)
					// 		->whereRaw($where_raw)
					// 		->count();
					if (isset($order[0]['column'])){
						$response['data'] = $model->where(function($query) use ($data,$search){
									foreach($data as $column) {
										$query->orWhere($column, 'like', "%{$search['value']}%");
									}
								})
								->where($where)
								->whereRaw($where_raw)
								->orderBy($data[$order[0]['column']],$order[0]['dir'])
								->take($length)
								->skip($start)
								->select($data)
								->get();
					}
					else{
						$response['data'] = $model->where(function($query) use ($data,$search){
									foreach($data as $column) {
										$query->orWhere($column, 'like', "%{$search['value']}%");
									}
								})
								->where($where)
								->whereRaw($where_raw)
								->take($length)
								->skip($start)
								->select($data)
								->get();
					}
				}
			}
		}
		$total_data = count($response['data']);
		if ($total_data == $length){
			unset($response['data'][$total_data-1]);
		}
		$response['recordsFiltered'] = $response['recordsTotal'] = $start + $total_data;

		return $response;
	}
}
