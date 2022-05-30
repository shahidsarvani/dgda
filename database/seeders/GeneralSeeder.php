<?php

namespace Database\Seeders;

use App\Models\Command;
use App\Models\Hardware;
use App\Models\LightingType;
use App\Models\Phase;
use App\Models\Room;
use App\Models\Setting;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //Add Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);

        //Add Site Settings
        Setting::create([
            'room_count' => 4,
        ]);

        //Add Rooms
        $room_data = [
            [
                'name' => 'Wadi Safer',
                'name_ar' => 'وادي صافر',
                'type' => '1',
                'status' => 1
            ],
            [
                'name' => 'Diriyah',
                'name_ar' => 'الدرعية',
                'type' => '1',
                'status' => 1
            ],
            [
                'name' => 'Combined',
                'name_ar' => 'مجموع',
                'type' => '1',
                'status' => 1
            ],
            [
                'name' => 'Technical',
                'name_ar' => 'اِصطِلاحِيّ',
                'type' => '2',
                'status' => 1
            ],
        ];
        foreach ($room_data as $value) {
            $room = Room::create($value);

            //Add phases
            if ($room->id != 4) {
                $phases_data = [
                    [
                        'name' => 'DG1',
                        'name_ar' => 'DG1',
                        'room_id' => $room->id,
                        'status' => 1,
                    ],
                    [
                        'name' => 'DG2',
                        'name_ar' => 'DG2',
                        'room_id' => $room->id,
                        'status' => 1,
                    ],
                    [
                        'name' => 'DG3',
                        'name_ar' => 'DG3',
                        'room_id' => $room->id,
                        'status' => 1,
                    ],
                ];
                foreach ($phases_data as $value) {
                    $phase = Phase::create($value);

                    //Add Zones
                    $zone_data = [
                        [
                            'name' => 'Mosques',
                            'name_ar' => 'Mosques',
                            'phase_id' => $phase->id,
                            'status' => 1,
                        ],
                        [
                            'name' => 'Shopping Malls',
                            'name_ar' => 'Shopping Malls',
                            'phase_id' => $phase->id,
                            'status' => 1,
                        ],
                        [
                            'name' => 'Parks',
                            'name_ar' => 'Parks',
                            'phase_id' => $phase->id,
                            'status' => 1,
                        ],
                        [
                            'name' => 'Parking Lots',
                            'name_ar' => 'Parking Lots',
                            'phase_id' => $phase->id,
                            'status' => 1,
                        ],
                        [
                            'name' => 'Hospitals',
                            'name_ar' => 'Hospitals',
                            'phase_id' => $phase->id,
                            'status' => 1,
                        ],
                        [
                            'name' => 'Schools',
                            'name_ar' => 'Schools',
                            'phase_id' => $phase->id,
                            'status' => 1,
                        ],
                    ];
                    foreach ($zone_data as $value) {
                        $zone = Zone::create($value);
                    }
                }
            }

            //Add Hardware

            $command_data = [];
            if ($room->name == 'Wadi Safer') {
                $hardware_data = [
                    [
                        'name' => 'Left Wall LED',
                        'device' => 'PC1',
                        'ip' => '192.168.10.6',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                    [
                        'name' => 'Right Wall LED',
                        'device' => 'PC2',
                        'ip' => '192.168.10.7',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                    [
                        'name' => 'Tablet',
                        'device' => 'PC9',
                        'ip' => '192.168.10.3',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                    [
                        'name' => 'Creston Controller',
                        'device' => 'PC10',
                        'ip' => '192.168.10.10',
                        'port' => '58900',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                ];
                foreach ($hardware_data as $value) {
                    $hardware = Hardware::create($value);

                    //Add Commands
                    if ($hardware->name == 'Creston Controller') {
                        $command_data = [
                            [
                                'name' => 'WSScene1',
                                'description' => 'Wadi Safar Scene 1',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSScene2',
                                'description' => 'Wadi Safar Scene 2',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSScene3',
                                'description' => 'Wadi Safar Scene 4',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSScene4',
                                'description' => 'Wadi Safar Scene 4',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSScene5',
                                'description' => 'Wadi Safar Scene 5',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSScene6',
                                'description' => 'Wadi Safar Scene 6',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSScene7',
                                'description' => 'Wadi Safar Scene 7',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSScene8',
                                'description' => 'Wadi Safar Scene 8',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSScene9',
                                'description' => 'Wadi Safar Scene 9',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSScene10',
                                'description' => 'Wadi Safar Scene 10',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSSpotsOn',
                                'description' => 'Spots @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSSpots80',
                                'description' => 'Spots @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSSpots60',
                                'description' => 'Spots @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSSpots40',
                                'description' => 'Spots @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSSpots20',
                                'description' => 'Spots @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSSpotsOff',
                                'description' => 'Spots @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSCoveOn',
                                'description' => 'Cove @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSCove80',
                                'description' => 'Cove @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSCove60',
                                'description' => 'Cove @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSCove40',
                                'description' => 'Cove @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSCove20',
                                'description' => 'Cove @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSCoveOff',
                                'description' => 'Cove @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntSpotsOn',
                                'description' => 'Entrance Spots @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntSpots80',
                                'description' => 'Entrance Spots @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntSpots60',
                                'description' => 'Entrance Spots @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntSpots40',
                                'description' => 'Entrance Spots @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntSpots20',
                                'description' => 'Entrance Spots @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntSpotsOff',
                                'description' => 'Entrance Spots @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntCoveOn',
                                'description' => 'Entrance Cove @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntCove80',
                                'description' => 'Entrance Cove @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntCove60',
                                'description' => 'Entrance Cove @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntCove40',
                                'description' => 'Entrance Cove @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntCove20',
                                'description' => 'Entrance Cove @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSEntCoveOff',
                                'description' => 'Entrance Cove @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSWashOn',
                                'description' => 'Wash @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSWash80',
                                'description' => 'Wash @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSWash60',
                                'description' => 'Wash @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSWash40',
                                'description' => 'Wash @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSWash20',
                                'description' => 'Wash @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSWashOff',
                                'description' => 'Wash @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSAllOn',
                                'description' => 'All @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSAll80',
                                'description' => 'All @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSAll60',
                                'description' => 'All @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSAll40',
                                'description' => 'All @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSAll20',
                                'description' => 'All @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'WSAllOff',
                                'description' => 'All @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                        ];
                    }

                    foreach ($command_data as $value) {
                        $command = Command::create($value);
                    }
                }
            }
            if ($room->name == 'Diriyah') {
                $hardware_data = [
                    [
                        'name' => 'Left Wall LED',
                        'device' => 'PC3',
                        'ip' => '192.168.10.21',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                    [
                        'name' => 'Middle Wall LED',
                        'device' => 'PC4',
                        'ip' => '192.168.10.22',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                    [
                        'name' => 'Right Wall LED',
                        'device' => 'PC5',
                        'ip' => '192.168.10.23',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                    [
                        'name' => 'Model Projection',
                        'device' => 'PC6',
                        'ip' => '192.168.10.24',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                    [
                        'name' => 'Model Controller',
                        'device' => 'PC7',
                        'ip' => '192.168.10.25',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                    [
                        'name' => 'Creston Controller',
                        'device' => 'PC10',
                        'ip' => '192.168.10.10',
                        'port' => '58900',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                ];

                foreach ($hardware_data as $value) {
                    $hardware = Hardware::create($value);

                    //Add Commands
                    if ($hardware->name == 'Creston Controller') {
                        $command_data = [
                            [
                                'name' => 'DScene1',
                                'description' => 'Diriyah Scene 1',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DScene2',
                                'description' => 'Diriyah Scene 2',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DScene3',
                                'description' => 'Diriyah Scene 4',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DScene4',
                                'description' => 'Diriyah Scene 4',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DScene5',
                                'description' => 'Diriyah Scene 5',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DScene6',
                                'description' => 'Diriyah Scene 6',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DScene7',
                                'description' => 'Diriyah Scene 7',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DScene8',
                                'description' => 'Diriyah Scene 8',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DScene9',
                                'description' => 'Diriyah Scene 9',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DScene10',
                                'description' => 'Diriyah Scene 10',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DSpotsOn',
                                'description' => 'Spots @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DSpots80',
                                'description' => 'All Spots @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DSpots60',
                                'description' => 'All Spots @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DSpots40',
                                'description' => 'All Spots @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DSpots20',
                                'description' => 'All Spots @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DSpotsOff',
                                'description' => 'All Spots @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DModelSpotsOn',
                                'description' => 'Model Spots @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DModelSpots80',
                                'description' => 'Model Spots @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DModelSpots60',
                                'description' => 'Model Spots @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DModelSpots40',
                                'description' => 'Model Spots @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DModelSpots20',
                                'description' => 'Model Spots @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DModelSpotsOff',
                                'description' => 'Model Spots @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DPeripheralSpotsOn',
                                'description' => 'Peripheral Spots @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DPeripheralSpots80',
                                'description' => 'Peripheral Spots @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DPeripheralSpots60',
                                'description' => 'Peripheral Spots @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DPeripheralSpots40',
                                'description' => 'Peripheral Spots @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DPeripheralSpots20',
                                'description' => 'Peripheral Spots @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DPeripheralSpotsOff',
                                'description' => 'Peripheral Spots @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DCoveOn',
                                'description' => 'Cove @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DCove80',
                                'description' => 'Cove @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DCove60',
                                'description' => 'Cove @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DCove40',
                                'description' => 'Cove @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DCove20',
                                'description' => 'Cove @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DCoveOff',
                                'description' => 'Cove @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DWashOn',
                                'description' => 'Wash Lights @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DWash80',
                                'description' => 'Wash Lights @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DWash60',
                                'description' => 'Wash Lights @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DWash40',
                                'description' => 'Wash Lights @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DWash20',
                                'description' => 'Wash Lights @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DWashOff',
                                'description' => 'Wash Lights @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DAllOn',
                                'description' => 'All Lights @ 100%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DAll80',
                                'description' => 'All Lights @ 80%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DAll60',
                                'description' => 'All Lights @ 60%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DAll40',
                                'description' => 'All Lights @ 40%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DAll20',
                                'description' => 'All Lights @ 20%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'DAllOff',
                                'description' => 'All Lights @ 0%',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                        ];
                    }

                    foreach ($command_data as $value) {
                        $command = Command::create($value);
                    }
                }
            }
            if ($room->name == 'Combined') {
                $hardware_data = [
                    [
                        'name' => 'Server',
                        'device' => 'PC8',
                        'ip' => '192.168.10.4',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                    [
                        'name' => 'Creston Controller',
                        'device' => 'PC10',
                        'ip' => '192.168.10.10',
                        'port' => '58900',
                        'status' => 1,
                        'room_id' => $room->id,
                    ],
                ];

                foreach ($hardware_data as $value) {
                    $hardware = Hardware::create($value);

                    //Add Commands
                    if ($hardware->name == 'Creston Controller') {
                        $command_data = [
                            [
                                'name' => 'SeparateRooms',
                                'description' => 'Separate rooms audio',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                            [
                                'name' => 'CombinedSuite',
                                'description' => 'Combine rooms audio',
                                'room_id' => $room->id,
                                'hardware_id' => $hardware->id,
                            ],
                        ];
                    }

                    foreach ($command_data as $value) {
                        $command = Command::create($value);
                    }
                }
            }
        }

        //Add Lighting Types
        $lightingType_data = [
            [
                'name' => 'Spots',
                'status' => 1
            ],
            [
                'name' => 'Cove',
                'status' => 1
            ],
            [
                'name' => 'Entrance Spot',
                'status' => 1
            ],
            [
                'name' => 'Entrance Cove',
                'status' => 1
            ],
            [
                'name' => 'Wash',
                'status' => 1
            ],
            [
                'name' => 'All',
                'status' => 1
            ],
        ];
        foreach ($lightingType_data as $value) {
            $lightingType = LightingType::create($value);
        }
    }
}
