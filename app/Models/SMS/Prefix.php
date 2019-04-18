<?php
namespace App\Models\SMS;
use Illuminate\Database\Eloquent\Model;

class Prefix extends Model{
    
    protected $table = 'sms_prefix_list';
    
    public $timestamps = false;
    
    protected $primaryKey = 'sms_prefix_id';

    protected $fillable = array('sms_prefix_group_id','prefix');
    
    protected $guarded = array('sms_prefix_id');

//Joins
    public function group()
    {
        return $this->belongsTo('App\Models\SMS\Group','sms_prefix_group_id','sms_prefix_group_id');
    }
}
