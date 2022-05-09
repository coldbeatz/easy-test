<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Mail\AccountActivateMail;
use App\User;
use App\Verification;

use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegistrationController extends Controller {

    use ApiController;

    public function index() {
        return view("entrance/registration");
    }

    public function jsonRegistration(Request $request):JsonResponse {
        try {
            $json = request()->json()->all();

            $name = $json['name'];
            $email = $json['email'];
            $password = $json['password'];
            //$captcha = $json['captcha'];

            //if (!captcha_check($captcha)) {
            //    return $this->jsonError('Captcha key invalid');
            //}

            $user = new User();

            $user->email = $email;
            $user->name = $name;
            $user->setPassword($password);
            $user->save();

            $verification = $this->createVerification($user->id);

            $mail = new AccountActivateMail($name, route('verification-mail', [
                'userId' => $user->id,
                'hash' => $verification->hash
            ]));

            Mail::to($user->email)->send($mail);

            return response()->json(['message' => 'Confirm your email, the message has been sent to your email']);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
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

        $mail = new AccountActivateMail($name, route('verification-mail', [
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
}
