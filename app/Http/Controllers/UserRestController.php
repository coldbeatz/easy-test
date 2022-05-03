<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class UserRestController extends Controller {

    public function parseUserData(Request $request):JsonResponse {
        $user = $request->user();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => URL::asset('storage/' . $user->avatar)
        ]);
    }
}
