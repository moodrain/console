<?php

namespace App\Http\Controllers;

use AlibabaCloud\Client\AlibabaCloud;

class DNSController extends Controller
{
    public function put()
    {
        $this->validate(request(), [
            'domain' => 'required',
            'putRecord' => 'array',
            'putRecord.rr' => 'required',
            'putRecord.value' => 'required',
            'putRecord.type' => 'required',
        ]);

    }
}