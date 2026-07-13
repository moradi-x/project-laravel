<?php

namespace App\Actions\Panel\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexPostAction
{
    public function handle(Request $request): array {

        /** @var  User */
        $user = Auth::user();
        $posts =  Post::with('categories', 'user')
            ->where(function ($query) use ($request) {
                return $query->where('title', 'like', "%{$request->get('search')}%")
                    ->orWhere('content', 'like', "%{$request->get('search')}%");
            })
            ->when($request->has('trash'), fn($query) => $query->onlyTrashed())
            ->when($user->isUser(), fn($query) => $query->where('user_id', $user->id))
            ->withCount('comments')
            ->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->withQueryString();

            return [
                'posts'=> $posts,
            ];
    }
}
