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
        Schema::create('verif_assocs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('comite_id');
            $table->string('nom')->unique();
            $table->string('token');
            $table->string('adresse');
            $table->string('status');
            $table->string('email')->unique();
            $table->string('telephone')->unique()->nullable();
            $table->text('description');
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
        Schema::dropIfExists('verif_assocs');
    }
};
