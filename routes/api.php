<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    Route::group(['namespace' => 'V1', 'prefix' => 'v1'], function () {
        Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
            Route::post('/password', [App\Http\Controllers\Api\V1\AuthController::class, 'password'])->name('login');
            Route::post('/logout', [App\Http\Controllers\Api\V1\AuthController::class, 'logout']);
            Route::post('/send_reset_password_email', [App\Http\Controllers\Api\V1\AuthController::class, 'sendResetPasswordEmail'])->name('auth.send_reset_password_email');
            Route::post('/reset_password', [App\Http\Controllers\Api\V1\AuthController::class, 'resetPassword'])->name('auth.resert_password');
            Route::post('/verify', [App\Http\Controllers\Api\V1\AuthController::class, 'verify'])->name('auth.verify');
            Route::post('/register', [App\Http\Controllers\Api\V1\AuthController::class, 'register'])->name('auth.register');
            Route::post('/register/temporary', [App\Http\Controllers\Api\V1\AuthController::class, 'temporaryRegister'])->name('auth.temporary.register');

            Route::group(['middleware' => 'auth:sanctum'], function () {
                Route::get('me', [App\Http\Controllers\Api\V1\AuthController::class, 'me']);
            });
        });

        Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth:sanctum'], function () {
            Route::get('constants', [App\Http\Controllers\Api\V1\Admin\ConstantController::class, 'index'])->name('admin.constants.index');
            Route::get('constants/attributes', [App\Http\Controllers\Api\V1\Admin\ConstantController::class, 'attributes'])->name('admin.constants.attributes');
            Route::get('constants/config', [App\Http\Controllers\Api\V1\Admin\ConstantController::class, 'config'])->name('admin.constants.config');

            Route::get('users', [App\Http\Controllers\Api\V1\Admin\UserController::class, 'index'])->name('admin.users.index');
            Route::get('users/{id}', [App\Http\Controllers\Api\V1\Admin\UserController::class, 'detail'])->where(['id' => '[0-9]+'])->name('admin.users.detail');
            Route::post('users', [App\Http\Controllers\Api\V1\Admin\UserController::class, 'store'])->name('admin.users.store');
            Route::patch('users/{id}', [App\Http\Controllers\Api\V1\Admin\UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('admin.users.update');
            Route::patch('users/{id}/deactivate', [App\Http\Controllers\Api\V1\Admin\UserController::class, 'deactivate'])->where(['id' => '[0-9]+'])->name('admin.users.deactivate');
            Route::patch('users/{id}/activate', [App\Http\Controllers\Api\V1\Admin\UserController::class, 'activate'])->where(['id' => '[0-9]+'])->name('admin.users.activate');
        });
    });
});
