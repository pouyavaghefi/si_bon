@extends('frontend.layouts.master')

@section('pageTitle', 'سفارشات من')

@section('wrapper')

    @php
        function orderStatusText($status) {
            return match($status) {
                'pending_review' => 'در انتظار بررسی',
                'waiting_payment' => 'در انتظار پرداخت',
                'processing' => 'در حال انجام',
                'ready', 'ready_delivery', 'ready_to_send' => 'آماده تحویل',
                'completed', 'done', 'finished' => 'تکمیل شده',
                'cancelled' => 'لغو شده',
                default => 'نامشخص',
            };
        }

        function orderStatusClass($status) {
            return match($status) {
                'ready', 'ready_delivery', 'ready_to_send' => 'status-ready',
                'completed', 'done', 'finished' => 'status-completed',
                'cancelled' => 'status-cancelled',
                default => 'status-pending',
            };
        }

        function paymentTypeText($type) {
            return match($type) {
                'online' => 'پرداخت آنلاین',
                'after_call' => 'بعد از تماس',
                default => 'نامشخص',
            };
        }
    @endphp

    <div class="orders-wrapper" dir="rtl">

        <div class="orders-card">

            <div class="orders-header">
                <h2>تمام سفارشات من</h2>
                <p>لیست سفارش‌ها، وضعیت بررسی و امکان ادامه پرداخت</p>
            </div>

            <ul class="nav nav-pills orders-tabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#new-orders" type="button">
                        سفارشات جدید
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#ready-orders" type="button">
                        آماده تحویل
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#completed-orders" type="button">
                        پایان یافته
                    </button>
                </li>
            </ul>

            <div class="tab-content orders-tab-content">

                <div class="tab-pane fade show active" id="new-orders">
                    @include('frontend.layouts.partials.orders-table', ['orders' => $newOrders])
                </div>

                <div class="tab-pane fade" id="ready-orders">
                    @include('frontend.layouts.partials.orders-table', ['orders' => $readyOrders])
                </div>

                <div class="tab-pane fade" id="completed-orders">
                    @include('frontend.layouts.partials.orders-table', ['orders' => $completedOrders])
                </div>

            </div>

        </div>

    </div>

    <style>
        .orders-wrapper {
            width: 100%;
            min-height: 70vh;
            padding: 65px 15px;
            background: #f4f6f8;
            direction: rtl;
        }

        .orders-card {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            background: #fff;
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 12px 35px rgba(0,0,0,.08);
            overflow: hidden;
        }

        .orders-header {
            margin-bottom: 25px;
            text-align: right;
        }

        .orders-header h2 {
            margin: 0 0 8px;
            font-size: 32px;
            font-weight: 800;
            color: #222;
        }

        .orders-header p {
            margin: 0;
            color: #777;
            font-size: 15px;
        }

        .orders-tabs {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 24px;
            border: none;
        }

        .orders-tabs .nav-link {
            border: none;
            background: #e9e9e9;
            color: #333;
            padding: 13px 34px;
            border-radius: 12px;
            font-weight: 800;
        }

        .orders-tabs .nav-link.active {
            background: #11b8cf;
            color: #fff;
        }

        .orders-tab-content {
            width: 100%;
        }

        .orders-table {
            width: 100%;
        }

        .orders-table table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            background: #fff;
            overflow: hidden;
            border-radius: 14px;
        }

        .orders-table th {
            background: #5a92a4;
            color: #fff;
            padding: 16px 8px;
            text-align: center;
            font-size: 14px;
            font-weight: 800;
            border-left: 1px solid rgba(255,255,255,.25);
        }

        .orders-table th:first-child {
            border-radius: 0 14px 0 0;
        }

        .orders-table th:last-child {
            border-radius: 14px 0 0 0;
            border-left: none;
        }

        .orders-table td {
            padding: 18px 8px;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
            border-left: 1px solid #eee;
            color: #222;
            font-size: 14px;
        }

        .orders-table td:last-child {
            border-left: none;
        }

        .orders-table tbody tr:hover td {
            background: #fafafa;
        }

        .orders-table th:nth-child(1),
        .orders-table td:nth-child(1) {
            width: 12%;
        }

        .orders-table th:nth-child(2),
        .orders-table td:nth-child(2) {
            width: 17%;
        }

        .orders-table th:nth-child(3),
        .orders-table td:nth-child(3) {
            width: 10%;
        }

        .orders-table th:nth-child(4),
        .orders-table td:nth-child(4) {
            width: 16%;
        }

        .orders-table th:nth-child(5),
        .orders-table td:nth-child(5) {
            width: 14%;
        }

        .orders-table th:nth-child(6),
        .orders-table td:nth-child(6) {
            width: 15%;
        }

        .orders-table th:nth-child(7),
        .orders-table td:nth-child(7) {
            width: 16%;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 13px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-ready {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .order-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .order-btn {
            border: none;
            border-radius: 9px;
            padding: 9px 12px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
            min-width: 105px;
            text-align: center;
        }

        .order-btn.view {
            background: #11b8cf;
            color: #fff;
        }

        .order-btn.continue {
            background: #f0003d;
            color: #fff;
        }

        .order-btn:hover {
            opacity: .9;
            color: #fff;
        }

        .empty-orders {
            padding: 60px 20px;
            text-align: center;
            color: #777;
            background: #fafafa;
            border-radius: 14px;
        }

        .empty-orders-icon {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .empty-orders h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .start-shopping-btn {
            display: inline-block;
            margin-top: 18px;
            background: #11b8cf;
            color: #fff;
            padding: 12px 26px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 800;
        }

        @media(max-width: 900px) {
            .orders-card {
                padding: 22px;
            }

            .orders-table {
                overflow-x: auto;
            }

            .orders-table table {
                min-width: 920px;
            }

            .orders-tabs .nav-link {
                width: 100%;
            }
        }
    </style>

@endsection
