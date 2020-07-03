<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQqConnectAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qq_connect_apps', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->nullable();
            $table->string('appid');
            $table->string('appkey');
            $table->string('callback_url');
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
        Schema::dropIfExists('qq_connect_apps');
    }
}
