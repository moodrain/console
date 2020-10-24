<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbBackupTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('db_backup_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('connection_id');
            $table->integer('database_id')->nullable();
            $table->string('name')->unique();
            $table->enum('save_type', \App\Models\DbBackup\Task::SAVE_TYPES)->comment('local 本地 | oss 阿里云OSS');
            $table->integer('backup_keep_count');
            $table->integer('backup_interval')->comment('间隔 秒');
            $table->json('ignore_tables')->nullable();
            $table->json('ignore_databases')->nullable();
            $table->boolean('on');
            $table->timestamp('last_run_at')->nullable();
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
        Schema::dropIfExists('db_backup_tasks');
    }
}
