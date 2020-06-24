<?php

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
        $users = collect();
        for ($i = 1; $i <= 3; $i++) {
            $users->push([
                'id' => $i,
                'email' => "user$i@mail.com",
                'name' => 'user' . $i,
                'password' => password_hash('123', PASSWORD_DEFAULT),
            ]);
        }
        $users->map(function($user) {
            \App\Models\User::query()->create($user);
        });
        \App\Models\Application::query()->create([
            'id' => 1,
            'name' => 'app-1',
            'detail' => 'app-1-detail',
            'site' => 'https://app-1.com',
        ]);
        \App\Models\JsonStorage::query()->create([
            'id' => 1,
            'application_id' => 1,
            'name' => 'app-1-json',
            'token' => 'app-1-token',
            'data' => ['visit' => 2, 'click' => 1],
            'note' => 'app-1-note',
        ]);
    }

}
