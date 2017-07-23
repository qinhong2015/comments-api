<?php
/**
 * Created by PhpStorm.
 * User: taint
 * Date: 7/23/2017
 * Time: 9:20 PM
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Firebase\JWT\JWT;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate jwt token with SHA256 signing algorithm';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            $secretKey = base64_decode(env('APP_KEY'));
            $issuedAt   = time();
            $notBefore  = $issuedAt;
            $serverName = 'Comments App';
            /*
             * Create the token as an array
             */
            $data = [
                'iat'  => $issuedAt,         // Issued at: time when the token was generated
                'iss'  => $serverName,       // Issuer
                'nbf'  => $notBefore,        // Not before
                'data' => [                  // Data related to the signer user
                    'get' => true,
                    'put' => true,
                    'post' => true,
                    'delete' => true
                ]
            ];

            /*
             * Encode the array to a JWT string.
             * Second parameter is the key to encode the token.
             *
             * The output string can be validated at http://jwt.io/
             */
            $jwt = JWT::encode(
                $data,      //Data to be encoded in the JWT
                $secretKey, // The signing key
                'HS256'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
            );

            $this->info($jwt);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}