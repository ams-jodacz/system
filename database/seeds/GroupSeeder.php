<?php
use App\Models\ACL\Group as Group;

class GroupSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();
        $this->groupList();
    }
    
    private function groupList(){
        Group::create(
            array(
                'group_id' => 1,
                'group_name' => 'Admin',
            )
        );
    }

}