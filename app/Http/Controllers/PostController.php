<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {

        $posts = Post::with('categories', 'user')
            ->where(function ($query) use ($request) {
                return $query->where('title', 'like', "%{$request->search}%")
                    ->orWhere('content', 'like', "%{$request->search}%");
            })
            ->when($request->has('trash'), fn($query) => $query->onlyTrashed())
            ->withCount('comments')
            ->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->withQueryString();

        return View::make('admins.post.index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        $categories = Category::all('id', 'name');
        return view::make('admins.post.create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'content' => ['required', 'string', 'min:3', 'max:100000'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'status' => ['required', 'in:active,inactive'],
            'thumbnail' => ['required', 'image'], // مرحله اول اعتبار سنجی
        ]);

        $slug = Str::slug($data['title']);
        if (Post::where('slug', $slug)->count())
            $slug = $slug . "-" . uniqid();


        $thumbnail = $data['thumbnail']->store();  // مرحله دوم ذخیره عکس در پوشه استوریج . اپ . پاپلیک


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

        return Redirect::route('post.index')
            ->with('message', "post ` {$post->title} ` has been created. ");
    }

    public function edit(Post $post)
    {

        $categories = Category::all('id', 'name');
        $post->load('categories');

        return View::make('admins.post.edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function update(Post $post, Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'content' => ['required', 'string', 'min:3', 'max:100000'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'status' => ['required', 'in:active,inactive'],
            'thumbnail' => ['nullable', 'image'], // مرحله اول  اعبار سنجی

        ]);

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

        return Redirect::route('post.index')
            ->with('message', "post `{$post->title}` has been update");
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return Redirect::back()->with('message', "post `{$post->title}` has been delete");
    }

    public function change(Post $post)
    {
        $post->status = !$post->status;
        $post->save();

        return Redirect::back()->with('message', "post `{$post->title}` has been change");
    }
}
