<?php

namespace App\Http\Controllers\Api;

use App\Models\Log;

class LogController extends Controller
{
    public function log()
    {
        $this->validate(request(), [
            'applicationId' => 'exists:applications,id',
            'content' => '',
            'note' => '',
        ]);
        Log::query()->create(request()->only('applicationId', 'content' ,'note'));
        return rs();
    }
}