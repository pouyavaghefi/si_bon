<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductShowController extends Controller
{
    public function show($slug)
    {
        $product = Product::with([
            'category',
            'brand',
            'images',
            'specifications',
        ])->where('slug', $slug)->firstOrFail();

        $options = DB::table('product_options')
            ->where('product_id', $product->id)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($option) {
                $option->values = DB::table('product_option_values')
                    ->where('product_option_id', $option->id)
                    ->get();

                return $option;
            });

        if ($product->type === 'print') {
            return view('frontend.simple-product', compact('product', 'options'));
        }

        if ($product->type === 'taki') {
            return view('frontend.taki-product', compact('product', 'options'));
        }

        abort(404);
    }
}
