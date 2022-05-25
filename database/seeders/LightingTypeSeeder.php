<?php

namespace Database\Seeders;

use App\Models\LightingType;
use Illuminate\Database\Seeder;

class LightingTypeSeeder extends Seeder
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
                'name' => 'Spots',
                'status' => '1'
            ],
            [
                'name' => 'Cove',
                'status' => '1'
            ],
            [
                'name' => 'Entrance Spot',
                'status' => '1'
            ],
            [
                'name' => 'Entrance Cove',
                'status' => '1'
            ],
            [
                'name' => 'Wash',
                'status' => '1'
            ],
            [
                'name' => 'All',
                'status' => '1'
            ],
        ];
        foreach($data as $value) {
            LightingType::create($value);
        }

    }
}
