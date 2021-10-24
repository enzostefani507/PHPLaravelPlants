<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantas_user', function (Blueprint $table) {
            $table->unsignedBigInteger('plantas_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('plantas_id')->references('id')->on('plantas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->primary(['plantas_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planta_user');
    }
}
