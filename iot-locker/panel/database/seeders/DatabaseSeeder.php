<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $role_name = ['super admin','locker admin','company admin','delivery man'];
        \App\Models\User::factory(1)->create();
        // foreach ($role_name as  $value) {
        //     DB::table('roles')->insert(
        //         [
        //             'role_name' => $value,
        //             'role_slug' => Str::slug($value),
        //         ],
        //     );
        // }
    }
}
