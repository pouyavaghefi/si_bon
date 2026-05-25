@extends('frontend.layouts.master')

@section('pageTitle', $product->meta_title ?? $product->title)

@section('wrapper')

    @php
        $images = $product->images ?? collect();
        $mainImage = $images->where('is_main', true)->first();
        $galleryImages = $images->count() ? $images : collect([$mainImage])->filter();
        $basePrice = $product->discount_price ?? $product->price;
    @endphp

    <section style="direction: rtl;" class="main-container col1-layout wow bounceInUp animated">
        <div style="margin: 125px auto 0;" class="main container">
            <div class="col-main">

                <div class="mainmenubar">
                    <ul>
                        <li>
                            <a href="{{ url('/') }}">
                                <span class="mainmenubara-span1">خانه</span>
                            </a>
                            <span class="mainmenubara-span2">/</span>
                        </li>

                        <li>
                            <a class="mainmenubara-a" href="{{ route('front.shop.categories') }}">
                                <span class="mainmenubara-span1">محصولات</span>
                            </a>
                            <span class="mainmenubara-span2">/</span>
                        </li>

                        @if($product->category)
                            <li>
                                <a class="mainmenubara-a" href="{{ route('front.shop.category', $product->category->slug) }}">
                                    <span class="mainmenubara-span1">{{ $product->category->title }}</span>
                                </a>
                                <span class="mainmenubara-span2">/</span>
                            </li>
                        @endif

                        <span>{{ $product->title }}</span>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-xs-12-inport">
                        <div class="product-view">
                            <div class="product-essential">

                                <form action="{{ route('cart.addTaki') }}"
                                      method="POST"
                                      id="product_addtocart_form">
                                    @csrf

                                    <input type="hidden" name="type" value="taki">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" id="base_price" value="{{ $basePrice }}">

                                    <div style="float: right;" class="col-xl-4 sticky-sidebar col-lg-4 gallery-product col-sm-12 col-md-12 p-0 mb-1">
                                        <div class="product-gallery float-right w-100">
                                            <div class="pd-wrap">
                                                <div class="m-r-40">
                                                    <div class="pr-0 pl-0 img-zoom product-slider-single-p">

                                                        <div id="slider" class="owl-carousel product-slider">
                                                            @forelse($galleryImages as $image)
                                                                <div class="item">
                                                                    <img src="{{ asset('storage/' . $image->image) }}"
                                                                         alt="{{ $product->title }}">
                                                                </div>
                                                            @empty
                                                                <div class="item">
                                                                    <img src="{{ asset('frontend/images/no-image.jpg') }}"
                                                                         alt="{{ $product->title }}">
                                                                </div>
                                                            @endforelse
                                                        </div>

                                                        <div id="thumb" class="owl-carousel product-thumb">
                                                            @forelse($galleryImages as $image)
                                                                <div class="item">
                                                                    <img src="{{ asset('storage/' . $image->image) }}"
                                                                         alt="{{ $product->title }}">
                                                                </div>
                                                            @empty
                                                                <div class="item">
                                                                    <img src="{{ asset('frontend/images/no-image.jpg') }}"
                                                                         alt="{{ $product->title }}">
                                                                </div>
                                                            @endforelse
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-shop col-sm-12 col-lg-8 col-xs-12">

                                        <div>
                                        <span class="product-name">
                                            <h1>{{ $product->title }}</h1>
                                        </span>

                                            @if($product->category)
                                                <span class="product-name">
                                                <span class="pr-2">دسته بندی :</span>
                                                <span>
                                                    <a href="{{ route('front.shop.category', $product->category->slug) }}">
                                                        {{ $product->category->title }}
                                                    </a>
                                                </span>
                                            </span>
                                            @endif

                                            @if($product->brand)
                                                <span class="product-name">
                                                <span class="pr-2">برند :</span>
                                                <span>
                                                    <a href="#">{{ $product->brand->title }}</a>
                                                </span>
                                            </span>
                                            @endif

                                            @if($product->show_price)
                                                <span class="price-sing">
                                                {{ number_format($basePrice) }} تومان
                                            </span>
                                            @endif
                                        </div>

                                        <div style="margin: -11px 0 21px;" class="lbsingle"></div>

                                        <div class="container">
                                            <div class="row">

                                                <div class="col-lg-12 p-0 col-md-12 mx-auto f-right">
                                                    <div class="product-name-l1">
                                                        <p class="p1">سفارش محصول</p>
                                                        <p class="p2">
                                                            تحویل {{ $product->delivery_time ?? '۲ تا ۳ روز کاری' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div style="background:#eaeaea;" class="col-lg-12 pb-4 p-4 col-md-12 mx-auto f-right">

                                                    @foreach($product->options as $option)
                                                        <div class="col-lg-4 col-lg-name p-1 pb-3 text-center body">
                                                            <p>{{ $option->title }} :</p>

                                                            @if(in_array($option->type, ['select', 'radio']))
                                                                <select name="options[{{ $option->id }}]"
                                                                        class="ddl-select1 taki-option"
                                                                        @if($option->is_required) required @endif>
                                                                    <option value="" data-price="0">انتخاب کنید</option>

                                                                    @foreach($option->values as $value)
                                                                        <option value="{{ $value->id }}"
                                                                                data-price="{{ $value->price }}"
                                                                                data-label="{{ $value->title }}">
                                                                            {{ $value->title }}
                                                                            @if($value->price > 0)
                                                                                - {{ number_format($value->price) }} تومان
                                                                            @endif
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <input type="{{ $option->type === 'number' ? 'number' : 'text' }}"
                                                                       name="options_text[{{ $option->id }}]"
                                                                       class="input-element not-empty"
                                                                       @if($option->is_required) required @endif>
                                                            @endif
                                                        </div>
                                                    @endforeach

                                                    <div class="col-lg-4 input-single col-lg-name p-1 pb-3 text-center body">
                                                        <p>تعداد:</p>
                                                        <input type="number"
                                                               name="quantity"
                                                               id="taki_quantity"
                                                               class="input-element not-empty"
                                                               min="{{ $product->min_order ?? 1 }}"
                                                               value="{{ $product->min_order ?? 1 }}">
                                                    </div>

                                                </div>

                                                <div class="col-lg-12 p-0 col-md-12 mx-auto f-right">
                                                    <div class="product-name-l2">
                                                        <p>
                                                            خلاصه سفارش :
                                                            <span id="taki-summary"></span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 p-0 col-md-12 mx-auto f-right">
                                                    <div class="product-name-l3">
                                                    <span class="span-prise">
                                                        <span class="product-name-l3-r">
                                                            <span class="span2-mab">مبلغ :</span>
                                                            <span id="taki-total-price">
                                                                {{ number_format($basePrice) }}
                                                            </span>
                                                        </span>
                                                        <span class="span2">تومان</span>
                                                    </span>

                                                        @if($product->allow_order && $product->stock > 0)
                                                            <button type="submit"
                                                                    class="product-name-l3-l product-name-l3-l-cart border-0">
                                                                افزودن به سبد
                                                            </button>
                                                        @else
                                                            <span class="product-name-l3-l2">
                                                            ناموجود
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
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
                            <div class="d-sm-block">
                                <ul class="nav nav-tabs" id="orders-tab1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active"
                                           data-bs-toggle="tab"
                                           href="#description-tab">
                                            توضیحات محصول
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link"
                                           data-bs-toggle="tab"
                                           href="#specifications-tab">
                                            مشخصات
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="orders-tab2">

                                <div class="tab-pane fade show active" id="description-tab">
                                    <section class="content-expert-summary">
                                        <div class="tabs-content">
                                            <div class="content-expert">
                                                <section class="tab-content-wrapper" style="display:block;">
                                                    <article>
                                                        <section class="content-expert-summary">
                                                            <div class="mask pm-3">
                                                                <div class="mask-text">
                                                                    <div class="std">
                                                                        {!! $product->description !!}
                                                                    </div>
                                                                </div>

                                                                <a href="#" class="mask-handler">
                                                                <span class="show-more">
                                                                    <span style="font-size:22px;position:relative;top:3px;line-height:32px;">+</span>
                                                                    ادامه ...
                                                                </span>

                                                                    <span class="show-less" style="display:none;">
                                                                    <span style="font-size:22px;position:relative;top:3px;line-height:32px;">-</span>
                                                                    بستن
                                                                </span>
                                                                </a>

                                                                <div class="shadow-box" style="display:block;"></div>
                                                            </div>
                                                        </section>
                                                    </article>
                                                </section>
                                            </div>
                                        </div>
                                    </section>
                                </div>

                                <div class="tab-pane fade" id="specifications-tab">
                                    <section>
                                        <div class="std">
                                            <div class="c-params__title">مشخصات فیزیکی</div>

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
                                    </section>
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

        function calculateTakiPrice() {
            const basePrice = parseFloat(document.getElementById('base_price').value || 0);
            const quantity = parseInt(document.getElementById('taki_quantity').value || 1);

            let optionsPrice = 0;
            let summaryItems = [];

            document.querySelectorAll('.taki-option').forEach(function (select) {
                const selected = select.options[select.selectedIndex];

                if (selected && selected.value) {
                    const label = selected.dataset.label || selected.textContent.trim();
                    const price = parseFloat(selected.dataset.price || 0);

                    optionsPrice += price;
                    summaryItems.push(label);
                }
            });

            const total = (basePrice + optionsPrice) * quantity;

            document.getElementById('taki-total-price').innerText = formatPrice(total);

            document.getElementById('taki-summary').innerHTML =
                summaryItems.map(function (item) {
                    return '<span class="product-sum-l4-r">' + item + '</span>';
                }).join('') +
                '<span class="product-sum-l4-r">' + quantity + ' عدد</span>';
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.taki-option, #taki_quantity').forEach(function (element) {
                element.addEventListener('change', calculateTakiPrice);
                element.addEventListener('keyup', calculateTakiPrice);
            });

            calculateTakiPrice();
        });
    </script>
@endpush
