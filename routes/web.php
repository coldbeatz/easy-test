<?php

use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RestoreController;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return view('lobby');
    }

    return redirect('login');
});

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return dd(Artisan::output());
});

Route::get('migrate', function () {
    Artisan::call('migrate:fresh', ['--force' => true]);

    return dd(Artisan::output());
});

Route::middleware('guest')->group(function() {
    Route::prefix('login')->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
        Route::post('auth', [LoginController::class, 'onLogin'])->name('auth');
    });
});

Route::prefix('registration')->group(function () {
    Route::get('/', [RegistrationController::class, 'index'])->name('registration');
    Route::post('register', [RegistrationController::class, 'onRegistration'])->name('register');
});

Route::prefix('restore')->group(function () {
    Route::get('/', [RestoreController::class, 'index'])->name('restore');
    Route::post('/', [RestoreController::class, 'onRestore']);

    Route::get('/{hash}', [RestoreController::class, 'recovery'])->name('recovery');
    Route::post('/{hash}', [RestoreController::class, 'onChangePassword']);
});


Route::get('activate/{userId}/{hash}', [LoginController::class, 'onActivateAccount'])->name('activate');
Route::get('refresh-captcha', [CaptchaController::class, 'refreshCaptcha'])->name('refreshCaptcha');

Route::middleware('auth')->group(function() {
    Route::get('lobby', function () {
        return view('lobby');
    })->name('lobby');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});
