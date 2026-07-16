<?php 

namespace App\Actions\Panel\Category;

use App\Models\Category;

class StoreCategoryAction{

    public function handle(array $data){

                $category = Category::create($data);

        return [
            'category' => $category
        ];
    }
}