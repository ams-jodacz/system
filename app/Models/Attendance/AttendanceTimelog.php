<?php
namespace App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;

class AttendanceTimelog extends Model{
    
    protected $table = 'attendance_time_logs';
    
    public $timestamps = false;
    
    // protected $primaryKey = '';

    protected $fillable = array('attendance_station_id','id_number','date_time','status');
    
    // protected $guarded = array('');

//Joins
    //Attendance Group
    public function station()
    {
        return $this->belongsTo('App\Models\Attendance\AttendanceStation','attendance_station_id','attendance_station_id');
    }

    //Classification Group
    public function member(){
        return $this->belongsTo('App\Models\Members\Member','id_number','id_number');
    }
}
