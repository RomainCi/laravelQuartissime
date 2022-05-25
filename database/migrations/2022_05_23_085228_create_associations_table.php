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
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->integer('comite_id');
            $table->string('associationName');
            $table->string('firstnamePresident');
            $table->string('lastnamePresident');
            $table->string('adress');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('facebookLink')->nullable();
            $table->string('webSite')->nullable();
            $table->string('description');
            $table->binary('image')->nullable();
            $table->float('latitude', 8, 6);
            $table->float('longitude', 8, 6);
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
        Schema::dropIfExists('associations');
    }
};
