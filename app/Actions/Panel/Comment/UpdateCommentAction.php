<?php

namespace App\Actions\Panel\Comment;

use App\Models\Comment;

class UpdateCommentAction
{

    public function handle(array $data, Comment $comment)
    {

        $comment->update($data);
        $comment->refresh();

        return [
            'comment' => $comment
        ];
    }
}
