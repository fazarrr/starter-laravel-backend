<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DomainException;
use InvalidArgumentException;
use UnexpectedValueException;

class AuthenticateJwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $jwt = $request->bearerToken();

        try {
            $jwt = $request->bearerToken();

            if (is_null($jwt) || $jwt == '') {
                return response()->json([
                    'status'    => 'unauthorized',
                    'message' => 'Token tidak boleh kosong',
                ], 401);
            } else {
                $decoded = JWT::decode($jwt, new Key(env('JWT_SECRET_KEY'), 'HS256'));
                return $next($request);
            }
        } catch (InvalidArgumentException $e) {
            // provided key/key-array is empty or malformed.
            return response()->json([
                'status'    => 'unauthorized',
                'message' => $e->getMessage(),
            ], 401);
        } catch (DomainException $e) {
            // provided algorithm is unsupported OR
            // provided key is invalid OR
            // unknown error thrown in openSSL or libsodium OR
            // libsodium is required but not available.
            return response()->json([
                'status'    => 'unauthorized',
                'message' => $e->getMessage(),
            ], 401);
        } catch (SignatureInvalidException $e) {
            // provided JWT signature verification failed.
            return response()->json([
                'status'    => 'unauthorized',
                'message' => $e->getMessage(),
            ], 401);
        } catch (BeforeValidException $e) {
            // provided JWT is trying to be used before "nbf" claim OR
            // provided JWT is trying to be used before "iat" claim.
            return response()->json([
                'status'    => 'unauthorized',
                'message' => $e->getMessage(),
            ], 401);
        } catch (ExpiredException $e) {
            // provided JWT is trying to be used after "exp" claim.
            return response()->json([
                'status'    => 'unauthorized',
                'message' => $e->getMessage(),
            ], 401);
        } catch (UnexpectedValueException $e) {
            // provided JWT is malformed OR
            // provided JWT is missing an algorithm / using an unsupported algorithm OR
            // provided JWT algorithm does not match provided key OR
            // provided key ID in key/key-array is empty or invalid.
            return response()->json([
                'status'    => 'unauthorized',
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}
