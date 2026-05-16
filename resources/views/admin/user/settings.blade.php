@extends('admin.layouts.master')

@section('pageTitle','تنظیمات حساب مدیریت')

@section('wrapper')
    <div class="container-fluid" dir="rtl">
        @php
            $admin = auth()->user();
        @endphp

        <style>
            .settings-avatar-wrapper {
                display: flex;
                justify-content: center;
            }

            .settings-avatar-box {
                position: relative;
                width: 130px;
                height: 130px;
            }

            .settings-avatar-image {
                width: 130px;
                height: 130px;
                object-fit: cover;
                border-radius: 50%;
                border: 4px solid #fff;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
                background: #f8f9fa;
            }

            .settings-avatar-edit-btn {
                position: absolute;
                bottom: 5px;
                right: 5px;
                width: 38px;
                height: 38px;
                border-radius: 50%;
                background: #111827;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                box-shadow: 0 4px 12px rgba(0, 0, 0, .18);
                cursor: pointer;
            }

            .settings-avatar-edit-btn i {
                width: 17px;
                height: 17px;
            }

            .password-tools {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            .password-strength-progress {
                height: 8px;
                border-radius: 20px;
                overflow: hidden;
            }
        </style>

        @if (session('success'))
            <div class="alert alert-success text-end">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger text-end">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-dashed">
                        <h4 class="card-title mb-0">تنظیمات پایه حساب</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.settings.basic') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">نام کاربری</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $admin->name) }}"
                                           placeholder="نام کاربری">

                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">ایمیل</label>
                                    <input type="email"
                                           name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', $admin->email) }}"
                                           placeholder="ایمیل">

                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">موبایل</label>
                                    <input type="text"
                                           name="mobile"
                                           class="form-control @error('mobile') is-invalid @enderror"
                                           value="{{ old('mobile', $admin->mobile) }}"
                                           placeholder="شماره موبایل">

                                    @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">وضعیت حساب</label>
                                    <input type="text"
                                           class="form-control"
                                           value="{{ $admin->is_active ? 'فعال' : 'غیرفعال' }}"
                                           disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">رمز عبور جهت تایید</label>
                                    <input type="password"
                                           name="password_confirm"
                                           class="form-control @error('password_confirm') is-invalid @enderror"
                                           placeholder="رمز عبور فعلی">

                                    @error('password_confirm')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        ذخیره تغییرات
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-dashed">
                        <h4 class="card-title mb-0">رمز عبور و امنیت</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.settings.password') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">رمز عبور فعلی</label>
                                    <input type="password"
                                           name="current_password"
                                           class="form-control @error('current_password') is-invalid @enderror"
                                           placeholder="رمز عبور فعلی">

                                    @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">رمز عبور جدید</label>
                                    <input type="password"
                                           name="password"
                                           id="newPassword"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="رمز عبور جدید">

                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div class="progress password-strength-progress mt-2">
                                        <div id="passwordStrengthBar"
                                             class="progress-bar"
                                             style="width: 0%;">
                                        </div>
                                    </div>

                                    <small id="passwordStrengthText" class="text-muted d-block mt-1">
                                        قدرت رمز عبور
                                    </small>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">تکرار رمز عبور جدید</label>
                                    <input type="password"
                                           name="password_confirmation"
                                           id="passwordConfirmation"
                                           class="form-control"
                                           placeholder="تکرار رمز عبور جدید">

                                    <div class="password-tools mt-2">
                                        <button type="button"
                                                class="btn btn-sm btn-light"
                                                id="generatePasswordBtn">
                                            تولید رمز
                                        </button>

                                        <button type="button"
                                                class="btn btn-sm btn-outline-dark"
                                                id="copyPasswordBtn">
                                            کپی رمز
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-3 rounded bg-light-subtle border">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i data-lucide="shield-check" class="text-success"></i>
                                            <strong>وضعیت امنیت</strong>
                                        </div>
                                        <p class="text-muted mb-0 small">
                                            حساب مدیریت فعال است و نشست فعلی با موفقیت تایید شده است.
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-3 rounded bg-light-subtle border">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i data-lucide="clock" class="text-primary"></i>
                                            <strong>آخرین بروزرسانی</strong>
                                        </div>
                                        <p class="text-muted mb-0 small">
                                            {{ $admin->updated_at ? $admin->updated_at->format('Y-m-d H:i') : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-dark">
                                        بروزرسانی رمز عبور
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-dashed">
                        <h4 class="card-title mb-0">تصویر پروفایل</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.settings.avatar') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="row align-items-center g-4">
                                <div class="col-lg-4 text-center">
                                    <div class="settings-avatar-wrapper">
                                        <div class="settings-avatar-box">
                                            <img src="{{ $admin->avatar ? asset($admin->avatar) : asset('/adm/img/admin.png') }}"
                                                 class="settings-avatar-image"
                                                 alt="admin-avatar">

                                            <label for="avatar" class="settings-avatar-edit-btn">
                                                <i data-lucide="camera"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <label class="form-label">انتخاب تصویر جدید</label>
                                    <input type="file"
                                           name="avatar"
                                           id="avatar"
                                           class="form-control @error('avatar') is-invalid @enderror"
                                           accept="image/*">

                                    @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <p class="text-muted small mt-2 mb-3">
                                        فرمت‌های مجاز: JPG، PNG، WEBP. بهتر است تصویر مربعی باشد.
                                    </p>

                                    <label class="form-label">رمز عبور جهت تایید</label>
                                    <input type="password"
                                           name="password_confirm_avatar"
                                           class="form-control @error('password_confirm_avatar') is-invalid @enderror"
                                           placeholder="رمز عبور فعلی">

                                    @error('password_confirm_avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            ذخیره تصویر پروفایل
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('newPassword');
            const confirmInput = document.getElementById('passwordConfirmation');
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');
            const generateBtn = document.getElementById('generatePasswordBtn');
            const copyBtn = document.getElementById('copyPasswordBtn');

            function checkStrength(password) {
                let score = 0;

                if (password.length >= 8) score++;
                if (password.length >= 12) score++;
                if (/[A-Z]/.test(password)) score++;
                if (/[a-z]/.test(password)) score++;
                if (/[0-9]/.test(password)) score++;
                if (/[^A-Za-z0-9]/.test(password)) score++;

                if (!password.length) {
                    return { width: 0, text: 'قدرت رمز عبور', className: '' };
                }

                if (score <= 2) {
                    return { width: 30, text: 'ضعیف', className: 'bg-danger' };
                }

                if (score <= 4) {
                    return { width: 65, text: 'متوسط', className: 'bg-warning' };
                }

                return { width: 100, text: 'قوی', className: 'bg-success' };
            }

            function updateStrength() {
                const result = checkStrength(passwordInput.value);

                strengthBar.style.width = result.width + '%';
                strengthBar.className = 'progress-bar ' + result.className;
                strengthText.textContent = result.text;
            }

            function generatePassword() {
                const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%^&*';
                let password = '';

                for (let i = 0; i < 14; i++) {
                    password += chars.charAt(Math.floor(Math.random() * chars.length));
                }

                passwordInput.value = password;
                confirmInput.value = password;

                updateStrength();
            }

            function copyPassword() {
                if (!passwordInput.value) {
                    return;
                }

                navigator.clipboard.writeText(passwordInput.value);

                copyBtn.textContent = 'کپی شد';

                setTimeout(function () {
                    copyBtn.textContent = 'کپی رمز';
                }, 1500);
            }

            if (passwordInput && confirmInput && strengthBar && strengthText && generateBtn && copyBtn) {
                passwordInput.addEventListener('input', updateStrength);
                generateBtn.addEventListener('click', generatePassword);
                copyBtn.addEventListener('click', copyPassword);
            }
        });
    </script>
@endsection
