<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $url)
    {
        $this->email = $email;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('Recover password'))
            ->view('layout_index.reset_password.view_password')->with(['email' => $this->email, 'url' => $this->url]);
    }
}
