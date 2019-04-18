<?php
use App\Models\ACL\Action as Action;
use App\Models\ACL\Module as Module;
use App\Models\ACL\Page as Page;
use App\Models\ACL\Permission as Permission;

class ACLSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();
        DB::table('tbl_permission')->delete();
        DB::table('tbl_page')->delete();
        DB::table('tbl_module')->delete();

        $default_group_id = 1;
        
        $data = array(
            array(
                'module_id' => 1,
                'module_name' => 'Settings',
                'pages' => array(
                    //USER
                    array(
                        'page_id' => 1,
                        'page_name' => 'User',
                        'page_url' => 'users',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //GROUP
                    array(
                        'page_id' => 2,
                        'page_name' => 'Group',
                        'page_url' => 'users/group',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    )
                ),
            ),
            array(
                'module_id' => 2,
                'module_name' => 'Stations',
                'pages' => array(
                    //Group
                    array(
                        'page_id' => 8,
                        'page_name' => 'Group',
                        'page_url' => 'stations/group',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Stations
                    array(
                        'page_id' => 3,
                        'page_name' => 'Station',
                        'page_url' => 'stations',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Station Access
                    array(
                        'page_id' => 7,
                        'page_name' => 'Access',
                        'page_url' => 'stations/access',
                        'page_max_action' => Action::$View | Action::$Add  | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                ),
            ),
            array(
                'module_id' => 3,
                'module_name' => 'Classifications',
                'pages' => array(
                    //Classificaiton
                    array(
                        'page_id' => 4,
                        'page_name' => 'Classification',
                        'page_url' => 'classification',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Classificaiton Group
                    array(
                        'page_id' => 5,
                        'page_name' => 'Group',
                        'page_url' => 'classification/group',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                ),
            ),
            array(
                'module_id' => 4,
                'module_name' => 'Members',
                'pages' => array(
                    //Member
                    array(
                        'page_id' => 6,
                        'page_name' => 'Member',
                        'page_url' => 'member',
                        // 'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                ),
            ),
            array(
                'module_id' => 5,
                'module_name' => 'Guest',
                'pages' => array(
                    //Guest Logs
                    array(
                        'page_id' => 9,
                        'page_name' => 'Tags',
                        'page_url' => 'guest',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Group
                    array(
                        'page_id' => 10,
                        'page_name' => 'Group',
                        'page_url' => 'guest/group',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Access
                    array(
                        'page_id' => 11,
                        'page_name' => 'Access',
                        'page_url' => 'guest/access',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Add Guest
                    array(
                        'page_id' => 15,
                        'page_name' => 'Add Guest',
                        'page_url' => 'guest/add_guest',
                        'page_max_action' => Action::$View | Action::$Add,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                ),
            ),
            array(
                'module_id' => 6,
                'module_name' => 'Attendance',
                'pages' => array(
                    //Group
                    array(
                        'page_id' => 12,
                        'page_name' => 'Group',
                        'page_url' => 'attendance/group',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Station
                    array(
                        'page_id' => 13,
                        'page_name' => 'Station',
                        'page_url' => 'attendance/station',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Access
                    array(
                        'page_id' => 14,
                        'page_name' => 'Access',
                        'page_url' => 'attendance/access',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                ),
            ),
            array(
                'module_id' => 7,
                'module_name' => 'Monitoring',
                'pages' => array(
                    //Station Controller
                    array(
                        'page_id' => 16,
                        'page_name' => 'Station Controller',
                        'page_url' => 'monitor/controller',
                        'page_max_action' => Action::$View,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Station Monitor
                    array(
                        'page_id' => 17,
                        'page_name' => 'Station',
                        'page_url' => 'monitor/station',
                        'page_max_action' => Action::$View,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Monitor History
                    array(
                        'page_id' => 30,
                        'page_name' => 'History',
                        'page_url' => 'monitor/history',
                        'page_max_action' => Action::$View,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Attendance Monitoring
                    array(
                        'page_id' => 18,
                        'page_name' => 'Attendance',
                        'page_url' => 'monitor/attendance',
                        'page_max_action' => Action::$View,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //Network Monitoring
                    array(
                        'page_id' => 28,
                        'page_name' => 'Network Connection',
                        'page_url' => 'monitor/network',
                        'page_max_action' => Action::$View,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                ),
            ),
            array(
                'module_id' => 8,
                'module_name' => 'Uploading',
                'pages' => array(
                    //Member Uploading
                    array(
                        'page_id' => 19,
                        'page_name' => 'Members',
                        'page_url' => 'upload/member',
                        'page_max_action' => Action::$View,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                ),
            ),
            array(
                'module_id' => 9,
                'module_name' => 'SMS Configuration',
                'pages' => array(
                    //SMS Configuration
                    array(
                        'page_id' => 20,
                        'page_name' => 'Server',
                        'page_url' => 'sms/server',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //SMS Group
                    array(
                        'page_id' => 21,
                        'page_name' => 'Prefix Group',
                        'page_url' => 'sms/group',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //SMS Prefix
                    array(
                        'page_id' => 22,
                        'page_name' => 'Prefix',
                        'page_url' => 'sms/prefix',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Edit | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    //SMS Access
                    array(
                        'page_id' => 23,
                        'page_name' => 'Access',
                        'page_url' => 'sms/access',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                ),
            ),
            array(
                'module_id' => 10,
                'module_name' => 'SMS Messaging',
                'pages' => array(
                    array(
                        'page_id' => 24,
                        'page_name' => 'Direct',
                        'page_url' => 'blast',
                        'page_max_action' => Action::$View,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    array(
                        'page_id' => 25,
                        'page_name' => 'Scheduled',
                        'page_url' => 'blast/occurance',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    array(
                        'page_id' => 26,
                        'page_name' => 'Late/Absent',
                        'page_url' => 'blast/late_absent',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    array(
                        'page_id' => 27,
                        'page_name' => 'Date Exemption',
                        'page_url' => 'blast/excemption',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                    array(
                        'page_id' => 29,
                        'page_name' => 'Holidays',
                        'page_url' => 'blast/holiday',
                        'page_max_action' => Action::$View | Action::$Add | Action::$Delete,
                        'permission' => array(
                            'group_id' => $default_group_id,
                        )
                    ),
                ),
            ),
        );
        
        $this->saveModules($data);
    }
    
    private function saveModules($data){
        foreach($data as $module){
            Module::create(
                array(
                    'module_id' => $module['module_id'],
                    'module_name' => $module['module_name'],
                )
            );
            
            foreach($module['pages'] as $page){
                Page::create(
                    array(
                        'page_id' => $page['page_id'],
                        'module_id' => $module['module_id'],
                        'page_name' => $page['page_name'],
                        'page_url' => $page['page_url'],
                        'page_max_action' => $page['page_max_action'],
                    )
                );
                $permission = $page['permission'];
                Permission::create(
                    array(
                        'group_id' => $permission['group_id'],
                        'module_id' => $module['module_id'],
                        'page_id' => $page['page_id'],
                        'action_value' => $page['page_max_action'],
                    )
                );
            }
        }
    }
}