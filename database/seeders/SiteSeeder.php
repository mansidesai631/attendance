<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site;
use Carbon\Carbon;

class SiteSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Site::create([
            'name' => 'Test',
            'code' => '91',
            'timezone' => 'Asia/kolkata',
            'addess' => 'test',
            'employee_mode' => '1',
            'ad_limit' => '0',
            'created_by' => '1',
            'deleted_by' => NULL,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => NULL
        ]);
    }
}
