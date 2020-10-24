<?php

use App\Models\User;
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
        User::query()->create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => password_hash('123', PASSWORD_DEFAULT),
        ]);
        \App\Models\DbBackup\Connection::query()->create([
            'name' => 'local',
            'host' => 'localhost',
            'username' => 'root',
            'password' => encrypt('password'),
            'driver' => \App\Models\DbBackup\Connection::DRIVER_MYSQL,
        ]);
    }

}
