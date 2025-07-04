<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@aksess.com',
            'role' => 'admin',
            'password' => bcrypt('adminaksess'),
        ]);
        User::create([
            'name' => 'guru',
            'email' => 'guru@aksess.com',
            'role' => 'guru',
            'password' => bcrypt('guruaksess'),
        ]);
        User::create([
            'name' => 'Muhder Muhrianra',
            'email' => 'muhdar@aksess.com',
            'role' => 'kepsek',
            'password' => bcrypt('kepsekaksess'),
        ]);

    }
}
