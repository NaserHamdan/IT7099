<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared('set global max_allowed_packet=104857600 ');
        // \App\Models\User::factory(10)->create();
        $this->call([
            schedule_seeder::class,
            yearsSeeder::class,
            majorsSeeder::class
        ]);
    }
}
