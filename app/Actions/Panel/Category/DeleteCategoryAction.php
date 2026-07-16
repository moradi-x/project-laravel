<?php 

namespace App\Actions\Panel\Category;

use App\Models\Category;

class DeleteCategoryAction{

    public function handle(Category $category){

                $category->delete();

        return [
            'category' => 'category'
        ];
    }
}