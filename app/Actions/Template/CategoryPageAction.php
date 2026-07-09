<?php

namespace App\Actions\Template;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryPageAction
{

    public function handle(Category $category, Request $request)
    {
        $order = ($request->filled('order') and in_array($request->order,  ['desc', 'asc'])) ? $request->order : 'desc';

        return [
            'posts' => $this->getPosts($category, $order)
        ];
    }

    private function getPosts(Category $category, $order): LengthAwarePaginator
    {
        return $category->posts()
            ->with('categories', 'user')
            ->where('status', true)
            ->orderBy('create_at',  $order)
            ->paginate(9)
            ->withQueryString();
    }
}
