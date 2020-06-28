<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWxMiniProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_mini_programs', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->nullable();
            $table->string('appid');
            $table->string('appsecret');
            $table->string('access_token');
            $table->integer('access_token_expires_at');
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
        Schema::dropIfExists('wx_mini_programs');
    }
}
