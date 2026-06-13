<?php

namespace App\Http\Controllers;

use App\Enums\CommentStatusEnum;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::orderBy('created_at', 'DESC')
            ->where('name', 'LIKE', "%{$request->search}%")
            ->with('post')
            ->paginate(10);

        return View::make('admins.Comment.index', [
            'comments' => $comments
        ]);
    }

    public function edit(Comment $comment)
    {
        $comment->load('post');

        return View::make('admins.comment.edit', [
            'comment' => $comment
        ]);
    }

    public function update(Comment $comment, Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'comment' => ['required', 'string', 'min:5', 'max:10000'],
            'status' => ['required', Rule::enum(CommentStatusEnum::class)],
        ]);

        // $data['status'] = $data['status'] == 'accept' ? true : false; 

        $comment->update($data);

        return Redirect::route('comment.index')
        ->with('meesage', "Comment `{$comment->name}` has been edited. ");
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return Redirect::back()
        ->with('meesage', "Comment `{$comment->name}` has been deleted ");
    }
}
