@extends('admin.layouts.master')

@section('wrapper')
    <div class="container-fluid" dir="rtl">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <div class="fw-bold mb-2">لطفاً خطاهای زیر را بررسی کنید:</div>

                <ul class="mb-0 pe-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center py-4">
            <div class="col-xxl-8 col-xl-9 text-center">
                <span class="badge badge-default fw-normal shadow px-3 py-2 mb-3 fs-xxs">
                    <i data-lucide="package-plus" class="fs-sm me-1"></i>
                    ویرایش محصول
                </span>

                <h2 class="fw-bold mb-2">
                    ویرایش محصول چاپ سفارشی
                </h2>

                <p class="text-muted fs-md mb-0">
                    در این بخش می‌توانید اطلاعات محصول، قیمت، تصاویر، مشخصات و تنظیمات سئو را ویرایش کنید.
                </p>
            </div>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-xl-9">

                    {{-- MAIN PRODUCT --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">اطلاعات اصلی محصول</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">نام محصول</label>

                                    <input type="text"
                                           name="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title', $product->title) }}"
                                           placeholder="مثلاً چاپ استیکر">

                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">اسلاگ</label>

                                    <input type="text"
                                           name="slug"
                                           class="form-control @error('slug') is-invalid @enderror"
                                           value="{{ old('slug', $product->slug) }}"
                                           placeholder="sticker-print">

                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">دسته‌بندی</label>

                                    <select name="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror">

                                        <option value="">انتخاب دسته‌بندی</option>

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">برند</label>

                                    <input type="text"
                                           name="brand"
                                           class="form-control @error('brand') is-invalid @enderror"
                                           value="{{ old('brand', $product->brand?->title) }}"
                                           placeholder="مثلاً TAT">

                                    @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">توضیح کوتاه</label>

                                    <textarea name="short_description"
                                              class="form-control @error('short_description') is-invalid @enderror"
                                              rows="3"
                                              placeholder="توضیح کوتاه برای بالای صفحه محصول">{{ old('short_description', $product->short_description) }}</textarea>

                                    @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- PRICE --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">قیمت و تنظیمات فروش</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-4">
                                    <label class="form-label">قیمت اصلی</label>

                                    <div class="input-group">
                                        <input type="number"
                                               name="price"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price', $product->price) }}"
                                               placeholder="500000">

                                        <span class="input-group-text">تومان</span>

                                        @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">قیمت با تخفیف</label>

                                    <div class="input-group">
                                        <input type="number"
                                               name="discount_price"
                                               class="form-control @error('discount_price') is-invalid @enderror"
                                               value="{{ old('discount_price', $product->discount_price) }}"
                                               placeholder="اختیاری">

                                        <span class="input-group-text">تومان</span>

                                        @error('discount_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">واحد فروش</label>

                                    <select name="sale_unit"
                                            class="form-select @error('sale_unit') is-invalid @enderror">

                                        @foreach (['number' => 'عدد', 'meter' => 'متر', 'square_meter' => 'متر مربع', 'roll' => 'رول', 'kg' => 'کیلوگرم', 'package' => 'بسته', 'service' => 'سرویس'] as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('sale_unit', $product->sale_unit) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('sale_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">موجودی</label>

                                    <input type="number"
                                           name="stock"
                                           class="form-control @error('stock') is-invalid @enderror"
                                           value="{{ old('stock', $product->stock) }}"
                                           placeholder="100">

                                    @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">حداقل سفارش</label>

                                    <input type="number"
                                           name="min_order"
                                           class="form-control @error('min_order') is-invalid @enderror"
                                           value="{{ old('min_order', $product->min_order) }}"
                                           placeholder="1">

                                    @error('min_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">زمان تحویل</label>

                                    <input type="text"
                                           name="delivery_time"
                                           class="form-control @error('delivery_time') is-invalid @enderror"
                                           value="{{ old('delivery_time', $product->delivery_time) }}"
                                           placeholder="۲ تا ۳ روز کاری">

                                    @error('delivery_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- OPTIONS --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">گزینه‌های سفارش محصول</h5>
                        </div>

                        <div class="card-body">

                            @php
                                $oldOptions = old('options');

                                $options = $oldOptions ?? optional($product->options)->map(function ($option) {

                                    return [
                                        'title' => $option->title,
                                        'type' => $option->type,
                                        'required' => $option->is_required,

                                        'values' => optional($option->values)->map(function ($value) {

                                            return $value->title . ' | ' . $value->price;

                                        })->implode("\n"),
                                    ];

                                })->toArray();

                                if (empty($options)) {

                                    $options = [
                                        [
                                            'title' => 'نوع متریال',
                                            'type' => 'radio',
                                            'required' => 1,
                                            'values' => '',
                                        ],
                                        [
                                            'title' => 'تعداد',
                                            'type' => 'number',
                                            'required' => 1,
                                            'values' => '',
                                        ],
                                    ];

                                }
                            @endphp

                            @foreach ($options as $index => $option)
                                <div class="border rounded p-4 mb-4">
                                    <div class="row g-3">

                                        <div class="col-md-4">
                                            <label class="form-label">عنوان گزینه</label>

                                            <input type="text"
                                                   name="options[{{ $index }}][title]"
                                                   class="form-control"
                                                   value="{{ $option['title'] ?? '' }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">نوع فیلد</label>

                                            <select name="options[{{ $index }}][type]" class="form-select">
                                                @foreach (['select' => 'لیست انتخابی', 'radio' => 'رادیویی', 'checkbox' => 'چند انتخابی', 'number' => 'عدد', 'text' => 'متن'] as $key => $label)
                                                    <option value="{{ $key }}" {{ ($option['type'] ?? '') == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">اجباری باشد؟</label>

                                            <select name="options[{{ $index }}][required]" class="form-select">
                                                <option value="1" {{ ($option['required'] ?? 0) == 1 ? 'selected' : '' }}>بله</option>
                                                <option value="0" {{ ($option['required'] ?? 0) == 0 ? 'selected' : '' }}>خیر</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">مقادیر گزینه</label>

                                            <textarea name="options[{{ $index }}][values]"
                                                      class="form-control"
                                                      rows="5"
                                                      placeholder="استیکر مات | 0&#10;استیکر براق | 150000">{{ $option['values'] ?? '' }}</textarea>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- SPECIFICATIONS --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">مشخصات فنی محصول</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                @php
                                    $oldSpecifications = old('specifications');
                                    $specifications = $oldSpecifications ?? $product->specifications->map(function ($spec) {
                                        return [
                                            'key' => $spec->key,
                                            'value' => $spec->value,
                                        ];
                                    })->toArray();

                                    if (empty($specifications)) {
                                        $specifications = [
                                            ['key' => 'عرض', 'value' => ''],
                                            ['key' => 'طول', 'value' => ''],
                                            ['key' => 'ضخامت', 'value' => ''],
                                        ];
                                    }
                                @endphp

                                @foreach ($specifications as $index => $specification)
                                    <div class="col-md-6">
                                        <label class="form-label">عنوان مشخصه</label>

                                        <input type="text"
                                               name="specifications[{{ $index }}][key]"
                                               class="form-control"
                                               value="{{ $specification['key'] ?? '' }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">مقدار مشخصه</label>

                                        <input type="text"
                                               name="specifications[{{ $index }}][value]"
                                               class="form-control"
                                               value="{{ $specification['value'] ?? '' }}">
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">توضیحات کامل محصول</h5>
                        </div>

                        <div class="card-body">
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="8"
                                      placeholder="توضیحات کامل محصول را وارد کنید...">{{ old('description', $product->description) }}</textarea>

                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">تنظیمات سئو</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">عنوان سئو</label>

                                    <input type="text"
                                           name="meta_title"
                                           class="form-control @error('meta_title') is-invalid @enderror"
                                           value="{{ old('meta_title', $product->meta_title) }}">

                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">کلمات کلیدی</label>

                                    <input type="text"
                                           name="meta_keywords"
                                           class="form-control @error('meta_keywords') is-invalid @enderror"
                                           value="{{ old('meta_keywords', $product->meta_keywords) }}">

                                    @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">توضیحات متا</label>

                                    <textarea name="meta_description"
                                              class="form-control @error('meta_description') is-invalid @enderror"
                                              rows="4">{{ old('meta_description', $product->meta_description) }}</textarea>

                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                {{-- SIDEBAR --}}
                <div class="col-xl-3">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">وضعیت محصول</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">وضعیت انتشار</label>

                                <select name="status"
                                        class="form-select @error('status') is-invalid @enderror">

                                    <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>
                                        منتشر شده
                                    </option>

                                    <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>
                                        پیش‌نویس
                                    </option>

                                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                        غیرفعال
                                    </option>

                                </select>

                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="checkbox"
                                       name="is_featured"
                                       value="1"
                                       class="form-check-input"
                                       id="isFeatured"
                                    {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>

                                <label class="form-check-label" for="isFeatured">
                                    محصول ویژه
                                </label>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="checkbox"
                                       name="show_price"
                                       value="1"
                                       class="form-check-input"
                                       id="showPrice"
                                    {{ old('show_price', $product->show_price) ? 'checked' : '' }}>

                                <label class="form-check-label" for="showPrice">
                                    نمایش قیمت
                                </label>
                            </div>

                            <div class="form-check form-switch">
                                <input type="checkbox"
                                       name="allow_order"
                                       value="1"
                                       class="form-check-input"
                                       id="allowOrder"
                                    {{ old('allow_order', $product->allow_order) ? 'checked' : '' }}>

                                <label class="form-check-label" for="allowOrder">
                                    امکان ثبت سفارش
                                </label>
                            </div>

                        </div>
                    </div>

                    {{-- IMAGES --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">تصاویر محصول</h5>
                        </div>

                        <div class="card-body">

                            @php
                                $mainImage = $product->images->where('is_main', true)->first();
                            @endphp

                            @if ($mainImage)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $mainImage->image) }}"
                                         class="img-fluid rounded border"
                                         alt="{{ $product->title }}">
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">تصویر اصلی جدید</label>

                                <input type="file"
                                       name="main_image"
                                       class="form-control @error('main_image') is-invalid @enderror">

                                @error('main_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">گالری تصاویر جدید</label>

                                <input type="file"
                                       name="gallery_images[]"
                                       class="form-control @error('gallery_images') is-invalid @enderror @error('gallery_images.*') is-invalid @enderror"
                                       multiple>

                                @error('gallery_images')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @error('gallery_images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- RELATED PRODUCTS --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">محصولات مرتبط</h5>
                        </div>

                        <div class="card-body">

                            @php
                                $oldRelatedProducts = old(
                                    'related_products',
                                    $product->relatedProducts?->pluck('id')->toArray() ?? []
                                );
                            @endphp

                            <select name="related_products[]"
                                    class="form-control"
                                    multiple>

                                @foreach ($products as $relatedProduct)
                                    <option value="{{ $relatedProduct->id }}"
                                        {{ in_array($relatedProduct->id, $oldRelatedProducts) ? 'selected' : '' }}>
                                        {{ $relatedProduct->title }}
                                    </option>
                                @endforeach

                            </select>

                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="card position-sticky" style="top:90px;">
                        <div class="card-body d-grid gap-2">

                            <button class="btn btn-success" type="submit">
                                بروزرسانی محصول
                            </button>

                            <a href="{{ route('admin.products.index') }}"
                               class="btn btn-light">
                                انصراف
                            </a>

                        </div>
                    </div>

                </div>

            </div>
        </form>

    </div>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'موفقیت آمیز',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'متوجه شدم',
                    confirmButtonColor: '#3085d6',
                });
            });
        </script>
    @endif
@endsection
