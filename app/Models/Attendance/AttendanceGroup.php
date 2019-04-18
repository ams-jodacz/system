<?php
namespace App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;

class AttendanceGroup extends Model{
    
    protected $table = 'attendance_group';
    
    public $timestamps = false;
    
    protected $primaryKey = 'attendance_group_id';

    protected $fillable = array('group_name');
    
    protected $guarded = array('attendance_group_id');

//Joins
    //Attendance Station
    public function station()
    {
        return $this->hasMany('App\Models\Attendance\AttendanceStation','attendance_group_id','attendance_group_id');
    }

    //Attendance Access
    public function access(){
        return $this->hasMany('App\Models\Attendance\AttendanceAccess','attendance_group_id','attendance_group_id');
    }
}
