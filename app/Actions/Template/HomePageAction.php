<?php 
namespace App\Actions\Template;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class HomePageAction {
    public function handle(): array{
        return [
            'posts' => $this->getLastePosts() ,
            'randomPosts' => $this->getRandomPosts()
        ] ;
    } 

    private function getLastePosts():Collection {
        return Post::where('status', true)
            ->with('categories', 'user')
            ->orderBy('created_at', 'DESC')
            ->take(9)
            ->get();
    }

    private function getRandomPosts():Collection {
        return Post::inRandomOrder()
             ->with('user', 'categories')
             ->where('status', true)
             ->orderBy('created_at', 'DESC')
             ->take(3)
             ->get();
    }
}