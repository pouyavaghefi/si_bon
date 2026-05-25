<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use App\Models\ProductSpecification;
use App\Models\RelatedProduct;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])
            ->latest()
            ->paginate(20);

        return view('admin.product.index', compact('products'));
    }
    public function createSimple()
    {
        $categories = ProductCategory::all();
        return view('admin.product.createSimple', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand' => ['nullable', 'string', 'max:255'],

            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'sale_unit' => ['required', 'in:meter,number,roll,square_meter,kg,package,service'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'delivery_time' => ['nullable', 'string', 'max:255'],
            'min_order' => ['nullable', 'integer', 'min:1'],

            'allowed_extensions' => ['nullable', 'array'],
            'allowed_extensions.*' => ['nullable', 'string', 'in:JPG,PNG,PDF,AI,PSD'],
            'max_upload_size' => ['nullable', 'integer', 'min:1'],
            'require_upload' => ['nullable', 'boolean'],

            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],

            'options' => ['nullable', 'array'],
            'options.*.title' => ['nullable', 'string', 'max:255'],
            'options.*.type' => ['nullable', 'in:select,radio,checkbox,number,text'],
            'options.*.required' => ['nullable', 'boolean'],
            'options.*.values' => ['nullable', 'string'],

            'specifications' => ['nullable', 'array'],
            'specifications.*.key' => ['nullable', 'string', 'max:255'],
            'specifications.*.value' => ['nullable', 'string', 'max:255'],

            'related_products' => ['nullable', 'array'],
            'related_products.*' => ['nullable', 'exists:products,id'],

            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],

            'status' => ['required', 'in:draft,published,inactive'],
            'is_featured' => ['nullable', 'boolean'],
            'show_price' => ['nullable', 'boolean'],
            'allow_order' => ['nullable', 'boolean'],
        ]);

        $brandId = null;

        if ($request->filled('brand')) {
            $brand = Brand::firstOrCreate(
                ['slug' => Str::slug($request->brand)],
                ['title' => $request->brand]
            );

            $brandId = $brand->id;
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'brand_id' => $brandId,

            'type' => 'print',

            'title' => $request->title,
            'slug' => $request->slug,

            'short_description' => $request->short_description,
            'description' => $request->description,

            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'sale_unit' => $request->sale_unit,
            'stock' => $request->stock ?? 0,
            'delivery_time' => $request->delivery_time,
            'min_order' => $request->min_order ?? 1,

            'allowed_extensions' => $request->allowed_extensions,
            'max_upload_size' => $request->max_upload_size,
            'require_upload' => $request->boolean('require_upload'),

            'status' => $request->has('publish') ? 'published' : $request->status,

            'is_featured' => $request->boolean('is_featured'),
            'show_price' => $request->boolean('show_price'),
            'allow_order' => $request->boolean('allow_order'),

            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ]);

        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
                'is_main' => true,
                'sort_order' => 0,
            ]);
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $key => $image) {
                $path = $image->store('products/gallery', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_main' => false,
                    'sort_order' => $key + 1,
                ]);
            }
        }

        if ($request->has('options')) {
            foreach ($request->options as $optionData) {
                if (empty($optionData['title'])) {
                    continue;
                }

                $option = ProductOption::create([
                    'product_id' => $product->id,
                    'title' => $optionData['title'],
                    'type' => $optionData['type'] ?? 'text',
                    'is_required' => !empty($optionData['required']),
                ]);

                if (!empty($optionData['values'])) {
                    $lines = preg_split('/\r\n|\r|\n/', $optionData['values']);

                    foreach ($lines as $line) {
                        if (trim($line) === '') {
                            continue;
                        }

                        $parts = explode('|', $line);

                        ProductOptionValue::create([
                            'product_option_id' => $option->id,
                            'title' => trim($parts[0]),
                            'price' => isset($parts[1]) ? trim($parts[1]) : 0,
                        ]);
                    }
                }
            }
        }

        if ($request->has('specifications')) {
            foreach ($request->specifications as $specification) {
                if (empty($specification['key']) && empty($specification['value'])) {
                    continue;
                }

                ProductSpecification::create([
                    'product_id' => $product->id,
                    'key' => $specification['key'],
                    'value' => $specification['value'],
                ]);
            }
        }

        if ($request->filled('related_products')) {
            foreach ($request->related_products as $relatedProductId) {
                if ($relatedProductId == $product->id) {
                    continue;
                }

                RelatedProduct::create([
                    'product_id' => $product->id,
                    'related_product_id' => $relatedProductId,
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول چاپی با موفقیت ایجاد شد.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول با موفقیت حذف شد.');
    }

    public function edit(Product $product)
    {
        $product->load([
            'category',
            'brand',
            'images',
            'options.values',
            'specifications',
        ]);

        $categories = ProductCategory::all();

        $products = Product::where('id', '!=', $product->id)
            ->latest()
            ->get();

        return view('admin.product.editSimple', compact(
            'product',
            'categories',
            'products'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Main Product
            |--------------------------------------------------------------------------
            */

            'title' => ['required', 'string', 'max:255'],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],

            'category_id' => ['nullable', 'exists:product_categories,id'],

            'brand' => ['nullable', 'string', 'max:255'],

            'short_description' => ['nullable', 'string'],

            'description' => ['nullable', 'string'],

            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            'price' => ['required', 'numeric', 'min:0'],

            'discount_price' => ['nullable', 'numeric', 'min:0'],

            'sale_unit' => ['required', 'string'],

            'stock' => ['nullable', 'integer', 'min:0'],

            'delivery_time' => ['nullable', 'string', 'max:255'],

            'min_order' => ['nullable', 'integer', 'min:1'],

            /*
            |--------------------------------------------------------------------------
            | Images
            |--------------------------------------------------------------------------
            */

            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],

            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'meta_title' => ['nullable', 'string', 'max:255'],

            'meta_keywords' => ['nullable', 'string'],

            'meta_description' => ['nullable', 'string'],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' => ['required', 'in:draft,published,inactive'],

            'is_featured' => ['nullable', 'boolean'],

            'show_price' => ['nullable', 'boolean'],

            'allow_order' => ['nullable', 'boolean'],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Brand
        |--------------------------------------------------------------------------
        */

        $brandId = null;

        if ($request->filled('brand')) {

            $brand = Brand::firstOrCreate(
                [
                    'slug' => Str::slug($request->brand),
                ],
                [
                    'title' => $request->brand,
                ]
            );

            $brandId = $brand->id;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->update([

            'category_id' => $request->category_id,

            'brand_id' => $brandId,

            'title' => $request->title,

            'slug' => $request->slug,

            'short_description' => $request->short_description,

            'description' => $request->description,

            'price' => $request->price,

            'discount_price' => $request->discount_price,

            'sale_unit' => $request->sale_unit,

            'stock' => $request->stock ?? 0,

            'delivery_time' => $request->delivery_time,

            'min_order' => $request->min_order ?? 1,

            'status' => $request->status,

            'is_featured' => $request->boolean('is_featured'),

            'show_price' => $request->boolean('show_price'),

            'allow_order' => $request->boolean('allow_order'),

            'meta_title' => $request->meta_title,

            'meta_keywords' => $request->meta_keywords,

            'meta_description' => $request->meta_description,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Main Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('main_image')) {

            $product->images()
                ->where('is_main', true)
                ->delete();

            $path = $request->file('main_image')
                ->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
                'is_main' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Gallery Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gallery_images')) {

            foreach ($request->file('gallery_images') as $key => $image) {

                $path = $image->store('products/gallery', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_main' => false,
                    'sort_order' => $key,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Product Options
        |--------------------------------------------------------------------------
        */

        $product->options()->delete();

        if ($request->has('options')) {

            foreach ($request->options as $optionData) {

                $option = ProductOption::create([
                    'product_id' => $product->id,
                    'title' => $optionData['title'] ?? null,
                    'type' => $optionData['type'] ?? 'text',
                    'is_required' => $optionData['required'] ?? false,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Option Values
                |--------------------------------------------------------------------------
                */

                if (!empty($optionData['values'])) {

                    $lines = preg_split('/\r\n|\r|\n/', $optionData['values']);

                    foreach ($lines as $line) {

                        if (!$line) {
                            continue;
                        }

                        $parts = explode('|', $line);

                        ProductOptionValue::create([
                            'product_option_id' => $option->id,
                            'title' => trim($parts[0]),
                            'price' => isset($parts[1])
                                ? trim($parts[1])
                                : 0,
                        ]);
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Specifications
        |--------------------------------------------------------------------------
        */

        $product->specifications()->delete();

        if ($request->has('specifications')) {

            foreach ($request->specifications as $specification) {

                if (
                    empty($specification['key']) &&
                    empty($specification['value'])
                ) {
                    continue;
                }

                ProductSpecification::create([
                    'product_id' => $product->id,
                    'key' => $specification['key'],
                    'value' => $specification['value'],
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Related Products
        |--------------------------------------------------------------------------
        */

        RelatedProduct::where('product_id', $product->id)
            ->delete();

        if ($request->filled('related_products')) {

            foreach ($request->related_products as $relatedProductId) {

                RelatedProduct::create([
                    'product_id' => $product->id,
                    'related_product_id' => $relatedProductId,
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول با موفقیت بروزرسانی شد.');
    }

    public function createTaki()
    {
        $categories = ProductCategory::all();

        return view('admin.product.createTaki', compact(
            'categories'
        ));
    }

    public function storeTaki(Request $request)
    {
        $validated = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Main Product
            |--------------------------------------------------------------------------
            */

            'title' => ['required', 'string', 'max:255'],

            'slug' => ['required', 'string', 'max:255', 'unique:products,slug'],

            'category_id' => ['nullable', 'exists:product_categories,id'],

            'brand' => ['nullable', 'string', 'max:255'],

            'short_description' => ['nullable', 'string'],

            'description' => ['nullable', 'string'],

            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            'price' => ['required', 'numeric', 'min:0'],

            'discount_price' => ['nullable', 'numeric', 'min:0'],

            'sale_unit' => ['required', 'string'],

            'stock' => ['nullable', 'integer', 'min:0'],

            'delivery_time' => ['nullable', 'string', 'max:255'],

            'min_order' => ['nullable', 'integer', 'min:1'],

            /*
            |--------------------------------------------------------------------------
            | Images
            |--------------------------------------------------------------------------
            */

            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],

            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'meta_title' => ['nullable', 'string', 'max:255'],

            'meta_keywords' => ['nullable', 'string'],

            'meta_description' => ['nullable', 'string'],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' => ['required', 'in:draft,published,inactive'],

            'is_featured' => ['nullable', 'boolean'],

            'show_price' => ['nullable', 'boolean'],

            'allow_order' => ['nullable', 'boolean'],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Brand
        |--------------------------------------------------------------------------
        */

        $brandId = null;

        if ($request->filled('brand')) {

            $brand = Brand::firstOrCreate(
                [
                    'slug' => Str::slug($request->brand),
                ],
                [
                    'title' => $request->brand,
                ]
            );

            $brandId = $brand->id;
        }

        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        */

        $product = Product::create([

            'category_id' => $request->category_id,

            'brand_id' => $brandId,

            'title' => $request->title,

            'slug' => $request->slug,

            'short_description' => $request->short_description,

            'description' => $request->description,

            'price' => $request->price,

            'discount_price' => $request->discount_price,

            'sale_unit' => $request->sale_unit,

            'stock' => $request->stock ?? 0,

            'delivery_time' => $request->delivery_time,

            'min_order' => $request->min_order ?? 1,

            'status' => $request->status,

            'is_featured' => $request->boolean('is_featured'),

            'show_price' => $request->boolean('show_price'),

            'allow_order' => $request->boolean('allow_order'),

            'meta_title' => $request->meta_title,

            'meta_keywords' => $request->meta_keywords,

            'meta_description' => $request->meta_description,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Main Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('main_image')) {

            $path = $request->file('main_image')
                ->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
                'is_main' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Gallery Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gallery_images')) {

            foreach ($request->file('gallery_images') as $key => $image) {

                $path = $image->store('products/gallery', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_main' => false,
                    'sort_order' => $key,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Product Options
        |--------------------------------------------------------------------------
        */

        if ($request->has('options')) {

            foreach ($request->options as $optionData) {

                if (empty($optionData['title'])) {
                    continue;
                }

                $option = ProductOption::create([
                    'product_id' => $product->id,
                    'title' => $optionData['title'] ?? null,
                    'type' => $optionData['type'] ?? 'text',
                    'is_required' => $optionData['required'] ?? false,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Option Values
                |--------------------------------------------------------------------------
                */

                if (!empty($optionData['values'])) {

                    $lines = preg_split('/\r\n|\r|\n/', $optionData['values']);

                    foreach ($lines as $line) {

                        if (!$line) {
                            continue;
                        }

                        $parts = explode('|', $line);

                        ProductOptionValue::create([
                            'product_option_id' => $option->id,
                            'title' => trim($parts[0]),
                            'price' => isset($parts[1])
                                ? trim($parts[1])
                                : 0,
                        ]);
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Specifications
        |--------------------------------------------------------------------------
        */

        if ($request->has('specifications')) {

            foreach ($request->specifications as $specification) {

                if (
                    empty($specification['key']) &&
                    empty($specification['value'])
                ) {
                    continue;
                }

                ProductSpecification::create([
                    'product_id' => $product->id,
                    'key' => $specification['key'],
                    'value' => $specification['value'],
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول با موفقیت ایجاد شد.');
    }

    public function editTaki(Product $product)
    {
        $product->load([
            'category',
            'brand',
            'images',
            'options.values',
            'specifications',
        ]);

        $categories = ProductCategory::all();

        $products = Product::where('id', '!=', $product->id)
            ->latest()
            ->get();

        return view('admin.product.editTaki', compact(
            'product',
            'categories',
            'products'
        ));
    }

    public function updateTaki(Request $request, Product $product)
    {
        $validated = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Main Product
            |--------------------------------------------------------------------------
            */

            'title' => ['required', 'string', 'max:255'],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],

            'category_id' => ['nullable', 'exists:product_categories,id'],

            'brand' => ['nullable', 'string', 'max:255'],

            'short_description' => ['nullable', 'string'],

            'description' => ['nullable', 'string'],

            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            'price' => ['required', 'numeric', 'min:0'],

            'discount_price' => ['nullable', 'numeric', 'min:0'],

            'sale_unit' => ['required', 'string'],

            'stock' => ['nullable', 'integer', 'min:0'],

            'delivery_time' => ['nullable', 'string', 'max:255'],

            'min_order' => ['nullable', 'integer', 'min:1'],

            /*
            |--------------------------------------------------------------------------
            | Images
            |--------------------------------------------------------------------------
            */

            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],

            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'meta_title' => ['nullable', 'string', 'max:255'],

            'meta_keywords' => ['nullable', 'string'],

            'meta_description' => ['nullable', 'string'],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' => ['required', 'in:draft,published,inactive'],

            'is_featured' => ['nullable', 'boolean'],

            'show_price' => ['nullable', 'boolean'],

            'allow_order' => ['nullable', 'boolean'],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Brand
        |--------------------------------------------------------------------------
        */

        $brandId = null;

        if ($request->filled('brand')) {

            $brand = Brand::firstOrCreate(
                [
                    'slug' => Str::slug($request->brand),
                ],
                [
                    'title' => $request->brand,
                ]
            );

            $brandId = $brand->id;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->update([

            'category_id' => $request->category_id,

            'brand_id' => $brandId,

            'title' => $request->title,

            'slug' => $request->slug,

            'short_description' => $request->short_description,

            'description' => $request->description,

            'price' => $request->price,

            'discount_price' => $request->discount_price,

            'sale_unit' => $request->sale_unit,

            'stock' => $request->stock ?? 0,

            'delivery_time' => $request->delivery_time,

            'min_order' => $request->min_order ?? 1,

            'status' => $request->status,

            'is_featured' => $request->boolean('is_featured'),

            'show_price' => $request->boolean('show_price'),

            'allow_order' => $request->boolean('allow_order'),

            'meta_title' => $request->meta_title,

            'meta_keywords' => $request->meta_keywords,

            'meta_description' => $request->meta_description,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Main Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('main_image')) {

            $product->images()
                ->where('is_main', true)
                ->delete();

            $path = $request->file('main_image')
                ->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
                'is_main' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Gallery Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gallery_images')) {

            foreach ($request->file('gallery_images') as $key => $image) {

                $path = $image->store('products/gallery', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_main' => false,
                    'sort_order' => $key,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Product Options
        |--------------------------------------------------------------------------
        */

        $product->options()->delete();

        if ($request->has('options')) {

            foreach ($request->options as $optionData) {

                if (empty($optionData['title'])) {
                    continue;
                }

                $option = ProductOption::create([
                    'product_id' => $product->id,
                    'title' => $optionData['title'] ?? null,
                    'type' => $optionData['type'] ?? 'text',
                    'is_required' => $optionData['required'] ?? false,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Option Values
                |--------------------------------------------------------------------------
                */

                if (!empty($optionData['values'])) {

                    $lines = preg_split('/\r\n|\r|\n/', $optionData['values']);

                    foreach ($lines as $line) {

                        if (!$line) {
                            continue;
                        }

                        $parts = explode('|', $line);

                        ProductOptionValue::create([
                            'product_option_id' => $option->id,
                            'title' => trim($parts[0]),
                            'price' => isset($parts[1])
                                ? trim($parts[1])
                                : 0,
                        ]);
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Specifications
        |--------------------------------------------------------------------------
        */

        $product->specifications()->delete();

        if ($request->has('specifications')) {

            foreach ($request->specifications as $specification) {

                if (
                    empty($specification['key']) &&
                    empty($specification['value'])
                ) {
                    continue;
                }

                ProductSpecification::create([
                    'product_id' => $product->id,
                    'key' => $specification['key'],
                    'value' => $specification['value'],
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول با موفقیت بروزرسانی شد.');
    }
}
