<?php
namespace App\Models\SMS;
use Illuminate\Database\Eloquent\Model;

class DateExcemption extends Model{
    
    protected $table = 'sms_date_excemption';
    
    public $timestamps = false;
    
    protected $primaryKey = 'sms_date_excemption_id';

    protected $fillable = array('class_id','class_group_id','member_id','occurance','message','start_date_time','end_date_time');
    
    protected $guarded = array('sms_date_excemption_id');

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
