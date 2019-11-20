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
use App\Helper\Socket;

class MonitorPublic extends Controller {
	
	public function index(){
		$station_group_id = Request::has('station_group')?Request::get('station_group'):0;
		$station_group = StationGroup::find($station_group_id);
		$total_in = 0;
		$total_out = 0;
		$in_stations = array();
		$out_stations = array();

		$station_id_list = array();
		if (!empty($station_group) && count($station_group->station) > 0){
			foreach ($station_group->station as $station) {
				if ($station->status == 'In'){
					$total_in++;
					$in_stations[] = $station;
					$station_id_list[] = $station->station_id;
				}
				else if ($station->status == 'Out'){
					$total_out++;
					$out_stations[] = $station;
					$station_id_list[] = $station->station_id;
				}
			}
		}

		return view('content.monitor_public.monitor_public',array(
			'school' => '',
			'port' => Socket::getPort(),
			'host' => Socket::getHost(),
			'station_ids' => $station_id_list,
			'station_group' => $station_group,
			'in_stations' => $in_stations,
			'out_stations' => $out_stations,
			'in_span' => $total_in > 4?3:$total_in != 0?(12/$total_in):0,
			'out_span' => $total_out > 4?3:$total_out != 0?(12/$total_out):0,
		));
	}

	public function data(){
		if (Request::ajax() && Input::has('group_id') && Input::has('type'))
		{
			$group_id = Input::get('group_id');
			$type = Input::get('type');

			switch ($type) {
				case 'station_profile':
					$station_group = StationGroup::find($group_id);
					$station_data = array();
					$current_time = Carbon::now();
					if (!is_null($station_group) && !empty($station_group)){
						foreach ($station_group->station as $station) {
							$data = $station->timeLogs()->orderBy('date_time','desc')->first();
							// 
							if (empty($data)){
								continue;
							}
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
							$data_data_time = Carbon::createFromFormat('Y-m-d H:i:s',$data->date_time);
							$data->date_time = $data_data_time->format('m-d-y h:i:s a');
							$data->time_diff = $current_time->diffInMinutes($data_data_time);
							if (file_exists('images/'.$data->id_number.'.jpg')){
								$data->image = $data->id_number.'.jpg';
							}
							else{
								$data->image = 'gender.jpg';
							}
							//
							$info = $data;
							$info->station_id = $station->station_id;
							$station_data[] = $info;
						}
					}
					return json_encode(array('station_data' => $station_data));
					break;
			}
		}
	}
	
}

