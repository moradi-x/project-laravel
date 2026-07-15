<?php

namespace App\Actions\Panel\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ForceDeletePostAction
{
    public function handle(Post $post)
    {
        $post->forceDelete();

        $thumbnail = Str::of($post->thumbnail)->replace('storage','')->toString();
        Storage::delete($thumbnail);


        return [
            'post' => $post
        ];
    }
}
