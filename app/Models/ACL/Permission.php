<?php
namespace App\Models\ACL;
use Illuminate\Database\Eloquent\Model;
use App\Models\ACL\User as User;
use App\Models\ACL\Permission as Permission;
use Auth;
use App;

class Permission extends Model{
    
    protected $table = 'tbl_permission';
    
    protected $primaryKey = 'permission_id';
    
    protected $fillable = array('group_id','module_id','page_id','action_value');
    
    public $timestamps = false;
    
    public function group(){
        return $this->belongsTo('App\Models\ACL\Group','group_id','group_id');
    }
    
    public function module(){
        return $this->belongsTo('App\Models\ACL\Module','module_id','module_id');
    }
    
    public function page(){
        return $this->belongsTo('App\Models\ACL\Page','page_id','page_id');
    }
    
    public static function getPageAction($module_id,$page_id){
        $where = array(
            'group_id' => User::find(Auth::id())->group->group_id,
            'module_id' => $module_id,
            'page_id' => $page_id,
        );
        $permission = Permission::where($where)->get()->toArray();
        if(count($permission) == 0){
            App::abort(403, 'Unauthorized action.');
        }
        return $permission[0]['action_value'];
    }
}
