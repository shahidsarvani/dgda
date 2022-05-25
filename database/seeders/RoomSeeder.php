<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'name' => 'Wadi Safer',
                'name_ar' => 'وادي صافر',
                'type' => '1',
                'status' => '1'
            ],
            [
                'name' => 'Diriyah',
                'name_ar' => 'الدرعية',
                'type' => '1',
                'status' => '1'
            ],
            [
                'name' => 'Combined',
                'name_ar' => 'مجموع',
                'type' => '1',
                'status' => '1'
            ],
            [
                'name' => 'Technical',
                'name_ar' => 'اِصطِلاحِيّ',
                'type' => '2',
                'status' => '1'
            ],
        ];
        foreach($data as $value) {
            Room::create($value);
        }
    }
}
