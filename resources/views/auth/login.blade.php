@extends('frontend.layouts.master')

@section('pageTitle', 'ورود - ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('theme/css/auth.css') }}">

    <style>
        .auth-links{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-top:18px;
            padding-top:16px;
            border-top:1px solid #e9e9e9;
            direction:rtl;
        }

        .auth-links a{
            color:#0f74a8;
            font-size:14px;
            font-weight:600;
            transition:.2s;
            text-decoration:none;
            display:flex;
            align-items:center;
            gap:6px;
        }

        .auth-links a:hover{
            color:#0a5a82;
            text-decoration:none;
        }

        .auth-links a i{
            font-size:13px;
        }

        .login-form-clean {
            direction: rtl;
            text-align: right;
        }

        .auth-alert {
            direction: rtl;
            text-align: right;
            background: #fff5f5;
            border: 1px solid #ffc7c7;
            border-right: 5px solid #e53935;
            color: #c62828;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .auth-alert ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .auth-alert li {
            display: flex;
            align-items: center;
            gap: 8px;
            line-height: 1.9;
        }

        .phone-field-wrapper {
            margin-bottom: 18px;
        }

        .phone-input-box {
            direction: ltr;
            display: flex;
            align-items: center;
            height: 55px;
            background: #fff;
            border: 1px solid #d1d1d1;
            border-radius: 6px;
            overflow: hidden;
            transition: .2s ease;
        }

        .phone-input-box:focus-within {
            border-color: #0f74a8;
            box-shadow: 0 0 0 3px rgba(15, 116, 168, .12);
        }

        .phone-input-box.is-invalid {
            border: 2px solid #e53935;
            background: #fffafa;
            box-shadow: 0 0 0 3px rgba(229, 57, 53, .10);
        }

        .phone-prefix {
            width: 70px;
            height: 100%;
            border-right: 1px solid #e5e5e5;
            background: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            font-weight: 700;
            color: #222;
            flex-shrink: 0;
        }

        .phone-input {
            width: 100%;
            height: 100%;
            border: 0 !important;
            box-shadow: none !important;
            outline: none !important;
            direction: ltr;
            text-align: left;
            font-size: 17px;
            padding: 0 16px;
            letter-spacing: 1px;
        }

        .phone-input::placeholder {
            color: #b8b8b8;
            letter-spacing: 0;
        }

        .field-error {
            direction: rtl;
            display: block;
            margin-top: 8px;
            color: #c62828;
            font-size: 13px;
            line-height: 1.8;
        }

        .container1 {
            direction: rtl;
            text-align: right;
            line-height: 2.2;
            font-size: 14px;
            color: #222;
        }

        .container1 a {
            color: #0097a7;
            font-weight: 700;
        }

        .btn-login.is-loading {
            pointer-events: none;
            color: transparent !important;
            position: relative;
        }

        .btn-login.is-loading::after {
            content: "";
            width: 24px;
            height: 24px;
            border: 3px solid #fff;
            border-top-color: transparent;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: btnSpin .7s linear infinite;
        }

        @keyframes btnSpin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }
    </style>
@endpush

