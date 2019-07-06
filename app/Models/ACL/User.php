<?php
namespace App\Models\ACL;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\ACL\Permission as Permission;
use Auth;
use Hash;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_users';

	protected $primaryKey = 'user_id';

    protected $fillable = array('username','password','status','remove_status','group_id');
    
    protected $guarded = array('user_id');

    protected $hidden = array('password');
	
	public $timestamps = false;

	public static $DefaultPassword = '123456';
	
	public function getRememberToken(){
		return null; // not supported
	}
	
	public function getRememberTokenName(){
		return null; // not supported
	}
	
	public function setAttribute($key, $value){
		$isRememberTokenAttribute = $key == $this->getRememberTokenName();
		if (!$isRememberTokenAttribute){
			parent::setAttribute($key, $value);
		}
	}
	
	public function group(){
		return $this->belongsTo('App\Models\ACL\Group','group_id','group_id');
	}
	
	public function userinfo(){
	    return $this->hasOne('App\Models\ACL\UserInfo', 'user_id', 'user_id');
	}
	
	public static function getFistName(){
		return 'Hi '.ucfirst(User::find(Auth::id())->userinfo->first_name);
	}

    public static function getPicName(){
    	return (User::find(Auth::id())->userinfo->profile_pic!='' && User::find(Auth::id())->userinfo->profile_pic!=null)
    		?User::find(Auth::id())->userinfo->profile_pic
    		:'avatar.png';
    }
	
	public static function getName(){
		return ucfirst(User::find(Auth::id())->userinfo->first_name).' '.ucfirst(User::find(Auth::id())->userinfo->last_name);
	}
	
	public static function updateStatus($id){
		$user = User::find($id);
		$user->status = ($user->status=='Active')?'Inactive':'Active';
		return $user->save();
	}
	
	public static function resetPassword($id){
		$user = User::find($id);
		$user->password = Hash::make(User::$DefaultPassword);
		return $user->save();
	}
	
	public static function checkUserModule($module_id){
	    $module_ids = array_unique(User::find(Auth::id())->group->permission->lists('module_id'));
	    return in_array($module_id,$module_ids);
	}
	
	public static function checkUserPages($module_id,$page_id){
		$page_ids = Permission::where('module_id',$module_id)->lists('page_id');
		return in_array($page_id,$page_ids);
	}

}
