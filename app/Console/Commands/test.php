<?php

namespace App\Console\Commands;

use App\Services\OssService;
use Illuminate\Console\Command;

class test extends Command
{
    protected $signature = 'test';
    protected $description = 'test';

    public function handle()
    {
        $oss = new OssService();
        $rs = $oss->directories('moodrain', 'bookmark');
        print_r($rs);
    }
}
