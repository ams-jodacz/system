<?php
namespace App\Models\ACL;
use Illuminate\Database\Eloquent\Model;

class Group extends Model{
    
    protected $table = 'tbl_group';
    
    protected $primaryKey = 'group_id';
    
    protected $fillable = array('group_name');
    
    protected $guarded = array('group_id');
    
    public $timestamps = false;
    
//JOINS
    //PERMISSION TABLE
    public function permission()
    {
        return $this->hasMany('App\Models\ACL\Permission', 'group_id', 'group_id');
    }
    //USER TABLE
    public function user()
    {
        return $this->hasMany('App\Models\ACL\User', 'group_id', 'group_id');
    }
}
