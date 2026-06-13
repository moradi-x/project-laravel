<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ViewServiceProvider extends ServiceProvider
{

    public function register(): void {}
    public function boot(): void
    {

        FacadesView::composer(['templates.blog', 'templates.category','templates.search'], function (View $view) {
            $view->with('popularCategories', $this->getPopularCategories());
        });
    }

    private function getPopularCategories()
    {
        return  Category::withCount([
            'posts' => fn($query) => $query->where('status', true)
        ])
            ->orderBy('posts_count', 'DESC')
            ->take(5)
            ->get();
    }
}
