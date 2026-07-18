<?php

namespace App\Actions\Panel\User;

use App\Mail\SendPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ResetUserAction
{

    public function handle(User $user)
    {

        $password = $this->generateRandomPassword(8);
        $user->password = $password;

        Mail::to($user->email)
            ->queue(new SendPasswordMail($user->FullName, $password));


        return [
            "user" => $user
        ];
    }

    private function generateRandomPassword($length = 12)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_';
        $charactersLength = strlen($characters);
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $password;
    }
}
