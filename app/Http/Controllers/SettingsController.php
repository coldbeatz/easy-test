<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserNameRequest;
use App\Http\Requests\ChangeUserPasswordRequest;

use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller {

    public function index() {
        return view("settings");
    }

    public function onChangeName(ChangeUserNameRequest $request) {
        $name = $request->input('name');

        $user = $request->user();
        $user->name = $name;

        $user->save();

        return back()
            ->withInput()
            ->with('success', 'Name changed successfully');
    }

    public function onChangePassword(ChangeUserPasswordRequest $request) {
        $currentPassword = $request->input('oldPassword');
        $newPassword = $request->input('password');

        $user = $request->user();

        if (Hash::check($currentPassword, $user->password)) {
            $user->setPassword($newPassword);
            $user->save();

            return back()
                ->withInput()
                ->with('success', 'Password changed successfully');
        }

        return back()->withInput()->withErrors([
            'fail' => 'Current password is incorrect'
        ]);
    }
}
