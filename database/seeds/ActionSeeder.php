<?php
use App\Models\ACL\Action as Action;
class ActionSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();
        $this->actionList();
    }
    
    private function actionList(){
    //Add Action Table Data
        $actions = array(
            '1' => 'View',
            '2' => 'Add',
            '3' => 'Update',
            '4' => 'Delete',
            '5' => 'Approver',
            '6' => 'Verifier',
        );
        foreach($actions as $key => $value){
            Action::create(
                array(
                    'action_id' => $key,
                    'action_name' => $value,
                    'action_value' => pow(2,($key-1)),
                )
            );
        }
    }

}