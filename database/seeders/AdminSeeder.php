<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => 'Carlos Cortez',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::ACTIVE
        ]);

        Admin::create([
            'name' => 'Alexander Vásquez',
            'email' => 'editor@admin.com',
            'password' => bcrypt('password'),
            'status' => UserStatus::ACTIVE
        ]);
    }
}
