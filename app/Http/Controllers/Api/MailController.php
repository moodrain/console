<?php

namespace App\Http\Controllers\Api;

use App\Jobs\SendMail;
use App\Mail\Mail;

class MailController extends Controller
{
    public function send()
    {
        $this->validate(request(), [
            'host' => 'required',
            'port' => 'required|int',
            'encryption' => 'in:ssl,tls',
            'username' => 'required',
            'password' => 'required',
            'fromName' => '',
            'fromAddress' => 'required',
            'toName' => '',
            'toAddress' => 'required',
            'cc' => 'array',
            'content' => 'required',
            'subject' => 'required',
        ]);

        $config = array_merge([
            'transport' => 'smtp',
            'timeout' => null,
            'auth_mode' => null,
        ], request()->only('host', 'port', 'encryption', 'username', 'password'));

        $mail = new Mail();
        $mail->mailer('tmp')
            ->content(request('content'))
            ->subject(request('subject'))
            ->from(request('fromAddress'), request('fromName'))
            ->to(request('toAddress'), request('toName'))
            ->cc(request('cc', []));
        SendMail::dispatch($mail, $config);
        return rs();
    }

}