<?php

namespace App\Http\Middleware;

use App\Http\Response\UnauthorizedRequestResponse;
use App\Services\Security\Authentication;
use Illuminate\Http\Response;;
use Closure;

class Administrator
{
    private $authentication;

    /**
     * AdministratorMiddleware constructor.
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($this->authentication->isAdministrator($user)) {
            return $next($request);
        }

        return (
            new UnauthorizedRequestResponse('Forbidden.')
        )
            ->response()
            ->setStatusCode(Response::HTTP_FORBIDDEN);
    }
}
