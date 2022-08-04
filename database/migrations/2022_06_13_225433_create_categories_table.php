<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->string('image');
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories');
            $table->boolean('is_offer')->default(0);
            $table->boolean('is_offer_by_category')->default(0);
            $table->float('offer_price')->default(0);
            $table->float('offer_discount')->default(0);
            $table->dateTime('end_offer')->nullable();
            $table->string('offer_image')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('featured')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
