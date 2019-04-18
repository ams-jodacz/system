<?php
namespace App\Models\SMS;
use Illuminate\Database\Eloquent\Model;

class Access extends Model{
    
    protected $table = 'sms_access';
    
    public $timestamps = false;
    
    protected $primaryKey = 'sms_access_id';

    protected $fillable = array('sms_server_id','sms_prefix_group_id');
    
    protected $guarded = array('sms_access_id');

//Joins
    public function server()
    {
        return $this->belongsTo('App\Models\SMS\Server','sms_server_id','sms_server_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\SMS\Group','sms_prefix_group_id','sms_prefix_group_id');
    }
}
