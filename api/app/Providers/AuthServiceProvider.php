<?php

namespace App\Providers;

use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Gate;
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

        $this->app['auth']->viaRequest('api', function ($request) {
            $authHeader = $request->header('authorization');
            if ($authHeader) {
                list($jwt) = sscanf( $authHeader, 'Bearer %s');
                if ($jwt) {
                    try {
                        /** @var $secretKey key used to encode the jwt token*/
                        $secretKey = base64_decode(env('APP_KEY'));
                        $token = JWT::decode($jwt, $secretKey, array('HS256'));
                        $method = strtolower($request->method());
                        //token data contains request method permission
                        //check if current request method is allowed for user
                        if($token->data->$method)
                            return true;
                    } catch (\Exception $e) {
                        /*
                         * the token was not able to be decoded.
                         * this is likely because the signature was not able to be verified (tampered token)
                         */
                    }
                }
            }
        });
    }
}
