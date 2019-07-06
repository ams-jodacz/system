<?php
namespace App\Models\SMS;
use Illuminate\Database\Eloquent\Model;

class Blast extends Model{
    
    protected $table = 'sms_blast';
    
    public $timestamps = false;
    
    protected $primaryKey = 'sms_blast_id';

    protected $fillable = array('class_id','class_group_id','member_id','occurance','message','send_date_time');
    
    protected $guarded = array('sms_blast_id');

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

    public function occurance()
    {
        return $this->hasOne('App\Models\SMS\BlastOccurance','sms_blast_id','sms_blast_id');
    }
}
