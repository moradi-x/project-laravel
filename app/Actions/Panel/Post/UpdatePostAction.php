<?php 

namespace App\Actions\Panel\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdatePostAction{
    public function handle(array $data , Post $post){

         $slug = Str::slug($data['title']);

        if (Post::where('slug', $slug)->where('id', '<>', $post->id)->count()) {
            $slug = $slug . "-" . uniqid();  // برای اینکه تایتل خود اون پست رو نبینن
        }

        $thumbnail = $post->thumbnail;
        // نگه داشتن عکس قبلی و اگر شرط پایین اجرا نشه این اجرا میشه

        // dd($thumbnail);

        if (isset($data['thumbnail'])) {
            $thumbnail = "storage/" . $data['thumbnail']->store(); // ذخیره عکس جدید در پوشه استوریج . اپ . پابلیک
            Storage::disk('public')->delete(Str::of($post->thumbnail)->replace('storage/', ''));
            // عکس قبلی رو حذف و جایگزینش کن با عکس جدید
        }

        $post->update([
            'title' => $data['title'],
            'slug' => $slug,
            'content' => $data['content'],
            'status' => $data['status'] == 'active' ? true : false,
            'thumbnail' => $thumbnail
        ]);

        $post->categories()->sync($data['categories']);

        $post->refresh();

        return [
            "post" => $post 
        ];
    }
}