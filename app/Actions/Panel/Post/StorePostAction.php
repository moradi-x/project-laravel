<?php

namespace App\Actions\Panel\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StorePostAction
{

    public function handle(array $data)
    {


        $slug = Str::slug($data['title']);
        if (Post::where('slug', $slug)->count())
            $slug = $slug . "-" . uniqid();


        $thumbnail = $data['thumbnail']->store(); 
        // $thumbnail = "image.jpg"; 
         // مرحله دوم ذخیره عکس در پوشه استوریج . اپ . پاپلیک


        /**  @var User  */
        $user = Auth::user();
        $post =  $user->posts()->create([
            'title' => $data['title'],
            'slug' => $slug,
            'content' => $data['content'],
            'status' => $data['status'] == 'active' ? true : false,
            'thumbnail' => "storage/{$thumbnail}",  // مرحله سوم ذخیره مسیر در دیتابیس
        ]);

        $post->categories()->attach($data['categories']);

        return [
            'post' => $post 
        ];
    }
}
