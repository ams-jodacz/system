<?php
namespace App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;

class AttendanceAccess extends Model{
    
    protected $table = 'attendance_access';
    
    public $timestamps = false;
    
    protected $primaryKey = 'access_id';

    protected $fillable = array('class_group_id','attendance_group_id');
    
    protected $guarded = array('access_id');

//Joins
    //Attendance Group
    public function group()
    {
        return $this->belongsTo('App\Models\Attendance\AttendanceGroup','attendance_group_id','attendance_group_id');
    }

    //Classification Group
    public function classificationGroup(){
        return $this->belongsTo('App\Models\Classification\ClassificationGroup','class_group_id','class_group_id');
    }
}
