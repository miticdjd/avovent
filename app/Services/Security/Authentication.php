<?php

namespace App\Services\Security;

use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Http;

/**
 * Handle authentication of a user by user microservice
 */
class Authentication
{
    /**
     * Fake tokens
     * @var array
     */
    private $tokens = [
        '21232f297a57a5a743894a0e4a801fc3' => 1,
        '8a5da52ed126447d359e70c05721a8aa' => 2
    ];

    /**
     * Authenticate a user
     * @param string $token
     * @return GenericUser|null
     */
    public function authenticate(string $token): ?GenericUser
    {
        $id = $this->getIdByToken($token);

        if ($id) {
            $response = Http::get(
                config('services.users') . $id
            )->json();

            $data = $response['data'];

            return new GenericUser($data);
        }

        return null;
    }

    /**
     * Get id of user by token
     * @param string $token
     * @return int|null
     */
    private function getIdByToken(string $token): ?int
    {
        if (isset($this->tokens[$token])) {
            return $this->tokens[$token];
        }

        return null;
    }
}
