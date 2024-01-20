<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->forceCreate([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 123456789,
            'is_admin' => 1,
        ]);
    }
}
