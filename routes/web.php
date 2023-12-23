<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ViewerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'post_login'])->name('post_login');
});
Route::group(['middleware' => ['checkLogin']], function () {
    Route::get('/', function () {
        return view('components.layouts.app');
    })->name('home');

    // management viewers
    Route::name('viewer-management.')->group(function () {
        Route::resource('/viewer-management/viewers', ViewerController::class);
        Route::resource('/user-management/roles', RoleController::class);
        Route::resource('/user-management/permissions', UserController::class);
    });
    // management users
    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserController::class);
        Route::resource('/user-management/roles', RoleController::class);
        Route::resource('/user-management/permissions', UserController::class);
    });

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
Route::get('/error', function () {
    abort(500);
});
