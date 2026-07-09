<?php 

namespace App\Actions\Template;

use App\Enums\CommentStatusEnum;
use App\Models\Post;

class SinglePageAction{
    public function handle(string $slug){
        return [
            'post' => $this->getPost($slug)
        ];
    }

    private function getPost(string $slug){
        return Post::where('slug', $slug)
            ->where('status', true)
            ->with([
                'categories',
                'user',
                'comments' => fn($query) => $query->where('status', CommentStatusEnum::ACCEPT)
            ])->firstOrFail();
    }
}