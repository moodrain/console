<?php

namespace App\Services\DbBackup;

use App\Models\DbBackup\Database;
use App\Models\DbBackup\Task;
use App\Services\OssService;
use Carbon\Carbon;

class BackupService
{
    public function runTask(Task $task)
    {
        if ($task->database) {
            $this->handleDatabase($task->database, $task);
        } else {
            $databases = $task->conn->databases;
            foreach ($databases as $database) {
                if (in_array($database->name, $task->ignoreDatabases)) {
                    continue;
                }
                $this->handleDatabase($database, $task);
            }
        }
    }

    private function handleDatabase(Database $database, Task $task)
    {
        switch ($task->saveType) {
            case Task::SAVE_TYPE_LOCAL: {
                $this->handleLocalTask($database, $task);
                break;
            }
            case Task::SAVE_TYPE_OSS: {
                $this->handleOssTask($database, $task);
                break;
            }
        }
    }

    private function handleLocalTask(Database $database, Task $task)
    {
        $db = new DatabaseService();
        $path = storage_path('app/db-backup/' . $database->connectionKey);
        $file = $path . '/' . date('YmdHis') . '.sql';
        ! file_exists($path) && mkdir($path);
        $files = scandir($path);
        $files = array_slice($files, 2);
        sort($files);
        if (count($files) >= $task->backupKeepCount) {
            $rmFiles = array_splice($files, 0, count($files) - $task->backupKeepCount + 1);
            foreach ($rmFiles as $rmFile) {
                unlink($path . '/' . $rmFile);
            }
        }
        $db->sqlDump($database, $file, $task);
        filesize($file) < 100 && unlink($file);
        $task->update(['lastRunAt' => Carbon::now()]);
    }

    private function handleOssTask(Database $database, Task $task)
    {
        $db = new DatabaseService();
        $oss = new OssService();
        $bucket = config('db-backup.oss.bucket');
        $ossPath = config('db-backup.oss.path') . '/' . $database->connectionKey;
        $localFile = storage_path('app/db-backup/' . $database->connectionKey . '.sql');
        $db->sqlDump($task->database, $localFile, $task);
        if (filesize($localFile) < 100) {
            return;
        }
        try {
            $files = $oss->files($bucket, $ossPath);
            if (count($files) >= $task->backupKeepCount) {
                $rmFiles = array_splice($files, 0, count($files) - $task->backupKeepCount + 1);
                dd($files, $rmFiles);
                foreach ($rmFiles as $rmFile) {
                    $oss->delete($bucket, $ossPath . '/' . $rmFile);
                }
            }
            $oss->put($bucket, $ossPath . '/' . date('YmdHis') . '.sql', file_get_contents($localFile));
            $task->update(['lastRunAt' => Carbon::now()]);
        } catch (\Throwable $e) {}
        unlink($localFile);
    }

    public function getReadyTasks()
    {
        return Task::query()->where('on', true)->where(function ($q) {
            $q->whereNull('last_run_at')->orWhereRaw('unix_timestamp() - unix_timestamp(last_run_at) > backup_interval');
        })->get();
    }
}
