<?php
namespace App\Models\SMS;
use Illuminate\Database\Eloquent\Model;

class Group extends Model{
    
    protected $table = 'sms_prefix_group';
    
    public $timestamps = false;
    
    protected $primaryKey = 'sms_prefix_group_id';

    protected $fillable = array('group_name');
    
    protected $guarded = array('sms_prefix_group_id');

//Joins
    public function prefixList()
    {
        return $this->hasMany('App\Models\SMS\Prefix','sms_prefix_group_id','sms_prefix_group_id');
    }

    public function access()
    {
        return $this->hasMany('App\Models\SMS\Access','sms_prefix_group_id','sms_prefix_group_id');
    }
}
