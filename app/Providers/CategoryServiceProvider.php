<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class CategoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        $this->app->bind('categories', function () {
            return \App\Models\Category::with('subcategory')
                ->where(['show_home' => 'Yes', 'status' => 'published'])
                ->limit(6)
                ->get();
        });
    }

    public function boot(): void
    {

        // Using View::share to share data with all views
        View::share('categories', $this->app->make('categories'));
        
        // Uncomment the line below if you want to debug the shared data
        // dd($this->app->make('categories'));
    }
}
