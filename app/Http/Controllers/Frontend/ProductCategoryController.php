<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function category($slug = null)
    {
        $category = null;

        if ($slug) {

            $category = ProductCategory::where('slug', $slug)
                ->firstOrFail();

            $categoryIds = ProductCategory::where('id', $category->id)
                ->orWhere('parent_id', $category->id)
                ->pluck('id');

            $products = Product::with(['images'])
                ->whereIn('category_id', $categoryIds)
                ->where('status', 'published')
                ->latest()
                ->paginate(12);
        } else {

            $products = Product::with(['images'])
                ->where('status', 'published')
                ->latest()
                ->paginate(12);
        }

        return view('frontend.categories', compact(
            'category',
            'products'
        ));
    }
}
