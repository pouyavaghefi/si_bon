@extends('frontend.layouts.master')

@section('pageTitle', 'تایید شماره موبایل - ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('theme/css/auth.css') }}">

    <style>
        .verify-form-clean {
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

        .verify-description {
            direction: rtl;
            text-align: center;
            color: #555;
            font-size: 14px;
            line-height: 2;
            margin: 0 10px 20px;
        }

        .verify-description strong {
            color: #0f74a8;
            direction: ltr;
            display: inline-block;
        }

        .code-field-wrapper {
            margin-bottom: 18px;
        }

        .code-input-box {
            direction: ltr !important;
            display: flex !important;
            align-items: center;
            height: 58px;
            background: #fff;
            border: 1px solid #d7d7d7;
            border-radius: 8px;
            overflow: hidden;
            transition: .2s ease;
        }

        .code-input-box:focus-within {
            border-color: #0f74a8;
            box-shadow: 0 0 0 3px rgba(15,116,168,.12);
        }

        .code-input-box.is-invalid {
            border: 2px solid #e53935;
            background: #fffafa;
            box-shadow: 0 0 0 3px rgba(229,57,53,.10);
        }

        .code-icon {
            width: 70px;
            height: 100%;
            border-right: 1px solid #ececec;
            background: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0f74a8;
            font-size: 22px;
            flex-shrink: 0;
        }

        .code-input {
            width: 100%;
            height: 100%;
            border: 0 !important;
            box-shadow: none !important;
            outline: none !important;
            direction: ltr !important;
            text-align: center !important;
            font-size: 22px;
            padding: 0 18px;
            letter-spacing: 8px;
            font-weight: 700;
        }

        .code-input::placeholder {
            color: #b8b8b8;
            letter-spacing: 2px;
            font-size: 15px;
            font-weight: 400;
        }

        .field-error {
            display: block;
            margin-top: 8px;
            color: #c62828;
            font-size: 13px;
            line-height: 1.8;
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

        .auth-links a,
        .auth-links button {
            color: #0f74a8;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            background: transparent;
            border: 0;
            padding: 0;
            cursor: pointer;
        }

        .auth-links button:disabled {
            color: #888;
            cursor: not-allowed;
        }

        .auth-links a:hover,
        .auth-links button:hover:not(:disabled) {
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
                                            تایید شماره موبایل
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-12">

                                        <form id="verify-form"
                                              action="{{ route('auth.verify.submit') }}"
                                              method="POST"
                                              class="verify-form-clean"
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

                                            @if (session('success'))
                                                <div class="auth-alert" style="background:#f1fff7;border-color:#b7e4c7;border-right-color:#2e7d32;color:#1b5e20;">
                                                    <ul>
                                                        <li>
                                                            <i class="fa fa-check-circle"></i>
                                                            <span>{{ session('success') }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif

                                            <p class="verify-description">
                                                کد تایید ارسال‌شده به شماره
                                                <strong>{{ session('auth_mobile') }}</strong>
                                                را وارد کنید.
                                            </p>

                                            <div class="code-field-wrapper">
                                                <div class="code-input-box @error('code') is-invalid @enderror">
                                                    <div class="code-icon">
                                                        <i class="fa fa-shield"></i>
                                                    </div>

                                                    <input type="text"
                                                           name="code"
                                                           id="code"
                                                           class="form-control code-input"
                                                           placeholder="کد تایید"
                                                           value="{{ old('code') }}"
                                                           minlength="5"
                                                           maxlength="5"
                                                           inputmode="numeric"
                                                           autocomplete="one-time-code">
                                                </div>

                                                @error('code')
                                                <span class="field-error">
                                                    <i class="fa fa-exclamation-triangle"></i>
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>

                                            <input type="submit"
                                                   id="verify-submit"
                                                   class="form-control btn btn-login"
                                                   value="تایید و ادامه">

                                            <div class="auth-links">
                                                <a href="{{ route('auth.register') }}">
                                                    <i class="fa fa-arrow-right"></i>
                                                    تغییر شماره
                                                </a>

                                                <form action="{{ route('auth.resend-code') }}"
                                                      method="POST"
                                                      id="resend-form"
                                                      style="margin:0;">
                                                    @csrf

                                                    <button type="submit" id="resend-submit">
                                                        <i class="fa fa-refresh"></i>
                                                        ارسال مجدد کد
                                                    </button>
                                                </form>
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
    <script>
        $(function () {
            const resendButton = $('#resend-submit');
            const resendAvailableAt = @json($resendAvailableAt ?? null);

            let interval = null;

            function formatTime(seconds) {
                let minutes = Math.floor(seconds / 60);
                let remainSeconds = seconds % 60;

                remainSeconds = remainSeconds < 10 ? '0' + remainSeconds : remainSeconds;

                return minutes + ':' + remainSeconds;
            }

            function enableResend() {
                resendButton
                    .prop('disabled', false)
                    .html('<i class="fa fa-refresh"></i> ارسال مجدد کد');
            }

            function disableResend(remaining) {
                resendButton
                    .prop('disabled', true)
                    .html('<i class="fa fa-clock-o"></i> ارسال مجدد تا ' + formatTime(remaining));
            }

            function startResendTimer() {
                if (!resendAvailableAt) {
                    enableResend();
                    return;
                }

                function tick() {
                    const now = Math.floor(Date.now() / 1000);
                    const remaining = resendAvailableAt - now;

                    if (remaining <= 0) {
                        if (interval) {
                            clearInterval(interval);
                        }

                        enableResend();
                        return;
                    }

                    disableResend(remaining);
                }

                tick();
                interval = setInterval(tick, 1000);
            }

            startResendTimer();

            $('#code').on('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 5);
            });

            $('#verify-form').on('submit', function () {
                $('#verify-submit')
                    .addClass('is-loading')
                    .prop('disabled', true);
            });

            $('#resend-form').on('submit', function () {
                resendButton
                    .prop('disabled', true)
                    .html('<i class="fa fa-spinner fa-spin"></i> در حال ارسال...');
            });
        });
    </script>
@endpush
