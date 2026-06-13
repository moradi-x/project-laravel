<?php

namespace App\Http\Controllers;

use App\Enums\CommentStatusEnum;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class TemplateController extends Controller
{
    public function home()
    {

        $posts  = Post::where('status', true)
            ->with('categories', 'user')
            ->orderBy('created_at', 'DESC')
            ->take(9)
            ->get();

        $randomPosts = Post::inRandomOrder()
            ->with('user', 'categories')
            ->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->get();
            
        return View::make('templates.home', [
            'posts' => $posts,
            'randomPosts' => $randomPosts
        ]);
    }
    
    public function blog(Request $request)
    {
        $order = ($request->filled('order') and in_array($request->order,  ['desc', 'asc'])) ? $request->order : 'desc';
        $posts = Post::where('status', True)
            ->with('categories', 'user')
            ->orderBy('created_at', $order)
            ->paginate(9)
            ->withQueryString();


        return View::make('templates.blog', [
            'posts' => $posts,
        ]);
    } 
    
    public function category(Category $category, Request $request)
    {
        $order = ($request->filled('order') and in_array($request->order,  ['desc', 'asc'])) ? $request->order : 'desc';

        $posts = $category->posts()
            ->where('status', true)
            ->orderBy('create_at',  $order)
            ->paginate(9);

        return View::make('templates.category', [
            'category' => $category,
            'posts' => $posts

        ]);
    }

    public function search(Request $request)
    {

        if (! $request->filled('word')) {
            return Redirect::route('home');
        }

        $order = ($request->filled('order') and in_array($request->order,  ['desc', 'asc'])) ? $request->order : 'desc';

        $word = $request->word;

        $posts = Post::where(function (Builder $query) use ($word) {
            return $query->where('title', 'like', "%{$word}%")
                ->orWhere('content', 'like', "%{$word}%");
        })
            ->where('status', true)
            ->orderBy('create_at',  $order)
            ->paginate(9)
            ->withQueryString();

        return View::make('templates.search', [
            'posts' => $posts
        ]);
    }

    public function single(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', true)
            ->with([
                'categories',
                'user',
                'comments' => fn($query) => $query->where('status', CommentStatusEnum::ACCEPT)
            ])->firstOrFail();

        return View::make('templates.single', [
            'post' => $post
        ]);
    }

    public function comment(int $id, Request $request)
    {

        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'string', 'max:100'],
            'comment' => ['required', 'string', 'min:3', 'max:10000']
        ]);

        $post = Post::where('status', true)
            ->where('id', $id)
            ->firstOrFail();

        $data['status'] = CommentStatusEnum::PENDING ;

        $post->comments()->create($data);

        return Redirect::back()->with('message', "Comment was posted and show after accept by admin")
            ->withFragment('comment');
    }

}
