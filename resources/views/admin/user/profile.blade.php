@extends('admin.layouts.master')

@section('pageTitle','پروفایل مدیریت')

@section('wrapper')
    <div class="container-fluid" dir="rtl">
        @php
            $admin = auth()->user();
        @endphp

        <style>
            .profile-avatar-wrapper {
                display: flex;
                justify-content: center;
            }

            .profile-avatar-box {
                position: relative;
                width: 120px;
                height: 120px;
            }

            .profile-avatar-image {
                width: 120px;
                height: 120px;
                object-fit: cover;
                border-radius: 50%;
                border: 4px solid #fff;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
                background: #f8f9fa;
            }

            .profile-avatar-edit-btn {
                position: absolute;
                bottom: 4px;
                right: 4px;
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: #111827;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                transition: .2s ease;
                box-shadow: 0 4px 12px rgba(0, 0, 0, .18);
            }

            .profile-avatar-edit-btn:hover {
                background: #000;
                color: #fff;
                transform: scale(1.08);
            }

            .profile-avatar-edit-btn i {
                width: 16px;
                height: 16px;
            }
        </style>

        <div class="row">
            <div class="col-xxl-4 col-lg-5">
                <div class="card">
                    <div class="card-body text-center">

                        <div class="profile-avatar-wrapper mb-3">
                            <div class="profile-avatar-box">
                                <img src="{{ $admin->avatar ? asset($admin->avatar) : asset('/adm/img/admin.png') }}"
                                     class="profile-avatar-image"
                                     alt="admin-avatar">

                                <a href="{{ route('admin.profile') }}"
                                   class="profile-avatar-edit-btn"
                                   title="ویرایش تصویر پروفایل">
                                    <i data-lucide="camera"></i>
                                </a>
                            </div>
                        </div>

                        <h4 class="mb-1">{{ $admin->name ?? 'مدیر سیستم' }}</h4>

                        <span class="badge bg-success-subtle text-success mb-3">
                            مدیر فعال
                        </span>

                        <p class="text-muted mb-4">
                            حساب کاربری مدیریت سایت
                        </p>

                        <div class="row text-center border-top pt-3">
                            <div class="col-4">
                                <h5 class="mb-1">{{ $admin->id }}</h5>
                                <small class="text-muted">شناسه</small>
                            </div>

                            <div class="col-4">
                                <h5 class="mb-1">{{ $admin->is_admin ? 'بله' : 'خیر' }}</h5>
                                <small class="text-muted">ادمین</small>
                            </div>

                            <div class="col-4">
                                <h5 class="mb-1">{{ $admin->is_active ? 'فعال' : 'غیرفعال' }}</h5>
                                <small class="text-muted">وضعیت</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xxl-8 col-lg-7">
                <div class="card">
                    <div class="card-header border-dashed">
                        <h4 class="card-title mb-0">اطلاعات حساب کاربری</h4>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="text-muted mb-1">نام کاربری</label>
                                <div class="fw-semibold">{{ $admin->name ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted mb-1">ایمیل</label>
                                <div class="fw-semibold">{{ $admin->email ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted mb-1">موبایل</label>
                                <div class="fw-semibold">{{ $admin->mobile ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted mb-1">تاریخ ساخت حساب</label>
                                <div class="fw-semibold">
                                    {{ $admin->created_at ? $admin->created_at->format('Y-m-d H:i') : '-' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted mb-1">آخرین بروزرسانی</label>
                                <div class="fw-semibold">
                                    {{ $admin->updated_at ? $admin->updated_at->format('Y-m-d H:i') : '-' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted mb-1">تایید ایمیل</label>
                                <div class="fw-semibold">
                                    {{ $admin->email_verified_at ? 'تایید شده' : 'تایید نشده' }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">

            <div class="col">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="text-uppercase mb-3">وضعیت ورود</h5>
                                <h3 class="mb-1 fw-normal">آنلاین</h3>
                                <p class="text-muted mb-0">نشست فعلی فعال است</p>
                            </div>
                            <i data-lucide="wifi" class="text-success fs-24"></i>
                        </div>
                    </div>

                    <div class="card-footer text-muted text-center">
                        ورود موفق به پنل مدیریت
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="text-uppercase mb-3">سطح دسترسی</h5>
                                <h3 class="mb-1 fw-normal">مدیر کل</h3>
                                <p class="text-muted mb-0">دسترسی کامل مدیریتی</p>
                            </div>
                            <i data-lucide="shield-check" class="text-primary fs-24"></i>
                        </div>
                    </div>

                    <div class="card-footer text-muted text-center">
                        مجوز مدیریت فعال است
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="text-uppercase mb-3">اعلان‌ها</h5>
                                <h3 class="mb-1 fw-normal">
                                    {{ $admin->unreadNotifications->count() }}
                                </h3>
                                <p class="text-muted mb-0">اعلان خوانده‌نشده</p>
                            </div>
                            <i data-lucide="bell" class="text-warning fs-24"></i>
                        </div>
                    </div>

                    <div class="card-footer text-muted text-center">
                        مرکز اعلان‌های حساب
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="text-uppercase mb-3">امنیت حساب</h5>
                                <h3 class="mb-1 fw-normal">ایمن</h3>
                                <p class="text-muted mb-0">رمز عبور فعال است</p>
                            </div>
                            <i data-lucide="lock-keyhole" class="text-danger fs-24"></i>
                        </div>
                    </div>

                    <div class="card-footer text-muted text-center">
                        حساب محافظت شده است
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xxl-6">
                <div class="card">
                    <div class="card-header border-dashed">
                        <h4 class="card-title mb-0">جزئیات ورود</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-centered table-custom mb-0">
                                <tbody>
                                <tr>
                                    <td class="text-muted">آی‌پی فعلی</td>
                                    <td class="text-end fw-semibold">{{ request()->ip() }}</td>
                                </tr>

                                <tr>
                                    <td class="text-muted">مرورگر / دستگاه</td>
                                    <td class="text-end fw-semibold">
                                        {{ Str::limit(request()->userAgent(), 45) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">زمان مشاهده صفحه</td>
                                    <td class="text-end fw-semibold">{{ now()->format('Y-m-d H:i') }}</td>
                                </tr>

                                <tr>
                                    <td class="text-muted">وضعیت نشست</td>
                                    <td class="text-end">
                                        <span class="badge bg-success-subtle text-success">فعال</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-6">
                <div class="card">
                    <div class="card-header border-dashed">
                        <h4 class="card-title mb-0">فعالیت‌های اخیر</h4>
                    </div>

                    <div class="card-body">

                        <div class="d-flex gap-3 mb-4">
                            <span class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success-subtle text-success rounded-circle">
                                    <i data-lucide="log-in"></i>
                                </span>
                            </span>

                            <div>
                                <h6 class="mb-1">ورود موفق به پنل مدیریت</h6>
                                <p class="text-muted mb-0 small">همین حالا</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <span class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                    <i data-lucide="user-check"></i>
                                </span>
                            </span>

                            <div>
                                <h6 class="mb-1">بررسی اطلاعات حساب کاربری</h6>
                                <p class="text-muted mb-0 small">امروز</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <span class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle text-warning rounded-circle">
                                    <i data-lucide="bell"></i>
                                </span>
                            </span>

                            <div>
                                <h6 class="mb-1">اعلان خوش‌آمدگویی ایجاد شد</h6>
                                <p class="text-muted mb-0 small">اولین ورود مدیر به داشبورد</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
