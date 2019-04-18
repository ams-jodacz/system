<?php
namespace App\Models\Members;
use Illuminate\Database\Eloquent\Model;

class Member extends Model{
    
    protected $table = 'members';
    
    public $timestamps = false;
    
    protected $primaryKey = 'member_id';

    protected $fillable = array('id_number','class_group_id','active_status');
    
    protected $guarded = array('member_id');

//Joins
    //Classification Group Table
    public function classificationGroup()
    {
        return $this->belongsTo('App\Models\Classification\ClassificationGroup','class_group_id','class_group_id');
    }

    //Member Information Table
    public function memberInformation()
    {
        return $this->hasOne('App\Models\Members\MemberInformation', 'member_id', 'member_id');
    }
    
    //Recipients Table
    public function recipients()
    {
        return $this->hasMany('App\Models\Members\Recipient', 'member_id', 'member_id');
    }

    //Tags Table
    public function tag()
    {
        return $this->hasOne('App\Models\Tags\Tag', 'id_number', 'id_number');
    }

    //Time Logs Table
    public function timeLogs()
    {
        return $this->hasMany('App\Models\Logs\TimeLog', 'id_number', 'id_number');
    }
}
