<?php 

namespace App\Actions\Template;

use App\Models\Category;

class RecomandedTopicAction{

     public function handle(){

        $categories =  Category::withCount([
            'posts' => fn($query) => $query->where('status', true)
        ])
            ->orderBy('posts_count', 'DESC')
            ->take(5)
           ->get();
    

        return [
            "categories" => $categories
        ];
     }
}