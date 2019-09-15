<?php

namespace Lucid\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Lucid\User;

class EmailMagicLoginLinkRequested extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $options;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, array $options)
    {
        $this->user = $user;
        $this->options = $options;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('lucid.social@gmail.com')->subject('Your Magic Login Link')->view('auth.magic-link')->with([
            'loginLink' =>$this->buildLink(),
        ]);

    }

    public function buildLink() {
        return url('/login/magic/'.$this->user->token->token.'?'.http_build_query($this->options));
    }
}
