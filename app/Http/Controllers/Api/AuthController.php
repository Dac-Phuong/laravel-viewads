<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Viewers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $email          = $request->input('email');
        $password       = $request->input('password');
        $username       = $request->input('username');
        $code_viewer    = $request->input('code_viewer');
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
        if ($code_viewer) {
            $check_code = Viewers::where('code', $code_viewer)->first();
            if (empty($check_code)) {
                return response()->json([
                    'error_code' => 1,
                    'message'    => trans('The introduction code is not correct'),
                ], 200);
            }
        }
        $shortenedUsername = substr($username, 0, 3);
        $viewer            = new Viewers();
        $viewer->code      = $shortenedUsername . Str::random(5);
        $viewer->username  = $username;
        $viewer->email     = $email;
        $viewer->password  = Hash::make($password);
        $viewer->presenter_id  = $check_code->id ?? 0;
        $viewer->save();

        return response()->json([
            'error_code' => 0,
            'message'    => trans('Registered!'),
            'data'       => [
                'viewer'  => $viewer,
            ],
        ], 200);
    }
    public function login(Request $request)
    {
        $username       = $request->input('username');
        $password       = $request->input('password');
        try {
            $viewer = Viewers::where('username', $username)->first();
            if ($viewer && Hash::check($password, $viewer->password)) {
                $token = JWTAuth::fromUser($viewer);
                return response()->json([
                    'error_code' => 0,
                    'data'       => [
                        'viewer'     => $viewer,
                        'token'    => $token,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'error_code' => 1,
                    'message'    => trans('Username or password is incorrect'),
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error_code' => 1,
                'message'    => $th->getMessage(),
                'jwt.ttl'    => config('jwt.ttl')
            ], 200);
        }
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
}
