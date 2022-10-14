<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Manager;
use Carbon\Carbon;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Manager::truncate();

       	$manager = [
            '0' => [
                'name' => 'Naushil Jain',
                'mobile' => '1234567890',
                'email' => 'nj@gmail.com',
                'role_id' => 1,
                'timezone' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
            '1' => [
                'name' => 'Anhi Shah',
                'mobile' => '9876543210',
                'email' => 'abhi@gmail.com',
                'role_id' => 1,
                'timezone' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => NULL
            ],
        ];

        Manager::insert($manager);
    }
}
