@extends('admin.layouts.master')

@section('pageTitle','تنظیمات سایت')

@section('wrapper')
    <div class="container-fluid" dir="rtl">
        @php
            $config = $config ?? null;
        @endphp

        <style>
            .settings-logo-box {
                width: 110px;
                height: 110px;
                border-radius: 20px;
                overflow: hidden;
                border: 1px dashed #d1d5db;
                background: #f8fafc;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: auto;
            }

            .settings-logo-box img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .settings-section-title {
                font-size: 15px;
                font-weight: 700;
                margin-bottom: 0;
            }

            .settings-card {
                border: 0;
                box-shadow: 0 2px 10px rgba(0,0,0,.04);
            }

            .settings-card .card-header {
                background: #fff;
            }

            .site-preview-box {
                background: linear-gradient(135deg, #111827, #1f2937);
                border-radius: 18px;
                padding: 30px;
                color: #fff;
                position: relative;
                overflow: hidden;
            }

            .site-preview-box::before {
                content: "";
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at top left, rgba(255,255,255,.12), transparent 40%);
            }
        </style>

        @if(session('success'))
            <div class="alert alert-success text-end">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger text-end">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-12">
                <div class="site-preview-box">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">
                        <div>
                            <span class="badge bg-light text-dark mb-3">تنظیمات کلی وبسایت</span>

                            <h2 class="fw-bold mb-2">
                                {{ $config->site_name ?? 'مدیریت اطلاعات و هویت سایت' }}
                            </h2>

                            <p class="mb-0 text-white-50">
                                {{ $config->site_description ?? 'اطلاعات اصلی وبسایت، سئو، لوگو و شبکه‌های اجتماعی را مدیریت کنید.' }}
                            </p>
                        </div>

                        <div class="text-center">
                            <div class="avatar avatar-xl bg-white text-dark rounded-circle">
                                <div class="avatar-title">
                                    <i data-lucide="settings-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.config.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-xxl-8">

                    <div class="card settings-card mb-4">
                        <div class="card-header border-dashed">
                            <h4 class="settings-section-title">اطلاعات اصلی سایت</h4>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">عنوان سایت</label>
                                    <input type="text"
                                           name="site_name"
                                           class="form-control"
                                           value="{{ old('site_name', $config->site_name ?? '') }}"
                                           placeholder="عنوان سایت">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">دامنه سایت</label>
                                    <input type="text"
                                           name="site_url"
                                           class="form-control"
                                           value="{{ old('site_url', $config->site_url ?? '') }}"
                                           placeholder="https://example.com">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">ایمیل مدیریت</label>
                                    <input type="email"
                                           name="admin_email"
                                           class="form-control"
                                           value="{{ old('admin_email', $config->admin_email ?? '') }}"
                                           placeholder="admin@example.com">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">شماره تماس</label>
                                    <input type="text"
                                           name="phone"
                                           class="form-control"
                                           value="{{ old('phone', $config->phone ?? '') }}"
                                           placeholder="شماره تماس">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">توضیح کوتاه سایت</label>
                                    <textarea name="site_description"
                                              rows="4"
                                              class="form-control"
                                              placeholder="توضیح کوتاه درباره سایت">{{ old('site_description', $config->site_description ?? '') }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card settings-card mb-4">
                        <div class="card-header border-dashed">
                            <h4 class="settings-section-title">تنظیمات سئو</h4>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-12">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text"
                                           name="meta_title"
                                           class="form-control"
                                           value="{{ old('meta_title', $config->meta_title ?? '') }}"
                                           placeholder="عنوان سئو سایت">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text"
                                           name="meta_keywords"
                                           class="form-control"
                                           value="{{ old('meta_keywords', $config->meta_keywords ?? '') }}"
                                           placeholder="کلمات کلیدی را با , جدا کنید">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description"
                                              rows="4"
                                              class="form-control"
                                              placeholder="توضیحات سئو">{{ old('meta_description', $config->meta_description ?? '') }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card settings-card">
                        <div class="card-header border-dashed">
                            <h4 class="settings-section-title">شبکه‌های اجتماعی</h4>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Instagram</label>
                                    <input type="text"
                                           name="instagram"
                                           class="form-control"
                                           value="{{ old('instagram', $config->instagram ?? '') }}"
                                           placeholder="Instagram URL">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Telegram</label>
                                    <input type="text"
                                           name="telegram"
                                           class="form-control"
                                           value="{{ old('telegram', $config->telegram ?? '') }}"
                                           placeholder="Telegram URL">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text"
                                           name="linkedin"
                                           class="form-control"
                                           value="{{ old('linkedin', $config->linkedin ?? '') }}"
                                           placeholder="LinkedIn URL">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">YouTube</label>
                                    <input type="text"
                                           name="youtube"
                                           class="form-control"
                                           value="{{ old('youtube', $config->youtube ?? '') }}"
                                           placeholder="YouTube URL">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xxl-4">

                    <div class="card settings-card mb-4">
                        <div class="card-header border-dashed">
                            <h4 class="settings-section-title">لوگوی سایت</h4>
                        </div>

                        <div class="card-body text-center">
                            <div class="settings-logo-box mb-3">
                                <img src="{{ !empty($config?->site_logo) ? asset($config->site_logo) : asset('/adm/img/admin.png') }}"
                                     alt="logo-preview">
                            </div>

                            <input type="file"
                                   name="site_logo"
                                   class="form-control"
                                   accept="image/*">

                            <small class="text-muted d-block mt-2">
                                فرمت‌های مجاز: PNG, JPG, WEBP
                            </small>
                        </div>
                    </div>

                    <div class="card settings-card mb-4">
                        <div class="card-header border-dashed">
                            <h4 class="settings-section-title">وضعیت سایت</h4>
                        </div>

                        <div class="card-body">

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="site_status"
                                       value="1"
                                       id="siteStatus"
                                    {{ old('site_status', $config->site_status ?? 1) ? 'checked' : '' }}>

                                <label class="form-check-label" for="siteStatus">
                                    فعال بودن سایت
                                </label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="maintenance_mode"
                                       value="1"
                                       id="maintenanceMode"
                                    {{ old('maintenance_mode', $config->maintenance_mode ?? 0) ? 'checked' : '' }}>

                                <label class="form-check-label" for="maintenanceMode">
                                    حالت تعمیرات
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="card settings-card">
                        <div class="card-header border-dashed">
                            <h4 class="settings-section-title">ذخیره تنظیمات</h4>
                        </div>

                        <div class="card-body">
                            <div class="alert alert-light border text-end mb-4">
                                پس از ذخیره تنظیمات، تغییرات به صورت مستقیم روی سایت اعمال خواهد شد.
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2">
                                    ذخیره تنظیمات سایت
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
@endsection
