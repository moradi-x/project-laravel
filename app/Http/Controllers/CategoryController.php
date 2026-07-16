<?php

namespace App\Http\Controllers;

use App\Actions\Panel\Category\DeleteCategoryAction;
use App\Actions\Panel\Category\IndexCategoryAction;
use App\Actions\Panel\Category\StoreCategoryAction;
use App\Actions\Panel\Category\UpdateCategoryAction;
use App\Http\Resources\CategoryCollection;
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

    public function index(IndexCategoryAction $action, Request $request)
    {
        $result = $action->handle($request);

        return View::make('admins.category.index', [
            'categories' => $result['categories']
        ]);
    }

    public  function create()
    {
        return View::make('admins.category.create');
    }

    public function store(StoreCategoryAction $action, Request $request)
    {
        $data  = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:categories,name']
        ]);
        $result = $action->handle($data);

        return Redirect::route('category.index')
            ->with('message', "category ` {$result['category']->name} ` has been created. ");
    }

    public function edit(Category $category)
    {
        return View::make('admins.category.edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryAction $action, Category $category, Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:categories,name,' . $category->id]
        ]);

        $result = $action->handle($data, $category);

        return Redirect::route('category.index')
            ->with('message', "category ` {$result['category']->name}` has been update");
    }

    public function destroy(DeleteCategoryAction $action, Category $category)
    {

        $action->handle($category);
        return Redirect::route('category.index')
            ->with('message', "category ` {$category->name}` has been Deleted ");
    }
}
