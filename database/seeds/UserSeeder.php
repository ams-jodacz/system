<?php
use App\Models\ACL\User as User;
use App\Models\ACL\UserInfo as UserInfo;

class UserSeeder extends Seeder {
    
    public $group_id = 1;
    
    public function run()
    {
        Eloquent::unguard();
        $this->userList();
        $this->userInfoList();
    }
    
    private function userList(){
        User::create(
            array(
                'user_id' => 1,
                'username' => 'Admin',
                'password' => Hash::make('Admin'),
                'group_id' => $this->group_id,
            )
        );
    }
    
    private function userInfoList(){
        UserInfo::create(
            array(
                'user_info_id' => 1,
                'user_id' => 1,
                'first_name' => 'Admin',
                'middle_name' => 'D',
                'last_name' => 'Admin',
            )
        );
    }
    
    

}