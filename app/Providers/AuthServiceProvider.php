<?php

namespace App\Providers;

use Illuminate\Auth\GenericUser;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest(
            'api',
            function ($request) {
                if ($request->input('api_token')) {
                    switch ($request->input('api_token')) {
                        case '21232f297a57a5a743894a0e4a801fc3':
                            return new GenericUser(['id' => 1, 'name' => 'Administrator']);
                            break;

                        case '8a5da52ed126447d359e70c05721a8aa':
                            return new GenericUser(['id' => 2, 'name' => 'Site API']);
                            break;

                        default:
                            return null;
                            break;
                    }
                }
                return null;
            }
        );
    }
}
