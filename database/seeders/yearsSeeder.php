<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class yearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sql = public_path('sql/years.sql');

        $db = [
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE')
        ];
        DB::unprepared(file_get_contents($sql));
        // exec("mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --database {$db['database']} < $sql");
    }
}
