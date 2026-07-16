<?php 

namespace App\Actions\Panel\User;

use App\Models\User;

class IndexUserAction {

    public function handle($request){


         $users = User::orderBy('created_at', 'DESC')
            ->where(function ($query) use ($request) {
                return $query->where('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('family', 'LIKE', "%{$request->search}%")
                    ->orWhere('email', 'LIKE', "%{$request->search}%");
            })
            ->withCount('posts')
            ->paginate(10);

        return [
            "users" => $users
        ];
    }
}