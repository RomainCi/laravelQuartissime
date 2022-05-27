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
        Schema::create('comites', function (Blueprint $table) {
            $table->id();
            $table->integer('user_comite_id')->nullable();
            $table->string('comiteName');
            $table->string('firstnamePresident');
            $table->string('lastnamePresident');
            $table->string('adress');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('facebookLink')->nullable();
            $table->string('webSite')->nullable();
            $table->string('description');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 10, 8);
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
        Schema::dropIfExists('comites');
    }
};
