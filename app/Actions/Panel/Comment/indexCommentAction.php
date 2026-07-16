<?php 

namespace App\Actions\Panel\Comment; ;

use App\Models\Comment;
use Illuminate\Http\Request;

class IndexCommentAction {

    public function handle(Request $request){


         $comments = Comment::orderBy('created_at', 'DESC')
            ->where('name', 'LIKE', "%{$request->search}%")
            ->with('post')
            ->paginate(10);

        return [
             'comments' => $comments
        ];
    }
}