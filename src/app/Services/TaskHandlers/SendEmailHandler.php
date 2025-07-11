<?php

namespace App\Services\TaskHandlers;

use Illuminate\Support\Facades\Mail;
use App\Mail\GenericNotification;

class SendEmailHandler
{
    public function handle(array $payload): void
    {
        Mail::to($payload['to'])->send(new GenericNotification(
            $payload['subject'],
            $payload['body']
        ));
    }
}

