<?php
namespace App\Models\SMS;
use Illuminate\Database\Eloquent\Model;

class LateAbsent extends Model{
    
    protected $table = 'sms_late_absent';
    
    public $timestamps = false;
    
    protected $primaryKey = 'sms_la_id';

    protected $fillable = array('class_id','class_group_id','member_id','description','late_message','absent_message','late_time','absent_time');
    
    protected $guarded = array('sms_la_id');

//Joins
    public function classification()
    {
        return $this->belongsTo('App\Models\Classification\Classification','class_id','class_id');
    }

    public function classificationGroup()
    {
        return $this->belongsTo('App\Models\Classification\ClassificationGroup','class_group_id','class_group_id');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Members\Member','member_id','member_id');
    }
}
