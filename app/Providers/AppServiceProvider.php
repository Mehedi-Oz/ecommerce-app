<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Both the admin and storefront themes are Bootstrap-based with no
        // Tailwind loaded, so render Bootstrap pagination (text arrows)
        // instead of the Tailwind default whose SVG arrows render huge.
        Paginator::useBootstrapFive();

        View::composer('frontend.layouts.header', function ($view): void {
            $view->with('navCategories', Category::query()
                ->where('status', 'published')
                ->orderBy('name')
                ->withCount(['products' => fn ($query) => $query->where('status', 'published')])
                ->with(['subCategories' => fn ($query) => $query->where('status', 'published')->orderBy('name')])
                ->get());
        });

        View::composer('frontend.products.index', function ($view): void {
            $view->with('categories', Category::query()
                ->where('status', 'published')
                ->orderBy('name')
                ->withCount(['products' => fn ($query) => $query->where('status', 'published')])
                ->get());
        });
    }
}
