<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

use Exception;

class UserRestController extends Controller {

    use ApiController;

    public function parseUserData(Request $request):JsonResponse {
        $user = $request->user();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => URL::asset('storage/' . $user->avatar)
        ]);
    }

    public function setName(Request $request):JsonResponse {
        try {
            $json = request()->json()->all();

            $name = $json['name'];

            $user = $request->user();
            $user->name = $name;

            $user->update();
            return $this->jsonMessage('success');
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }

    public function changePassword(Request $request) {
        try {
            $json = request()->json()->all();

            $currentPassword = $json['oldPassword'];
            $newPassword = $json['password'];

            $user = $request->user();

            if (Hash::check($currentPassword, $user->password)) {
                $user->setPassword($newPassword);
                return $this->jsonMessage('success');
            }

            return $this->jsonError('Current password is incorrect');
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }
}
