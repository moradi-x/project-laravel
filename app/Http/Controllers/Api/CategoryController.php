<?php

namespace App\Http\Controllers\Api;

use App\Actions\Panel\Category\DeleteCategoryAction;
use App\Actions\Panel\Category\IndexCategoryAction;
use App\Actions\Panel\Category\StoreCategoryAction;
use App\Actions\Panel\Category\UpdateCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{

     public function __construct()
    {
        Gate::authorize('admin');
    }

    public function index(IndexCategoryAction $action ,Request $request)
    {
        $result = $action->handle($request);
        
        return Response::json( [
            'categories' => CategoryCollection::make($result['categories'])
        ]);
    }

    public function store( StoreCategoryAction $action,Request $request)
    {
        $data  = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:categories,name']
        ]);
        $result = $action->handle($data) ;

        return  Response::json( [
            'category' => CategoryResource::make($result['category']) ,
            'message' => "category ` {$result['category']->name} ` has been created. "
        ]);
    }

    public function update( UpdateCategoryAction $action, Category $category, Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:categories,name,' . $category->id]
        ]);

        $result = $action->handle($data , $category);

        return  Response::json( [
            'category' => CategoryResource::make($result['category']) ,
            'message' => "category ` {$result['category']->name} ` has been update. "
        ]);
    }

    public function destroy(DeleteCategoryAction $action, Category $category)
    {

        $action->handle($category);
        return  Response::json( [
            'message' => "category ` {$category->name} ` has been deleted. "
        ]);
    }
}
