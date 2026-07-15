<?php

namespace App\Actions\Panel\Post;

use App\Models\Post;

class RestorePostAcrtion
{
    public function handle(Post $post): array
    {

        $post->restore();

        return [
            'post' => $post
        ];
    }
}
