<?php

namespace App\Policies;

use App\Models\User;
use App\Models\post;
use Illuminate\Auth\Access\Response;

class postPolicy
{

    public function viewAny(User $user): bool
    {
        return true;
    }


    public function create(User $user): bool
    {
        return true;
    }


    public function update(User $user, post $post): bool
    {

        if ($user->isAdmin()) {
            return true;
        }

        return $user->id == $post->user_id;
    }


    public function delete(User $user, post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id == $post->user_id;
    }


    public function restore(User $user, post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }


    public function forceDelete(User $user, post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }


    public function change(User $user, post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id == $post->user_id;
    }
}
