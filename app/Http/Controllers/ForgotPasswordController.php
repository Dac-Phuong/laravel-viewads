<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller {

    public function forgot_password( Request $request ) {
        $request->validate( [ 'email' => 'required|email' ] );

        $status = Password::sendResetLink(
            $request->only( 'email' )
        );
        if ( $status === Password::RESET_LINK_SENT ) {
            return response()->json( [
                'error_code' => 0,
                'message'    => trans( $status ),
            ], 200 );
        } else {
            return response()->json( [
                'error_code' => 1,
                'message'    => trans( $status ),
            ], 200 );
        }

    }

    public function reset_password( Request $request ) {

        $validator = Validator::make( $request->all(), [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'error_code' => 1,
                'message'    => trans( 'The given data is invalid' ),
                'errors'     => $validator->errors()
            ], 200 );
        }

        $status = Password::reset(
            $request->only( 'email', 'password', 'password_confirmation', 'token' ),
            function ( $user, $password ) use ( $request ) {
                $user->forceFill( [
                    'password' => Hash::make( $password )
                ] )->save();

                $user->setRememberToken( Str::random( 60 ) );

                event( new PasswordReset( $user ) );
            }
        );
        if( $status == Password::PASSWORD_RESET){
            return response()->json( [
                'error_code' => 0,
                'message'    => trans( $status ),
            ], 200 );
        }else{
            return response()->json( [
                'error_code' => 1,
                'message'    => trans( $status ),
            ], 200 );
        }
    }
}
