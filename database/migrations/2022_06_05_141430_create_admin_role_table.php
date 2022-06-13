<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('admin_role', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles')->onDelete('CASCADE');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_role');
    }
};
