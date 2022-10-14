<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shift;
use Carbon\Carbon;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Shift::truncate();

        $shift = [
            '0' => [
                'site_id' => '1',
                'name' => 'None',
                'code' => 'None',
                'grace_time' => '15',
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'created_by'=> 1,
                'updated_by'=> NULL,
                'deleted_by'=> NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '1' => [
                'site_id' => '1',
                'name' => 'First Shift',
                'code' => 'FIR',
                'grace_time' => '15',
                'start_time' => '07:00:00',
                'end_time' => '14:00:00',
                'created_by'=> 1,
                'updated_by'=> NULL,
                'deleted_by'=> NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '2' => [
                'site_id' => '1',
                'name' => 'Second Shift',
                'code' => 'SEC',
                'grace_time' => '15',
                'start_time' => '14:00:00',
                'end_time' => '21:00:00',
                'created_by'=> 1,
                'updated_by'=> NULL,
                'deleted_by'=> NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '3' => [
                'site_id' => '1',
                'name' => 'General Shift',
                'code' => 'GEN',
                'grace_time' => '15',
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'created_by'=> 1,
                'updated_by'=> NULL,
                'deleted_by'=> NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
        ];

        Shift::insert($shift);
    }
}
