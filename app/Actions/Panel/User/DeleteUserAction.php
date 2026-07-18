<?php

namespace App\Actions\Panel\User;

use App\Models\User;

class DeleteUserAction
{

    public function handle(User $user)
    {


        $user = $user->loadCount('posts');
        if (!$user->posts_count) {
            $user->delete();
            return [
                'user' => $user,
                'status' => true
            ];
        }

        return [
            'user' => $user,
            'status' => false
        ];
    }
}
