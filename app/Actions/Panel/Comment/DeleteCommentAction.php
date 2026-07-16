<?php 

namespace App\Actions\Panel\Comment; ;

use App\Models\Comment;

class DeleteCommentAction {

    public function handle(Comment $comment){

                $comment->delete();

        return [
             "comment" => $comment
        ];
    }
}