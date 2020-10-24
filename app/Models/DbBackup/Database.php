<?php

namespace App\Models\DbBackup;

use App\Models\Model;

class Database extends Model
{
    protected $table = 'db_backup_databases';

    public static $searchRule = [
        'id' => '=',
        'name' => 'like',
        'connectionId/d' => '=',
    ];

    public static $sortRule = ['id', 'name', 'updatedAt'];

    public function conn()
    {
        return $this->belongsTo(Connection::class, 'connection_id');
    }

    public function getConnectionKeyAttribute()
    {
        return $this->conn->name . '-' . $this->name;
    }
}