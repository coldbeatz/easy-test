<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class AvatarUploadController extends Controller {

    private const DEFAULT_AVATAR = 'default.jpg';

    public function upload(Request $request) {
        try {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,jpg|max:2048'
            ]);

            $image = $request->file('image');

            $destinationPath = public_path('/storage/');
            $name = $this->uniqueFilename($destinationPath, $image->getClientOriginalExtension());

            $image->move($destinationPath, $name);

            $user = $request->user();

            $currentAvatar = $user->avatar;
            if ($currentAvatar !== self::DEFAULT_AVATAR) {
                // удаляем предыдущий аватар, он уже не используется
                File::delete($destinationPath . $currentAvatar);
            }

            $user->avatar = $name;
            $user->save();

            return response()->json([
                'src' => URL::asset('storage/' . $name)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    private function uniqueFilename($path, $ext) {
        $output = null;
        do {
            $output = uniqid() . '.' . $ext;
        } while (File::exists($path . $output));

        return $output;
    }
}
