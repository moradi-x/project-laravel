<?php

namespace App\Actions\Template;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogPageAction
{
    public function handle(Request $request)
    {
        $order = ($request->filled('order') and in_array($request->order,  ['desc', 'asc'])) ? $request->order : 'desc';
        return [
            'posts' => $this->getPosts($order)
        ];
    }

    private function getPosts(string $order): LengthAwarePaginator
    {
        return Post::where('status', True)
            ->with('categories', 'user')
            ->orderBy('created_at', $order)
            ->paginate(9)
            ->withQueryString();
    }
}
