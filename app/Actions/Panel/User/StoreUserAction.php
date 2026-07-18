<?php

namespace App\Actions\Panel\User;

use App\Mail\SendPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class StoreUserAction
{

    public function handle(array $data)
    {

        $data['password'] = $this->generateRandomPassword(8);
        $data['status'] = $data['status'] === 'active' ? 1 : 0;

        $user = User::create($data);
        // Log::alert("Your Password is `{$data['password']}` ");

        Mail::to($user->email)
            ->queue(new SendPasswordMail($user->FullName, $data['password']));

        return [
            'user' => $user
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
