<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $notifiable;
    public $expireTime;

    /**
     * Create a new message instance.
     */
    public function __construct($url, $notifiable, $expireTime)
    {
        $this->url = $url;
        $this->notifiable = $notifiable;
        $this->expireTime = $expireTime;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->notifiable->email)
            ->subject('Reset Password Notification')
            ->view('emails.reset-password')
            ->text('emails.reset-password-text')
            ->with([
                'url' => $this->url,
                'notifiable' => $this->notifiable,
                'expireTime' => $this->expireTime
            ]);
    }
}
