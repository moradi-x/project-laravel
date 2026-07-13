<?php

namespace App\Http\Controllers\api;

use App\Actions\Panel\Post\IndexPostAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    public function index(IndexPostAction $action , Request $request ){

        $result = $action->handle($request);

        Gate::authorize('viewAny', Post::class);


        return Response::json([
            'posts' => PostCollection::make($result['posts'])
        ]);

    }
}
