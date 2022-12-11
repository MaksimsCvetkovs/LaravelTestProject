<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

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

        return $user;
    }
}
