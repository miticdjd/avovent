<?php

namespace App\Http\Response;

use Illuminate\Auth\AuthenticationException;

/**
 * Unauthorized request response
 */
class UnauthorizedRequestResponse extends ErrorResponse
{
    public function __construct(string $message)
    {
        parent::__construct([]);

        $this->addAdditional('message', $message);
    }
}
