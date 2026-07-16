<?php 

namespace App\Actions\Panel\Category;

use App\Models\Category;

class  UpdateCategoryAction{

    public function handle(array $data , Category $category){

        
        $category->name = $data['name'];
        $category->save();

        return [
            'category' => $category
        ];
    }
}