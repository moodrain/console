<?php

namespace App\Models\DbBackup;

use App\Models\Model;

class Task extends Model
{
    protected $table = 'db_backup_tasks';

    const SAVE_TYPES = ['local', 'oss'];
    const SAVE_TYPE_LOCAL = 'local';
    const SAVE_TYPE_OSS = 'oss';

    protected $casts = [
        'on' => 'bool',
        'ignore_tables' => 'json',
        'ignore_databases' => 'json',
    ];
    protected $appends = ['ignoreDatabasesStr', 'ignoreTablesStr', 'onText'];

    public function conn()
    {
        return $this->belongsTo(Connection::class, 'connection_id');
    }

    public function database()
    {
        return $this->belongsTo(Database::class);
    }

    public function getIgnoreDatabasesStrAttribute()
    {
        return $this->ignoreDatabases ? join(' ', $this->ignoreDatabases) : null;
    }

    public function getIgnoreTablesStrAttribute()
    {
        return $this->ignoreTables ? join(' ', $this->ignoreTables) : null;
    }

    public function getOnTextAttribute()
    {
        return $this->on ? ___('yes') : ___('no');
    }
}