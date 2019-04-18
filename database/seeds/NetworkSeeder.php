<?php
use App\Models\SMS\Group as Group;
use App\Models\SMS\Prefix as Prefix;
class NetworkSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();
        $this->clearTable();
        $this->actionStationList();
    }
    
    private function actionStationList(){
    //Add Action Table Data
        $station_list = array(
            array(
                'sms_prefix_group_id' => 1,
                'group_name' => 'Globe or TM Prefix',
                'prefixs' => array(
                    '817',
                    '905',
                    '906',
                    '915',
                    '916',
                    '917',
                    '926',
                    '927',
                    '935',
                    '936',
                    '937',
                    '945',
                    '975',
                    '946',
                    '994',
                    '995',
                    '996',
                    '997',
                    '977',
                    '978',
                    '979',
                )
            ),
            array(
                'sms_prefix_group_id' => 2,
                'group_name' => 'Sun Prefix',
                'prefixs' => array(
                    '922',
                    '923',
                    '924',
                    '925',
                    '932',
                    '933',
                    '934',
                    '942',
                    '943',
                )
            ),
            array(
                'sms_prefix_group_id' => 3,
                'group_name' => 'Smart and TNT Prefix',
                'prefixs' => array(
                    '813',
                    '907',
                    '908',
                    '909',
                    '910',
                    '911',
                    '912',
                    '913',
                    '914',
                    '918',
                    '919',
                    '920',
                    '921',
                    '928',
                    '929',
                    '930',
                    '938',
                    '939',
                    '946',
                    '947',
                    '948',
                    '949',
                    '989',
                    '998',
                    '999',
                )
            ),
        );
        foreach($station_list as $value){
            Group::create(
                array(
                    'sms_prefix_group_id' => $value['sms_prefix_group_id'],
                    'group_name' => $value['group_name'],
                )
            );
            foreach ($value['prefixs'] as $prefix) {
                Prefix::create(
                    array(
                        'sms_prefix_group_id' => $value['sms_prefix_group_id'],
                        'prefix' => $prefix,
                    )
                );
            }
        }
    }

    private function clearTable(){
        DB::table('sms_prefix_list')->delete();
        DB::table('sms_prefix_group')->delete();
    }

}