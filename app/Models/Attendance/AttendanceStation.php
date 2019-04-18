<?php
namespace App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;

class AttendanceStation extends Model{
    
    protected $table = 'attendance_station';
    
    public $timestamps = false;
    
    protected $primaryKey = 'attendance_station_id';

    protected $fillable = array('ip','name','description','enable_status','attendance_group_id');
    
    protected $guarded = array('attendance_station_id');

//Joins
    //Attendance Group
    public function group()
    {
        return $this->belongsTo('App\Models\Attendance\AttendanceGroup','attendance_group_id','attendance_group_id');
    }

    //Classification Group
    public function timelogs(){
        return $this->hasMany('App\Models\Attendance\AttendanceTimelog','attendance_station_id','attendance_station_id');
    }
}
