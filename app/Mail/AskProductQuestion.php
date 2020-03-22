<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AskProductQuestion extends Mailable
{
    use SerializesModels;

    /**
     * @var Request
     */
    public $data;
    /**
     * @var Product
     */
    public $product;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, Product $product)
    {
        $this->data = (object)$data;
        $this->product = $product;
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
            ->subject('Вопрос по товару')
            ->view('mail.product_question');
    }
}
