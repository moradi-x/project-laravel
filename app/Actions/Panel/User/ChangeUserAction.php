<?php 

namespace App\Actions\Panel\User;

use App\Models\User;

class ChangeUserAction{

    public function handle(User $user){

        $user->status = !$user->status;
        $user->save();

        return [
            "user" => $user
        ];
    }
}