<?php

namespace App\Providers\User;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class SimpleProvider implements UserProvider
{
    private GenericUser $user;

    public function __construct()
    {
        $this->user = new GenericUser([
            "id" => "sanjaya",
            "name" => "Sanjaya",
            "token" => "secret"
        ]);
    }

    public function retrieveByCredentials(array $credentials)
    {
        if($credentials["token"] == $this->user->__get("token")){
            return $this->user;
        }
        return null;
    }

    public function retrieveById($identifier)
    {
        return $this->user->getAuthIdentifier() == $identifier ? $this->user : null;
    }

    public function retrieveByToken($identifier, $token)
    {
        if ($this->user->getAuthIdentifier() == $identifier && $this->user->__get('token') == $token) {
            return $this->user;
        }
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Jika menggunakan remember token, update logikanya di sini
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $credentials['token'] == $user->__get('token');
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): bool
    {
        // Jika tidak menggunakan password hash, Anda bisa return false
        return false;
    }
}
