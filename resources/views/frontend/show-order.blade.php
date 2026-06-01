@extends('frontend.layouts.master')

@section('pageTitle', 'مشاهده سفارش')

@section('wrapper')

    <div class="invoice-wrapper" dir="rtl">

        <div class="invoice-card">

            <div class="invoice-header">

                <div>
                    <h1>
                        سفارش #{{ $order->id }}
                    </h1>

                    <p>
                        تاریخ ثبت:
                        {{ $order->created_at->format('Y/m/d H:i') }}
                    </p>
                </div>

                <div>

                    @php

                        $statusText = match($order->status) {
                            'pending_review' => 'در انتظار بررسی',
                            'waiting_payment' => 'در انتظار پرداخت',
                            'processing' => 'در حال انجام',
                            'ready', 'ready_delivery', 'ready_to_send' => 'آماده تحویل',
                            'completed', 'done', 'finished' => 'تکمیل شده',
                            'cancelled' => 'لغو شده',
                            default => 'نامشخص',
                        };

                        $statusClass = 'status-pending';

                        if(in_array($order->status, ['ready', 'ready_delivery', 'ready_to_send'])) {
                            $statusClass = 'status-ready';
                        }

                        if(in_array($order->status, ['completed', 'done', 'finished'])) {
                            $statusClass = 'status-completed';
                        }

                        if($order->status === 'cancelled') {
                            $statusClass = 'status-cancelled';
                        }

                    @endphp

                    <span class="status-badge {{ $statusClass }}">
                    {{ $statusText }}
                </span>

                </div>

            </div>

            <div class="invoice-section">

                <h3>
                    اطلاعات سفارش
                </h3>

                <div class="invoice-grid">

                    <div>
                        <span>نام گیرنده</span>

                        <strong>
                            {{ $order->receiver_name }}
                            {{ $order->receiver_lastname }}
                        </strong>
                    </div>

                    <div>
                        <span>شماره تماس</span>

                        <strong>
                            {{ $order->receiver_mobile }}
                        </strong>
                    </div>

                    <div>
                        <span>استان</span>

                        <strong>
                            {{ $order->province }}
                        </strong>
                    </div>

                    <div>
                        <span>شهر</span>

                        <strong>
                            {{ $order->city }}
                        </strong>
                    </div>

                    <div class="full">
                        <span>آدرس</span>

                        <strong>
                            {{ $order->address }}
                        </strong>
                    </div>

                </div>

            </div>

            <div class="invoice-section">

                <h3>
                    آیتم‌های سفارش
                </h3>

                <div class="items-list">

                    @foreach($order->items as $item)

                        <div class="item-card">

                            <div class="item-image">

                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}">
                                @endif

                            </div>

                            <div class="item-content">

                                <h4>
                                    {{ $item->title }}
                                </h4>

                                <div class="item-meta">
                                    تعداد:
                                    {{ $item->quantity }}
                                </div>

                                <div class="item-meta">
                                    مبلغ:
                                    {{ number_format($item->total) }}
                                    تومان
                                </div>

                                @if($item->description)

                                    <div class="item-description">
                                        {{ $item->description }}
                                    </div>

                                @endif

                                @if($item->file_path)

                                    <a href="{{ asset('storage/' . $item->file_path) }}"
                                       target="_blank"
                                       class="download-btn">

                                        دانلود فایل چاپی

                                    </a>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            <div class="invoice-total">

                مبلغ نهایی سفارش:

                <strong>
                    {{ number_format($order->total_price) }}
                    تومان
                </strong>

            </div>

        </div>

    </div>

    <style>

        .invoice-wrapper{
            width:100%;
            min-height:70vh;
            background:#f5f6f8;
            padding:60px 15px;
        }

        .invoice-card{
            width:100%;
            max-width:1100px;
            margin:auto;
            background:#fff;
            border-radius:20px;
            padding:35px;
            box-shadow:0 12px 35px rgba(0,0,0,.08);
        }

        .invoice-header{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:20px;
            margin-bottom:30px;
        }

        .invoice-header h1{
            margin:0 0 10px;
            font-size:34px;
            font-weight:800;
        }

        .invoice-header p{
            margin:0;
            color:#777;
        }

        .invoice-section{
            margin-bottom:30px;
        }

        .invoice-section h3{
            font-size:24px;
            font-weight:800;
            margin-bottom:20px;
        }

        .invoice-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:18px;
        }

        .invoice-grid .full{
            grid-column:1/-1;
        }

        .invoice-grid div{
            background:#fafafa;
            border-radius:12px;
            padding:18px;
        }

        .invoice-grid span{
            display:block;
            color:#777;
            margin-bottom:10px;
        }

        .items-list{
            display:flex;
            flex-direction:column;
            gap:20px;
        }

        .item-card{
            display:flex;
            gap:20px;
            border:1px solid #eee;
            border-radius:16px;
            padding:20px;
        }

        .item-image{
            width:140px;
            height:140px;
            border-radius:14px;
            overflow:hidden;
            background:#f3f3f3;
            flex-shrink:0;
        }

        .item-image img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .item-content{
            flex:1;
        }

        .item-content h4{
            font-size:24px;
            margin-bottom:14px;
            font-weight:800;
        }

        .item-meta{
            margin-bottom:10px;
            color:#555;
        }

        .item-description{
            margin-top:15px;
            background:#fafafa;
            border-radius:10px;
            padding:14px;
            line-height:2;
        }

        .download-btn{
            margin-top:16px;
            display:inline-block;
            background:#11b8cf;
            color:#fff;
            padding:10px 18px;
            border-radius:10px;
            text-decoration:none;
            font-weight:800;
        }

        .invoice-total{
            background:#f0003d;
            color:#fff;
            padding:24px;
            border-radius:16px;
            text-align:center;
            font-size:28px;
            font-weight:800;
        }

        .status-badge{
            display:inline-block;
            padding:10px 18px;
            border-radius:30px;
            font-size:13px;
            font-weight:800;
        }

        .status-pending{
            background:#fff3cd;
            color:#856404;
        }

        .status-ready{
            background:#d1ecf1;
            color:#0c5460;
        }

        .status-completed{
            background:#d4edda;
            color:#155724;
        }

        .status-cancelled{
            background:#f8d7da;
            color:#721c24;
        }

        @media(max-width:768px){

            .invoice-card{
                padding:20px;
            }

            .invoice-header{
                flex-direction:column;
            }

            .invoice-grid{
                grid-template-columns:1fr;
            }

            .item-card{
                flex-direction:column;
            }

            .item-image{
                width:100%;
                height:220px;
            }

            .invoice-total{
                font-size:22px;
            }

        }

    </style>

@endsection
