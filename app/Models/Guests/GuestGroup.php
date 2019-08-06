<?php
namespace App\Models\Guests;
use Illuminate\Database\Eloquent\Model;

class GuestGroup extends Model{
    
    protected $table = 'guest_tag_group';
    
    public $timestamps = false;
    
    protected $primaryKey = 'guest_group_id';

    protected $fillable = array('group_name');
    
    protected $guarded = array('guest_group_id');

//Joins
    //Classification Group Table
    public function tags()
    {
        return $this->hasMany('App\Models\Guests\GuestTag','guest_group_id','guest_group_id');
    }

    public function access(){
        return $this->hasMany('App\Models\Guests\GuestAccess','guest_group_id','guest_group_id');
    }
}
