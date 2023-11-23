<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Carbon\Carbon;
use App\Models\{
    User,
};
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = $request->validate(
            [
                'email'     => 'required',
                'password'  => 'required'
            ],
            [
                'email.required'        => 'Email wajib diisi',
                'password.required'     => 'Password wajib diisi'
            ]
        );

        if (!$validator) {
            return response()->json($validator, 422);
        }

        if (Auth::attempt($validator)) {
            if (Auth::user()->roles == 'Super Admin' || Auth::user()->roles == 'Admin' || Auth::user()->roles == 'User') {
                $session_id = bin2hex(random_bytes(15));
                $payload = [
                    'iss'           => 'https://dinkes.jakarta.go.id/jaksimpel/',
                    'session_id'    => $session_id,
                    'id'            => Auth::user()->id,
                    'name'          => Auth::user()->name,
                    'roles'         => Auth::user()->roles,
                    'iat'           => Carbon::now()->timestamp,
                    'exp'           => Carbon::now()->timestamp + 60 * 60 * 2, //Set expired token, ini 2 jam (60 detik x 60 menit x 2 jam)
                ];

                $jwt = JWT::encode($payload, env('JWT_SECRET_KEY'), 'HS256');

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Token berhasil di generate',
                    'user'      => [
                        'nama'  => Auth::user()->name,
                        'roles' => Auth::user()->roles,
                    ],
                    'token'     => 'Bearer ' . $jwt
                ], 200);
            } else {
                Auth::logout();

                return response()->json([
                    'status'    => 'unauthorized',
                    'message'   => 'Anda tidak bisa mengakses modul API'
                ], 401);
            }
        }

        return response()->json([
            'status'    => 'not found',
            'message'   => 'Username atau password salah'
        ], 401);
    }
}
