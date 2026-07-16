<?php

namespace App\Http\Controllers\Api;

use App\Actions\Panel\Comment\DeleteCommentAction;
use App\Actions\Panel\Comment\IndexCommentAction;
use App\Actions\Panel\Comment\UpdateCommentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCommentlRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller
{
    public function __construct()
    {
        Gate::authorize('admin');
    }

    public function index(IndexCommentAction $action ,Request $request)
    {
       $result = $action->handle($request);

        return Response::json( [
            'comments' => CommentCollection::make($result['comments'])
        ]);   
    }

    public function update(UpdateCommentAction $actionn, Comment $comment, UpdateCommentlRequest $request)
    {
        $data = $request->validated();
        $result = $actionn->handle($data , $comment);

        return Response::json( [
            'comment' => CommentResource::make($result['comment']),
            'message' => "comment `{$result['comment']->name}` has been update"
        ]); 
    }

    public function destroy(DeleteCommentAction $action,Comment $comment)
    {

        $resultl = $action->handle($comment);

        return Response::json( [
            'message' => "comment `{$comment->name}` has been delered"
        ]); 
    }


}
