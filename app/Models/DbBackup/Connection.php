<?php

namespace App\Models\DbBackup;

use App\Models\Model;

class Connection extends Model
{
    protected $table = 'db_backup_connections';

    public static $searchRule = [
        'id' => '=',
        'name' => 'like',
        'host' => 'like'
    ];

    const DRIVERS = ['mysql'];
    const DRIVER_MYSQL = 'mysql';

    public static $sortRule = ['id', 'name', 'host', 'updatedAt'];

    protected $hidden = ['password'];

    public function databases()
    {
        return $this->hasMany(Database::class);
    }

    public function getPasswordAttribute($password)
    {
        return decrypt($password);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = encrypt($password);
    }
}