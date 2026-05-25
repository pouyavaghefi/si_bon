@extends('frontend.layouts.master')

@section('pageTitle', $category->title ?? 'چاپ سی بن - آنلاین')

@section('wrapper')
    <div class="bodymargin-shop">
        <div id="page-content" class="page-wrapper">
            <div class="shop-section mb-80">
                <div class="container">
                    <div class="row mb-5">

                        {{-- SIDEBAR --}}
                        <div class="col-lg-3 col-lg-3-p col-shop-category col-md-12 sticky-sidebar">

                            <aside class="widget widget-categories box-shadow mb-30">
                                <h6 class="widget-title border-left mb-20">
                                    دسته بندی ها
                                </h6>

                                <div class="product-cat">
                                    <ul>
                                        <li class="closed">
                                            <a href="#"></a>

                                            <ul style="padding: 8px 0">
                                                @foreach ($frontendCategories as $parentCategory)
                                                    <li>
                                                        <a href="{{ route('front.shop.category', $parentCategory->slug) }}">
                                                            {{ $parentCategory->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </aside>

                            @php
                                $hasSecondLevelCategories = $frontendCategories->contains(function ($parentCategory) {
                                    return $parentCategory->children->isNotEmpty();
                                });
                            @endphp

                            @if ($hasSecondLevelCategories)

                                <aside class="widget widget-categories box-shadow mb-30">
                                    <h6 class="widget-title border-left mb-20">
                                        دسته بندی دوم
                                    </h6>

                                    <div class="product-cat">
                                        <ul>
                                            <li class="closed">
                                                <a href="#"></a>

                                                <ul style="padding: 8px 0">

                                                    @foreach ($frontendCategories as $parentCategory)

                                                        @foreach ($parentCategory->children as $child)

                                                            <li>
                                                                <a href="{{ route('shop.category', $child->slug) }}">
                                                                    {{ $child->title }}
                                                                </a>
                                                            </li>

                                                            @foreach ($child->children as $subChild)

                                                                <li>
                                                                    <a href="{{ route('shop.category', $subChild->slug) }}">
                                                                        {{ $subChild->title }}
                                                                    </a>
                                                                </li>

                                                            @endforeach

                                                        @endforeach

                                                    @endforeach

                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </aside>

                            @endif

                        </div>

                        {{-- CONTENT --}}
                        <div class="col-lg-9 col-lg-9-p col-md-12">
                            <div class="shop-content">
                                <div class="tab-content">

                                    {{-- SLIDER --}}
{{--                                    <div class="main-content-slider-main slider-main-category mb-5">--}}
{{--                                        <div class="owl-carousel m-0 owl-theme">--}}

{{--                                            <div class="item">--}}
{{--                                                <div class="box-slider">--}}
{{--                                                    <img src="{{ asset('frontend/images/slider/1-4.jpg') }}"--}}
{{--                                                         alt="چاپ استیکر"--}}
{{--                                                         title="چاپ استیکر">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="item">--}}
{{--                                                <div class="box-slider">--}}
{{--                                                    <img src="{{ asset('frontend/images/slider/1-6.jpg') }}"--}}
{{--                                                         alt="چاپ مش"--}}
{{--                                                         title="چاپ مش">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}

{{--                                        <div class="owl-theme">--}}
{{--                                            <div class="owl-controls">--}}
{{--                                                <div class="custom-nav owl-nav"></div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    {{-- PRODUCTS --}}
                                    <div role="tabpanel"
                                         class="tab-pane active"
                                         id="grid-view">

                                        <div class="row">

                                            <div style="padding: 0 0 0 15px;"
                                                 class="col-md-12">

                                                <div class="main-content-slider-main3">
                                                    <div class="owl-carousel m-0 owl-theme"></div>

                                                    <div class="owl-theme">
                                                        <div class="owl-controls">
                                                            <div class="custom-nav owl-nav"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            @forelse ($products as $product)

                                                @php
                                                    $mainImage = $product->images->where('is_main', true)->first();
                                                @endphp

                                                <div style="float: right;"
                                                     class="col-md-4 col-sm-4 col-lg-3 col-xs-12">

                                                    <div class="product-item">

                                                        <div class="product-img">
                                                            <a href="{{ route('front.product.show', $product->slug) }}">

                                                                @if ($mainImage)
                                                                    <img src="{{ asset('storage/' . $mainImage->image) }}"
                                                                         alt="{{ $product->title }}">
                                                                @else
                                                                    <img src="{{ asset('frontend/images/no-image.jpg') }}"
                                                                         alt="{{ $product->title }}">
                                                                @endif

                                                            </a>
                                                        </div>

                                                        <div class="product-info">

                                                            <h6 class="product-title">
                                                                <a href="{{ route('front.product.show', $product->slug) }}">
                                                                    {{ $product->title }}
                                                                </a>
                                                            </h6>

                                                            @if ($product->show_price)
                                                                <span style="font-size: 12px;padding-right: 14px;"
                                                                      class="price-label">
                                                                قیمت :
                                                            </span>

                                                                <span class="price">
                                                                {{ number_format($product->discount_price ?? $product->price) }}
                                                                <span class="price-no">
                                                                    تومان
                                                                </span>
                                                            </span>
                                                            @endif

                                                        </div>

                                                    </div>

                                                </div>

                                            @empty

                                                <div class="col-12">
                                                    <div class="alert alert-warning text-center">
                                                        محصولی در این دسته بندی یافت نشد.
                                                    </div>
                                                </div>

                                            @endforelse

                                        </div>

                                        <div class="mt-4">
                                            {{ $products->links() }}
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
