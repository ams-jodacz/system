<?php
namespace App\Models\SMS;
use Illuminate\Database\Eloquent\Model;

class Server extends Model{
    
    protected $table = 'sms_server';
    
    public $timestamps = false;
    
    protected $primaryKey = 'sms_server_id';

    protected $fillable = array('server_name','ip','username','password');
    
    protected $guarded = array('sms_server_id');

//Joins
    public function access()
    {
        return $this->hasMany('App\Models\SMS\Access','sms_server_id','sms_server_id');
    }
}
