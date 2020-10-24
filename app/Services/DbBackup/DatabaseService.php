<?php

namespace App\Services\DbBackup;

use App\Models\DbBackup\Connection;
use App\Models\DbBackup\Database;
use App\Models\DbBackup\Task;
use Illuminate\Support\Facades\DB;

class DatabaseService
{
    private const defaultConfig = [
        'mysql' => [
            'driver' => 'mysql',
            'url' => null,
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => [],
        ],
    ];

    public function initDatabase(Database $database)
    {
        switch ($database->conn->driver) {
            case Connection::DRIVER_MYSQL: {
                $key = $database->connectionKey;
                $connections = config('database.connections');
                if (empty($connections[$key])) {
                    $conn = $database->conn;
                    $host = $conn->host;
                    $port = 3306;
                    $username = $conn->username;
                    $password = decrypt($conn->password);
                    str_contains($host, ':') && ([$host, $port] = explode(':', $host));
                    $mysql = array_merge(self::defaultConfig['mysql'], compact('host', 'port', 'username', 'password'), ['database' => $database->name]);
                    $connections[$key] = $mysql;
                    config()->set('database.connections', $connections);
                }
            }
        }

    }

    public function getTables(Database $database)
    {
        switch ($database->conn->driver) {
            case Connection::DRIVER_MYSQL: {
                $rs = DB::connection($database->connectionKey)->select('show tables');
                return data_get($rs, '*.Tables_in_' . $database->name);
            }
        }
    }

    public function sqlDump(Database $db, string $file, Task $task)
    {
        switch ($db->conn->driver) {
            case Connection::DRIVER_MYSQL: {
                $conn = $db->conn;
                $host = $conn->host;
                $port = 3306;
                $username = $conn->username;
                $password = decrypt($conn->password);
                str_contains($host, ':') && ([$host, $port] = explode(':', $host));
                $ignoreTables = [];
                foreach ($task->ignoreTables as $ignoreTable) {
                    $ignoreTables[] = '--ignore-table=' . $db->name . '.' . $ignoreTable;
                }
                $ignoreTablesStr = join(' ', $ignoreTables);
                $cmd = ['mysqldump', "-u$username", "-p$password", "-h$host", "-P$port", $db->name, $ignoreTablesStr, '>', $file];
                exec(join(' ', $cmd));
            }
        }
    }
}