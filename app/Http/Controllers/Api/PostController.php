<?php

namespace App\Http\Controllers\api;

use App\Actions\Panel\Post\ChangePostAction;
use App\Actions\Panel\Post\DeletePostAction;
use App\Actions\Panel\Post\ForceDeletePostAction;
use App\Actions\Panel\Post\IndexPostAction;
use App\Actions\Panel\Post\RestorePostAcrtion;
use App\Actions\Panel\Post\StorePostAction;
use App\Actions\Panel\Post\UpdatePostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    public function index(IndexPostAction $action, Request $request)
    {

        $result = $action->handle($request);

        Gate::authorize('viewAny', Post::class);


        return Response::json([
            'posts' => PostCollection::make($result['posts'])
        ]);
    }


    public function store(StorePostAction $action, StorePostRequest $request)
    {

        $data = $request->validated();
        $result = $action->handle($data);

        return Response::json(
            [
                'post' => PostResource::make($result['post']),
                'message' => "post ` {$result['post']->title} ` has been created. ",
            ]
        );
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

        return Response::json(
            [
                'post' => $result['post'],
                'message' => "post ` {$result['post']->title} ` has been Updated... ",
            ]
        );
    }


    public function destroy(DeletePostAction $action, Post $post)
    {
        Gate::authorize('delete', $post);
        $action->handle($post);

        return Response::json([
            'message' => "post ` {$post->title} ` has been deleted. ",
        ]);
    }


    public function change(ChangePostAction $action, Post $post)
    {
        Gate::authorize('change', $post);
        $action->handle($post);

        return Response::json([
            'message' => "post ` {$post->title} ` has been changed. ",
        ]);
    }

    public function forcedelete(int $id, ForceDeletePostAction $action)
    {

        $post = Post::onlyTrashed()
            ->where('id', $id)
            ->firstOrFail();

        Gate::authorize('forcedelete', $post);

        $result = $action->handle($post);

        return Response::json([
            'message' => "post ` {$post->title} ` has been force Deleted. ",
        ]);
    }

    public function restore(RestorePostAcrtion $action, int $id)
    {
        //  نمیتونی بایند بکنی چون حذف شده و در ترش هست

        $post = Post::onlyTrashed()
            ->where('id', $id)
            ->firstOrFail();

        Gate::authorize('restore', $post);

        $result = $action->handle($post);

        return Response::json([
            'message' => "post ` {$post->title} ` has been force restored. ",
        ]);
    }
}
