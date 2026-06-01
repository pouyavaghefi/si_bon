@extends('frontend.layouts.master')

@section('pageTitle', 'ثبت سفارش')

@section('wrapper')

    <div class="checkout-success-page">

        <div class="success-box">

            <div class="success-icon">
                ✓
            </div>

            <h1>
                سفارش شما با موفقیت ثبت شد
            </h1>

            <p>
                سفارش شما دریافت شد و پس از بررسی توسط تیم فروش با شما تماس گرفته خواهد شد.
            </p>

            <div class="order-info">

                <div>
                    <span>شماره سفارش:</span>
                    <strong>#{{ $order->id }}</strong>
                </div>

                <div>
                    <span>مبلغ سفارش:</span>
                    <strong>
                        {{ number_format($order->total_price) }}
                        تومان
                    </strong>
                </div>

                <div>
                    <span>وضعیت سفارش:</span>
                    <strong>
                        در انتظار بررسی
                    </strong>
                </div>

            </div>

            <div class="success-actions">

                <a href="{{ route('front.landing') }}" class="back-home">
                    بازگشت به صفحه اصلی
                </a>

                <a href="{{ route('front.user.orders') }}" class="view-orders">
                    مشاهده سفارش‌ها
                </a>

            </div>

        </div>

    </div>

    <style>
        .checkout-success-page {
            min-height: 70vh;
            background: #f3f3f3;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 70px 20px;
            direction: rtl;
        }

        .success-box {
            width: 100%;
            max-width: 700px;
            background: #fff;
            border-radius: 18px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,.08);
            border: 1px solid #e5e5e5;
        }

        .success-icon {
            width: 110px;
            height: 110px;
            margin: 0 auto 25px;
            border-radius: 50%;
            background: #18b45b;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 55px;
            font-weight: bold;
        }

        .success-box h1 {
            font-size: 34px;
            margin-bottom: 18px;
            color: #222;
            font-weight: 800;
        }

        .success-box p {
            color: #666;
            line-height: 2.2;
            font-size: 16px;
            margin-bottom: 35px;
        }

        .order-info {
            background: #f8f8f8;
            border-radius: 14px;
            padding: 25px;
            margin-bottom: 35px;
            text-align: right;
        }

        .order-info div {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e5e5;
        }

        .order-info div:last-child {
            border-bottom: none;
        }

        .order-info span {
            color: #666;
        }

        .order-info strong {
            color: #111;
            font-weight: 800;
        }

        .success-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .success-actions a {
            min-width: 220px;
            padding: 14px 22px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            transition: .2s;
        }

        .back-home {
            background: #00bcd4;
            color: #fff;
        }

        .back-home:hover {
            background: #00a0b5;
            color: #fff;
        }

        .view-orders {
            background: #f0003d;
            color: #fff;
        }

        .view-orders:hover {
            background: #d70037;
            color: #fff;
        }

        @media (max-width: 700px) {

            .success-box {
                padding: 35px 20px;
            }

            .success-box h1 {
                font-size: 26px;
            }

            .success-actions {
                flex-direction: column;
            }

            .success-actions a {
                width: 100%;
            }
        }
    </style>

@endsection
