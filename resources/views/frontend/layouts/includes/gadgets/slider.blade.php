<div class="section-slider amazing-section mb-3 mt-4" style="background:#5555ff;">
    <div class="container">
        <div class="row">
            <div class="container-amazing">

                <div class="container-main">
                    <div>

                        <div style="margin-bottom:20px;" class="col-lg-2 display-md-none pull-right">
                            <div class="amazing-product text-center">
                                <a href="#">
                                    <img src="{{ asset('theme/image/amazing.png') }}" alt="">
                                </a>

                                <a href="#" class="view-all-amazing-btn">
                                    مشاهده همه
                                    <i class="uil uil-angle-left"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-10 col-md-12 pull-left">
                            <div class="section-slider-content">
                                <div class="section-slider-product slider-amazing mt-3">
                                    <div class="widget widget-product" style="margin:0;">
                                        <header class="card-header card-header-amazing">
                                            <span style="margin-bottom:4px;" class="title-one">پیشنهاد ویژه</span>
                                            <a href="#" class="card-title">مشاهده همه</a>
                                        </header>

                                        <div class="product-carousel owl-carousel owl-theme owl-rtl">

                                            @php
                                                $products = [
                                                    ['image' => 'Holder-1.jpg---607567b45dc7d.jpg', 'title' => 'چاپ دنگلر', 'discount' => '۱۰%', 'old' => '۴۹۰,۰۰۰', 'new' => '۴۴۰,۰۰۰'],
                                                    ['image' => 'product-pad-2.jpg---60fd4e4fa7f77.jpg', 'title' => 'چاپ و برش استیکر', 'discount' => '۱۳%', 'old' => '۲۲۰,۰۰۰', 'new' => '۱۹۰,۰۰۰'],
                                                    ['image' => 'Summa.jpg---6109782f58bf4.jpg', 'title' => 'شیشه مات کن', 'discount' => '۲۷%', 'old' => '۲۹۰,۰۰۰', 'new' => '۲۱۰,۰۰۰'],
                                                    ['image' => 'Cutter-ploter-blade-New-45.jpg---610fe7e62c7a6.jpg', 'title' => 'استندهای نمایشگاهی', 'discount' => '۹%', 'old' => '۲۱۰,۰۰۰', 'new' => '۱۹۰,۰۰۰'],
                                                ];
                                            @endphp

                                            @foreach($products as $product)
                                                <div class="item">
                                                    <a href="#">
                                                        <img src="{{ asset('theme/image/' . $product['image']) }}" class="img-fluid" alt="{{ $product['title'] }}">
                                                    </a>

                                                    <h2 class="post-title">
                                                        <a href="#">{{ $product['title'] }}</a>
                                                    </h2>

                                                    <div class="price">
                                                        <div class="discount-item">
                                                            <span>{{ $product['discount'] }}</span>
                                                        </div>
                                                        <del><span>{{ $product['old'] }}<span>تومان</span></span></del>
                                                        <ins><span>{{ $product['new'] }}<span>تومان</span></span></ins>
                                                    </div>
                                                </div>
                                            @endforeach

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
</div>
