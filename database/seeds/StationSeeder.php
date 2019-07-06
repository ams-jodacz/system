<?php
use App\Models\Stations\StationGroup as StationGroup;
use App\Models\Stations\Station as Station;
class StationSeeder extends Seeder {

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
                'station_group_id' => 1,
                'group_name' => 'Gate 4',
                'stations' => array(
                    array(
                        'ip' => '10.0.104.10',
                        'name' => 'Entrance 1',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.11',
                        'name' => 'Entrance 2',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.12',
                        'name' => 'Exit 1',
                        'description' => '',
                        'status' => 'Out',
                    ),
                    array(
                        'ip' => '10.0.104.13',
                        'name' => 'Exit 2',
                        'description' => '',
                        'status' => 'Out',
                    ),
                )
            ),
            array(
                'station_group_id' => 2,
                'group_name' => 'CAS 1',
                'stations' => array(
                    array(
                        'ip' => '10.0.104.14',
                        'name' => 'Entrance 1',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.15',
                        'name' => 'Entrance 2',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.16',
                        'name' => 'Exit 1',
                        'description' => '',
                        'status' => 'Out',
                    ),
                    array(
                        'ip' => '10.0.104.17',
                        'name' => 'Exit 2',
                        'description' => '',
                        'status' => 'Out',
                    ),
                )
            ),
            array(
                'station_group_id' => 3,
                'group_name' => 'CAS 2',
                'stations' => array(
                    array(
                        'ip' => '10.0.104.18',
                        'name' => 'Entrance 1',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.19',
                        'name' => 'Entrance 2',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.20',
                        'name' => 'Exit 1',
                        'description' => '',
                        'status' => 'Out',
                    ),
                    array(
                        'ip' => '10.0.104.21',
                        'name' => 'Exit 2',
                        'description' => '',
                        'status' => 'Out',
                    ),
                )
            ),
            array(
                'station_group_id' => 4,
                'group_name' => 'St. Maur',
                'stations' => array(
                    array(
                        'ip' => '10.0.104.22',
                        'name' => 'Entrance 1',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.23',
                        'name' => 'Entrance 2',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.24',
                        'name' => 'Exit 1',
                        'description' => '',
                        'status' => 'Out',
                    ),
                    array(
                        'ip' => '10.0.104.25',
                        'name' => 'Exit 2',
                        'description' => '',
                        'status' => 'Out',
                    ),
                )
            ),
            array(
                'station_group_id' => 5,
                'group_name' => 'Christ the King',
                'stations' => array(
                    array(
                        'ip' => '10.0.104.26',
                        'name' => 'Entrance 1',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.34',
                        'name' => 'Entrance 2',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.30',
                        'name' => 'Entrance 3',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.32',
                        'name' => 'Entrance 4',
                        'description' => '',
                        'status' => 'In',
                    ),
                    array(
                        'ip' => '10.0.104.27',
                        'name' => 'Exit 1',
                        'description' => '',
                        'status' => 'Out',
                    ),
                    array(
                        'ip' => '10.0.104.29',
                        'name' => 'Exit 2',
                        'description' => '',
                        'status' => 'Out',
                    ),
                    array(
                        'ip' => '10.0.104.31',
                        'name' => 'Exit 3',
                        'description' => '',
                        'status' => 'Out',
                    ),
                    array(
                        'ip' => '10.0.104.33',
                        'name' => 'Exit 4',
                        'description' => '',
                        'status' => 'Out',
                    ),
                )
            ),
        );
        foreach($station_list as $value){
            StationGroup::create(
                array(
                    'station_group_id' => $value['station_group_id'],
                    'group_name' => $value['group_name'],
                )
            );
            foreach ($value['stations'] as $station) {
                Station::create(
                    array(
                        'station_group_id' => $value['station_group_id'],
                        'ip' => $station['ip'],
                        'name' => $station['name'],
                        'description' => $station['description'],
                        'status' => $station['status'],
                    )
                );
            }
        }
    }

    private function clearTable(){
        DB::table('stations')->delete();
        DB::table('station_group')->delete();
    }

}