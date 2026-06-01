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

        function cartFileUrl($path) {
            return !empty($path) ? asset('storage/' . $path) : null;
        }

        function isImageFile($path) {
            if (empty($path)) return false;

            return in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), [
                'jpg', 'jpeg', 'png', 'gif', 'webp'
            ]);
        }
    @endphp

    <ul class="bodymainchrtc">
        <li>
            <div class="container">
                <div class="row">

                    <div class="col-lg-9 col-md-12">

                        @forelse($cart as $key => $item)

                            @php
                                $fileUrl = cartFileUrl($item['file_path'] ?? null);
                                $isImage = isImageFile($item['file_path'] ?? null);
                                $itemTotal = $item['total'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? 1));
                            @endphp

                            <div class="bodyright cart-box">

                                <div class="cart-head">
                                    <span class="onvanchrt">مشخصات محصول {{ $loop->iteration }}</span>

                                    @if(($item['type'] ?? null) === 'print')
                                        <span class="pasvandt">
                                        پسوندهای قابل آپلود jpg, png, webp, pdf, psd, zip, rar, cdr, tiff میباشد
                                    </span>
                                    @endif
                                </div>

                                <div class="bodymainmoshtrak cart-body">

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

                                        @if(!empty($item['product_id']))
                                            <span>
                                            <a href="{{ route('front.cart.edit', $key) }}" class="linkeditc">
                                                ویرایش
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </span>
                                        @endif

                                        @if(!empty($item['width']) && !empty($item['height']))
                                            <span class="onvanvigegichrt onvanvigegichrtnew">
                                            ابعاد (سانتی متر): {{ $item['width'] }}x{{ $item['height'] }}
                                        </span>
                                        @endif

                                        <span class="onvanvigegichrt onvanvigegichrtnew">
                                        تعداد سفارش:
                                        <div class="num-block2 num-block2-cart">
                                            <div>
                                                <div class="num-in2">
                                                    <span class="plus2"></span>
                                                    <input type="text" class="in-num2" value="{{ $item['quantity'] ?? 1 }}" readonly>
                                                    <span class="minus2 dis2"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </span>

                                        @if(!empty($item['options']) && is_array($item['options']))
                                            @foreach($item['options'] as $option)
                                                <span class="onvanvigegichrt onvanvigegichrtnew">
                                                گزینه انتخابی: {{ is_array($option) ? implode('، ', $option) : $option }}
                                            </span>
                                            @endforeach
                                        @endif

                                        @if(!empty($item['options_number']) && is_array($item['options_number']))
                                            @foreach($item['options_number'] as $option)
                                                <span class="onvanvigegichrt onvanvigegichrtnew">
                                                مقدار وارد شده: {{ $option }}
                                            </span>
                                            @endforeach
                                        @endif

                                        @if(!empty($item['installer_required']))
                                            <span class="onvanvigegichrt onvanvigegichrtnew">نیاز به نصاب: دارد</span>

                                            @if(!empty($item['installer_type']))
                                                <span class="onvanvigegichrt onvanvigegichrtnew">
                                                نوع نصب: {{ $item['installer_type'] }}
                                            </span>
                                            @endif

                                            @if(!empty($item['installer_address']))
                                                <span class="onvanvigegichrt onvanvigegichrtnew">
                                                آدرس نصب: {{ $item['installer_address'] }}
                                            </span>
                                            @endif
                                        @endif

                                        <span class="onvanvigegichrt cart-price-row">
                                        <strong>قیمت کل:</strong>
                                        <span>{{ number_format($itemTotal) }} تومان</span>
                                    </span>

                                    </div>

                                    <div class="bodyleftproduct cart-file-side">

                                        @if(($item['type'] ?? null) === 'print')

                                            <div class="cart-upload-grid">

                                                <div class="cart-file-card">
                                                    <div class="cart-file-preview">
                                                        @if($fileUrl && $isImage)
                                                            <a href="{{ $fileUrl }}" target="_blank">
                                                                <img src="{{ $fileUrl }}" alt="فایل آپلود شده">
                                                            </a>
                                                        @else
                                                            <img src="{{ asset('theme/images/Upload-Files2.jpg') }}" alt="upload" class="placeholder-img">
                                                        @endif
                                                    </div>

                                                    <div class="cart-file-info">
                                                        <strong>فایل آپلود شده</strong>

                                                        @if($fileUrl)
                                                            <a href="{{ $fileUrl }}" target="_blank">مشاهده / دانلود فایل</a>
                                                        @else
                                                            <span class="empty-file">فایلی ثبت نشده است</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="cart-file-card">
                                                    <div class="cart-file-preview">
                                                        <img src="{{ asset('theme/images/Upload-Files2.jpg') }}" alt="upload" class="placeholder-img">
                                                    </div>

                                                    <div class="cart-file-info">
                                                        <strong>فایل تکمیلی</strong>
                                                        <span>ثبت نشده است</span>
                                                    </div>
                                                </div>

                                                <textarea class="textarea-cart" rows="4" placeholder="توضیحات">{{ $item['description'] ?? '' }}</textarea>

                                                <div class="cartimport">
                                                    توجه: کار شما بعد از چک شدن توسط تیم فروش با مبلغ نهایی تدقیق میگردد
                                                </div>

                                            </div>

                                        @else

                                            <div class="cart-file-card">
                                                <div class="cart-file-preview">
                                                    <img src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : asset('theme/images/2-color-2.jpg---5f3fb80ae20ab.jpg') }}"
                                                         alt="{{ $item['title'] ?? 'محصول' }}">
                                                </div>
                                            </div>

                                        @endif

                                    </div>

                                </div>
                            </div>

                        @empty

                            <div class="bodyright">
                                <div style="padding:35px;text-align:center;">
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

                            <div style="border-bottom:1px solid #d9d9d9;"></div>
                            <div class="linehightleft"></div>

                            <div class="onvansurathesabchrtx">
                                <span class="xx">تومان</span>
                                <span class="x">{{ number_format($cartTotal) }}</span>
                                جمع:
                            </div>

                            <div class="onvansurathesabchrt">
                                <span style="float:left">{{ number_format($shippingPrice) }} تومان</span>
                                هزینه ارسال:
                            </div>

                            <div class="onvansurathesabchrtx">
                                <span class="xx">تومان</span>
                                <span class="x">{{ number_format($payablePrice) }}</span>
                                مبلغ قابل پرداخت:
                            </div>

                            <div class="surathesab" style="margin-top:16px;">
                                <button class="button1 btn-cart" type="button">
                                    <a href="{{ route('front.shop.categories') }}">افزودن محصول جدید</a>
                                </button>

                                <button style="background:#9a9a9a;" class="button2" type="button">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#fakto">
                                        دریافت پیش فاکتور
                                    </a>
                                </button>
                            </div>
                        </div>

                        <div style="height:auto;" class="bodyleft">
                            <div class="surathesab paetma surathesab2">
                                <a href="{{ route('front.checkout.index') }}"
                                   style="margin:0;display:block;text-align:center;"
                                   class="button2 btn-cart final-cart-btn">
                                    اتمام و ثبت نهایی خرید
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </li>
    </ul>

    <div class="modal fade" id="fakto" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content invoice-modal">

                <div class="modal-header">
                    <h4>دریافت فاکتور</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div id="invoice-print-area" class="invoice-box">

                        <div class="invoice-header">
                            <div>
                                <h2>پیش فاکتور</h2>
                                <p>تاریخ: {{ \Morilog\Jalali\Jalalian::now()->format('Y/m/d') }}</p>
                                <p>شماره: پیش فاکتور</p>
                            </div>

                            <div class="invoice-brand">
                                <img src="{{ asset('theme/images/logo.png') }}" alt="logo" onerror="this.style.display='none'">
                            </div>
                        </div>

                        <div class="invoice-customer">
                            <label>نام خریدار:</label>
                            <input type="text" placeholder="نام خریدار">
                        </div>

                        <table class="invoice-table">
                            <thead>
                            <tr>
                                <th>توضیحات محصول</th>
                                <th>ابعاد</th>
                                <th>تعداد کالا</th>
                                <th>فی</th>
                                <th>مبلغ</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($cart as $item)
                                @php
                                    $rowTotal = $item['total'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? 1));
                                @endphp

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
                                    <td>{{ number_format($item['price'] ?? 0) }} تومان</td>
                                    <td>{{ number_format($rowTotal) }} تومان</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">سبد خرید خالی است.</td>
                                </tr>
                            @endforelse

                            <tr class="invoice-total">
                                <td colspan="3"></td>
                                <td>جمع کل:</td>
                                <td>{{ number_format($cartTotal) }} تومان</td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="invoice-footer">
                            <p>آدرس: خیابان پادگان ولیعصر - نبش کوچه شهدا - پلاک ۴۴ - واحد</p>
                            <p>تلفن: 77638612 - 77634286 - 77638179 - 77631371</p>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        انصراف
                    </button>

                    <button type="button" class="btn btn-primary" onclick="printInvoice()">
                        دریافت / پرینت
                    </button>
                </div>

            </div>
        </div>
    </div>

    <style>
        .cart-box {
            margin-bottom: 20px;
            overflow: hidden;
        }

        .cart-head {
            width: 100%;
            padding: 12px 0;
            border-bottom: 1px solid #d9d9d9;
        }

        .cart-head .onvanchrt {
            font-size: 16px;
        }

        .cart-body {
            position: relative;
        }

        .cart-file-side {
            position: relative;
            direction: rtl;
            text-align: right;
            padding-bottom: 0;
        }

        .cart-price-row {
            padding: 12px 0;
        }

        .cart-price-row span {
            color: red;
        }

        .cart-upload-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 15px;
        }

        .cart-file-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .cart-file-preview {
            height: 150px;
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-file-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .placeholder-img {
            opacity: .45;
            padding: 20px;
        }

        .cart-file-info {
            padding: 10px;
            text-align: center;
            direction: rtl;
        }

        .cart-file-info strong,
        .cart-file-info span,
        .cart-file-info a {
            display: block;
            margin-top: 5px;
        }

        .cart-file-info a {
            color: #0066cc;
            font-weight: bold;
        }

        .empty-file {
            color: red;
        }

        .textarea-cart {
            width: 100%;
            min-height: 110px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            resize: vertical;
            direction: rtl;
            text-align: right;
            background: #fff;
        }

        .cartimport {
            background: #fff8df;
            border: 1px solid #eadca5;
            border-radius: 8px;
            padding: 15px;
            line-height: 2;
            direction: rtl;
        }

        .invoice-modal {
            direction: rtl;
        }

        .invoice-box {
            background: #fff;
            padding: 30px;
            direction: rtl;
            color: #111;
            width: 100%;
            box-sizing: border-box;
            font-family: Tahoma, Arial, sans-serif;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .invoice-header h2 {
            margin: 0 0 10px;
            font-size: 26px;
            font-weight: bold;
        }

        .invoice-header p {
            margin: 6px 0;
            font-size: 15px;
        }

        .invoice-brand img {
            max-width: 150px;
            max-height: 80px;
            object-fit: contain;
        }

        .invoice-customer {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .invoice-customer label {
            font-weight: bold;
            white-space: nowrap;
        }

        .invoice-customer input {
            flex: 1;
            height: 42px;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 0 12px;
            direction: rtl;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            direction: rtl;
            text-align: center;
            margin-bottom: 25px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 12px 8px;
            vertical-align: middle;
            font-size: 15px;
            white-space: normal;
            word-break: normal;
        }

        .invoice-table th:nth-child(1),
        .invoice-table td:nth-child(1) {
            width: 34%;
        }

        .invoice-table th:nth-child(2),
        .invoice-table td:nth-child(2) {
            width: 20%;
        }

        .invoice-table th:nth-child(3),
        .invoice-table td:nth-child(3) {
            width: 18%;
        }

        .invoice-table th:nth-child(4),
        .invoice-table td:nth-child(4),
        .invoice-table th:nth-child(5),
        .invoice-table td:nth-child(5) {
            width: 14%;
            min-width: 110px;
        }

        .invoice-total td {
            font-weight: bold;
            background: #fafafa;
        }

        .invoice-footer {
            margin-top: 20px;
            line-height: 2;
            text-align: right;
            font-size: 15px;
        }

        @media screen and (max-width: 1000px) {
            .cart-upload-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        function printInvoice() {
            const invoice = document.getElementById('invoice-print-area').innerHTML;

            const printWindow = window.open('', '_blank', 'width=900,height=700');

            printWindow.document.write(`
            <!DOCTYPE html>
            <html lang="fa" dir="rtl">
            <head>
                <meta charset="UTF-8">
                <title>پیش فاکتور</title>
                <style>
                    * {
                        box-sizing: border-box;
                    }

                    body {
                        margin: 0;
                        padding: 25px;
                        direction: rtl;
                        font-family: Tahoma, Arial, sans-serif;
                        color: #111;
                        background: #fff;
                    }

                    .invoice-box {
                        width: 100%;
                        direction: rtl;
                    }

                    .invoice-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: flex-start;
                        border-bottom: 1px solid #ddd;
                        padding-bottom: 20px;
                        margin-bottom: 25px;
                    }

                    .invoice-header h2 {
                        margin: 0 0 10px;
                        font-size: 26px;
                        font-weight: bold;
                    }

                    .invoice-header p {
                        margin: 6px 0;
                        font-size: 15px;
                    }

                    .invoice-brand img {
                        max-width: 150px;
                        max-height: 80px;
                        object-fit: contain;
                    }

                    .invoice-customer {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        margin-bottom: 25px;
                    }

                    .invoice-customer label {
                        font-weight: bold;
                        white-space: nowrap;
                    }

                    .invoice-customer input {
                        flex: 1;
                        height: 42px;
                        border: 1px solid #ddd;
                        border-radius: 6px;
                        padding: 0 12px;
                        direction: rtl;
                    }

                    .invoice-table {
                        width: 100%;
                        border-collapse: collapse;
                        table-layout: fixed;
                        direction: rtl;
                        text-align: center;
                        margin-bottom: 25px;
                    }

                    .invoice-table th,
                    .invoice-table td {
                        border: 1px solid #ccc;
                        padding: 12px 8px;
                        vertical-align: middle;
                        font-size: 15px;
                        word-break: break-word;
                    }

                    .invoice-table th {
                        background: #f3f3f3;
                        font-weight: bold;
                    }

                    .invoice-total td {
                        font-weight: bold;
                        background: #fafafa;
                    }

                    .invoice-footer {
                        margin-top: 20px;
                        line-height: 2;
                        text-align: right;
                        font-size: 15px;
                    }

                    @page {
                        size: A4 portrait;
                        margin: 12mm;
                    }
                </style>
            </head>
            <body>
                <div class="invoice-box">
                    ${invoice}
                </div>

                <script>
                    window.onload = function () {
                        window.print();
                        setTimeout(function () {
                            window.close();
                        }, 500);
                    };
                <\/script>
            </body>
            </html>
        `);

            printWindow.document.close();
        }
    </script>

@endsection
