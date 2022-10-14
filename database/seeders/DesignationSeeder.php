<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;
use Carbon\Carbon;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Designation::truncate();

        $designation = [
            '0' => [
                'name' => 'None',
                'site_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '1' => [
                'name' => 'Director',
                'site_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '2' => [
                'name' => 'Engineer',
                'site_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '3' => [
                'name' => 'Manager',
                'site_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '4' => [
                'name' => 'Office Assistant',
                'site_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '5' => [
                'name' => 'Supervisor',
                'site_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
        ];

        Designation::insert($designation);
    }
}
