<?php 

namespace App\Actions\Panel\Post;

use App\Models\Post;

class ChangePostAction{

    public function handle(Post $post){


        
        $post->status = !$post->status;
        $post->save();

        return [
            'post' => $post
        ];
    }
}