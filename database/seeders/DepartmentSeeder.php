<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::truncate();

        $department = [
            '0' => [
                'name' => 'None',
                'site_id' => '1',
                'head_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '1' => [
                'name' => 'Admin',
                'site_id' => '1',
                'head_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '2' => [
                'name' => 'HR',
                'site_id' => '1',
                'head_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '3' => [
                'name' => 'IT',
                'site_id' => '1',
                'head_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '4' => [
                'name' => 'Marketing',
                'site_id' => '1',
                'head_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '5' => [
                'name' => 'Sales',
                'site_id' => '1',
                'head_id' => '1',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
        ];

        Department::insert($department);
    }
}
