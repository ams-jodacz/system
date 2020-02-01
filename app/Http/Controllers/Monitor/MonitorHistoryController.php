<?php
namespace App\Http\Controllers\Monitor;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Members\Member as Member;
use App\Models\Guests\Guest as Guest;
use App\Models\Guests\GuestTag as GuestTag;
use App\Models\Stations\StationGroup as StationGroup;
use App\Models\Logs\TimeLog as TimeLog;
use Carbon\Carbon as Carbon;
use Request;
use Input;
use Controller;

class MonitorHistoryController extends Controller {
    protected $page_module = 7;
	protected $page_id = 30;

	public function __construct()
	{
	    $this->middleware('auth');
	}
        
	public function index(){
		$this->checkModule();
		$action_value = Permission::getPageAction($this->page_module,$this->page_id);
		return view('content.monitor_history.monitor_history',array('action_value'=>$action_value));
	}
	
	public function view($id){
		$this->checkPageAction($this->page_id,Action::$View);
		if (Input::has('classType')){
			$classType = Input::get('classType');
			switch ($classType) {
				case 'tags':
					if (Input::has('guest_group_id')){
						$guest_group_id = Input::get('guest_group_id');
						$guest = Guest::where('return_date_time','=',null)->get(array('tag_id'));
						$guest_tags = GuestTag::where('guest_group_id',$guest_group_id)->whereNotIn('tag_id',$guest->toArray())->get();
						$data = array();
						foreach ($guest_tags as $guest_tag) {
							$data[] = array(
								'id' => $guest_tag->tag_id,
								'text' => $guest_tag->tag_name
							);
						}
						return json_encode($data);
					}
					break;
			}
		}
		if ($id != '0'){
			$format = explode('-', $id);
			if (count($format) < 2){
				return view('common.invalid_modal',array('msg' => 'Invalid id number format!'));
			}
			$id = $format[1];
			$id_format = $format[0];
			if ($id_format == 'm' && Member::find($id)){
				$member = Member::find($id);
				return view('content.member.modal.member_info',array('member_info' => $member));
			}
			else if ($id_format == 'g' && Guest::find($id)){
				$guest = Guest::find($id);
				return view('content.guest.modal.guest_log_info',array('guest_log_info' => $guest));
			}
		}
		return view('common.invalid_modal',array('msg' => 'Unable to find data!'));
	}

	public function data(){
		$this->checkPageAction($this->page_id,Action::$View);

		$start = Input::has('start')?Input::get('start'):0;
		$length = Input::has('length')?Input::get('length'):10;
		$search = Input::has('search')?Input::get('search'):array();
		$order = Input::has('order')?Input::get('order'):array();
		$selected_id = Input::has('selected_id')?Input::get('selected_id'):'';
		$page = Input::has('page')?Input::get('page'):1;
		
		if (Request::ajax())
		{
			$select = array(
				'station_group.group_name',
				'stations.name',
				'id_number',
				'date_time',
				'stations.status',
			);


			$model = TimeLog::select($select)
				->join('stations','stations.station_id','=','time_logs.station_id')
				->join('station_group','station_group.station_group_id','=','stations.station_group_id');

			if (isset($search) && isset($search['value']) && !empty($search['value'])){
				$new_search = $search['value'];
				$model = $model->where(function($q) use ($new_search,$select){
					$q->where($select[0],'like',$new_search.'%')
						->orWhere($select[1],'like',$new_search.'%')
						->orWhere($select[2],'like',$new_search.'%');
				});
			}

			$group_id = Input::has('group_id')?Input::get('group_id'):null;
			if (!empty($group_id) && $group_id != ''){
				$model = $model->where('station_group.station_group_id',$group_id);
			}

			$start_date_time = Input::has('date_time_start')?Input::get('date_time_start'):null;
			if (!empty($start_date_time) && $start_date_time != ''){
				$start_date_time = Carbon::createFromFormat('M d, Y h:i a',$start_date_time);
			}

			$end_date_time = Input::has('date_time_end')?Input::get('date_time_end'):null;
			if (!empty($end_date_time) && $end_date_time != ''){
				$end_date_time = Carbon::createFromFormat('M d, Y h:i a',$end_date_time);
			}

			if (!empty($start_date_time) && !empty($end_date_time)){
				$model = $model->whereBetween('date_time',[$start_date_time,$end_date_time]);
			}

			$model = $model->skip($start)->take($length+1);
			if (count($order) > 0){
				foreach($order as $sort){
					$model = $model->orderBy($select[$sort['column']],$sort['dir']);
				}
			}
			
			$data = $model->get();
			$total = $length+$start;
			if (count($data) > $length){
				$total += 1;
				unset($data[count($data)-1]);
			}

			
			foreach ($data as &$info) {
				$member = Member::where('id_number',$info->id_number)->first();
				$guest_tag = GuestTag::where('id_number',$info->id_number)->first();
				$info->id = 0;
				if (!empty($member) && $member != null){
					$info->full_name = $member->memberInformation->first_name.' '.$member->memberInformation->middle_name.' '.$member->memberInformation->last_name;
					$info->id = 'm-'.$member->member_id;
				}
				else if (!empty($guest_tag) && $guest_tag != null){
					$guest = Guest::where('tag_id',$guest_tag->tag_id)
						->whereNotNull('return_date_time')
						->where('borrow_date_time','<',$info->date_time)
						->where('return_date_time','>',$info->date_time)
						->orderBy('borrow_date_time','desc')
						->first();
					if (empty($guest)){
						$guest = Guest::where('tag_id',$guest_tag->tag_id)
							->whereNull('return_date_time')
							->where('borrow_date_time','<',$info->date_time)
							->where('return_date_time','=',NULL)
							->orderBy('borrow_date_time','desc')
							->first();
					}
					if (empty($guest)){
						$info->full_name = 'No User But Used!';
					}
					else{
						$info->full_name = $guest->users;
						$info->id = 'g-'.$guest->id;
					}
				}
				else{
					$info->full_name = 'Invalid ID Number Added!';
				}
				$info->date_time = Carbon::createFromFormat('Y-m-d H:i:s',$info->date_time)->format('m-d-y h:i:s a');
				if (file_exists('images/'.$info->id_number.'.jpg')){
					$info->image = $info->id_number.'.jpg';
				}
				else{
					$info->image = 'avatar.png';
				}
			}

			return json_encode(array(
				'data' => $data,
				'recordsTotal' => $total,
				'recordsFiltered' => $total,
			));
		}
	}
	
}

