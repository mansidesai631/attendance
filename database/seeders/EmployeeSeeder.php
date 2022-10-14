<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Employee::factory()->create([
            'name' => 'Test Employee',
            'email' => 'test@example.com',
            'mobile' => '8758457898',
            'role_id' => '9',
            'gender' => 'Male',
            'created_by' => '9',
        ]);
    }
}
