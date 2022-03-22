<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Mail\AccountActivateMail;
use App\User;
use App\Verification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mews\Captcha\Facades\Captcha;

class RegistrationController extends Controller {

    public function index() {
        return view("entrance/registration");
    }

    public function onRegistration(RegistrationRequest $request) {
        $user = new User();

        $email = $request->email;
        $name = $request->name;

        $user->email = $email;
        $user->name = $name;
        $user->setPassword($request->password);
        $user->save();

        $verification = $this->createVerification($user->id);

        $mail = new AccountActivateMail($name, route('activate', [
            'userId' => $user->id,
            'hash' => $verification->hash
        ]));

        Mail::to($user->email)->send($mail);

        return back()->withInput()->with('success', 'Confirm your email, the message has been sent to your email');
    }

    private function generateUniqueHash():string {
        $hash = null;
        do {
            $hash = Str::random(32);
        } while (!empty(Verification::where('hash', $hash)->first()));
        return $hash;
    }

    private function createVerification(int $userId):Verification {
        $verification = new Verification();

        $verification->user_id = $userId;
        $verification->hash = $this->generateUniqueHash();

        $verification->save();
        return $verification;
    }

    public function activateAccount() {

    }
}
