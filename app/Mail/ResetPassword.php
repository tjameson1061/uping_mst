<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $link;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param $token
     * @param $link
     * @param $user
     */
    public function __construct($token, $link, $user)
    {
        $this->token = $token;
        $this->link = $link;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mail-reset-password')
                ->subject('Reset Password - UPING')
                ->with(['token' =>$this->token, 'url' => $this->link, 'user' => $this->user]);
    }
}
