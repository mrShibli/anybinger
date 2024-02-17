<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;
    public $customerName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($resetLink, $customerName)
    {
        $this->resetLink = $resetLink;
        $this->customerName = $customerName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Password Reset - AnyBringr')
            ->view('mail.reset');
    }
}
