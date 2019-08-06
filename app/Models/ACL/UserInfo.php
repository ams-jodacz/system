<?php
namespace App\Models\ACL;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model{
    
    protected $table = 'tbl_user_info';
    
    protected $primaryKey = 'user_info_id';	
    
    public $timestamps = false;
    
    protected $fillable = array('first_name','middle_name','last_name');
    
    protected $guarded = array('user_info_id','user_id');
    
    public function user()
    {
        return $this->belongsTo('App\Models\ACL\User', 'user_id', 'user_id');
    }
}
