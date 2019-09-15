<?php 

namespace Lucid\Auth;

use Illuminate\Http\Request;

use Lucid\User;


class MagicAuthentication
{
    protected $request;

    protected $identifier = "email";

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function requestLink() {
        $user = $this->getUserByIdentifier($this->request->get($this->identifier));
        
        

        $user->storeToken()->sendMagicLink([
            'remember' => 1,
            'email'    => $user->email,
        ]);
    }

    protected function getUserByIdentifier($value) {
        return User::where($this->identifier, $value)->firstOrFail();
    }
    
}

?>