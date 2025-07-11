<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $subjectLine;
    public string $messageBody;

    public function __construct(string $subjectLine, string $messageBody)
    {
        $this->subjectLine = $subjectLine;
        $this->messageBody = $messageBody;
    }

    public function build()
    {
        return $this
            ->subject($this->subjectLine)
            ->view('emails.generic')
            ->with([
                'body' => $this->messageBody
            ]);
    }

}
