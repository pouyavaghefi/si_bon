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
                    ایجاد محصول صفحه Single Product
                </span>

                <h2 class="fw-bold mb-2">
                    ایجاد محصول تکی
                </h2>

                <p class="text-muted fs-md mb-0">
                    مناسب برای صفحه محصول فرانت شامل گالری، قیمت، گزینه‌های سفارش، خلاصه سفارش و افزودن به سبد خرید.
                </p>
            </div>
        </div>

        <form action="{{ route('admin.products.storeTaki') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-xl-9">

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
                                           value="{{ old('title') }}"
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
                                           value="{{ old('slug') }}"
                                           placeholder="chap-sticker">

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
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                           value="{{ old('brand') }}"
                                           placeholder="مثلاً TAT">

                                    @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">توضیح کوتاه بالای صفحه محصول</label>

                                    <textarea name="short_description"
                                              class="form-control @error('short_description') is-invalid @enderror"
                                              rows="3"
                                              placeholder="متن کوتاه برای معرفی محصول">{{ old('short_description') }}</textarea>

                                    @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">قیمت و تنظیمات فروش</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-4">
                                    <label class="form-label">قیمت پایه</label>

                                    <div class="input-group">
                                        <input type="number"
                                               name="price"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price') }}"
                                               placeholder="580000">

                                        <span class="input-group-text">تومان</span>

                                        @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">قیمت تخفیف</label>

                                    <div class="input-group">
                                        <input type="number"
                                               name="discount_price"
                                               class="form-control @error('discount_price') is-invalid @enderror"
                                               value="{{ old('discount_price') }}"
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
                                        <option value="number" {{ old('sale_unit', 'number') == 'number' ? 'selected' : '' }}>عدد</option>
                                        <option value="meter" {{ old('sale_unit') == 'meter' ? 'selected' : '' }}>متر</option>
                                        <option value="square_meter" {{ old('sale_unit') == 'square_meter' ? 'selected' : '' }}>متر مربع</option>
                                        <option value="roll" {{ old('sale_unit') == 'roll' ? 'selected' : '' }}>رول</option>
                                        <option value="service" {{ old('sale_unit') == 'service' ? 'selected' : '' }}>سرویس</option>
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
                                           value="{{ old('stock', 0) }}">

                                    @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">حداقل سفارش</label>

                                    <input type="number"
                                           name="min_order"
                                           class="form-control @error('min_order') is-invalid @enderror"
                                           value="{{ old('min_order', 1) }}">

                                    @error('min_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">زمان تحویل</label>

                                    <input type="text"
                                           name="delivery_time"
                                           class="form-control @error('delivery_time') is-invalid @enderror"
                                           value="{{ old('delivery_time', '۲ تا ۳ روز کاری') }}">

                                    @error('delivery_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">گزینه‌های سفارش در فرانت</h5>
                        </div>

                        <div class="card-body">

                            <div class="alert alert-info">
                                این بخش همان فیلدهای داخل صفحه محصول است؛ مثل نوع استند، تعداد، خدمات اضافه و خلاصه سفارش.
                            </div>

                            <div class="border rounded p-4 mb-4">
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <label class="form-label">عنوان گزینه</label>

                                        <input type="text"
                                               name="options[0][title]"
                                               class="form-control"
                                               value="{{ old('options.0.title', 'نوع استند') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">نوع فیلد</label>

                                        <select name="options[0][type]" class="form-select">
                                            <option value="select" {{ old('options.0.type', 'select') == 'select' ? 'selected' : '' }}>لیست انتخابی</option>
                                            <option value="radio" {{ old('options.0.type') == 'radio' ? 'selected' : '' }}>رادیویی</option>
                                            <option value="checkbox" {{ old('options.0.type') == 'checkbox' ? 'selected' : '' }}>چند انتخابی</option>
                                            <option value="text" {{ old('options.0.type') == 'text' ? 'selected' : '' }}>متن</option>
                                            <option value="number" {{ old('options.0.type') == 'number' ? 'selected' : '' }}>عدد</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">اجباری؟</label>

                                        <select name="options[0][required]" class="form-select">
                                            <option value="1" {{ old('options.0.required', 1) == 1 ? 'selected' : '' }}>بله</option>
                                            <option value="0" {{ old('options.0.required') == 0 ? 'selected' : '' }}>خیر</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">مقادیر انتخابی</label>

                                        <textarea name="options[0][values]"
                                                  class="form-control"
                                                  rows="5"
                                                  placeholder="استند نقره ای | 0&#10;استند مشکی | 150000">{{ old('options.0.values') }}</textarea>

                                        <small class="text-muted">
                                            هر خط: عنوان گزینه | قیمت اضافه
                                        </small>
                                    </div>

                                </div>
                            </div>

                            <div class="border rounded p-4 mb-4">
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <label class="form-label">عنوان گزینه</label>

                                        <input type="text"
                                               name="options[1][title]"
                                               class="form-control"
                                               value="{{ old('options.1.title', 'تعداد') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">نوع فیلد</label>

                                        <select name="options[1][type]" class="form-select">
                                            <option value="number" {{ old('options.1.type', 'number') == 'number' ? 'selected' : '' }}>عدد</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">اجباری؟</label>

                                        <select name="options[1][required]" class="form-select">
                                            <option value="1" {{ old('options.1.required', 1) == 1 ? 'selected' : '' }}>بله</option>
                                            <option value="0" {{ old('options.1.required') == 0 ? 'selected' : '' }}>خیر</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="border rounded p-4">
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <label class="form-label">عنوان گزینه</label>

                                        <input type="text"
                                               name="options[2][title]"
                                               class="form-control"
                                               value="{{ old('options.2.title', 'خدمات اضافه') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">نوع فیلد</label>

                                        <select name="options[2][type]" class="form-select">
                                            <option value="checkbox" {{ old('options.2.type', 'checkbox') == 'checkbox' ? 'selected' : '' }}>چند انتخابی</option>
                                            <option value="select" {{ old('options.2.type') == 'select' ? 'selected' : '' }}>لیست انتخابی</option>
                                            <option value="radio" {{ old('options.2.type') == 'radio' ? 'selected' : '' }}>رادیویی</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">اجباری؟</label>

                                        <select name="options[2][required]" class="form-select">
                                            <option value="0" {{ old('options.2.required', 0) == 0 ? 'selected' : '' }}>خیر</option>
                                            <option value="1" {{ old('options.2.required') == 1 ? 'selected' : '' }}>بله</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">مقادیر خدمات</label>

                                        <textarea name="options[2][values]"
                                                  class="form-control"
                                                  rows="5"
                                                  placeholder="لمینت براق | 50000&#10;برش با دستگاه | 80000&#10;برش شکل خاص | 120000">{{ old('options.2.values') }}</textarea>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">مشخصات فنی محصول</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                @foreach ([0 => 'عرض', 1 => 'طول', 2 => 'ضخامت', 3 => 'رنگ', 4 => 'بسته بندی'] as $index => $label)
                                    <div class="col-md-6">
                                        <label class="form-label">عنوان مشخصه</label>

                                        <input type="text"
                                               name="specifications[{{ $index }}][key]"
                                               class="form-control"
                                               value="{{ old('specifications.' . $index . '.key', $label) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">مقدار مشخصه</label>

                                        <input type="text"
                                               name="specifications[{{ $index }}][value]"
                                               class="form-control"
                                               value="{{ old('specifications.' . $index . '.value') }}">
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">توضیحات کامل محصول</h5>
                        </div>

                        <div class="card-body">
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="10"
                                      placeholder="توضیحات کامل محصول را وارد کنید...">{{ old('description') }}</textarea>

                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

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
                                           class="form-control"
                                           value="{{ old('meta_title') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">کلمات کلیدی</label>

                                    <input type="text"
                                           name="meta_keywords"
                                           class="form-control"
                                           value="{{ old('meta_keywords') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">توضیحات متا</label>

                                    <textarea name="meta_description"
                                              class="form-control"
                                              rows="4">{{ old('meta_description') }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

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
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>منتشر شده</option>
                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
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
                                    {{ old('is_featured') ? 'checked' : '' }}>

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
                                    {{ old('show_price', 1) ? 'checked' : '' }}>

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
                                    {{ old('allow_order', 1) ? 'checked' : '' }}>

                                <label class="form-check-label" for="allowOrder">
                                    امکان ثبت سفارش
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">تصاویر محصول</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">تصویر اصلی محصول</label>

                                <input type="file"
                                       name="main_image"
                                       class="form-control @error('main_image') is-invalid @enderror">

                                @error('main_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">گالری تصاویر محصول</label>

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

                    <div class="card position-sticky" style="top:90px;">
                        <div class="card-body d-grid gap-2">

                            <button class="btn btn-success" type="submit">
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
