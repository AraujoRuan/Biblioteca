<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('primary_color')->default('#2c3e50');
            $table->string('secondary_color')->default('#3498db');
            $table->integer('loan_period')->default(14);
            $table->integer('max_books_per_user')->default(5);
            $table->decimal('fine_amount_per_day', 8, 2)->default(2.00);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('libraries');
    }
};