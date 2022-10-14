<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaffCategory;
use Carbon\Carbon;

class StaffCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffCategory::truncate();

        $category = [
            '0' => [
                'name' => 'Permanent',
                'ad_limit' => '0',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '1' => [
                'name' => 'Contract',
                'ad_limit' => '0',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '2' => [
                'name' => 'Casual',
                'ad_limit' => '0',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '3' => [
                'name' => 'Temporary',
                'ad_limit' => '0',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '4' => [
                'name' => 'Other',
                'ad_limit' => '0',
                'created_by' => '1',
                'deleted_by' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
        ];

        StaffCategory::insert($category);
    }
}
