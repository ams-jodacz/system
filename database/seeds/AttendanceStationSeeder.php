<?php
use App\Models\Attendance\AttendanceGroup as AttendanceGroup;
use App\Models\Attendance\AttendanceStation as AttendanceStation;
class AttendanceStationSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();
        $this->clearTable();
        $this->actionStationList();
    }
    
    private function actionStationList(){
        $station_list = array(
            array(
                'attendance_group_id' => 1,
                'group_name' => 'Gate 2',
                'stations' => array(
                    array(
                        'ip' => '10.0.104.2',
                        'name' => 'Gate 2 Station',
                        'description' => '',
                    ),
                )
            ),
            array(
                'attendance_group_id' => 2,
                'group_name' => 'Gate 3',
                'stations' => array(
                    array(
                        'ip' => '10.0.104.3',
                        'name' => 'Gate 3 Station',
                        'description' => '',
                    ),
                )
            ),
            array(
                'attendance_group_id' => 3,
                'group_name' => 'Gate 5',
                'stations' => array(
                    array(
                        'ip' => '10.0.104.5',
                        'name' => 'Gate 5 Station',
                        'description' => '',
                    ),
                )
            ),
            array(
                'attendance_group_id' => 4,
                'group_name' => 'Gate 8',
                'stations' => array(
                    array(
                        'ip' => '10.0.104.8',
                        'name' => 'Gate 8 Station',
                        'description' => '',
                    ),
                )
            ),
            array(
                'attendance_group_id' => 5,
                'group_name' => 'Court',
                'stations' => array(
                    array(
                        'ip' => '10.0.104.6',
                        'name' => 'Court Station',
                        'description' => '',
                    ),
                )
            ),
        );
        foreach($station_list as $value){
            AttendanceGroup::create(
                array(
                    'attendance_group_id' => $value['attendance_group_id'],
                    'group_name' => $value['group_name'],
                )
            );
            foreach ($value['stations'] as $station) {
                AttendanceStation::create(
                    array(
                        'attendance_group_id' => $value['attendance_group_id'],
                        'ip' => $station['ip'],
                        'name' => $station['name'],
                        'description' => $station['description'],
                    )
                );
            }
        }
    }

    private function clearTable(){
        DB::table('attendance_station')->delete();
        DB::table('attendance_group')->delete();
    }

}