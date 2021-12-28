<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Modules\SuperAdmin\Models\SuperAdmin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('staff')->insert([
          'email' => 'xxxxx@gmail.com',
          'name' => 'Ranger',
          'password' => bcrypt('1234'),
          'user_type' => SuperAdmin::class
        ]);
    }
}
