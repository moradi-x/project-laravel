<?php

namespace App\Http\Controllers;

use App\Actions\Panel\Post\ChangePostAction;
use App\Actions\Panel\Post\DeletePostAction;
use App\Actions\Panel\Post\ForceDeletePostAction;
use App\Actions\Panel\Post\IndexPostAction;
use App\Actions\Panel\Post\RestorePostAcrtion;
use App\Actions\Panel\Post\StorePostAction;
use App\Actions\Panel\Post\UpdatePostAction;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(IndexPostAction $action, Request $request)
    {
        $result = $action->handle($request);

        Gate::authorize('viewAny', Post::class);


        return View::make('admins.post.index', [
            'posts' => PostCollection::make($result['posts'])
        ]);
    }

    public function create()
    {
        Gate::authorize('create', Post::class);

        $categories = Category::all('id', 'name');
        return view::make('admins.post.create', [
            'categories' => $categories
        ]);
    }

    public function store(StorePostAction $action, StorePostRequest $request)
    {


        // Gate::authorize('create', Post::class);
        // در فایل ریکوس گذاشتیم جایگذینش را


        $data = $request->validated();

        $result = $action->handle($data);
        //  این گد بالا مربوط به فایل ریکویس هست اونجا روب هارو گذاشتیم

        // $data = $request->validate([
        //     'title' => ['required', 'string', 'min:3', 'max:200'],
        //     'content' => ['required', 'string', 'min:3', 'max:100000'],
        //     'categories' => ['required', 'array'],
        //     'categories.*' => ['exists:categories,id'],
        //     'status' => ['required', 'in:active,inactive'],
        //     'thumbnail' => ['required', 'image'], // مرحله اول اعتبار سنجی
        // ]);



        return Redirect::route('post.index')
            ->with('message', "post ` {$result['post']->title} ` has been created. ");
    }

    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        $categories = Category::all('id', 'name');
        $post->load('categories');

        return View::make('admins.post.edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function update( UpdatePostAction $action ,Post $post, UpdatePostRequest $request)
    {
        // Gate::authorize('update', $post);
        $data = $request->validated();

        $result = $action->handle($data ,$post) ;

        // $data = $request->validate([
        //     'title' => ['required', 'string', 'min:3', 'max:200'],
        //     'content' => ['required', 'string', 'min:3', 'max:100000'],
        //     'categories' => ['required', 'array'],
        //     'categories.*' => ['exists:categories,id'],
        //     'status' => ['required', 'in:active,inactive'],
        //     'thumbnail' => ['nullable', 'image'], // مرحله اول  اعبار سنجی
        // ]);

        return Redirect::route('post.index')
            ->with('message', "post `{$result['post']->title}` has been update");
    }

    public function destroy(DeletePostAction $action, Post $post)
    {
        Gate::authorize('delete', $post);
        $action->handle($post);

        return Redirect::back()->with('message', "post `{$post->title}` has been deleted");
    }

    public function change(ChangePostAction $action, Post $post)
    {
        Gate::authorize('change', $post);
        $action->handle($post);

        return Redirect::back()->with('message', "post `{$post->title}` has been change");
    }

    public function restore(RestorePostAcrtion $action ,int $id)
    {
        //  نمیتونی بایند بکنی چون حذف شده و در ترش هست

        $post = Post::onlyTrashed()
            ->where('id', $id)
            ->firstOrFail();

        Gate::authorize('restore', $post);

        $result = $action->handle($post);

        return Redirect::back()->with('message', "post `{$post->title}` has been restored");
    }

    public function forcedelete(int $id, ForceDeletePostAction $action)
    {

        $post = Post::onlyTrashed()
            ->where('id', $id)
            ->firstOrFail();

        Gate::authorize('forcedelete', $post);

        $result = $action->handle($post) ;

        return Redirect::back()->with('message', "post `{$post->title}` has been forc Deleted");
    }
}
