@extends('frontend.layouts.master')

@section('pageTitle', 'ادامه سفارش')

@section('wrapper')

    <div class="container py-5" dir="rtl">

        <div class="payment-page">

            <h2>ادامه سفارش #{{ $order->id }}</h2>

            <div class="payment-box">

                <p>
                    وضعیت سفارش:
                    <strong>
                        @if($order->status === 'pending_review')
                            در انتظار بررسی
                        @elseif($order->status === 'waiting_payment')
                            در انتظار پرداخت
                        @else
                            {{ $order->status }}
                        @endif
                    </strong>
                </p>

                <p>
                    مبلغ سفارش:
                    <strong>{{ number_format($order->total_price) }} تومان</strong>
                </p>

                @if($order->status === 'pending_review')
                    <div class="warning-box">
                        سفارش شما هنوز توسط تیم فروش بررسی نشده است. بعد از بررسی، مبلغ نهایی اعلام می‌شود.
                    </div>
                @endif

                @if($order->status === 'waiting_payment')
                    <button class="pay-btn">
                        پرداخت آنلاین
                    </button>
                @endif

            </div>

        </div>

    </div>

    <style>
        .payment-page{
            max-width:800px;
            margin:auto;
        }

        .payment-page h2{
            font-size:30px;
            font-weight:800;
            margin-bottom:25px;
        }

        .payment-box{
            background:#fff;
            border-radius:18px;
            padding:35px;
            box-shadow:0 10px 30px rgba(0,0,0,.06);
        }

        .payment-box p{
            font-size:18px;
            margin-bottom:18px;
        }

        .payment-box strong{
            color:#f0003d;
        }

        .warning-box{
            background:#fff3cd;
            color:#856404;
            border-radius:12px;
            padding:18px;
            line-height:2;
            margin-top:25px;
        }

        .pay-btn{
            width:100%;
            border:none;
            background:#f0003d;
            color:#fff;
            padding:15px;
            border-radius:12px;
            font-size:20px;
            font-weight:800;
        }
    </style>

@endsection
