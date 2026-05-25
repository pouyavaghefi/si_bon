@extends('admin.layouts.master')

@section('wrapper')
    <div class="container-fluid" dir="rtl">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <div class="fw-bold mb-2">
                    لطفاً خطاهای زیر را بررسی کنید:
                </div>

                <ul class="mb-0 pe-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center py-4">
            <div class="col-xxl-8 col-xl-9 text-center">

                <span class="badge badge-default fw-normal shadow px-3 py-2 mb-3 fs-xxs">
                    <i data-lucide="package-plus" class="fs-sm me-1"></i>
                    مدیریت صفحه Single Product
                </span>

                <h2 class="fw-bold mb-2">
                    ایجاد محصول چاپ سفارشی
                </h2>

                <p class="text-muted fs-md mb-0">
                    در این بخش می‌توانید اطلاعات محصول، قیمت، فایل چاپی، مراحل سفارش، تصاویر و تنظیمات سئو را مدیریت کنید.
                </p>

            </div>
        </div>

        <form action="{{ route('admin.products.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-xl-9">

                    {{-- MAIN PRODUCT --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                اطلاعات اصلی محصول
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">
                                        نام محصول
                                    </label>

                                    <input type="text"
                                           name="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title') }}"
                                           placeholder="مثلاً چاپ استیکر">

                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        اسلاگ
                                    </label>

                                    <input type="text"
                                           name="slug"
                                           class="form-control @error('slug') is-invalid @enderror"
                                           value="{{ old('slug') }}"
                                           placeholder="sticker-print">

                                    @error('slug')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        دسته‌بندی
                                    </label>

                                    <select name="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror">

                                        <option value="" {{ old('category_id') ? '' : 'selected' }}>
                                            انتخاب دسته‌بندی
                                        </option>

                                        @isset($categories)
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="1" {{ old('category_id') == 1 ? 'selected' : '' }}>
                                                چاپ استیکر
                                            </option>

                                            <option value="2" {{ old('category_id') == 2 ? 'selected' : '' }}>
                                                چاپ بنر
                                            </option>

                                            <option value="3" {{ old('category_id') == 3 ? 'selected' : '' }}>
                                                چاپ مش
                                            </option>

                                            <option value="4" {{ old('category_id') == 4 ? 'selected' : '' }}>
                                                چاپ شیشه
                                            </option>
                                        @endisset

                                    </select>

                                    @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        برند
                                    </label>

                                    <input type="text"
                                           name="brand"
                                           class="form-control @error('brand') is-invalid @enderror"
                                           value="{{ old('brand') }}"
                                           placeholder="مثلاً TAT">

                                    @error('brand')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">
                                        توضیح کوتاه
                                    </label>

                                    <textarea name="short_description"
                                              class="form-control @error('short_description') is-invalid @enderror"
                                              rows="3"
                                              placeholder="توضیح کوتاه برای بالای صفحه محصول">{{ old('short_description') }}</textarea>

                                    @error('short_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- PRICE --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                قیمت و تنظیمات فروش
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-4">
                                    <label class="form-label">
                                        قیمت اصلی
                                    </label>

                                    <div class="input-group">
                                        <input type="number"
                                               name="price"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price') }}"
                                               placeholder="500000">

                                        <span class="input-group-text">
                                            تومان
                                        </span>

                                        @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        قیمت با تخفیف
                                    </label>

                                    <div class="input-group">
                                        <input type="number"
                                               name="discount_price"
                                               class="form-control @error('discount_price') is-invalid @enderror"
                                               value="{{ old('discount_price') }}"
                                               placeholder="اختیاری">

                                        <span class="input-group-text">
                                            تومان
                                        </span>

                                        @error('discount_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        واحد فروش
                                    </label>

                                    <select name="sale_unit"
                                            class="form-select @error('sale_unit') is-invalid @enderror">

                                        <option value="number" {{ old('sale_unit', 'number') == 'number' ? 'selected' : '' }}>
                                            عدد
                                        </option>

                                        <option value="meter" {{ old('sale_unit') == 'meter' ? 'selected' : '' }}>
                                            متر
                                        </option>

                                        <option value="square_meter" {{ old('sale_unit') == 'square_meter' ? 'selected' : '' }}>
                                            متر مربع
                                        </option>

                                        <option value="roll" {{ old('sale_unit') == 'roll' ? 'selected' : '' }}>
                                            رول
                                        </option>

                                        <option value="kg" {{ old('sale_unit') == 'kg' ? 'selected' : '' }}>
                                            کیلوگرم
                                        </option>

                                        <option value="package" {{ old('sale_unit') == 'package' ? 'selected' : '' }}>
                                            بسته
                                        </option>

                                        <option value="service" {{ old('sale_unit') == 'service' ? 'selected' : '' }}>
                                            سرویس
                                        </option>

                                    </select>

                                    @error('sale_unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        موجودی
                                    </label>

                                    <input type="number"
                                           name="stock"
                                           class="form-control @error('stock') is-invalid @enderror"
                                           value="{{ old('stock') }}"
                                           placeholder="100">

                                    @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        حداقل سفارش
                                    </label>

                                    <input type="number"
                                           name="min_order"
                                           class="form-control @error('min_order') is-invalid @enderror"
                                           value="{{ old('min_order', 1) }}"
                                           placeholder="1">

                                    @error('min_order')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        زمان تحویل
                                    </label>

                                    <input type="text"
                                           name="delivery_time"
                                           class="form-control @error('delivery_time') is-invalid @enderror"
                                           value="{{ old('delivery_time') }}"
                                           placeholder="۲ تا ۳ روز کاری">

                                    @error('delivery_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- PRODUCT FILE CONFIGURATION --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                تنظیمات فایل چاپی
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                @php
                                    $oldExtensions = old('allowed_extensions', []);
                                @endphp

                                <div class="col-md-4">
                                    <label class="form-label">
                                        فرمت‌های مجاز فایل
                                    </label>

                                    <select name="allowed_extensions[]"
                                            class="form-select @error('allowed_extensions') is-invalid @enderror"
                                            multiple>

                                        <option value="JPG" {{ in_array('JPG', $oldExtensions) ? 'selected' : '' }}>JPG</option>
                                        <option value="PNG" {{ in_array('PNG', $oldExtensions) ? 'selected' : '' }}>PNG</option>
                                        <option value="PDF" {{ in_array('PDF', $oldExtensions) ? 'selected' : '' }}>PDF</option>
                                        <option value="AI" {{ in_array('AI', $oldExtensions) ? 'selected' : '' }}>AI</option>
                                        <option value="PSD" {{ in_array('PSD', $oldExtensions) ? 'selected' : '' }}>PSD</option>

                                    </select>

                                    @error('allowed_extensions')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        حداکثر حجم فایل
                                    </label>

                                    <div class="input-group">
                                        <input type="number"
                                               name="max_upload_size"
                                               class="form-control @error('max_upload_size') is-invalid @enderror"
                                               value="{{ old('max_upload_size') }}"
                                               placeholder="200">

                                        <span class="input-group-text">
                                            MB
                                        </span>

                                        @error('max_upload_size')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        نیاز به آپلود فایل؟
                                    </label>

                                    <select name="require_upload"
                                            class="form-select @error('require_upload') is-invalid @enderror">

                                        <option value="1" {{ old('require_upload', 1) == 1 ? 'selected' : '' }}>
                                            بله
                                        </option>

                                        <option value="0" {{ old('require_upload') == 0 ? 'selected' : '' }}>
                                            خیر
                                        </option>

                                    </select>

                                    @error('require_upload')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ORDER OPTIONS --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                گزینه‌های سفارش محصول
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="border rounded p-4 mb-4">
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <label class="form-label">
                                            عنوان گزینه
                                        </label>

                                        <input type="text"
                                               name="options[0][title]"
                                               class="form-control"
                                               value="{{ old('options.0.title', 'نوع متریال') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">
                                            نوع فیلد
                                        </label>

                                        <select name="options[0][type]"
                                                class="form-select">

                                            <option value="select" {{ old('options.0.type') == 'select' ? 'selected' : '' }}>
                                                لیست انتخابی
                                            </option>

                                            <option value="radio" {{ old('options.0.type', 'radio') == 'radio' ? 'selected' : '' }}>
                                                رادیویی
                                            </option>

                                            <option value="checkbox" {{ old('options.0.type') == 'checkbox' ? 'selected' : '' }}>
                                                چند انتخابی
                                            </option>

                                            <option value="number" {{ old('options.0.type') == 'number' ? 'selected' : '' }}>
                                                عدد
                                            </option>

                                            <option value="text" {{ old('options.0.type') == 'text' ? 'selected' : '' }}>
                                                متن
                                            </option>

                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">
                                            اجباری باشد؟
                                        </label>

                                        <select name="options[0][required]"
                                                class="form-select">

                                            <option value="1" {{ old('options.0.required', 1) == 1 ? 'selected' : '' }}>
                                                بله
                                            </option>

                                            <option value="0" {{ old('options.0.required') == 0 ? 'selected' : '' }}>
                                                خیر
                                            </option>

                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">
                                            مقادیر گزینه
                                        </label>

                                        <textarea name="options[0][values]"
                                                  class="form-control"
                                                  rows="5"
                                                  placeholder="استیکر مات | 0&#10;استیکر براق | 150000&#10;استیکر شیشه‌ای | 300000">{{ old('options.0.values') }}</textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="border rounded p-4">
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <label class="form-label">
                                            عنوان گزینه
                                        </label>

                                        <input type="text"
                                               name="options[1][title]"
                                               class="form-control"
                                               value="{{ old('options.1.title', 'تعداد') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">
                                            نوع فیلد
                                        </label>

                                        <select name="options[1][type]"
                                                class="form-select">

                                            <option value="number" {{ old('options.1.type', 'number') == 'number' ? 'selected' : '' }}>
                                                عدد
                                            </option>

                                            <option value="text" {{ old('options.1.type') == 'text' ? 'selected' : '' }}>
                                                متن
                                            </option>

                                            <option value="select" {{ old('options.1.type') == 'select' ? 'selected' : '' }}>
                                                لیست انتخابی
                                            </option>

                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">
                                            اجباری باشد؟
                                        </label>

                                        <select name="options[1][required]"
                                                class="form-select">

                                            <option value="1" {{ old('options.1.required', 1) == 1 ? 'selected' : '' }}>
                                                بله
                                            </option>

                                            <option value="0" {{ old('options.1.required') == 0 ? 'selected' : '' }}>
                                                خیر
                                            </option>

                                        </select>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- SPECIFICATIONS --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                مشخصات فنی محصول
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">
                                        عنوان مشخصه
                                    </label>

                                    <input type="text"
                                           name="specifications[0][key]"
                                           class="form-control"
                                           value="{{ old('specifications.0.key', 'عرض') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        مقدار مشخصه
                                    </label>

                                    <input type="text"
                                           name="specifications[0][value]"
                                           class="form-control"
                                           value="{{ old('specifications.0.value') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        عنوان مشخصه
                                    </label>

                                    <input type="text"
                                           name="specifications[1][key]"
                                           class="form-control"
                                           value="{{ old('specifications.1.key', 'طول') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        مقدار مشخصه
                                    </label>

                                    <input type="text"
                                           name="specifications[1][value]"
                                           class="form-control"
                                           value="{{ old('specifications.1.value') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        عنوان مشخصه
                                    </label>

                                    <input type="text"
                                           name="specifications[2][key]"
                                           class="form-control"
                                           value="{{ old('specifications.2.key', 'ضخامت') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        مقدار مشخصه
                                    </label>

                                    <input type="text"
                                           name="specifications[2][value]"
                                           class="form-control"
                                           value="{{ old('specifications.2.value') }}">
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                توضیحات کامل محصول
                            </h5>
                        </div>

                        <div class="card-body">
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="8"
                                      placeholder="توضیحات کامل محصول را وارد کنید...">{{ old('description') }}</textarea>

                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                تنظیمات سئو
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">
                                        عنوان سئو
                                    </label>

                                    <input type="text"
                                           name="meta_title"
                                           class="form-control @error('meta_title') is-invalid @enderror"
                                           value="{{ old('meta_title') }}">

                                    @error('meta_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        کلمات کلیدی
                                    </label>

                                    <input type="text"
                                           name="meta_keywords"
                                           class="form-control @error('meta_keywords') is-invalid @enderror"
                                           value="{{ old('meta_keywords') }}">

                                    @error('meta_keywords')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">
                                        توضیحات متا
                                    </label>

                                    <textarea name="meta_description"
                                              class="form-control @error('meta_description') is-invalid @enderror"
                                              rows="4">{{ old('meta_description') }}</textarea>

                                    @error('meta_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
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
                            <h5 class="card-title mb-0">
                                وضعیت محصول
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">
                                    وضعیت انتشار
                                </label>

                                <select name="status"
                                        class="form-select @error('status') is-invalid @enderror">

                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                        منتشر شده
                                    </option>

                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>
                                        پیش‌نویس
                                    </option>

                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                        غیرفعال
                                    </option>

                                </select>

                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="checkbox"
                                       name="is_featured"
                                       value="1"
                                       class="form-check-input"
                                       id="isFeatured"
                                    {{ old('is_featured') ? 'checked' : '' }}>

                                <label class="form-check-label"
                                       for="isFeatured">
                                    محصول ویژه
                                </label>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="checkbox"
                                       name="show_price"
                                       value="1"
                                       class="form-check-input"
                                       id="showPrice"
                                    {{ old('show_price', 1) ? 'checked' : '' }}>

                                <label class="form-check-label"
                                       for="showPrice">
                                    نمایش قیمت
                                </label>
                            </div>

                            <div class="form-check form-switch">
                                <input type="checkbox"
                                       name="allow_order"
                                       value="1"
                                       class="form-check-input"
                                       id="allowOrder"
                                    {{ old('allow_order', 1) ? 'checked' : '' }}>

                                <label class="form-check-label"
                                       for="allowOrder">
                                    امکان ثبت سفارش
                                </label>
                            </div>

                        </div>
                    </div>

                    {{-- PRODUCT IMAGES --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                تصاویر محصول
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">
                                    تصویر اصلی
                                </label>

                                <input type="file"
                                       name="main_image"
                                       class="form-control @error('main_image') is-invalid @enderror">

                                @error('main_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">
                                    گالری تصاویر
                                </label>

                                <input type="file"
                                       name="gallery_images[]"
                                       class="form-control @error('gallery_images') is-invalid @enderror @error('gallery_images.*') is-invalid @enderror"
                                       multiple>

                                @error('gallery_images')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                @error('gallery_images.*')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- RELATED PRODUCTS --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                محصولات مرتبط
                            </h5>
                        </div>

                        <div class="card-body">

                            @php
                                $oldRelatedProducts = old('related_products', []);
                            @endphp

                            <select name="related_products[]"
                                    class="form-control"
                                    multiple>

                                @isset($products)
                                    @foreach ($products as $relatedProduct)
                                        <option value="{{ $relatedProduct->id }}"
                                            {{ in_array($relatedProduct->id, $oldRelatedProducts) ? 'selected' : '' }}>
                                            {{ $relatedProduct->title }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="1" {{ in_array(1, $oldRelatedProducts) ? 'selected' : '' }}>
                                        چاپ مش
                                    </option>

                                    <option value="2" {{ in_array(2, $oldRelatedProducts) ? 'selected' : '' }}>
                                        چاپ سولیت
                                    </option>
                                @endisset

                            </select>

                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="card position-sticky"
                         style="top:90px;">

                        <div class="card-body d-grid gap-2">

                            <button class="btn btn-success"
                                    type="submit">
                                ذخیره محصول
                            </button>

                            <button class="btn btn-primary"
                                    type="submit"
                                    name="publish"
                                    value="1">
                                ذخیره و انتشار
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
