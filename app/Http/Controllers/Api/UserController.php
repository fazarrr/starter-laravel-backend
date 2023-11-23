<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;
    protected $jwt;

    public function __construct(Request $request)
    {
        $this->user = new User;
        $this->jwt  = $request->bearerToken();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jwt        = JWT::decode($this->jwt, new Key(env('JWT_SECRET_KEY'), 'HS256'));
        // $id_user    = $jwt->id;
        $name       = $jwt->name;
        $roles      = $jwt->roles;

        $user       = [
            'nama'      => $name,
            'roles'     => $roles,
        ];

        $data = User::all();

        return response()->json([
            'status'    => 'success',
            'user'      => $user,
            'data'      => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'          => 'required',
                'email'         => 'required|email',
                'password'      => 'required',
                'roles'         => 'required',
                'is_active'     => 'required|digits:1'
            ],
            [
                'name.required'         => 'Nama wajib diisi',
                'email.required'        => 'Email wajib diisi',
                'email.email'           => 'Format email tidak valid',
                'password.required'     => 'Password wajib diisi',
                'roles.required'        => 'Roles wajib diisi',
                'is_active.required'    => 'Active wajib diisi',
                'is_active.digits'      => 'Active hanya 1 dan 0',
            ]
        );

        $save = $this->user->create([
            'id'        => str::uuid(),
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password')),
            'roles'     => $request->input('roles'),
            'is_active' => $request->input('is_active'),
        ]);

        if (!$save) {
            return response()->json([
                'status'        => 'invalid',
                'message'       => $save->errors(),
            ], 422);
        } else {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Data berhasil di simpan',
                'data'      => $save
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jwt        = JWT::decode($this->jwt, new Key(env('JWT_SECRET_KEY'), 'HS256'));
        // $id_user    = $jwt->id;
        $name       = $jwt->name;
        $roles      = $jwt->roles;

        $user       = [
            'nama'  => $name,
            'roles' => $roles,
        ];

        if (strlen($id) == 36) {
            $users = User::where('id', $id)->first();
        } else {
            $users = null;
        }

        if ($users != null) {
            return response()->json([
                'status'    => 'success',
                'user'      => $user,
                'data'      => $users
            ], 200);
        } else {
            return response()->json([
                'status'    => 'not found',
                'message'   => 'Data user tidak ada',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $password = $request->input('password');
        $request->validate(
            [
                'name'          => 'required',
                'email'         => 'required|email',
                'roles'         => 'required',
                'is_active'     => 'required|digits:1'
            ],
            [
                'name.required'         => 'Nama wajib diisi',
                'email.required'        => 'Email wajib diisi',
                'email.email'           => 'Format email tidak valid',
                'roles.required'        => 'Roles wajib diisi',
                'is_active.required'    => 'Active wajib diisi',
                'is_active.digits'      => 'Active hanya 1 dan 0',
            ]
        );

        if ($password) {
            $update = $this->user->where('id', $id)->update([
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'password'  => Hash::make($password),
                'roles'     => $request->input('roles'),
                'is_active' => $request->input('is_active'),
            ]);
        } else {
            $update = $this->user->where('id', $id)->update([
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'roles'     => $request->input('roles'),
                'is_active' => $request->input('is_active'),
            ]);
        }

        if (!$update) {
            return response()->json([
                'status'        => 'invalid',
                'message'       => "Id user tidak di temukan",
            ], 422);
        } else {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Data berhasil di perbarui',
            ], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (strlen($id) == 36) {
            $delete = $this->user->where('id', $id)->delete();
        } else {
            $delete = null;
        }

        if ($delete) {
            return response()->json([
                'status'        => 'success',
                'message'       => 'Data berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'status'        => 'error',
                'header'        => 'Data gagal dihapus',
            ], 422);
        }
    }
}
