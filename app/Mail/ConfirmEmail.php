<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $confirmationLink;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $confirmationLink
     */
    public function __construct($user, $confirmationLink)
    {
        $this->user = $user;
        $this->confirmationLink = $confirmationLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Xác nhận đăng ký tài khoản')
                    ->view('client.page.auth.emails.confirm');
    }
}
