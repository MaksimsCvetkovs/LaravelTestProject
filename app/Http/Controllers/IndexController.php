<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\PersonalAccessToken;

use Carbon\Carbon;

class IndexController extends Controller {

    public function index(Request $request) {
        return view("index");
    }

    public function token(Request $request, $token) {
        $accessToken = PersonalAccessToken::where("token", $token)->firstOrFail();

        if ($accessToken->name == "verification") {
            $data = json_decode($accessToken->abilities, true);

            $userId = $data["userId"];
            $email = $data["email"];

            $user = User::findOrFail($userId);

            if ($user->email == $email) {
                $user->email_verified_at = Carbon::now();
                $user->save();

                return redirect()->route("index");
            }
        }

        abort(404);
    }
}
