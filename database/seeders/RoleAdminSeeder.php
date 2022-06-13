<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class RoleAdminSeeder extends Seeder
{
    public function run()
    {
        Admin::findOrFail(1)->roles()->sync([1]);
        Admin::findOrFail(2)->roles()->sync([2]);
    }
}
