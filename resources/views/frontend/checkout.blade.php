@extends('frontend.layouts.master')

@section('pageTitle', 'تکمیل خرید')

@section('wrapper')

    @php
        $cart = $cart ?? session()->get('cart', []);
        $addresses = $addresses ?? collect();
        $cartCount = count($cart);

        $cartTotal = collect($cart)->sum(function ($item) {
            return $item['total'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? 1));
        });

        $defaultShippingPrice = 85000;
        $payablePrice = $cartTotal + $defaultShippingPrice;
    @endphp

    <div class="checkout-page">

        <form action="{{ route('front.cart.checkout') }}" method="POST" id="checkoutForm">
            @csrf

            <div class="checkout-summary">
                <div>
                    <strong>تعداد محصول در سبد خرید ({{ $cartCount }})</strong>
                    <span class="user-name">{{ auth()->user()->name ?? 'کاربر' }}</span>
                </div>

                <div>
                    مبلغ قابل پرداخت:
                    <strong>
                        <span id="payable_price_text">{{ number_format($payablePrice) }}</span>
                        تومان
                    </strong>
                </div>
            </div>

            <div class="checkout-steps">
                <span>افزودن به سبد</span>
                <span class="active">شیوه ارسال</span>
                <span class="active">آدرس و نحوه پرداخت</span>
                <span>پایان</span>
            </div>

            <div class="checkout-layout">

                <div class="checkout-main">

                    <section class="checkout-box">
                        <h3>انتخاب شیوه ارسال</h3>

                        <label class="shipping-card selected">
                            <input type="radio" name="shipping_method" value="post" data-price="85000" checked>
                            <div>
                                <strong>پست پیشتاز</strong>
                                <span>ارسال معمولی ۲ تا ۵ روز کاری</span>
                                <b>85,000 تومان</b>
                            </div>
                        </label>

                        <label class="shipping-card">
                            <input type="radio" name="shipping_method" value="tipax" data-price="120000">
                            <div>
                                <strong>تیپاکس</strong>
                                <span>مناسب سفارش‌های سریع‌تر</span>
                                <b>120,000 تومان</b>
                            </div>
                        </label>

                        <label class="shipping-card">
                            <input type="radio" name="shipping_method" value="pickup" data-price="0">
                            <div>
                                <strong>تحویل حضوری</strong>
                                <span>دریافت سفارش از محل فروشگاه</span>
                                <b>رایگان</b>
                            </div>
                        </label>

                        <label class="shipping-card">
                            <input type="radio" name="shipping_method" value="after_call" data-price="0">
                            <div>
                                <strong>هماهنگی بعد از تماس</strong>
                                <span>برای سفارش‌های چاپی، حجیم یا نیازمند نصب</span>
                                <b>بعدا اعلام می‌شود</b>
                            </div>
                        </label>

                        <input type="hidden" name="shipping_price" id="shipping_price" value="{{ $defaultShippingPrice }}">
                    </section>

                    <section class="checkout-box">
                        <h3>انتخاب آدرس</h3>

                        @forelse($addresses as $address)
                            <label class="address-card {{ $loop->first ? 'selected' : '' }}">
                                <input type="radio"
                                       name="address_id"
                                       value="{{ $address->id }}"
                                    {{ $loop->first ? 'checked' : '' }}>

                                <div>
                                    <strong>
                                        گیرنده:
                                        {{ $address->receiver_name }}
                                        {{ $address->receiver_lastname }}
                                    </strong>

                                    <span>
                                    موبایل:
                                    {{ $address->receiver_mobile }}
                                </span>

                                    <p>
                                        آدرس:
                                        {{ $address->province }}،
                                        {{ $address->city }}،
                                        {{ $address->address }}
                                    </p>
                                </div>
                            </label>
                        @empty
                            <div class="empty-address">
                                هنوز آدرسی ثبت نشده است. لطفا یک آدرس جدید اضافه کنید.
                            </div>
                        @endforelse

                        <button type="button"
                                class="add-address"
                                data-bs-toggle="modal"
                                data-bs-target="#addressModal">
                            + افزودن آدرس جدید
                        </button>
                    </section>

                </div>

                <aside class="checkout-side">

                    <section class="checkout-box order-review">
                        <h3>خلاصه سفارش</h3>

                        <div class="review-row">
                            <span>جمع محصولات</span>
                            <strong>{{ number_format($cartTotal) }} تومان</strong>
                        </div>

                        <div class="review-row">
                            <span>هزینه ارسال</span>
                            <strong>
                                <span id="shipping_price_text">{{ number_format($defaultShippingPrice) }}</span>
                                تومان
                            </strong>
                        </div>

                        <div class="review-row total">
                            <span>مبلغ قابل پرداخت</span>
                            <strong>
                                <span id="final_price_text">{{ number_format($payablePrice) }}</span>
                                تومان
                            </strong>
                        </div>
                    </section>

                    <section class="checkout-box">
                        <h3>انتخاب نحوه پرداخت</h3>

                        <label class="payment-card">
                            <input type="radio" name="payment_type" value="online">
                            <span>پرداخت آنلاین</span>
                        </label>

                        <label class="payment-card selected">
                            <input type="radio" name="payment_type" value="after_call" checked>
                            <span>بعد از تماس و اعلام قیمت نهایی واریز می‌کنم</span>
                        </label>

                        <button type="submit" class="checkout-submit">
                            تکمیل خرید
                        </button>

                        <p class="checkout-note">
                            سفارش‌های چاپی پس از بررسی فایل، ابعاد و خدمات انتخابی توسط تیم فروش تایید نهایی می‌شوند.
                        </p>
                    </section>

                </aside>

            </div>
        </form>
    </div>

    <div class="modal fade" id="addressModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content address-modal">

                <div class="modal-header">
                    <h4>افزودن آدرس</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="address-grid">
                        <div>
                            <label>نام تحویل گیرنده</label>
                            <input type="text" id="modal_receiver_name">
                        </div>

                        <div>
                            <label>نام خانوادگی</label>
                            <input type="text" id="modal_receiver_lastname">
                        </div>

                        <div>
                            <label>شماره همراه</label>
                            <input type="text" id="modal_receiver_mobile">
                        </div>

                        <div>
                            <label>تلفن ثابت</label>
                            <input type="text" id="modal_receiver_phone">
                        </div>

                        <div>
                            <label>کد پستی</label>
                            <input type="text" id="modal_postal_code">
                        </div>

                        <div>
                            <label>استان</label>
                            <select id="modal_province">
                                <option value="">انتخاب کنید</option>
                                <option value="تهران">تهران</option>
                                <option value="البرز">البرز</option>
                                <option value="اصفهان">اصفهان</option>
                                <option value="فارس">فارس</option>
                                <option value="خراسان رضوی">خراسان رضوی</option>
                            </select>
                        </div>

                        <div>
                            <label>شهر</label>
                            <input type="text" id="modal_city">
                        </div>

                        <div class="full">
                            <label>آدرس</label>
                            <textarea id="modal_address" rows="4"></textarea>
                        </div>
                    </div>

                    <button type="button" class="save-address" id="saveAddressBtn">
                        ثبت آدرس
                    </button>

                </div>

            </div>
        </div>
    </div>

    <style>
        .checkout-page {
            direction: rtl;
            padding: 55px 0 90px;
            background: #f3f3f3;
            min-height: 70vh;
        }

        .checkout-page form {
            width: 88%;
            margin: 0 auto;
        }

        .checkout-summary {
            background: #fff;
            border-radius: 12px;
            padding: 18px 24px;
            margin-bottom: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #666;
            border: 1px solid #ddd;
            box-shadow: 0 4px 18px rgba(0,0,0,.04);
        }

        .checkout-summary strong {
            color: #222;
        }

        .checkout-summary div:last-child strong {
            color: #e60033;
            margin-right: 8px;
        }

        .user-name {
            margin-right: 18px;
            color: #777;
        }

        .checkout-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 22px;
        }

        .checkout-steps span {
            background: #dcdcdc;
            color: #555;
            padding: 13px;
            text-align: center;
            border-radius: 8px;
            font-weight: 700;
        }

        .checkout-steps .active {
            background: #00bcd4;
            color: #fff;
        }

        .checkout-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .checkout-box {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 18px;
            box-shadow: 0 4px 18px rgba(0,0,0,.04);
        }

        .checkout-box h3 {
            margin: 0 0 18px;
            font-size: 20px;
            font-weight: 800;
            padding: 13px;
            border-radius: 10px;
            background: #066582;
            color: #fff;
            text-align: center;
        }

        .address-card,
        .payment-card,
        .shipping-card {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            background: #fafafa;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 14px;
            cursor: pointer;
            transition: .2s;
        }

        .address-card:hover,
        .payment-card:hover,
        .shipping-card:hover,
        .address-card.selected,
        .payment-card.selected,
        .shipping-card.selected {
            background: #f4fbfd;
            border-color: #00bcd4;
            box-shadow: 0 0 0 3px rgba(0,188,212,.10);
        }

        .address-card input,
        .payment-card input,
        .shipping-card input {
            margin-top: 5px;
        }

        .address-card strong,
        .address-card span,
        .address-card p,
        .shipping-card strong,
        .shipping-card span,
        .shipping-card b {
            display: block;
            margin-bottom: 7px;
        }

        .shipping-card b {
            color: #e60033;
        }

        .address-card p {
            margin-bottom: 0;
            color: #555;
            line-height: 2;
        }

        .empty-address {
            background: #fff3cd;
            color: #856404;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 14px;
            line-height: 2;
            font-weight: 700;
        }

        .add-address {
            width: 100%;
            border: 3px dashed #ccc;
            background: #f9f9f9;
            border-radius: 12px;
            padding: 30px;
            font-size: 17px;
            color: #444;
            cursor: pointer;
            transition: .2s;
        }

        .add-address:hover {
            background: #fff;
            border-color: #00bcd4;
            color: #008da0;
        }

        .order-review .review-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            color: #555;
        }

        .order-review .review-row.total {
            border-bottom: none;
            color: #222;
            font-size: 16px;
            font-weight: 800;
        }

        .order-review .review-row.total strong {
            color: #e60033;
        }

        .checkout-submit {
            width: 100%;
            border: none;
            background: #f0003d;
            color: #fff;
            border-radius: 10px;
            padding: 13px;
            font-size: 19px;
            font-weight: 800;
            cursor: pointer;
            margin-top: 12px;
            transition: .2s;
        }

        .checkout-submit:hover {
            background: #d90036;
        }

        .checkout-note {
            margin: 16px 0 0;
            padding: 12px;
            border-radius: 10px;
            background: #fff8df;
            border: 1px solid #eadca5;
            color: #665200;
            line-height: 2;
            font-size: 13px;
        }

        .address-modal {
            direction: rtl;
        }

        .address-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .address-grid .full {
            grid-column: 1 / -1;
        }

        .address-grid label {
            display: block;
            margin-bottom: 7px;
            font-weight: 700;
        }

        .address-grid input,
        .address-grid select,
        .address-grid textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            direction: rtl;
            background: #fff;
        }

        .save-address {
            margin-top: 20px;
            background: #00bcd4;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 11px 32px;
            font-weight: 700;
        }

        @media (max-width: 1000px) {
            .checkout-page form {
                width: 96%;
            }

            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .address-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .checkout-summary {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            .checkout-steps {
                grid-template-columns: 1fr;
            }

            .address-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartTotal = Number(@json((float) $cartTotal));

            function formatNumber(number) {
                return new Intl.NumberFormat('en-US').format(Number(number || 0));
            }

            @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'متوجه شدم',
                confirmButtonColor: '#e60033'
            });
            @endif

            @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                text: @json(session('error')),
                confirmButtonText: 'متوجه شدم',
                confirmButtonColor: '#e60033'
            });
            @endif

            @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'موفق',
                text: @json(session('success')),
                confirmButtonText: 'باشه',
                confirmButtonColor: '#00bcd4'
            });
            @endif

            document.querySelectorAll('input[name="shipping_method"]').forEach(function (input) {
                input.addEventListener('change', function () {
                    const shippingPrice = Number(this.dataset.price || 0);

                    document.getElementById('shipping_price').value = shippingPrice;
                    document.getElementById('shipping_price_text').innerText = formatNumber(shippingPrice);
                    document.getElementById('final_price_text').innerText = formatNumber(cartTotal + shippingPrice);
                    document.getElementById('payable_price_text').innerText = formatNumber(cartTotal + shippingPrice);

                    document.querySelectorAll('.shipping-card').forEach(function (card) {
                        card.classList.remove('selected');
                    });

                    this.closest('.shipping-card').classList.add('selected');
                });
            });

            document.querySelectorAll('input[name="payment_type"]').forEach(function (input) {
                input.addEventListener('change', function () {
                    document.querySelectorAll('.payment-card').forEach(function (card) {
                        card.classList.remove('selected');
                    });

                    this.closest('.payment-card').classList.add('selected');
                });
            });

            document.querySelectorAll('input[name="address_id"]').forEach(function (input) {
                input.addEventListener('change', function () {
                    document.querySelectorAll('.address-card').forEach(function (card) {
                        card.classList.remove('selected');
                    });

                    this.closest('.address-card').classList.add('selected');
                });
            });

            const saveAddressBtn = document.getElementById('saveAddressBtn');

            if (saveAddressBtn) {
                saveAddressBtn.addEventListener('click', function () {
                    const formData = new FormData();

                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('receiver_name', document.getElementById('modal_receiver_name').value || '');
                    formData.append('receiver_lastname', document.getElementById('modal_receiver_lastname').value || '');
                    formData.append('receiver_mobile', document.getElementById('modal_receiver_mobile').value || '');
                    formData.append('receiver_phone', document.getElementById('modal_receiver_phone').value || '');
                    formData.append('postal_code', document.getElementById('modal_postal_code').value || '');
                    formData.append('province', document.getElementById('modal_province').value || '');
                    formData.append('city', document.getElementById('modal_city').value || '');
                    formData.append('address', document.getElementById('modal_address').value || '');

                    fetch('{{ route('front.user.addresses.store') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                        .then(async function (response) {
                            const data = await response.json();

                            if (!response.ok) {
                                let message = '';

                                if (data.errors) {
                                    Object.values(data.errors).forEach(function (items) {
                                        items.forEach(function (item) {
                                            message += item + '<br>';
                                        });
                                    });
                                } else {
                                    message = data.message || 'خطا در ثبت آدرس';
                                }

                                throw message;
                            }

                            return data;
                        })
                        .then(function () {
                            Swal.fire({
                                icon: 'success',
                                title: 'آدرس ثبت شد',
                                text: 'آدرس شما با موفقیت ذخیره شد.',
                                confirmButtonText: 'باشه',
                                confirmButtonColor: '#00bcd4'
                            }).then(function () {
                                window.location.reload();
                            });
                        })
                        .catch(function (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطا',
                                html: error,
                                confirmButtonText: 'متوجه شدم',
                                confirmButtonColor: '#e60033'
                            });
                        });
                });
            }

            const checkoutForm = document.getElementById('checkoutForm');

            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function (e) {
                    const selectedAddress = document.querySelector('input[name="address_id"]:checked');

                    if (!selectedAddress) {
                        e.preventDefault();

                        Swal.fire({
                            icon: 'error',
                            title: 'آدرس انتخاب نشده است',
                            text: 'لطفا ابتدا یک آدرس ثبت یا انتخاب کنید.',
                            confirmButtonText: 'متوجه شدم',
                            confirmButtonColor: '#e60033'
                        });

                        return;
                    }

                    const submitButton = checkoutForm.querySelector('.checkout-submit');

                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerText = 'در حال ثبت سفارش...';
                    }
                });
            }
        });
    </script>

@endsection
