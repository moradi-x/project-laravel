<?php

namespace App\Http\Controllers;

use App\Actions\Template\BlogPageAction;
use App\Actions\Template\CategoryPageAction;
use App\Actions\Template\CreateCommentAction;
use App\Enums\CommentStatusEnum;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use App\Actions\Template\HomePageAction;
use App\Actions\Template\SearchePageAction;
use App\Actions\Template\SinglePageAction;
use App\Http\Requests\Template\StoreCommentRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;

class TemplateController extends Controller
{
    public function home(HomePageAction $action)
    {
        $result = $action->handle();

        // $posts  = Post::where('status', true)
        //     ->with('categories', 'user')
        //     ->orderBy('created_at', 'DESC')
        //     ->take(9)
        //     ->get();

        // $randomPosts = Post::inRandomOrder()
        //     ->with('user', 'categories')
        //     ->where('status', true)
        //     ->orderBy('created_at', 'DESC')
        //     ->take(3)
        //     ->get();

        // return View::make('templates.home', [
        //     'posts' => $posts,
        //     'randomPosts' => $randomPosts
        // ]);

        return View::make('templates.home', $result);
    }

    public function blog(BlogPageAction $action, Request $request)
    {
        $request =  $action->handle($request);

        return View::make('templates.blog', [
            'posts' => $request['posts'],
        ]);
    }

    public function category(Category $category, CategoryPageAction $action, Request $request)
    {
        $result = $action->handle($category, $request);

        return View::make('templates.category', [

            'category' => CategoryResource::make($category),
            'posts' => PostCollection::make($result['posts'])
        ]);
    }


    public function search(SearchePageAction $action, Request $request)
    {

        if (! $request->filled('word')) {
            return Redirect::route('home');
        }

        $result = $action->handle($request);

        return View::make('templates.search', [
            'posts' => PostCollection::make($result['posts'])
        ]);
    }


    public function single(SinglePageAction $action, string $slug)
    {
        $result = $action->handle($slug);

        return View::make('templates.single', [
            'post' => PostResource::make($result['post'])
        ]);
    }

    public function comment(string $slug, CreateCommentAction $action, StoreCommentRequest $request)
    {

        $data = $request->validated();

        $throttlekey = $request->ip();

        $result = $action->handle($slug, $data, $throttlekey);

        return Redirect::back()
            ->with($result['message'])
            ->withFragment('comment');
    }


    
}