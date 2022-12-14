<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

use App\Mail\EmailVerificationMail;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\PersonalAccessToken;

class CreateNewUser implements CreatesNewUsers {

    use PasswordValidationRules;

    public function create(array $input) {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $userGroup = UserGroup::where("name", "user")->firstOrFail();

        $user = new User;
        $user->name = $input["name"];
        $user->email = $input["email"];
        $user->password = Hash::make($input["password"]);
        $user->user_group_id = $userGroup->id;
        $user->save();

        $token = bin2hex(random_bytes(20));

        $accessToken = new PersonalAccessToken;
        $accessToken->tokenable_type = $token;
        $accessToken->tokenable_id = random_int(0, 10000000);
        $accessToken->name = "verification";
        $accessToken->token = $token;
        $accessToken->abilities = json_encode([
            "userId" => $user->id,
            "email" => $user->email,
        ], true);
        $accessToken->save();

        Mail::to($user->email)->send(new EmailVerificationMail($token));

        return $user;
    }
}
