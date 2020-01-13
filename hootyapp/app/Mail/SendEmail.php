<?php

namespace App\Mail;

use App\User;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
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
        $this->user = new User;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "";
        $id = auth()->guard('web')->user()->id;
        $email = auth()->guard('web')->user()->email;
        $userName = auth()->guard('web')->user()->user_name;
        $name = auth()->guard('web')->user()->first_name;
        if (empty($userName)) {
            $Name = str_replace(' ', '_', $name);
            $cstrong = true;
            $bytes = openssl_random_pseudo_bytes(4, $cstrong);
            $hex = bin2hex($bytes);
            $userName = $Name . "_" . $hex;
            $user = Auth::user();
            $user->user_name = $userName;
            $user->save();
        }
        if (empty($this->data['subject'])) {
            $subject = "Message from " . $this->data['first_name'];
        } else {
            $subject = $this->data['subject'];
        }
        error_log("********************");
        error_log(json_encode($this->data));
        error_log("********************");

        $address = $userName . '@hooty.co';

        error_log("************************");
        error_log("MESSAGE ID");
        error_log($this->data["messageId"]);
        error_log("************************");

        $headerData = [
            'unique_args' => [
                'MessageUID' => $this->data["messageId"],
            ],
        ];

        $header = json_encode($headerData);

        error_log($header);

        $this->withSwiftMessage(function ($message) use ($header) {
            error_log($header);
            $message->getHeaders()
                ->addTextHeader('X-SMTPAPI', $header);
        });

        return $this->view($this->data['view'])
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject)
            ->with(['data' => $this->data]);
    }

    private function asJSON($data)
    {
        $json = json_encode($data);
        $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);

        return $json;
    }

    private function asString($data)
    {
        $json = $this->asJSON($data);

        return wordwrap($json, 76, "\n   ");
    }
}
