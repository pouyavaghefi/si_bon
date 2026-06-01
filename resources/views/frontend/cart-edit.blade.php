@extends('frontend.layouts.master')

@section('pageTitle', 'ویرایش سفارش')

@section('wrapper')

    <div class="cart-edit-page">
        <div class="cart-edit-card">

            <div class="cart-edit-header">
                <h2>ویرایش سفارش</h2>
                <p>اطلاعات سفارش خود را تغییر دهید و ذخیره کنید.</p>
            </div>

            <form action="{{ route('front.cart.update', $key) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-row">
                    <label>تعداد</label>
                    <input type="number"
                           name="quantity"
                           min="1"
                           value="{{ $item['quantity'] ?? 1 }}">
                </div>

                <div class="form-row">
                    <label>توضیحات</label>
                    <textarea name="description" rows="5" placeholder="توضیحات سفارش را وارد کنید...">{{ $item['description'] ?? '' }}</textarea>
                </div>

                @if(($item['type'] ?? null) === 'print')
                    <div class="form-row">
                        <label>آپلود فایل جدید</label>
                        <input type="file" name="print_file">
                    </div>

                    @if(!empty($item['file_path']))
                        <div class="current-file-box">
                            <span>فایل فعلی سفارش</span>
                            <a href="{{ asset('storage/' . $item['file_path']) }}" target="_blank">
                                مشاهده فایل فعلی
                            </a>
                        </div>
                    @endif
                @endif

                <div class="cart-edit-actions">
                    <a href="{{ route('front.cart.index') }}" class="btn-back">بازگشت</a>
                    <button type="submit" class="btn-save">ذخیره تغییرات</button>
                </div>

            </form>

        </div>
    </div>

    <style>
        .cart-edit-page {
            width: 100%;
            min-height: 75vh;
            padding: 70px 15px;
            background: linear-gradient(180deg, #f7f9fb 0%, #eef2f5 100%);
            direction: rtl;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .cart-edit-card {
            width: 100%;
            max-width: 760px;
            background: #fff;
            border-radius: 18px;
            padding: 34px;
            box-shadow: 0 12px 35px rgba(0,0,0,.10);
            border: 1px solid #edf0f2;
        }

        .cart-edit-header {
            margin-bottom: 30px;
            padding-bottom: 18px;
            border-bottom: 1px solid #eef0f2;
        }

        .cart-edit-header h2 {
            margin: 0 0 8px;
            font-size: 28px;
            font-weight: 800;
            color: #222;
        }

        .cart-edit-header p {
            margin: 0;
            color: #777;
            font-size: 15px;
        }

        .form-row {
            margin-bottom: 22px;
        }

        .form-row label {
            display: block;
            margin-bottom: 9px;
            font-weight: 700;
            color: #333;
            font-size: 15px;
        }

        .form-row input,
        .form-row textarea {
            width: 100%;
            border: 1px solid #dfe4e8;
            border-radius: 12px;
            padding: 13px 15px;
            font-size: 15px;
            background: #fbfbfb;
            direction: rtl;
            text-align: right;
            transition: .2s;
        }

        .form-row textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-row input:focus,
        .form-row textarea:focus {
            outline: none;
            background: #fff;
            border-color: #00bcd4;
            box-shadow: 0 0 0 4px rgba(0,188,212,.12);
        }

        .form-row input[type="file"] {
            direction: ltr;
            text-align: left;
            background: #fff;
            padding: 10px;
        }

        .current-file-box {
            margin: 5px 0 25px;
            padding: 14px 16px;
            border-radius: 12px;
            background: #f4fbfd;
            border: 1px solid #d8f3f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .current-file-box span {
            font-weight: 700;
            color: #333;
        }

        .current-file-box a {
            color: #0088aa;
            font-weight: 700;
            text-decoration: none;
        }

        .cart-edit-actions {
            margin-top: 32px;
            display: flex;
            justify-content: flex-start;
            gap: 12px;
        }

        .btn-save,
        .btn-back {
            min-width: 135px;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-save {
            background: #00bcd4;
            color: #fff;
        }

        .btn-back {
            background: #8b8b8b;
            color: #fff;
        }

        .btn-save:hover {
            background: #00a9bf;
        }

        .btn-back:hover {
            background: #777;
            color: #fff;
        }

        @media (max-width: 768px) {
            .cart-edit-page {
                padding: 35px 12px;
            }

            .cart-edit-card {
                padding: 24px 18px;
            }

            .current-file-box,
            .cart-edit-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-save,
            .btn-back {
                width: 100%;
            }
        }
    </style>

@endsection
