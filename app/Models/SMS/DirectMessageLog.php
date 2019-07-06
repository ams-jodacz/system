<?php
namespace App\Models\SMS;
use Illuminate\Database\Eloquent\Model;

class DirectMessageLog extends Model{
    
    protected $table = 'sms_direct_message_logs';
    
    public $timestamps = false;
    
    protected $primaryKey = 'direct_message_id';

    protected $fillable = array('class_id','class_group_id','member_id','message','send_date_time');
    
    protected $guarded = array('direct_message_id');

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
