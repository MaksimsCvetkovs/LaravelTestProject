<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller {

    public function userView(Request $request, $userId) {
        $user = User::findOrFail($userId);

        $authUser = auth()->user();

        if ($user->id != $authUser->id) {
            abort(404);
        }

        return view("user.view", ["user" => $user]);
    }
}
