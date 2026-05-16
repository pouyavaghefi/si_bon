<section class="blog-section sec-ptb-100 clearfix">

    <div class="masulat">
        <div style="width:100%;">
            <h4>طراحی سایت1</h4>

            <div class="container">
                <div class="row">
                    <div class="masulats col-lg-12">
                        <ul>
                            @php
                                $categories = [
                                    ['image' => '5-3-5.jpg---61c03f79ee3f5.jpg', 'title' => 'برچسب آسانسور'],
                                    ['image' => '5-1.jpg---6102b69daea1b.jpg', 'title' => 'استندهای نمایشگاهی'],
                                    ['image' => '5-4.jpg---6102b70405be2.jpg', 'title' => 'چاپ دنگلر'],
                                    ['image' => '5-2.jpg---6102b724cc020.jpg', 'title' => 'چاپ پرده شید'],
                                ];
                            @endphp

                            @foreach($categories as $category)
                                <li class="masulatmin col-lg-3 col-12">
                                    <div class="blogmasulat">
                                        <div class="blog-img">
                                            <img src="{{ asset('theme/image/' . $category['image']) }}" alt="{{ $category['title'] }}">
                                        </div>

                                        <div class="blog-contant clearfix">
                                            <p>{{ $category['title'] }}</p>

                                            <div class="edamematlabp">
                                                <a style="color:#fff;" href="#">
                                                    <span>مشاهده</span>
                                                    <i class="ion-android-arrow-forward"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="baner4 mt-4 col-lg-12">
                <div class="col-lg-3 col-6">
                    <a href="#"><img src="{{ asset('theme/image/4-1.jpg---601e6f1a2d05c.jpg') }}" alt="سلفون کم چسب" class="img-fluid"></a>
                </div>

                <div class="col-lg-3 col-6">
                    <a href="#"><img src="{{ asset('theme/image/4-4-1.jpg---5f36d3831b300.jpg') }}" alt="برچسب دودی" class="img-fluid"></a>
                </div>

                <div class="col-lg-3 col-6">
                    <a href="#"><img src="{{ asset('theme/image/4-3.jpg---5f40ec48b4984.jpg') }}" alt="روز رنگ طلایی و نقره ای" class="img-fluid"></a>
                </div>

                <div class="col-lg-3 col-6">
                    <a href="#"><img src="{{ asset('theme/image/4-3-1.jpg---5f45ffa40455f.jpg') }}" alt="برچسب طرح کربن" class="img-fluid"></a>
                </div>
            </div>
        </div>
    </div>
</section>
