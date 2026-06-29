<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{

    public function __construct()
    {
        Gate::authorize('admin');
    }

    public function index(Request $request)
    {
        $categories = Category::orderBy('created_at', 'DESC')
            ->where('name', 'LIKE', "%{$request->search}%")
            ->withCount('posts')
            ->paginate(10);

        return View::make('admins.category.index', [
            'categories' => $categories
        ]);
    }

    public  function create()
    {
        return View::make('admins.category.create');
    }

    public function store(Request $request)
    {
        $data  = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:categories,name']
        ]);
        $category = Category::create($data);

        return Redirect::route('category.index')
            ->with('message', "category ` {$category->name} ` has been created. ");
    }

    public function edit(Category $category)
    {
        return View::make('admins.category.edit', [
            'category' => $category,
        ]);
    }

    public function update(Category $category, Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:categories,name,' . $category->id]
        ]);

        $category->name = $data['name'];
        $category->save();

        return Redirect::route('category.index')
            ->with('message', "category ` {$category->name}` has been edited");
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return Redirect::route('category.index')
            ->with('message', "category ` {$category->name}` has been Deleted ");
    }
}
