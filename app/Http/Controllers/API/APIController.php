<?php
namespace App\Http\Controllers\API;
use App\Models\Members\Member as Member;
use App\Models\Members\MemberInformation as MemberInformation;
use App\Models\Members\Recipient as Recipient;
use App\Models\Classification\Classification as Classification;
use App\Models\Classification\ClassificationGroup as ClassificationGroup;
use App\Models\Stations\Station as Station;
use App\Models\Stations\StationGroup as StationGroup;
use App\Models\Logs\TimeLog as TimeLog;
use App\Models\Attendance\AttendanceStation as AttendanceStation;
use App\Models\Attendance\AttendanceTimelog as AttendanceTimelog;
use App\Models\Tags\Tag as Tag;
use App\Models\Guests\Guest as Guest;
use App\Models\Guests\GuestTag as GuestTag;
use App\Models\Access\StationAccess as StationAccess;
use App\Models\Guests\GuestAccess as GuestAccess;
use App\Models\Attendance\AttendanceAccess as AttendanceAccess;
use Request;
use Input;
use URL;
use Controller;
use Carbon\Carbon as Carbon;
use App\Models\Prism\PrismViews as PrismViews;
use App\Helper\Socket;
use DB;

class APIController extends Controller {

	public function __construct()
	{
	    // $this->middleware('auth');
	}
	
