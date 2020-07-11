<?php

namespace App\Console\Commands;

use App\Services\OSSService;
use Illuminate\Console\Command;

class test extends Command
{
    protected $signature = 'test';
    protected $description = 'test';

    public function handle()
    {
        $oss = new OSSService();
    }
}
