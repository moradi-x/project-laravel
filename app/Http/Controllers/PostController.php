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
            ->when($request->has('trash'), fn($query) => $query->onlyTrashed() )
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
            'thumbnail' => ['required', 'image'],
        ]);

        $slug = Str::slug($data['title']);
        if (Post::where('slug', $slug)->count())
            $slug = $slug . "-" . uniqid();

        /**  @var User  */

        $thumbnail = $data['thumbnail']->store();

        $user = Auth::user();
        $post =  $user->posts()->create([
            'title' => $data['title'],
            'slug' => $slug,
            'content' => $data['content'],
            'status' => $data['status'] == 'active' ? true : false,
            'thumbnail' => "storage/{$thumbnail}" ,
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
            'thumbnail' => ['nullable', 'image'],

        ]);

        $slug = Str::slug($data['title']);

        if (Post::where('slug', $slug)->where('id', '<>', $post->id)->count()) {
            $slug = $slug . "-" . uniqid();
        }

        $thumbnail = $post->thumbnail ;
        
        // dd($thumbnail);

        if(isset($data['thumbnail'])){
           $thumbnail = "storage/" . $data['thumbnail']->store();
           Storage::disk('public')->delete(Str::of($post->thumbnail)->replace('storage/',''));
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

    public function change(Post $post){
        $post->status = !$post->status ;
        $post->save();

        return Redirect::back()->with('message', "post `{$post->title}` has been change"); 
    }
}