@section('wrapper')

    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="logout-head" style="display:none;">
        @csrf
    </form>

    <div style="direction: ltr; top: 90px; margin-bottom: 120px; position: relative;"
         id="particles-js"
         class="main-form-box">

        <div class="md-form">
            <div class="container">
                <div class="row">

                    <div class="col-md-6 vvv">
                        <div class="panel panel-login">

                            <div class="panel-heading" style="padding: 0 !important;">
                                <div class="row" style="padding: 0; margin: 0;">
                                    <div class="col-lg-12 col-sm-12 col-xl-12" style="padding: 0; margin: 0;">
                                        <span class="register-form-link" id="register-form-link">
                                            ورود به حساب
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12" style="padding: 0; margin: 0;">

                                        <form name="login-form"
                                              id="login-form"
                                              action="{{ route('auth.submit.login') }}"
                                              method="POST"
                                              role="form"
                                              class="login-form-clean"
                                              style="display:block;-webkit-appearance:none;-moz-appearance:none;margin:0 10px;">

                                            @csrf

                                            @if ($errors->any())
                                                <div class="auth-alert">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>
                                                                <i class="fa fa-exclamation-circle"></i>
                                                                <span>{{ $error }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="phone-field-wrapper">
                                                <div class="phone-input-box @error('phone') is-invalid @enderror">
                                                    <div class="phone-prefix">09</div>

                                                    <input type="text"
                                                           name="mobile"
                                                           id="phone"
                                                           tabindex="1"
                                                           class="form-control phone-input"
                                                           placeholder="12 123 4567"
                                                           value="{{ old('phone') }}"
                                                           minlength="9"
                                                           maxlength="9"
                                                           inputmode="numeric"
                                                           autocomplete="off">
                                                </div>

                                                @error('phone')
                                                <span class="field-error">
                                                        <i class="fa fa-exclamation-triangle"></i>
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="container1">
                                                    <input class="checkmark"
                                                           style="background-color:#0f74a8;margin:0 10px;"
                                                           name="checkbox"
                                                           type="checkbox"
                                                           checked
                                                           required
                                                           id="checkmark">

                                                    <span></span>
                                                    <span class="checkmark"></span>

                                                    <a href="#" id="privacy-policy-btn">حریم خصوصی</a>
                                                    ،
                                                    <a href="#" id="terms-btn">شرایط و قوانین</a>
                                                    استفاده از سرویس های سایت {{ config('app.name') }} را مطالعه نموده و با آنها موافقم.
                                                </label>
                                            </div>

                                            <input type="submit"
                                                   name="login-submit"
                                                   id="login-submit"
                                                   tabindex="4"
                                                   class="form-control btn btn-login"
                                                   value="ورود">

                                            <div class="auth-links">

                                                <a href="{{ route('auth.register') }}">
                                                    <i class="fa fa-user-plus"></i>
                                                    ثبت نام
                                                </a>

                                                <a href="{{ route('auth.forgot-password') }}">
                                                    <i class="fa fa-lock"></i>
                                                    فراموشی رمز عبور
                                                </a>

                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#phone').on('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 9);
        });

        $('#login-form').on('submit', function () {
            $('#login-submit')
                .addClass('is-loading')
                .prop('disabled', true);
        });

        $('#privacy-policy-btn').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'حریم خصوصی',
                html: `
                    <div style="direction:rtl;text-align:right;line-height:2;font-size:14px;">
                        <p>
                            اطلاعات کاربران نزد ${@json(config('app.name'))} محفوظ بوده و
                            صرفاً جهت پردازش سفارشات، ارسال پیامک و بهبود خدمات استفاده می‌شود.
                        </p>
                        <p>
                            اطلاعات شما به هیچ شخص یا مجموعه ثالثی فروخته یا منتقل نخواهد شد.
                        </p>
                        <p>
                            با ثبت‌نام در سایت، شما با قوانین حفظ حریم خصوصی موافقت می‌نمایید.
                        </p>
                    </div>
                `,
                confirmButtonText: 'متوجه شدم',
                confirmButtonColor: '#0f74a8',
                width: 600
            });
        });

        $('#terms-btn').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'شرایط و قوانین',
                html: `
                    <div style="direction:rtl;text-align:right;line-height:2;font-size:14px;">
                        <p>ثبت سفارش به منزله پذیرش قوانین سایت می‌باشد.</p>
                        <p>زمان آماده‌سازی و تحویل سفارش بسته به نوع خدمات چاپ متغیر خواهد بود.</p>
                        <p>مسئولیت صحت فایل‌های ارسالی بر عهده کاربر می‌باشد.</p>
                    </div>
                `,
                confirmButtonText: 'متوجه شدم',
                confirmButtonColor: '#0f74a8',
                width: 600
            });
        });
    </script>

@endpush
