<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWxMsgTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_msg_temps', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->nullable();
            $table->string('name');
            $table->string('temp_id');
            $table->json('data');
            $table->json('map');
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
        Schema::dropIfExists('wx_msg_temps');
    }
}
