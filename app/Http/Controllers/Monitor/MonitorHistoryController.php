<?php
namespace App\Http\Controllers\Monitor;
use App\Models\ACL\Permission as Permission;
use App\Models\ACL\User as User;
use App\Models\ACL\Action as Action;
use App\Models\Members\Member as Member;
use App\Models\Guests\Guest as Guest;
use App\Models\Guests\GuestTag as GuestTag;
use App\Models\Stations\StationGroup as StationGroup;
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
		if (Request::ajax())
		{
			$model_name = 'App\Models\Logs\TimeLog';
			$data = array(
				'station_group.group_name',
				'stations.name',
				'id_number',
				'date_time',
				'stations.status',
				// 'items',
				// 'id',
			);
			$joins = array(
				'stations,stations.station_id,=,time_logs.station_id,inner',
				'station_group,station_group.station_group_id,=,stations.station_group_id,inner',
			);
			$where = array();
			$start = Input::get('start');
			$length = Input::get('length');
			$search = Input::get('search');
			// $order = Input::get('order');
			$order = array(
				array(
					'column' => '3',
					'dir' => 'desc'
				)
			);
			$response = $this->filterData($model_name,$data,$start,$length,$order,$search,$joins,$where);
			foreach ($response['data'] as &$data) {
				$member = Member::where('id_number',$data->id_number)->first();
				$guest_tag = GuestTag::where('id_number',$data->id_number)->first();
				$data->id = 0;
				if (!empty($member) && $member != null){
					$data->full_name = $member->memberInformation->first_name.' '.$member->memberInformation->middle_name.' '.$member->memberInformation->last_name;
					$data->id = 'm-'.$member->member_id;
				}
				else if (!empty($guest_tag) && $guest_tag != null){
					$guest = Guest::where('tag_id',$guest_tag->tag_id)
						->whereNotNull('return_date_time')
						->where('borrow_date_time','<',$data->date_time)
						->where('return_date_time','>',$data->date_time)
						->orderBy('borrow_date_time','desc')
						->first();
					if (empty($guest)){
						$guest = Guest::where('tag_id',$guest_tag->tag_id)
							->whereNull('return_date_time')
							->where('borrow_date_time','<',$data->date_time)
							->where('return_date_time','=',NULL)
							->orderBy('borrow_date_time','desc')
							->first();
					}
					if (empty($guest)){
						$data->full_name = 'No User But Used!';
					}
					else{
						$data->full_name = $guest->users;
						$data->id = 'g-'.$guest->id;
					}
				}
				else{
					$data->full_name = 'Invalid ID Number Added!';
				}
				$data->date_time = Carbon::createFromFormat('Y-m-d H:i:s',$data->date_time)->format('m-d-y h:i:s a');
				if (file_exists('images/'.$data->id_number.'.jpg')){
					$data->image = $data->id_number.'.jpg';
				}
				else{
					$data->image = 'avatar.png';
				}
			}
			return json_encode($response);
		}
	}
	
}

