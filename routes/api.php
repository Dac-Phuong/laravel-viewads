<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

/*
	|--------------------------------------------------------------------------
	| API Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register API routes for your application. These
	| routes are loaded by the RouteServiceProvider and all of them will
	| be assigned to the "api" middleware group. Make something great!
	|
	*/

Route::group(['middleware' => ['language']], function () {
	// Route::get('permissions', [\App\Http\Controllers\RoleController::class, 'get_all_permissions']);
	// Route::get('allRoles', [\App\Http\Controllers\UserController::class, 'get_all_roles']);
	// Route::get('all_user', [\App\Http\Controllers\UserController::class, 'get_all_user']);

	// Auth
	Route::group(['prefix' => 'auth'], function () {
		Route::post('login', [AuthController::class, 'login']);
		Route::post('register', [AuthController::class, 'register']);

		Route::post('forgot-password', [ForgotPasswordController::class, 'forgot_password']);
		Route::post('reset-password', [ForgotPasswordController::class, 'reset_password']);
		Route::group(['middleware' => ['jwt.verify']], function () {
			Route::post('logout', [AuthController::class, 'logout']);
		});
	});


	// Route::group(['middleware' => ['jwt.verify']], function () {
	// 	// IP
	// 	Route::apiResource('whileIp', \App\Http\Controllers\WhileIpController::class);
	// 	// User
	// 	Route::apiResource('users', \App\Http\Controllers\UserController::class);
	// 	Route::apiResource('roles', \App\Http\Controllers\RoleController::class);
	// });
});
