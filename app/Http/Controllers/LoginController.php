<?php

namespace App\Http\Controllers;

use App\User;

use App\Verification;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    public function index() {
        return view("entrance/login");
    }

    public function onLogin(Request $request) {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', '=', $request->email)->first();
        if ($user == null) {
            return $this->onError('Invalid email');
        }

        if ($user->email_verified_at == null) {
            return $this->onError('Email not confirmed, confirm from email');
        }

        if (Auth::attempt($credentials, $request->remember != null)) {
            return redirect()->intended('lobby');
        }

        return $this->onError('Invalid password');
    }

    public function onActivateAccount(string $userId, string $hash) {
        $user = User::find($userId);

        if ($user != null && $user->email_verified_at != null) {
            return view('entrance/verification/verification-danger', [
                'email' => $user->email
            ]);
        }

        $verification = Verification::where('hash', '=', $hash)->first();
        if ($verification == null) {
            return view('entrance/verification/verification-fail', [
                'hash' => $hash
            ]);
        }

        $verification->delete();

        $user->email_verified_at = Carbon::now();
        $user->update();

        return view('entrance/verification/verification-success');
    }

    private function onError(string $text) {
        return back()->withInput()->withErrors([
            'fail' => $text
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