	public function index(){
		if (Input::has('type')){
			$type = Input::get('type');
			switch($type){
				//general
				case 'time':
					return Carbon::now()->format('m/d/Y H:i:s');
					break;
				// Tag Registration
				case 'tag':
					$status = false;
					$msg = 'Invalid Data Format';
					if (Input::has('id_number') && Input::has('tag')){
						$id_number = Input::get('id_number');
						$tag_number = Input::get('tag');

						$valid_tag_status = true;

						$tags = Tag::where('tag',$tag_number)->where('id_number','<>',$id_number)->get();
						if (count($tags) > 0){
							$msg = 'Tag already exists for another user!';
							$valid_tag_status = false;
						}

						$tags = GuestTag::where('tag',$tag_number)->where('id_number','<>',$id_number)->get();
						if (count($tags) > 0){
							$msg = 'Tag already exists for another user!';
							$valid_tag_status = false;
						}

						if ($valid_tag_status){
							$member = Member::where(
								array(
									'id_number' => $id_number,
								)
							)->first();
							if (!is_null($member) && !empty($member)){
								$tag = Tag::where(array('id_number' => $id_number))->first();
								if (!is_null($tag) && !empty($tag)){
									$tag->tag = $tag_number;
									if ($tag->save()){
										$status = true;
										$msg = 'Succesfully Updated Tag!';
									}
								}
								else{
									$tag = new Tag;
									$tag->id_number = $id_number;
									$tag->tag = $tag_number;
									if ($tag->save()){
										$status = true;
										$msg = 'Succesfully Added Tag!';
									}
								}
							}
							$guest = GuestTag::where(
								array(
									'id_number' => $id_number,
								)
							)->first();
							if (!is_null($guest) && !empty($guest)){
								$guest->tag = $tag_number;
								if ($guest->save()){
									$status = true;
									$msg = 'Succesfully Added/Updated Tag!';
								}
							}
						}
						
						if (!$status){
							$msg = "Unable to register tag, Please check ID Number!";
						}
					}
					return json_encode(
						array(
							'status' => $status,
							'msg' => $msg,
						)
					);
					break;
				case 'check_tag':
					$valid_tag_status = true;
					if (Input::has('tag')){
						$tag_number = Input::get('tag');
						$tags = Tag::where('tag',$tag_number)->get();
						if (count($tags) > 0){
							$valid_tag_status = false;
						}

						$tags = GuestTag::where('tag',$tag_number)->get();
						if (count($tags) > 0){
							$valid_tag_status = false;
						}
					}

					$msg = "";
					if ($valid_tag_status){
						$msg = "Tag is not yet used!";
					}
					else{
						$msg = "Tag is already been used!";
					}
					return json_encode(
						array(
							'status' => $valid_tag_status,
							'msg' => $msg,
						)
					);
					break;
				// Turnstile monitoring
				case 'change_restart_status':
					if (Input::has('ip')){
						$ip = Input::get('ip');
						$station = Station::where(
							array(
								'ip' => $ip
							)
						)->first();
						if (!empty($station)){
							$station->restart_status = false;
							if ($station->save()){
								return json_encode(
									array(
										'status' => true
									)
								);
							}
						}
					}
					return json_encode(
						array(
							'status' => false
						)
					);
					break;
				// Attendance
				case 'attendance': // get allowed user for attendance per station
					if (Input::has('ip')){
						$ip = Input::get('ip');

						$station = AttendanceStation::where(
							array(
								'ip' => $ip,
							)
						)->first();

						$info = array();
						if (!empty($station) && $station->enable_status){
							foreach ($station->group->access as $access) {
								foreach ($access->classificationGroup->member()->where('active_status',true)->get() as $data) {
									if (is_null($data->memberInformation) || is_null($data->tag)){
										continue;
									}
									$info[] = array(
										'ID_Number' => $data->id_number,
										'Name' => $data->memberInformation->first_name.' '.$data->memberInformation->middle_name.' '.$data->memberInformation->last_name,
										'Img' => $data->memberInformation->image,
										'Tag' => $data->tag->tag,
									);
								}
							};
						}
						return json_encode($info);
					}
					break;
				case 'attendance_timelog':
					$status = false;
					if (Input::has('ip') && Input::has('date_time') && Input::has('id_number') && Input::has('status')){
						$ip = Input::get('ip');
						$date_time = Input::get('date_time');
						$id_number = Input::get('id_number');
						$status = Input::get('status');

						$date_time = Carbon::createFromFormat('m/d/Y h:i:s a',$date_time)->format('Y-m-d H:i:s');

						$station = AttendanceStation::where(
							array(
								'ip' => $ip,
							)
						)->first();

						if (!empty($station)){
							$timelog = new AttendanceTimelog;
							$timelog->fill(
								array(
									'attendance_station_id' => $station->attendance_station_id,
									'id_number' => $id_number,
									'date_time' => $date_time,
									'status' => $status
								)
							);
							if ($timelog->save()){
								$status = true;
							}
						}
					}
					return json_encode(
						array(
							'status' => $status
						)
					);
					break;
					
				//Turnstile loging
				case 'access_check':
					$status = false;
					if (Input::has('ip') && Input::has('tag')){
						$ip = Input::get('ip');
						$tag_number = Input::get('tag');

						$station = Station::where('ip',$ip)->first();
						if (!is_null($station) && !empty($station)){
							$socket_data = array();
							//check if valid member
							$tags = Tag::where('tag',$tag_number)->first();
							if (!is_null($tags) && !empty($tags)){
								$member = Member::where('id_number',$tags->id_number)->first();
								if (!is_null($member) && !empty($member)){
									$access_list = StationAccess::where(array(
										'class_group_id' => $member->class_group_id,
										'station_group_id' => $station->station_group_id
									))->get();
									if (count($access_list) > 0){
										$current_time = Carbon::now();
										//add time log
										$timelog = new TimeLog;
										$timelog->station_id = $station->station_id;
										$timelog->id_number = $member->id_number;
										$timelog->date_time = $current_time;
										$timelog->save();

										$img_path = 'avatar.png';
										if (file_exists('images/'.$member->id_number.'.jpg')){
											$img_path = $member->id_number.'.jpg';
										}

										$socket_data = array(
											'station_id' => $station->station_id,
											'id_number' => $member->id_number,
											'date_time' => $current_time->format('m-d-y h:i:s a'),
											'id' => 'm-'.$member->member_id,
											'full_name' => $member->memberInformation->first_name.' '.$member->memberInformation->middle_name.' '.$member->memberInformation->last_name,
											'image' => $img_path,
										);

										$status = true;
									}
								}
							}
							else{
								//check if guess
								$tags = GuestTag::where('tag',$tag_number)->first();
								if (!is_null($tags) && !empty($tags)){
									$access_list = GuestAccess::where(array(
										'guest_group_id' => $tags->guest_group_id,
										'station_group_id' => $station->station_group_id
									))->get();
									if (count($access_list) > 0){
										$current_time = Carbon::now();

										//add time log
										$timelog = new TimeLog;
										$timelog->station_id = $station->station_id;
										$timelog->id_number = $tags->id_number;
										$timelog->date_time = $current_time;
										$timelog->save();
										$status = true;

										$full_name = 'No User But Used!';
										$guest_id = '';

										$guest = Guest::where('tag_id',$tags->tag_id)
											->whereNotNull('return_date_time')
											->where('borrow_date_time','<',$current_time)
											->where('return_date_time','>',$current_time)
											->orderBy('borrow_date_time','desc')
											->first();
										if (empty($guest)){
											$guest = Guest::where('tag_id',$tags->tag_id)
												->whereNull('return_date_time')
												->where('borrow_date_time','<',$current_time)
												->orderBy('borrow_date_time','desc')
												->first();
										}

										if (!empty($guest)){
											$full_name = $guest->users;
											$guest_id = 'g-'.$guest->id;
										}

										$img_path = 'avatar.png';
										if (file_exists('images/'.$tags->id_number.'.jpg')){
											$img_path = $tags->id_number.'.jpg';
										}

										$socket_data = array(
											'station_id' => $station->station_id,
											'id_number' => $tags->id_number,
											'date_time' => $current_time->format('m-d-y h:i:s a'),
											'id' => $guest_id,
											'full_name' => $full_name,
											'image' => $img_path,
										);

									}
								}
							}

							if ($status && !empty($socket_data)){
								Socket::sendData(json_encode($socket_data));
							}
						}
					}
					return json_encode(
						array(
							'status' => $status,
						)
					);
				//Attendance Loging
				case 'attendance_check':
					$status = true	;
					$img = URL::to('/images/avatar.png');
					// $info = array(
					// 	'first_name' => 'Sample',
					// 	'last_name' => 'Sample',
					// 	'image_loc' => $img,
					// );

					if (Input::has('ip') && Input::has('tag')){
						$ip = Input::get('ip');
						$tag_number = Input::get('tag');

						$station = AttendanceStation::where('ip',$ip)->first();
						$tags = Tag::where('tag',$tag_number)->first();
						if (!is_null($station) && !empty($station) && !is_null($tags) && !empty($tags)){
							$member = Member::where('id_number',$tags->id_number)->first();
							if (!is_null($member) && !empty($member)){
								$access_list = AttendanceAccess::where(array(
									'class_group_id' => $member->class_group_id,
									'attendance_group_id' => $station->attendance_group_id
								))->get();
								if (count($access_list) > 0){
									//add time log
									$timelog = new AttendanceTimelog;
									$timelog->fill(
										array(
											'attendance_station_id' => $station->attendance_station_id,
											'id_number' => $member->id_number,
											'date_time' => Carbon::now(),
										)
									);
									$timelog->save();
									$status = true;
									if (file_exists('images/'.$member->id_number.'.jpg')){
										$img = URL::to('/images/'.$data->id_number.'.jpg');
									}
									$info = array(
										'first_name' => $member->memberInformation->first_name,
										'last_name' => $member->memberInformation->last_name,
										'image_loc' => $img,
									);
								}
							}
						}
					}
					return json_encode(
						array(
							'status' => $status,
							'info' => $info,
						)
					);
				//ERROR
				case 'error':
					break;
				case 'check_prism_return':
					if (Input::has('term_id')){
						$term_id = Input::get('term_id');
						echo '<pre>';
						$data = PrismViews::getOfficialK12List($term_id);
						print_r($data);
					}
					break;
				case 'timelogs':
					if (Input::has('start_date') && Input::has('end_date')){
						$start_date = null;
						$end_date = null;
						if (Input::has('start_date')){
							try {
								$start_date = Carbon::parse(Input::get('start_date'));
							}
							catch (Throwable $e) {
							}
						}
						if (Input::has('end_date')){
							try {
								$end_date = Carbon::parse(Input::get('end_date'));
							}
							catch (Throwable $e) {
							}
						}
						if ($start_date != null && $end_date != null){
							$id_number = Input::has('id_numbers')?Input::get('id_numbers'):'';
							$id_number_list = array();
							if ($id_number != ''){
								$id_number_list = explode(',',$id_number);
							}
							if ($start_date->diffInDays($end_date, false) >= 0){
								$start_date->hour = 0;
								$start_date->minute = 0;
								$start_date->second = 0;

								$end_date->hour = 23;
								$end_date->minute = 59;
								$end_date->second = 59;
								
								$log_data = TimeLog::whereBetween('date_time',array($start_date,$end_date))->orderBy('date_time','asc');
								if (count($id_number_list) > 0){
									$log_data = $log_data->whereIn('id_number',$id_number_list);
								}
								
								$data_list = $log_data->select(array(
									'id_number',
									DB::raw('DATE_FORMAT(date_time,"%Y/%m/%d %h:%i:%s") as date')
								))->get();
								if (count($data_list) > 0){
									return json_encode(
										array(
											'error' => false,
											'data' =>$data_list->toArray()
										)
									);
								}
								else{
									return json_encode(
										array(
											'error'=>false,
											'data' => array(),
										)
									);
								}
							}
						}
					}
					return json_encode(
						array(
							'error'=>true,
							'message'=>'Unknow Request'
						)
					);
					break;
			}
		}
		return json_encode(array('station'=>'Invalid Request','message'=>'Unknow Request'));
	}
}
