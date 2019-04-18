<?php
namespace App\Models\ACL;
use Illuminate\Database\Eloquent\Model;

class Module extends Model{
    
    protected $table = 'tbl_module';
    
    protected $primaryKey = 'module_id';	
    
    public $timestamps = false;
    
    public function permission()
    {
        return $this->hasMany('App\Models\ACL\Permission', 'module_id', 'module_id');
    }
    
    public function page(){
        return $this->hasMany('App\Models\ACL\Page', 'module_id', 'module_id');
    }
}
