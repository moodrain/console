<?php

namespace App\Jobs;

use App\Mail\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    private $mail;
    private $mailer;
    private $mailerConfig;

    public function __construct(Mail $mail, $mailerConfig)
    {
        $this->queue = 'mail';
        $this->mail = $mail;
        $this->mailerConfig = $mailerConfig;
    }


    public function handle()
    {
        Config::set('mail.mailers.tmp', $this->mailerConfig);
        \Illuminate\Support\Facades\Mail::mailer($this->mail->mailer)->send($this->mail);
    }

}
