<?php
namespace App\Http\Controllers;
use App\Models\ACL\User as User;
use App\Models\ACL\UserInfo as UserInfo;
use Request;
use Auth;
use Hash;
use Input;

class MyAccountController extends Controller {
    protected $layout = 'main';

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        return view('common.myaccount.myaccount');
    }
    
    public function edit(){
        if (Request::ajax() && Request::isMethod('post')){
            if (Input::has('userinfo')){
                $userinfo = json_decode(Input::get('userinfo'),TRUE);
                if (User::find(Auth::id())->userinfo->fill($userinfo)->save()){
                    return json_encode(array('status' => true,'msg' => 'Done updating user info!'));
                }
                else{
                    return json_encode(array('msg' => 'Unable to update user info, Please Try Again'));
                }
            }
            elseif(Input::has('password')){
                $password = json_decode(Input::get('password'),TRUE);
                $user = User::find(Auth::id());
                if (isset($password['old_password']) && isset($password['new_password']) && Hash::check($password['old_password'], $user->password)){
                    $user->password = Hash::make($password['new_password']);
                    if ($user->save()){
                        return json_encode(array('status' => true,'msg' => 'Done updating password!'));
                    }
                    else{
                        return json_encode(array('msg' => 'Unable to update user info, Please Try Again'));
                    }
                }
            }
        }
        return json_encode(array('msg' => 'Unable to update user info, Please Try Again'));
    }

    public function uploadPic(){
        if (Request::ajax() && Input::hasFile('profile_pic') && Input::file('profile_pic')->isValid()){
            $file = Input::file('profile_pic');
            $path = $file->getRealPath();
            $destinationPath = public_path().'/images';
            $filename = $file->getClientOriginalName();
            $filename = explode('.', $filename);
            $filename = date('mdHisy').'.'.$filename[count($filename)-1];
            $user = UserInfo::find(Auth::id());
            $old_filename = $user->profile_pic;
            if ($file->move($destinationPath,$filename)){
                if ($old_filename != '' && $old_filename != null){
                    $old_file = $destinationPath.'/'.$old_filename;
                    if (file_exists($old_file))
                        unlink($old_file);
                }
                $user->profile_pic = $filename;
                $user->save();
                return 'true';
            }
            return 'false';
        }
    }
    
}
