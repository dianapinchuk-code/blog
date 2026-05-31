<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Observers\BlogPostObserver;
use App\Observers\BlogCategoryObserver;

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
        // РЕЄСТРАЦІЯ ОБСЕРВЕРІВ
        BlogCategory::observe(BlogCategoryObserver::class);
        BlogPost::observe(BlogPostObserver::class);
    }
}
