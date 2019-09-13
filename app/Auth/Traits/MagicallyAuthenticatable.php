<?php 

namespace Lucid\Auth\Traits;

use Lucid\UserEmailLoginToken;
use Mail;
use Lucid\Mail\EmailMagicLoginLinkRequested;

trait MagicallyAuthenticatable 
{
    public function token() {
        return $this->hasOne(UserEmailLoginToken::class);
    }

    public function storeToken() {
        $this->token()->delete();

        $this->token()->create([
            'token'=>str_random(255),
        ]);

        return $this;
    }

    public function sendMagicLink(array $options) {
        Mail::to($this)->send(new EmailMagicLoginLinkRequested($this, $options));
    }
}


?>