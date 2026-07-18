<?php 

namespace App\Actions\Panel\User;

use App\Models\User;
use Illuminate\Http\Request;

class IndexUserAction {

    public function handle(Request $request){


         $users = User::orderBy('created_at', 'DESC')
            ->where(function ($query) use ($request) {
                return $query->where('name', 'LIKE', "%{$request->get('search')}%")
                    ->orWhere('family', 'LIKE', "%{$request->get('search')}%")
                    ->orWhere('email', 'LIKE', "%{$request->get('search')}%");
            })
            ->withCount('posts')
            ->paginate(10);

        return [
            "users" => $users
        ];
    }
}