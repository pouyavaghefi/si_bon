<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::latest()
            ->paginate(20);

        return view('admin.categories.index', compact(
            'categories'
        ));
    }

    public function create()
    {
        $categories = ProductCategory::all();

        return view('admin.categories.create', compact(
            'categories'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'parent_id' => ['nullable', 'exists:product_categories,id'],

            'title' => ['required', 'string', 'max:255'],

            'slug' => ['nullable', 'string', 'max:255', 'unique:product_categories,slug'],

            'image' => ['nullable', 'image'],

        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('categories', 'public');

        }

        ProductCategory::create([

            'parent_id' => $request->parent_id,

            'title' => $request->title,

            'slug' => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->title),

            'image' => $image,

        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'دسته‌بندی با موفقیت ایجاد شد.');
    }

    public function edit(ProductCategory $category)
    {
        $categories = ProductCategory::where('id', '!=', $category->id)
            ->get();

        return view('admin.categories.edit', compact(
            'category',
            'categories'
        ));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $validated = $request->validate([

            'parent_id' => ['nullable', 'exists:product_categories,id'],

            'title' => ['required', 'string', 'max:255'],

            'slug' => ['nullable', 'string', 'max:255'],

            'image' => ['nullable', 'image'],

        ]);

        $image = $category->image;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('categories', 'public');

        }

        $category->update([

            'parent_id' => $request->parent_id,

            'title' => $request->title,

            'slug' => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->title),

            'image' => $image,

        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'دسته‌بندی بروزرسانی شد.');
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'دسته‌بندی حذف شد.');
    }
}
