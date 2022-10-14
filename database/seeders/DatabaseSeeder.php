<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(SiteSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(StaffCategorySeeder::class);
        $this->call(ManagerSeeder::class);
        $this->call(ShiftSeeder::class);
    }
}
