<?php

namespace App\Actions\Template;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchePageAction
{
    public function handle(Request $request): array
    {

        $order = ($request->filled('order') and in_array($request->get('order'),  ['desc', 'asc'])) ? $request->get('order') : 'desc';

        return [
            'posts' => $this->getPosts($request->get('word'), $order)
        ];
    }

    private function getPosts(string | null $word, string $order): LengthAwarePaginator
    {

        return Post::where(function (Builder $query) use ($word) {

            return $query->where('title', 'like', "%{$word}%")
                ->orWhere('content', 'like', "%{$word}%");
        })
            ->with('categories', 'user')

            ->where('status', true)
            ->orderBy('create_at',  $order)
            ->paginate(9)
            ->withQueryString();
    }
}
