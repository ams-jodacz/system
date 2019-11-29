<?php
namespace App\Http\Controllers;
use App\Models\ACL\User as User;
use App\Models\Members\MemberInformation as MemberInformation;
use Auth;
use Input;
use DB;
use Carbon\Carbon as Carbon;
use App\Models\Logs\TimeLog as TimeLog;

class DashboardController extends Controller {
	public function __construct()
	{
	    $this->middleware('auth');
	}

	protected $layout = 'main';
	
	public function index(){
		return view('content.dashboard');
	}

	public function data(){
		$type = Input::has('type')?Input::get('type'):'';
		if (Input::ajax())
		{
			$start = Input::has('start')?Input::get('start'):0;
			$length = Input::has('length')?Input::get('length'):10;
			$search = Input::has('search')?Input::get('search'):array();
			$order = Input::has('order')?Input::get('order'):array();
			$selected_id = Input::has('selected_id')?Input::get('selected_id'):'';
			$page = Input::has('page')?Input::get('page'):1;

			switch($type){
				case 'member_list':
					$select_raw = array(
						DB::raw('concat(last_name,", ",first_name,middle_name) as name'),
						'member_id',
					);

					$select = array(
						'last_name',
						'first_name',
						'middle_name',
						'member_id'
					);

					$model = MemberInformation::select($select_raw);

					if (isset($search) && !empty($search)){
						$new_search = $search;
						$model = $model->where(function($q) use ($new_search,$select){
							$q->where($select[0],'like',$new_search.'%');
							$q->orWhere($select[1],'like',$new_search.'%');
							$q->orWhere($select[2],'like',$new_search.'%');
						});
					}
					

					$start = $length * ($page-1);
					$model = $model->skip($start)->take($length+1);
					// if (count($order) > 0){
					// 	foreach($order as $sort){
					// 		$model = $model->orderBy($select[$sort['column']],$sort['dir']);
					// 	}
					// }
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
						$info->id = empty($info->member_id)?'Unknown':$info->member_id;
						unset($info->member_id);

						$info->text = empty($info->name)?'Unknown':$info->name;
						unset($info->name);
					}

					return json_encode(array(
						'results' => $data,
						'more' => $more,
					));

					break;

				case 'report':
					$member_id = Input::has('member_id')?Input::get('member_id'):0;
					$date_start = Input::has('date_start')?Input::get('date_start'):'';
					$date_end = Input::has('date_end')?Input::get('date_end'):'';
					
					if (!MemberInformation::find($member_id)){
						return json_encode(array(
							'status' => false,
							'message' => 'Unable to find Member information!',
						));
					}

					if ($date_start == '' || $date_end == ''){
						return json_encode(array(
							'status' => false,
							'message' => 'Problem processing the dates, Please check date interval!',
						));
					}

					$date_start = Carbon::createFromFormat('m/d/Y',$date_start);
					$date_end = Carbon::createFromFormat('m/d/Y',$date_end);
					if ($date_start->diffInDays($date_end, false) >= 0){
						$date_start->hour = 0;
						$date_start->minute = 0;
						$date_start->second = 0;

						$date_end->hour = 23;
						$date_end->minute = 59;
						$date_end->second = 59;

						$member_info = MemberInformation::find($member_id);
						$log_data = TimeLog::where()->whereBetween('date_time',array($date_start,$date_end))->orderBy('date_time','asc')->get();
						return json_encode(array(
							'status' => true,
							'content' => view('content.reports.dtr',array(
								'member_info' => $member_info,
								'start_date' => $date_start,
								'end_date' => $date_end,
								'logs' => $log_data,
							))->render(),
							'message' => '',
						));
					}
					else{
						return json_encode(array(
							'status' => false,
							'content' => '',
							'message' => 'Problem processing the dates, Please check date interval!',
						));
					}

					return json_encode(array(
						'status' => false,
						'content' => '',
						'message' => 'Unexpected error encounter, Please try again!',
					));
					break;
			}
		}
	}
}
