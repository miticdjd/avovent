<?php

namespace App\Http\Controllers;

use App\Http\Response\BaseResponse;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Home controller actions
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display Avovent test message
     * @return JsonResponse
     */
    public function welcome(): JsonResponse
    {
        return (
            new BaseResponse()
        )
            ->setMessage('Welcome to Avovent test')
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
