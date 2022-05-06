<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

trait ApiController {

    public function jsonError(string $text):JsonResponse {
        return response()->json([
            'error' => $text
        ]);
    }

    public function jsonMessage(string $text):JsonResponse {
        return response()->json([
            'message' => $text
        ]);
    }
}
