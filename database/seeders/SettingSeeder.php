<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::query()->insert([
                [
                    'key' => 'max_files',
                    'value' => 100,
                ],
                [
                    'key' => 'log_level',
                    'value' => 100,
                    ],
            ]
        );
    }
}
