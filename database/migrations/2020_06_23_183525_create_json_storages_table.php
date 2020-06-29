<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJsonStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('json_storages', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->default(0);
            $table->string('name');
            $table->json('data');
            $table->string('note')->nullable();
            $table->unique(['application_id', 'name']);
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
        Schema::dropIfExists('json_storages');
    }
}
