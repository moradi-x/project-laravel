<?php 

namespace App\Actions\Panel\Post;

use App\Models\Post;


class DeletePostAction{
    public function handle(Post $post):array{


     $post->delete();

      return  [
        'post' => $post
      ];
    }
}