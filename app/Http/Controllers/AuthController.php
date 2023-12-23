<?php

namespace App\Http\Controllers;

use App\Models\Viewers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $remember    = $request->input('remember');
        $credentials = $request->only('username', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error_code' => 1,
                    'message'    => trans('Username or password is incorrect'),
                ], 200);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error_code' => 1,
                'message'    => $e->getMessage(),
                'jwt.ttl'    => config('jwt.ttl')
            ], 200);
        }
        $user = Auth::user();

        $user['roles'] = $user->getRoleSlugAttribute();
        $user['permissions'] = $user->getPermissionSlugAttribute();

        return response()->json([
            'error_code' => 0,
            'data'       => [
                'user'     => $user,
                'token'    => $token,
                'remember' => $remember
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        $token = JWTAuth::getToken();
        if ($token) {
            JWTAuth::setToken($token)->invalidate();
        }

        return response()->json([
            'error_code' => 0,
            'data'       => [],
            'message'    => trans('Logout success')
        ], 200);
    }

    public function register(Request $request)
    {
        $email          = $request->input('email');
        $password       = $request->input('password');
        $username       = $request->input('username');
        $customMessages = [];
        $validator      = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:255',
                'min:3',
                'unique:viewers',
                function ($attribute, $value, $fail) use ($request) {
                    if (!ctype_alnum($value)) {
                        return $fail('Tên tài khoản chỉ bao gồm chữ và số');
                    }
                }
            ],
            'email'    => ['nullable', 'string', 'email', 'max:255', 'unique:viewers'],
            'password' => ['required'],
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'message'    => trans('The given data is invalid'),
                'errors'     => $validator->errors()
            ], 200);
        }

        $viewer            = new Viewers();
        $viewer->username  = $username;
        $viewer->email     = $email;
        $viewer->password  = Hash::make($password);
        $viewer->save();

        $token = JWTAuth::fromUser($viewer);

        return response()->json([
            'error_code' => 0,
            'message'    => trans('Registered!'),
            'data'       => [
                'viewer'  => $viewer,
                'token' => $token
            ],
        ], 200);
    }
}
