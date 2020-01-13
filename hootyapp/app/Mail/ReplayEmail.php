<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplayEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        error_log("TRIGGERED");
        $name = auth()->guard('web')->user()->first_name;
        $userName = auth()->guard('web')->user()->user_name;
        $address = $userName . '@hooty.co';
        $subject = "Message from " . $name;
        return $this->view($this->data['view'])
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject)
            ->with($this->data);
    }
}
// 'sm' => $sm,"path" => $path
