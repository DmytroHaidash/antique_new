<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AskQuestion extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * AskQuestion constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = (object)$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to(config('app.admin_email'))
            ->subject('Вопрос  по кспертизе и оценке')
            ->view('mail.question');
    }
}
