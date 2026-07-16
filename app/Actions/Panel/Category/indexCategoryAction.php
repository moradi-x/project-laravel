<?php 

namespace App\Actions\Panel\Category;

use App\Models\Category;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;

class IndexCategoryAction{

    public function handle(Request $request){

        $categories = Category::orderBy('created_at', 'DESC')
            ->where('name', 'LIKE', "%{$request->search}%")
            ->withCount('posts')
            ->paginate(10);


        return [
            'categories' => $categories
        ];
    }
}