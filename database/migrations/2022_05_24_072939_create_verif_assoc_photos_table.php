<?php

use App\Models\VerifAssoc;
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
        Schema::create('verif_assoc_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedBigInteger('verif_assocs_id');
            $table->foreign('verif_assocs_id')->references('id')->on('verif_assocs')->onDelete('cascade');;
            $table->string('pathPhoto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verif_assoc_photos');
    }
};
