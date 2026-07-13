<?php

namespace App\Actions\Auth;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterUserAction
{
    public function handle(array $data, Request $request): array
    {

        if ($request->expectsJson()) {
            $user = $this->apiRegister($data);
        } else {
            $user = $this->WebRegister($data);
        }
        return [
            'user' => $user
        ];
    }

    private function apiRegister(array $data): User
    {

        $data['status'] = true;
        $data['role'] = UserRoleEnum::USER;

        return User::create($data);
    }

    private function WebRegister(array $data): User
    {

        $data['status'] = true;
        $data['role'] = UserRoleEnum::USER;

        $user = User::create($data);
        Auth::login($user);
        return $user;
    }
}
