<?php

namespace App\Providers;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class FrontendServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $frontendCategories = ProductCategory::with([
                'children.children'
            ])
                ->whereNull('parent_id')
                ->orderBy('id')
                ->get();

            $view->with('frontendCategories', $frontendCategories);
        });
    }
}
