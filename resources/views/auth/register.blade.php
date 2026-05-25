@extends('frontend.layouts.master')

@section('pageTitle', 'ثبت نام - ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('theme/css/auth.css') }}">

    <style>
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

        .email-field-wrapper {
            margin-bottom: 18px;
        }

        .email-input-box {
            direction: ltr !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center;
            height: 58px;
            background: #fff;
            border: 1px solid #d7d7d7;
            border-radius: 8px;
            overflow: hidden;
            transition: .2s ease;
        }

        .email-input-box:focus-within {
            border-color: #0f74a8;
            box-shadow: 0 0 0 3px rgba(15,116,168,.12);
        }

        .email-input-box.is-invalid {
            border: 2px solid #e53935;
            background: #fffafa;
            box-shadow: 0 0 0 3px rgba(229,57,53,.10);
        }

        .email-prefix {
            order: 1;
            width: 75px;
            height: 100%;
            border-right: 1px solid #ececec;
            background: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #222;
            flex-shrink: 0;
        }

        .email-input {
            order: 2;
            width: 100%;
            height: 100%;
            border: 0 !important;
            box-shadow: none !important;
            outline: none !important;
            direction: ltr !important;
            text-align: left !important;
            font-size: 16px;
            padding: 0 18px;
        }

        .email-input::placeholder {
            color: #b8b8b8;
        }

        .field-error {
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
            text-decoration: none;
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

        .auth-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid #e9e9e9;
            direction: rtl;
        }

        .auth-links a {
            color: #0f74a8;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .auth-links a:hover {
            color: #0a5a82;
        }
    </style>
@endpush

@section('wrapper')

    <div style="direction:ltr;top:90px;margin-bottom:120px;position:relative;"
         id="particles-js"
         class="main-form-box">

        <div class="md-form">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-lg-5 col-md-7 col-12">
                        <div class="panel panel-login">

                            <div class="panel-heading" style="padding:0 !important;">
                                <div class="row" style="padding:0;margin:0;">
                                    <div class="col-12" style="padding:0;margin:0;">
                                        <span class="register-form-link">
                                            ثبت نام
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-12">

                                        <form id="register-form"
                                              action="{{ route('auth.submit.register') }}"
                                              method="POST"
                                              class="login-form-clean"
                                              style="margin:0 10px;">

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

                                            <div class="email-field-wrapper">
                                                <div class="email-input-box @error('email') is-invalid @enderror">
                                                    <div class="email-prefix">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>

                                                    <input type="email"
                                                           name="email"
                                                           id="email"
                                                           class="form-control email-input"
                                                           placeholder="example@gmail.com"
                                                           value="{{ old('email') }}"
                                                           autocomplete="email">
                                                </div>

                                                @error('email')
                                                <span class="field-error">
                                                    <i class="fa fa-exclamation-triangle"></i>
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>

                                            <div style="margin-bottom:20px;">
                                                <label class="container1">
                                                    <input class="checkmark"
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
                                                    استفاده از سرویس های سایت {{ config('app.name') }}
                                                    را مطالعه نموده و با آنها موافقم.
                                                </label>
                                            </div>

                                            <input type="submit"
                                                   id="register-submit"
                                                   class="form-control btn btn-login"
                                                   value="ثبت نام">

                                            <div class="auth-links">
                                                <a href="{{ route('auth.login') }}">
                                                    <i class="fa fa-sign-in"></i>
                                                    ورود به حساب
                                                </a>

                                                <a href="#">
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
        $('#register-form').on('submit', function () {
            $('#register-submit')
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
                            اطلاعات کاربران نزد ${@json(config('app.name'))}
                            محفوظ بوده و صرفاً جهت پردازش سفارشات،
                            ارسال ایمیل و بهبود خدمات استفاده می‌شود.
                        </p>
                        <p>
                            اطلاعات شما به هیچ شخص یا مجموعه ثالثی
                            فروخته یا منتقل نخواهد شد.
                        </p>
                        <p>
                            با ثبت‌نام در سایت، شما با قوانین حفظ
                            حریم خصوصی موافقت می‌نمایید.
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
                        <p>
                            ثبت سفارش به منزله پذیرش قوانین سایت می‌باشد.
                        </p>
                        <p>
                            زمان آماده‌سازی و تحویل سفارش بسته به نوع
                            خدمات چاپ متغیر خواهد بود.
                        </p>
                        <p>
                            مسئولیت صحت فایل‌های ارسالی بر عهده کاربر می‌باشد.
                        </p>
                    </div>
                `,
                confirmButtonText: 'متوجه شدم',
                confirmButtonColor: '#0f74a8',
                width: 600
            });
        });
    </script>
@endpush
