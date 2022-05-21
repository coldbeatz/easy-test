<?php

use Andyabih\LaravelToUML\Http\Controllers\LaravelToUMLController;
use App\Http\Controllers\Api\ApiTestingsController;
use App\Http\Controllers\AvatarUploadController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RestoreController;

use App\Http\Controllers\ResultsController;
use App\Http\Controllers\SettingsController;

use App\Http\Controllers\TestController;
use App\Http\Controllers\Testings\ActivateTestingController;
use App\Http\Controllers\Testings\MakeTestingController;
use App\Http\Controllers\Testings\QuestionController;
use App\Http\Controllers\Testings\TestingsController;
use App\Http\Controllers\Testings\TestingSettingsController;
use App\Http\Controllers\UserRestController;

use App\Mail\AccountActivateMail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
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
    return Auth::check() ? view('lobby') : redirect('login');
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
    Route::get('app_auth', function () {
        return response()->json([
            'error' => 'user not auth'
        ]);
    })->name('app_auth');

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

Route::get('verification-mail/{userId}/{hash}', [LoginController::class, 'onActivateAccount'])->name('verification-mail');
Route::get('refresh-captcha', [CaptchaController::class, 'refreshCaptcha'])->name('refreshCaptcha');

Route::middleware('auth')->group(function() {
    Route::get('lobby', function () {
        return view('lobby');
    })->name('lobby');

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])
            ->name('settings');

        Route::post('setName', [SettingsController::class, 'onChangeName'])
            ->name('setName');

        Route::post('setPassword', [SettingsController::class, 'onChangePassword'])
            ->name('setPassword');
    });

    Route::prefix('testings')->group(function () {
        Route::get('/', [TestingsController::class, 'index'])
            ->name('testings');

        Route::post('connect', [TestController::class, 'onConnected'])
            ->name('connect');

        Route::get('new', [MakeTestingController::class, 'index'])
            ->name('make-test');

        Route::post('create', [MakeTestingController::class, 'create']);

        Route::prefix('/{test}')->group(function () {
            Route::get('/', [TestingSettingsController::class, 'index'])
                ->name('testing');

            Route::post('/', [TestingSettingsController::class, 'update']);

            Route::post('question', [QuestionController::class, 'onCreateQuestion']);
            Route::post('question/{id}', [QuestionController::class, 'onUpdateQuestion']);

            Route::get('question', [QuestionController::class, 'index'])
                ->name('make-question');

            Route::get('question/{id}', [QuestionController::class, 'index'])
                ->name('edit-question');

            Route::post('delete', [TestingSettingsController::class, 'onDelete']);

            Route::get('activate', [ActivateTestingController::class, 'index'])
                ->name('activate');

            Route::get('activate/{id}', [ActivateTestingController::class, 'index'])
                ->name('edit-activate');

            Route::post('activate', [ActivateTestingController::class, 'onActivate']);

            Route::prefix('activate/{id}')->group(function() {
                Route::post('/', [ActivateTestingController::class, 'onEditActivate']);
                Route::get('chart', [ActivateTestingController::class, 'ratingsChart']);
                Route::get('results', [ActivateTestingController::class, 'userResultsHTML']);
                Route::post('delete', [ActivateTestingController::class, 'onDeleteActivate']);
            });
        });

        Route::post('delete-question', [QuestionController::class, 'onRemoveQuestion'])
            ->name('delete-question');
    });

    Route::post('upload_image', [AvatarUploadController::class, 'upload']);

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('api', function () {
        return view('api');
    });

    Route::get('test/{hash}', [TestController::class, 'index'])
        ->name('test');

    Route::post('test/{hash}', [TestController::class, 'update']);

    Route::get('results', [ResultsController::class, 'index'])
        ->name('results');

    /**
     * Rest api
     */
    Route::prefix('app')->group(function () {
        Route::post('user', [UserRestController::class, 'parseUserData']);
        Route::post('setName', [UserRestController::class, 'setName']);
        Route::post('changePassword', [UserRestController::class, 'changePassword']);
        Route::post('uploadImage', [AvatarUploadController::class, 'upload']);
        Route::post('logout', [LoginController::class, 'apiLogout']);

        Route::prefix('testings')->group(function () {
            Route::post('all', [ApiTestingsController::class, 'parseAllTestings']);
            Route::post('new', [ApiTestingsController::class, 'onMakeTesting']);
            Route::post('get', [ApiTestingsController::class, 'getTestingById']);
            Route::post('update', [ApiTestingsController::class, 'onUpdateTesting']);
            Route::post('delete', [ApiTestingsController::class, 'onDeleteTesting']);

            Route::post('questions', [ApiTestingsController::class, 'getTestingQuestions']);
            Route::post('getQuestion', [ApiTestingsController::class, 'getQuestionById']);
            Route::post('makeQuestion', [ApiTestingsController::class, 'onMakeQuestion']);
            Route::post('updateQuestion', [ApiTestingsController::class, 'onUpdateQuestion']);
            Route::post('deleteQuestion', [ApiTestingsController::class, 'onDeleteQuestion']);

            Route::post('activate', [ApiTestingsController::class, 'onActivateTesting']);
            Route::post('getActivate', [ApiTestingsController::class, 'getActivate']);
            Route::post('allActivates', [ApiTestingsController::class, 'allActivates']);
            Route::post('updateActivate', [ApiTestingsController::class, 'onEditActivate']);
            Route::post('deleteActivate', [ApiTestingsController::class, 'onDeleteActivate']);
            Route::post('activateResults', [ApiTestingsController::class, 'getActivateResults']);
        });

        Route::prefix('test')->group(function () {
            Route::post('connect', [ApiTestingsController::class, 'onTestConnection']);
            Route::post('updateJsonProgress', [ApiTestingsController::class, 'updateTestProgress']);
            Route::post('complete', [ApiTestingsController::class, 'onTestComplete']);
        });

        Route::post('result', [ApiTestingsController::class, 'getResult']);
        Route::post('results', [ApiTestingsController::class, 'getResults']);
        Route::post('getResultById', [ApiTestingsController::class, 'getResultById']);
        Route::post('getResultByHash', [ApiTestingsController::class, 'getResultByHash']);
    });
});

/*Route::get('tests', function () {
    $mail = new AccountActivateMail("vbitmar@mail.ru", route('verification-mail', [
        'userId' => '$user->id',
        'hash' => '$verification->hash'
    ]));

    dd(Mail::to("vbitmar@mail.ru")->send($mail));
});*/

Route::prefix('app')->group(function () {
    Route::post('auth', [LoginController::class, 'jsonLogin']);
    Route::post('registration', [RegistrationController::class, 'jsonRegistration']);
    Route::post('restore', [RestoreController::class, 'jsonRestore']);
});
