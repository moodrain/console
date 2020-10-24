<?php

namespace App\Console\Commands\DbBackup;

use App\Services\DbBackup\BackupService;
use Illuminate\Console\Command;

class Backup extends Command
{
    protected $signature = 'db-backup:backup';
    protected $description = 'Run all backup';

    public function handle()
    {
        $backupSrv = new BackupService();
        $tasks = $backupSrv->getReadyTasks();
        foreach ($tasks as $task) {
            $backupSrv->runTask($task);
        }
    }
}
