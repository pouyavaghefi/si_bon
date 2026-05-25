@extends('frontend.layouts.master')

@section('pageTitle', $product->meta_title ?? $product->title)

@section('wrapper')

    @php
        $images = $product->images ?? collect();
        $galleryImages = $images->count() ? $images : collect();
        $basePrice = $product->discount_price ?? $product->price;

        $allowedExtensions = is_array($product->allowed_extensions ?? null)
            ? $product->allowed_extensions
            : json_decode($product->allowed_extensions ?? '[]', true);
    @endphp

    <section style="direction: rtl;" class="main-container col1-layout">
        <div style="margin: 125px auto 0;" class="main container">

            <div class="mainmenubar mb-3">
                <ul>
                    <li><a href="{{ url('/') }}">خانه</a> /</li>
                    <li><a href="{{ route('front.shop.categories') }}">محصولات</a> /</li>

                    @if($product->category)
                        <li>
                            <a href="{{ route('front.shop.category', $product->category->slug) }}">
                                {{ $product->category->title }}
                            </a>
                            /
                        </li>
                    @endif

                    <span>{{ $product->title }}</span>
                </ul>
            </div>

            <div class="row">

                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="product-gallery">

                        <div id="slider" class="owl-carousel product-slider">
                            @forelse($galleryImages as $image)
                                <div class="item">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->title }}">
                                </div>
                            @empty
                                <div class="item">
                                    <img src="{{ asset('frontend/images/no-image.jpg') }}" alt="{{ $product->title }}">
                                </div>
                            @endforelse
                        </div>

                        <div id="thumb" class="owl-carousel product-thumb mt-3">
                            @forelse($galleryImages as $image)
                                <div class="item">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->title }}">
                                </div>
                            @empty
                                <div class="item">
                                    <img src="{{ asset('frontend/images/no-image.jpg') }}" alt="{{ $product->title }}">
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>

                <div class="col-lg-8 col-md-12">

                    <form action="{{ route('front.cart.addPrint') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          id="product_addtocart_form">
                        @csrf

                        <input type="hidden" name="total_price" id="total_price_input" value="{{ $basePrice }}">
                        <input type="hidden" name="type" value="print">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" id="base_price" value="{{ $basePrice }}">

                        <div class="mb-3">
                            <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 10px;">
                                {{ $product->title }}
                            </h1>

                            @if($product->category)
                                <div style="font-size: 15px; margin-bottom: 8px;">
                                    دسته بندی :
                                    <a href="{{ route('front.shop.category', $product->category->slug) }}">
                                        {{ $product->category->title }}
                                    </a>
                                </div>
                            @endif

                            @if($product->brand)
                                <div style="font-size: 15px; margin-bottom: 8px;">
                                    برند :
                                    <a href="#">{{ $product->brand->title }}</a>
                                </div>
                            @endif

                            @if($product->show_price)
                                <div style="
                                display: inline-flex;
                                align-items: center;
                                gap: 6px;
                                background: #f5f5f5;
                                border: 1px solid #ddd;
                                border-radius: 8px;
                                padding: 10px 18px;
                                color: #e60023;
                                font-size: 22px;
                                font-weight: bold;
                                margin-top: 8px;
                            ">
                                    <span>{{ number_format($basePrice) }}</span>
                                    <span style="font-size: 15px; color: #333;">تومان</span>

                                    @if($product->sale_unit)
                                        <span style="font-size: 14px; color: #777;">
                                        / {{ $product->sale_unit }}
                                    </span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="product-name-l1">
                            <p class="p1">سفارش چاپ سفارشی</p>
                            <p class="p2">تحویل {{ $product->delivery_time ?? '۲ تا ۳ روز کاری' }}</p>
                        </div>

                        <div style="background:#eaeaea;" class="p-4 mb-3">

                            <div class="row">

                                @if($product->require_upload)
                                    <div class="col-12 p-2 text-center">
                                        <p>فایل چاپی:</p>

                                        <input type="file"
                                               name="print_file"
                                               class="form-control"
                                               @if(!empty($allowedExtensions))
                                                   accept=".{{ implode(',.', array_map('strtolower', $allowedExtensions)) }}"
                                               @endif
                                               required>
                                    </div>
                                @endif

                                <div class="col-lg-4 col-md-6 p-2 text-center">
                                    <p>عرض:</p>
                                    <input type="number" step="0.01" min="0" name="width" id="print_width" class="form-control text-end" required>
                                </div>

                                <div class="col-lg-4 col-md-6 p-2 text-center">
                                    <p>طول:</p>
                                    <input type="number" step="0.01" min="0" name="height" id="print_height" class="form-control text-end" required>
                                </div>

                                <div class="col-lg-4 col-md-6 p-2 text-center">
                                    <p>تعداد:</p>
                                    <input type="number"
                                           name="quantity"
                                           id="print_quantity"
                                           class="form-control text-end"
                                           min="{{ $product->min_order ?? 1 }}"
                                           value="{{ $product->min_order ?? 1 }}">
                                </div>

                                @foreach($options as $option)
                                    <div class="col-lg-4 col-md-6 p-2 text-center">
                                        <p>{{ $option->title }}:</p>

                                        @if($option->type === 'select')
                                            <select name="options[{{ $option->id }}]" class="form-control print-option">
                                                <option value="" data-price="0">انتخاب کنید</option>

                                                @foreach($option->values as $value)
                                                    <option value="{{ $value->id }}"
                                                            data-price="{{ $value->price ?? 0 }}"
                                                            data-label="{{ $value->title }}">
                                                        {{ $value->title }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        @elseif($option->type === 'number')
                                            <input type="number"
                                                   name="options_number[{{ $option->id }}]"
                                                   class="form-control text-end print-number-option"
                                                   data-label="{{ $option->title }}">

                                        @elseif($option->type === 'checkbox')
                                            @foreach($option->values as $value)
                                                <label class="d-block text-end">
                                                    <input type="checkbox"
                                                           name="options[{{ $option->id }}][]"
                                                           value="{{ $value->id }}"
                                                           class="print-checkbox"
                                                           data-price="{{ $value->price ?? 0 }}"
                                                           data-label="{{ $value->title }}">
                                                    {{ $value->title }}
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach

                                <div class="col-lg-4 col-md-6 p-2 text-center">
                                    <p>نیاز به نصاب:</p>

                                    <select name="installer_required" id="installer_required" class="form-control">
                                        <option value="0">نیاز ندارم</option>
                                        <option value="1">نیاز دارم</option>
                                    </select>
                                </div>

                                <div class="col-lg-4 col-md-6 p-2 text-center installer-box" style="display:none;">
                                    <p>نوع نصب:</p>

                                    <select name="installer_type" id="installer_type" class="form-control installer-price">
                                        <option value="" data-price="0">انتخاب کنید</option>
                                        <option value="simple" data-price="250000">نصب ساده</option>
                                        <option value="professional" data-price="500000">نصب حرفه‌ای</option>
                                    </select>
                                </div>

                                <div class="col-lg-4 col-md-6 p-2 text-center installer-box" style="display:none;">
                                    <p>آدرس نصب:</p>

                                    <input type="text"
                                           name="installer_address"
                                           id="installer_address"
                                           class="form-control"
                                           placeholder="آدرس محل نصب">
                                </div>

                            </div>

                        </div>

                        <div class="product-name-l2">
                            <p>
                                خلاصه سفارش :
                                <span id="print-summary"></span>
                            </p>
                        </div>

                        <div class="product-name-l3">
                        <span class="span-prise">
                            <span class="product-name-l3-r">
                                <span class="span2-mab">مبلغ :</span>
                                <span id="print-total-price">{{ number_format($basePrice) }}</span>
                            </span>
                            <span class="span2">تومان</span>
                        </span>

                            @if($product->allow_order)
                                <button type="submit" class="product-name-l3-l product-name-l3-l-cart border-0">
                                    افزودن به سبد
                                </button>
                            @else
                                <span class="product-name-l3-l2">ناموجود</span>
                            @endif
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </section>

    <section class="related-pro wow bounceInUp animated">
        <div style="width:97%;" class="container">
            <section style="direction: rtl;">
                <div class="row mb-4">
                    <div class="col-12">

                        <div class="shadow-around shadow-around-s">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#description-tab">
                                        توضیحات محصول
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#specifications-tab">
                                        مشخصات
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane fade show active" id="description-tab">
                                    <div class="std p-3">
                                        {!! $product->description !!}
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="specifications-tab">
                                    <div class="std p-3">
                                        <ul class="c-params__list">
                                            @forelse($product->specifications as $specification)
                                                <li>
                                                    <div class="c-params__list-key">
                                                        <span class="block">{{ $specification->key }}</span>
                                                    </div>

                                                    <div class="c-params__list-value">
                                                        <span class="block">{{ $specification->value }}</span>
                                                    </div>
                                                </li>
                                            @empty
                                                <li>
                                                    <div class="c-params__list-value">
                                                        <span class="block">مشخصاتی ثبت نشده است.</span>
                                                    </div>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function formatPrice(number) {
            return new Intl.NumberFormat('fa-IR').format(number);
        }

        function calculatePrintPrice() {
            const basePrice = parseFloat(document.getElementById('base_price').value || 0);
            const width = parseFloat(document.getElementById('print_width').value || 0);
            const height = parseFloat(document.getElementById('print_height').value || 0);
            const quantity = parseInt(document.getElementById('print_quantity').value || 1);

            let area = width * height;
            let optionsPrice = 0;
            let installerPrice = 0;
            let summaryItems = [];

            document.querySelectorAll('.print-option').forEach(function (select) {
                const selected = select.options[select.selectedIndex];

                if (selected && selected.value) {
                    optionsPrice += parseFloat(selected.dataset.price || 0);
                    summaryItems.push(selected.dataset.label || selected.textContent.trim());
                }
            });

            document.querySelectorAll('.print-checkbox:checked').forEach(function (checkbox) {
                optionsPrice += parseFloat(checkbox.dataset.price || 0);
                summaryItems.push(checkbox.dataset.label || checkbox.value);
            });

            document.querySelectorAll('.print-number-option').forEach(function (input) {
                if (input.value) {
                    summaryItems.push(input.dataset.label + ': ' + input.value);
                }
            });

            document.querySelectorAll('.installer-price').forEach(function (select) {
                const selected = select.options[select.selectedIndex];

                if (selected && selected.value) {
                    installerPrice += parseFloat(selected.dataset.price || 0);
                    summaryItems.push(selected.textContent.trim());
                }
            });

            let total = area > 0
                ? ((basePrice + optionsPrice) * area * quantity) + installerPrice
                : ((basePrice + optionsPrice) * quantity) + installerPrice;

            document.getElementById('print-total-price').innerText = formatPrice(total);

            let sizeText = width && height ? width + ' × ' + height : '';

            document.getElementById('print-summary').innerHTML =
                (sizeText ? '<span class="product-sum-l4-r">ابعاد: ' + sizeText + '</span>' : '') +
                '<span class="product-sum-l4-r">تعداد: ' + quantity + '</span>' +
                summaryItems.map(function (item) {
                    return '<span class="product-sum-l4-r">' + item + '</span>';
                }).join('');
        }

        function toggleInstallerOptions() {
            const installerRequired = document.getElementById('installer_required').value;
            const installerBoxes = document.querySelectorAll('.installer-box');
            const installerAddress = document.getElementById('installer_address');

            installerBoxes.forEach(function (box) {
                box.style.display = installerRequired === '1' ? 'block' : 'none';
            });

            if (installerRequired === '1') {
                installerAddress.setAttribute('required', 'required');
            } else {
                installerAddress.removeAttribute('required');
                installerAddress.value = '';

                document.querySelectorAll('.installer-price').forEach(function (select) {
                    select.selectedIndex = 0;
                });
            }

            calculatePrintPrice();
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll(
                '.print-option, .print-checkbox, .print-number-option, .installer-price, #print_width, #print_height, #print_quantity'
            ).forEach(function (element) {
                element.addEventListener('change', calculatePrintPrice);
                element.addEventListener('keyup', calculatePrintPrice);
            });

            document.getElementById('installer_required').addEventListener('change', toggleInstallerOptions);

            toggleInstallerOptions();
            calculatePrintPrice();
        });
    </script>
@endpush
