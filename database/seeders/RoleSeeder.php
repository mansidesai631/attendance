<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use File;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        $json = File::get("database/data/roles.json");
        $roles = json_decode($json);

        foreach ($roles as $key => $value) {
            Role::create([
                "name" => $value->name,
                "permission" => json_encode($value->permission),
                "created_by" => 1,
                "deleted_by"=> NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                "deleted_at" => NULL

            ]);
        }
    }
}
