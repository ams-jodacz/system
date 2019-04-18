<?php
namespace App\Models\ACL;
use Illuminate\Database\Eloquent\Model;

class Page extends Model{
    
    protected $table = 'tbl_page';
    
    protected $primaryKey = 'page_id';
    
    public $timestamps = false;
    
    public function module()
    {
        return $this->belongsTo('App\Models\ACL\Module', 'module_id', 'module_id');
    }
    
    public function permission(){
        return $this->hasMany('App\Models\ACL\Permission', 'page_id', 'page_id');
    }
}
