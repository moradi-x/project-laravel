<?php

namespace App\Http\Controllers\Api;

use App\Actions\Template\BlogPageAction;
use App\Actions\Template\CategoryPageAction;
use App\Actions\Template\CreateCommentAction;
use App\Actions\Template\HomePageAction;
use App\Actions\Template\SearchePageAction;
use App\Actions\Template\SinglePageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Template\StoreCommentRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TemplateController extends Controller
{
    public function home(HomePageAction $action)
    {
        $result = $action->handle();

        return Response::json([
            'posts' => PostResource::collection($result['posts']),
            'randomPosts' => PostResource::collection($result['randomPosts'])
        ]);
    }

    public function blog(BlogPageAction $action, Request $request)
    {
        $result = $action->handle($request);

        return Response::json([
            // 'posts' => PostCollection::collection($result['posts'])
            'posts' => new PostCollection($result['posts'])
        ]);
    }

    public function category(Category $category,CategoryPageAction $action , Request $request)
    {
        $result = $action->handle($category,$request);

        return Response::json([

            'category' => CategoryResource::make($category),
            'posts' => PostCollection::make($result['posts'])
        ]);
    } 

    public function search(SearchePageAction $action ,Request $request)
    {

        $result = $action->handle($request);

        return response::json([
            'posts' => PostCollection::make($result['posts'])
        ]);
    }

    public function single(SinglePageAction $action , string $slug)
    {
        $result = $action->handle($slug);

        return Response::json( [
            'post' => PostResource::make($result['post'])
        ]);
    }

    public function comment(string $slug, CreateCommentAction $action, StoreCommentRequest $request)
    {

        $data = $request->validated();

        $throttlekey = $request->ip();

        $result = $action->handle($slug ,$data , $throttlekey);

        return Response::json([
            'comment' => CommentResource::make($result['comment']),
            'message' =>  $result['message']
        ]) ;
    } 
}
