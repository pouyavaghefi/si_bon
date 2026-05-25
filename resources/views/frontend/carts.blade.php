@extends('frontend.layouts.master')

@section('pageTitle', 'سبد خرید')

@section('wrapper')

    @php
        $cart = $cart ?? session()->get('cart', []);
        $cartCount = count($cart);
        $shippingPrice = 0;

        $cartTotal = collect($cart)->sum(function ($item) {
            return $item['total'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? 1));
        });

        $payablePrice = $cartTotal + $shippingPrice;
    @endphp

    <ul class="bodymainchrtc">
        <li>
            <div class="container">
                <div class="row">

                    <div class="col-lg-9 col-md-12">

                        @forelse($cart as $key => $item)

                            <div style="margin-bottom: 20px;" class="bodyright">

                                <div style="width: 100%;padding: 12px 0;border-bottom: 1px solid #d9d9d9;">
                                <span style="font-size: 16px;" class="onvanchrt">
                                    مشخصات محصول {{ $loop->iteration }}
                                </span>

                                    @if(($item['type'] ?? null) === 'print')
                                        <span class="pasvandt">
                                        پسوندهای قابل آپلود Gpg و Tiff ، cdr , rar , zip , psd میباشد
                                    </span>
                                    @endif
                                </div>

                                <div style="position: relative;" class="bodymainmoshtrak">

                                    <form action="{{ route('front.cart.remove', $key) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="buttondel">
                                            <img src="{{ asset('theme/images/delete.svg') }}" alt="">
                                            حذف سفارش
                                        </button>
                                    </form>

                                    <div class="linehight"></div>

                                    <div class="imgright linehightd">

                                    <span class="onvanvigegichrt onvanvigegichrtnew">
                                        {{ $item['title'] ?? $item['name'] ?? 'محصول' }}
                                    </span>

                                        <span>
                                        <a href="{{ !empty($item['product_id']) ? route('front.product.show', $item['product_id']) : '#' }}" class="linkeditc">
                                            ویرایش
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </span>

                                        @if(($item['type'] ?? null) === 'print')

                                            @if(!empty($item['width']) && !empty($item['height']))
                                                <span class="onvanvigegichrt onvanvigegichrtnew">
                                                ابعاد ( سانتی متر ) : {{ $item['width'] }}x{{ $item['height'] }}
                                            </span>
                                            @endif

                                            <span class="onvanvigegichrt onvanvigegichrtnew">
                                            تعداد سفارش :
                                            <div class="num-block2 num-block2-cart">
                                                <div>
                                                    <div class="num-in2">
                                                        <span class="plus2"></span>
                                                        <input type="text" class="in-num2" value="{{ $item['quantity'] ?? 1 }}" readonly="">
                                                        <span class="minus2 dis2"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>

                                            @if(!empty($item['options']) && is_array($item['options']))
                                                @foreach($item['options'] as $option)
                                                    <span class="onvanvigegichrt onvanvigegichrtnew">
                                                    گزینه انتخابی : {{ is_array($option) ? implode('، ', $option) : $option }}
                                                </span>
                                                @endforeach
                                            @endif

                                            @if(!empty($item['options_number']) && is_array($item['options_number']))
                                                @foreach($item['options_number'] as $option)
                                                    <span class="onvanvigegichrt onvanvigegichrtnew">
                                                    مقدار وارد شده : {{ $option }}
                                                </span>
                                                @endforeach
                                            @endif

                                            @if(!empty($item['installer_required']))
                                                <span class="onvanvigegichrt onvanvigegichrtnew">
                                                نیاز به نصاب : دارد
                                            </span>

                                                @if(!empty($item['installer_type']))
                                                    <span class="onvanvigegichrt onvanvigegichrtnew">
                                                    نوع نصب : {{ $item['installer_type'] }}
                                                </span>
                                                @endif

                                                @if(!empty($item['installer_address']))
                                                    <span class="onvanvigegichrt onvanvigegichrtnew">
                                                    آدرس نصب : {{ $item['installer_address'] }}
                                                </span>
                                                @endif
                                            @else
                                                <span class="onvanvigegichrt onvanvigegichrtnew">
                                                نیاز به نصاب : نیاز ندارم
                                            </span>
                                            @endif

                                        @else

                                            <span class="onvanvigegichrt onvanvigegichrtnew">
                                            فروش به صورت : تکی و تعداد
                                        </span>

                                            <span class="onvanvigegichrt onvanvigegichrtnew">
                                            تعداد سفارش :
                                            <div class="num-block2 num-block2-cart">
                                                <div>
                                                    <div class="num-in2">
                                                        <span class="plus2"></span>
                                                        <input type="text" class="in-num2" value="{{ $item['quantity'] ?? 1 }}" readonly="">
                                                        <span class="minus2 dis2"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>

                                            @if(!empty($item['options']) && is_array($item['options']))
                                                @foreach($item['options'] as $option)
                                                    <span class="onvanvigegichrt onvanvigegichrtnew">
                                                    ویژگی : {{ is_array($option) ? implode('، ', $option) : $option }}
                                                </span>
                                                @endforeach
                                            @endif

                                        @endif

                                        <span style="padding:12px 0;" class="onvanvigegichrt">
                                        <strong>قیمت کل :</strong>
                                        <span style="color: red;">
                                            {{ number_format($item['total'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? 1))) }}
                                            تومان
                                        </span>
                                    </span>

                                    </div>

                                    <div style="position: relative;direction: ltr;text-align: left;padding-bottom: 0px;" class="bodyleftproduct">

                                        <div class="col p-1 mb-2">
                                            <div class="row">
                                                <div class="col-12 p-0 mob-upload-c col-md-12">

                                                    @if(($item['type'] ?? null) === 'print')

                                                        <div class="col-lg-6 p-1 input-single">
                                                            <div>
                                                                <div class="upload-img-padding input-single">
                                                                    <div class="img-upload-main">
                                                                        <img src="{{ asset('theme/images/Upload-Files2.jpg') }}" alt="your image" class="upload-img">
                                                                    </div>
                                                                </div>

                                                                <div class="input-file-upload">
                                                                <span class="upload-label" style="color: #ccc;">
                                                                    فایل آپلود شده
                                                                </span>

                                                                    @if(!empty($item['file_path']))
                                                                        <a href="{{ asset('storage/' . $item['file_path']) }}" target="_blank">
                                                                            مشاهده فایل
                                                                        </a>
                                                                    @else
                                                                        <span>فایلی ثبت نشده است</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 p-1 input-single">
                                                            <div>
                                                                <div class="upload-img-padding input-single">
                                                                    <div class="img-upload-main">
                                                                        <img src="{{ asset('theme/images/Upload-Files2.jpg') }}" alt="your image" class="upload-img">
                                                                    </div>
                                                                </div>

                                                                <div class="input-file-upload">
                                                                <span class="upload-label" style="color: #ccc;">
                                                                    فایل تکمیلی
                                                                </span>
                                                                    <span>ثبت نشده است</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 p-1 input-single">
                                                            <div class="mb-tozih">
                                                                <textarea class="textarea-cart" rows="4" cols="50" readonly>توضیحات : {{ $item['description'] ?? '' }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 p-1 input-single input-single-cart">
                                                            <div class="cartimport">
                                                                توجه : کار شما بعد از چک شدن توسط تیم فروش با مبلغ نهایی تدقیق میگردد
                                                            </div>
                                                        </div>

                                                    @else

                                                        <div style="max-width: 100%; margin: 20px auto;" class="col-12 p-0 mob-upload-c col-md-12">
                                                            <div class="col-lg-6 p-1 input-single"></div>

                                                            <div class="col-lg-6 p-1 input-single">
                                                                <div>
                                                                    <div class="input-single">
                                                                        <div class="img-upload-main">
                                                                            <img src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : asset('theme/images/2-color-2.jpg---5f3fb80ae20ab.jpg') }}"
                                                                                 alt="{{ $item['title'] ?? 'محصول' }}"
                                                                                 class="upload-img"
                                                                                 style="max-height:340px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endif

                                                </div>

                                                <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                                                    <div class="product-view">
                                                        <div style="padding: 2px; width: 100%;" class="product-shop-v product-shop col-sm-12 col-xs-12"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bodymainmoshtrak"></div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div style="margin-bottom: 20px;" class="bodyright">
                                <div style="padding: 35px;text-align:center;">
                                    <span class="onvanchrt">سبد خرید شما خالی است.</span>
                                </div>
                            </div>

                        @endforelse

                    </div>

                    <div class="col-lg-3 col-md-12 sticky-sidebar">

                        <div class="bodyleft">
                            <h3 class="onvanchrt">
                                تعداد محصول در سبد خرید ({{ $cartCount }})
                            </h3>

                            <div style="border-bottom: 1px solid #d9d9d9;"></div>

                            <div class="linehightleft"></div>

                            <div class="onvansurathesabchrtx">
                                <span class="xx">تومان</span>
                                <span class="x" id="total-price-base">
                                {{ number_format($cartTotal) }}
                            </span>
                                جمع :
                            </div>

                            <div class="onvansurathesabchrt">
                            <span style="float: left">
                                {{ number_format($shippingPrice) }} تومان
                            </span>
                                هزینه ارسال :
                            </div>

                            <div class="onvansurathesabchrtx">
                                <span class="xx">تومان</span>
                                <span class="x" id="total-price">
                                {{ number_format($payablePrice) }}
                            </span>
                                مبلغ قابل پرداخت :
                            </div>

                            <div class="surathesab" style="margin-top: 16px;">
                                <button class="button1 btn-cart" title="Add to Cart" type="button">
                                    <a href="{{ route('front.shop.categories') }}">افزودن محصول جدید</a>
                                </button>

                                <button style="background: #9a9a9a;" class="button2" title="Invoice" type="button">
                                    <a href="#" class="editefaktor active" data-bs-toggle="modal" data-bs-target="#fakto">
                                        دریافت پیش فاکتور
                                    </a>
                                </button>
                            </div>
                        </div>

                        <div style="height:auto;" class="bodyleft">
                            <div class="surathesab paetma surathesab2">
                                <button style="margin: 0;" class="button2 btn-cart" title="Checkout" type="button">
                                    <a href="#">اتمام و ثبت نهایی خرید</a>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </li>
    </ul>

    <style>
        .bodymainmoshtrakright {
            display: flex;
            flex-wrap: wrap;
            margin: 0 2.2% 0 0;
            width: 68%;
        }

        .bodymainmoshtrakleft {
            display: flex;
            flex-wrap: wrap;
            margin: 0 20px 0 1%;
            width: 26%;
        }

        @media screen and (max-width: 1000px) {
            .bodymainmoshtrakright {
                width: 97%;
            }

            .bodymainmoshtrakleft {
                width: 97%;
            }
        }
    </style>

    <div class="modal fade" id="fakto" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h4>دریافت فاکتور</h4>

                    <button style="position: absolute;left: 11px;font-size: 12px;background-color: #eee;"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">

                    <form action="#" method="post" id="addAddress">
                        @csrf
                    </form>

                    <div class="col-lg-12">
                        <div style="border: none;" class="modal-content">
                            <div class="modal-body">

                                <div style="position: relative;height: 51px;">
                                    <div style="position: absolute;left: 0;">
                                        تاریخ : ............................
                                    </div>

                                    <div style="position: absolute;left: 0;top: 26px;">
                                        شماره : پیش فاکتور
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    نام خریدار :
                                    <input type="text"
                                           form="addAddress"
                                           required=""
                                           placeholder="نام خریدار"
                                           name="company"
                                           class="control-input custumer-name1">
                                </div>

                                <div class="col-lg-12" style="padding: 0;margin-top: 19px;">

                                    <div class="sefareshatnew-main">
                                        <div style="float: right;" class="col-md-12 hedtable">
                                            <div class="sefareshatnew-body"></div>
                                        </div>

                                        <div style="float: right;padding: 0;" class="col-md-12 bodytable Pre-ivnoice">

                                            <form class="tables" id="gallerylist" action="#" method="post">
                                                @csrf

                                                <table class="table" cellspacing="0" style="margin-bottom: 20px;">
                                                    <tbody>
                                                    <tr>
                                                        <th>توضیحات محصول</th>
                                                        <th>ابعاد</th>
                                                        <th>تعداد کالا</th>
                                                        <th>فی</th>
                                                        <th>مبلغ</th>
                                                    </tr>

                                                    @forelse($cart as $item)
                                                        <tr>
                                                            <td>{{ $item['title'] ?? $item['name'] ?? 'محصول' }}</td>

                                                            <td>
                                                                @if(!empty($item['width']) && !empty($item['height']))
                                                                    {{ $item['width'] }}x{{ $item['height'] }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>

                                                            <td>{{ $item['quantity'] ?? 1 }} عدد</td>

                                                            <td>
                                                                {{ number_format($item['price'] ?? 0) }}
                                                                تومان
                                                            </td>

                                                            <td>
                                                                {{ number_format($item['total'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? 1))) }}
                                                                تومان
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5">سبد خرید خالی است.</td>
                                                        </tr>
                                                    @endforelse

                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>جمع کل :</td>
                                                        <td>{{ number_format($cartTotal) }} تومان</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </form>

                                        </div>
                                    </div>

                                </div>

                                <div style="padding-top: 15px;">
                                    <p style="line-height: 36px;">
                                        آدرس : خیابان پادگان ولیعصر - نبش کوچه شهدا - پلاک ۴۴ - واحد
                                    </p>

                                    <p>
                                        تلفن: 77638612 - 77634286 - 77638179 - 77631371
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            style="background-color: #9d9d9d;">
                        انصراف
                    </button>

                    <button type="button" class="btn btn-primary">
                        دریافت / پرینت
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection
