<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecoveryRequest;
use App\Http\Requests\RestoreRequest;
use App\Mail\AccountRecoveryMail;
use App\User;

use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RestoreController extends Controller {

    use ApiController;

    public function index() {
        return view("entrance/restore");
    }

    public function jsonRestore(RestoreRequest $request):JsonResponse {
        try {
            $json = request()->json()->all();

            $email = $json['email'];
            $captcha = $json['captcha'];

            if (!captcha_check($captcha)) {
                return $this->jsonError('Captcha key invalid');
            }

            $user = User::where('email', '=', $email)->first();
            if ($user == null)
                return $this->jsonError('Email ' . $email . ' not registered');

            if ($user->email_verified_at == null)
                return $this->jsonError('Email ' . $email . ' not confirmed. Check your email and confirm your account');

            if ($user->restore_hash == null) {
                $user->restore_hash = $this->generateUniqueHash();
                $user->update();
            }

            $mail = new AccountRecoveryMail($user->name, route('recovery', [
                'hash' => $user->restore_hash
            ]));

            Mail::to($user->email)->send($mail);

            return response()->json(['message' => 'Instructions have been sent. Check your email']);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function onRestore(RestoreRequest $request) {
        $email = $request->email;
        $user = User::where('email', '=', $email)->first();

        if ($user == null) {
            return $this->onError('Email ' . $email . ' not registered');
        }

        if ($user->email_verified_at == null) {
            return $this->onError('Email ' . $email . ' not confirmed. Check your email and confirm your account');
        }

        if ($user->restore_hash == null) {
            $user->restore_hash = $this->generateUniqueHash();
            $user->update();
        }

        $mail = new AccountRecoveryMail($user->name, route('recovery', [
            'hash' => $user->restore_hash
        ]));

        Mail::to($user->email)->send($mail);

        return back()->withInput()->with('success', 'Instructions have been sent. Check your email');
    }

    public function recovery($hash) {
        $user = User::where('restore_hash', '=', $hash)->first();

        if ($user == null) {
            return redirect('restore');
        }

        return view('entrance/recovery', [
            'email' => $user->email
        ]);
    }

    public function onChangePassword(RecoveryRequest $request) {
        $password = $request->password;
        $user = User::where('restore_hash', '=', $request->hash)->first();

        $user->setPassword($password);
        $user->restore_hash = null;

        $user->update();

        Session::flash('email', $user->email);
        Session::flash('password', $password);

        return redirect('login');
    }

    private function generateUniqueHash():string {
        $hash = null;
        do {
            $hash = Str::random(32);
        } while (!empty(User::where('restore_hash', $hash)->first()));
        return $hash;
    }

    private function onError(string $text) {
        return back()->withInput()->withErrors([
            'fail' => $text
        ]);
    }
}
