<?php

namespace App\Http\Controllers\Api;

use App\Actions\Template\HomePageAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Response;

class TemplateController extends Controller
{
    public function home(HomePageAction $action )
    {
        $result = $action->handle();
        
        return Response::json([
            'posts' => PostResource::collection($result['posts']),
            'randomPosts' => PostResource::collection($result['randomPosts'])
        ]);
    }
}
