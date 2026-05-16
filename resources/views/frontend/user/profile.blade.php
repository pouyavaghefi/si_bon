@extends('frontend.layouts.master')

@section('pageTitle', 'پروفایل کاربری')

@push('styles')
    <style>
        .avatar-upload-box {
            width: 100%;
            display: block;
            border: 2px dashed #cfd8e3;
            border-radius: 14px;
            background: #fff;
            padding: 28px;
            text-align: center;
            cursor: pointer;
            transition: .25s;
        }

        .avatar-upload-box:hover,
        .avatar-upload-box.dragover {
            border-color: #2196F3;
            background: #f3f9ff;
        }

        .avatar-upload-preview {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 18px rgba(0,0,0,.12);
            margin-bottom: 14px;
        }

        .avatar-upload-title {
            font-weight: 700;
            color: #333;
            margin-bottom: 6px;
        }

        .avatar-upload-text {
            color: #777;
            font-size: 13px;
        }

        .avatar-upload-input {
            display: none;
        }

        .input-prof {
            height: 48px;
            border: 1px solid #eaeaea;
            border-radius: 6px;
            background: #fff;
            padding: 0 12px;
            display: flex;
            align-items: center;
        }

        .input-prof .form-element-row {
            width: 100%;
            display: flex;
            align-items: center;
            flex-direction: row-reverse;
        }

        .input-prof label {
            margin: 0;
            padding: 0 8px 0 0;
            color: #333;
            flex: 0 0 auto;
        }

        .input-prof input,
        .input-prof select {
            width: 100%;
            height: 42px;
            border: 0;
            outline: 0;
            background: transparent;
            color: #333;
            font-size: 14px;
            padding: 0 8px;
        }

        .input-prof input::placeholder {
            color: #b8b8b8;
        }

        .Tar-As {
            width: auto !important;
            min-width: 58px;
            height: 36px;
            border: 0;
            background: transparent;
            color: #111;
        }
    </style>
@endpush

@section('wrapper')

    @php
        $user = auth()->user();
        $member = $user->member;

        $avatar = !empty($user->avatar)
            ? asset($user->avatar)
            : asset('frnt/img/user.png');

        $defaultAvatar = asset('frnt/img/user.png');

        $wallet = number_format($user->wallet ?? 0);

        $birthYear = optional($member?->birth_date)->format('Y') ?? 1404;
        $birthMonth = optional($member?->birth_date)->format('n') ?? 1;
        $birthDay = optional($member?->birth_date)->format('j') ?? 1;

        $months = [
            1 => 'فروردین',
            2 => 'اردیبهشت',
            3 => 'خرداد',
            4 => 'تیر',
            5 => 'مرداد',
            6 => 'شهریور',
            7 => 'مهر',
            8 => 'آبان',
            9 => 'آذر',
            10 => 'دی',
            11 => 'بهمن',
            12 => 'اسفند',
        ];
    @endphp

    <div class="bodymargin-shop">
        <div id="page-content" class="page-wrapper">
            <div class="shop-section mb-80">
                <div class="container">
                    <div class="row mb-5">

                        <div class="col-lg-3 col-lg-3-p col-md-12">
                            <div class="menu-1st-hid-karbar">

                                <aside class="widget-user box-shadow mb-30">
                                    <div class="profile-sidebar shadow-around">
                                        <div class="d-flex align-items-center">
                                            <div class="profile-avatar">
                                                <img src="{{ $avatar }}"
                                                     alt="{{ $user->name ?? 'کاربر' }}"
                                                     title="{{ $user->name ?? 'کاربر' }}"
                                                     onerror="this.src='{{ $defaultAvatar }}'">
                                            </div>

                                            <div class="profile-info">
                                                <div class="d-inline-block p-1">
                                                    <h6>
                                                        <strong>{{ $user->name ?? 'کاربر' }}</strong>
                                                    </h6>
                                                </div>

                                                <div class="d-inline-block">
                                                    <strong class="text-muted">{{ $user->mobile }}</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="user-options">
                                            <ul>
                                                <li>
                                                    <a href="#">
                                                        <span>موجودی حساب :</span>
                                                        <span>{{ $wallet }} <span class="text-info font-weight-bold">تومان</span></span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="mt-3 fb1">
                                                <i style="margin: 0 4px;" class="fa fa-credit-card"></i>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#comment1">افزایش موجودی</a>
                                            </div>

                                            <div class="mt-3 fb1">
                                                <i style="margin: 0 4px;" class="fa fa-cog"></i>
                                                <a href="{{ route('front.user.profile') }}">پروفایل من</a>
                                            </div>
                                        </div>
                                    </div>
                                </aside>

                                <aside class="widget-user box-shadow mb-30">
                                    <div class="profile-sidebar shadow-around">
                                        <div class="user-menu">
                                            <div class="widget-content2">
                                                <div id="jquery-accordion-menu" class="jquery-accordion-menu red">
                                                    <ul id="demo-list">
                                                        <li>
                                                            <a href="{{ route('front.user.orders') }}">
                                                                <i class="fa fa-gift"></i>
                                                                تمام سفارشات من
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('front.user.orders.new') }}">
                                                                <i class="fa fa-hourglass-start"></i>
                                                                سفارشات جدید
                                                            </a>
                                                        </li>

                                                        <li class="active">
                                                            <a href="{{ route('front.user.orders.ready') }}">
                                                                <i class="fa fa-hourglass-half"></i>
                                                                سفارشات آماده تحویل
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('front.user.orders.completed') }}">
                                                                <i class="fa fa-hourglass-end"></i>
                                                                سفارشات پایان یافته
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </aside>

                                <aside class="widget-user box-shadow mb-30">
                                    <div class="profile-sidebar shadow-around">
                                        <div class="user-menu">
                                            <div class="widget-content2">
                                                <div class="jquery-accordion-menu red">
                                                    <ul>
                                                        <li>
                                                            <a href="{{ route('front.user.finance') }}">
                                                                <i class="fa fa-calculator"></i>
                                                                موارد مالی
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('front.user.deposits') }}">
                                                                <i class="fa fa-bar-chart"></i>
                                                                واریزی ها
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('front.user.credits') }}">
                                                                <i class="fa fa-credit-card"></i>
                                                                بستانکاری
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="{{ route('front.user.cashback') }}">
                                                                <i class="fa fa-money"></i>
                                                                بازگشت وجه
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </aside>

                                <aside class="widget-user box-shadow mb-30">
                                    <div class="profile-sidebar shadow-around">
                                        <div class="user-menu user-menu2">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('front.user.comments') }}" class="userlink userlink2">
                                                        <i class="fa fa-comment-o"></i>
                                                        نظرات
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ route('front.user.addresses') }}" class="userlink userlink2">
                                                        <i class="fa fa-map-marker"></i>
                                                        نشانی ها
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ route('front.user.tickets') }}" class="userlink userlink2">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                        تیکت پشتیبانی
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ route('front.user.password') }}" class="userlink userlink2">
                                                        <i class="fa fa-user-o"></i>
                                                        تغییر پسورد
                                                    </a>
                                                </li>

                                                <li>
                                                    <form action="{{ route('auth.logout') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="userlink userlink2 border-0 bg-transparent p-0">
                                                            <i class="fa fa-sign-out"></i>
                                                            خروج
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </aside>

                            </div>
                        </div>

                        <div class="col-lg-9 col-lg-9-p col-md-12">
                            <div class="shop-content">
                                <div class="tab-content body-user">

                                    <p class="onvanuser">پروفایل من</p>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">

                                                    <section class="shadow-around marginpro p-3" style="background: #f4f4f4;margin-right: -3px;">
                                                        @if($errors->any())
                                                            <div class="alert alert-danger mb-4">
                                                                <ul class="mb-0">
                                                                    @foreach($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif

                                                        <form class="montform"
                                                              id="sendform"
                                                              action="{{ route('front.user.profile.update') }}"
                                                              enctype="multipart/form-data"
                                                              method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="row" style="margin: 20px auto;">

                                                                <div class="col-lg-3 mt-0 mb-4">
                                                                    <div class="text-sm text-muted mb-2 mt-1">نام و نام خانوادگی / نام شرکت :</div>

                                                                    <div class="text-dark input-prof font-weight-bold">
                                                                        <div class="form-element-row mb-0">
                                                                            <label><i class="fa fa-user"></i></label>

                                                                            <input class="input-element"
                                                                                   type="text"
                                                                                   name="name"
                                                                                   placeholder="نام / عنوان"
                                                                                   value="{{ old('name', $user->name) }}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 mb-4">
                                                                    <div class="text-sm text-muted mb-2 mt-1">کد ملی / کد اقتصادی :</div>

                                                                    <div class="text-dark input-prof font-weight-bold">
                                                                        <div class="form-element-row mb-0">
                                                                            <label><i class="fa fa-id-card"></i></label>

                                                                            <input class="input-element"
                                                                                   type="text"
                                                                                   name="code_meli"
                                                                                   value="{{ old('code_meli', $member->national_code ?? '') }}"
                                                                                   placeholder="کد ملی / کد اقتصادی">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 mb-4">
                                                                    <div class="text-sm text-muted mb-2 mt-1">پست الكترونيك :</div>

                                                                    <div class="text-dark input-prof font-weight-bold">
                                                                        <div class="form-element-row mb-0">
                                                                            <label><i class="fa fa-envelope"></i></label>

                                                                            <input class="input-element"
                                                                                   type="email"
                                                                                   name="email"
                                                                                   value="{{ old('email', $user->email) }}"
                                                                                   placeholder="ایمیل">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 mb-4">
                                                                    <div class="text-sm text-muted mb-2 mt-1">شماره تلفن ثابت:</div>

                                                                    <div class="text-dark input-prof font-weight-bold">
                                                                        <div class="form-element-row mb-0">
                                                                            <label><i class="fa fa-fax"></i></label>

                                                                            <input class="input-element"
                                                                                   type="text"
                                                                                   name="base_phone"
                                                                                   value="{{ old('base_phone', $member->phone ?? '') }}"
                                                                                   placeholder="شماره ثابت">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 mb-4">
                                                                    <div class="text-sm text-muted mb-2 mt-1">شغل:</div>

                                                                    <div class="text-dark input-prof font-weight-bold">
                                                                        <div class="form-element-row mb-0">
                                                                            <label><i class="fa fa-id-card"></i></label>

                                                                            <input type="text"
                                                                                   placeholder="شغل"
                                                                                   class="input-element"
                                                                                   name="job"
                                                                                   value="{{ old('job', $member->job ?? '') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 mb-4">
                                                                    <div class="text-sm text-muted mb-2 mt-1">روش بازگشت وجه:</div>

                                                                    <div class="text-dark input-prof font-weight-bold">
                                                                        <div class="form-element-row mb-0">
                                                                            <label><i class="fa fa-credit-card-alt"></i></label>

                                                                            <input type="text"
                                                                                   placeholder="شماره کارت یا شبا"
                                                                                   class="input-element"
                                                                                   name="refund"
                                                                                   value="{{ old('refund', $member->refund ?? '') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 mb-4">
                                                                    <div class="text-sm text-muted mb-2 mt-1">تاریخ تولد / تاریخ ثبت شرکت :</div>

                                                                    <div class="text-dark input-prof font-weight-bold">
                                                                        <div class="form-element-row mb-0">
                                                                            <label><i class="fa fa-id-card"></i></label>

                                                                            <select name="day" class="Tar-As">
                                                                                @for($day = 1; $day <= 31; $day++)
                                                                                    <option value="{{ $day }}" {{ old('day', $birthDay) == $day ? 'selected' : '' }}>
                                                                                        {{ $day }}
                                                                                    </option>
                                                                                @endfor
                                                                            </select>

                                                                            <select name="month" class="Tar-As">
                                                                                @foreach($months as $monthNumber => $monthName)
                                                                                    <option value="{{ $monthNumber }}" {{ old('month', $birthMonth) == $monthNumber ? 'selected' : '' }}>
                                                                                        {{ $monthName }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>

                                                                            <select name="year" class="Tar-As">
                                                                                @for($year = 1404; $year >= 1300; $year--)
                                                                                    <option value="{{ $year }}" {{ old('year', $birthYear) == $year ? 'selected' : '' }}>
                                                                                        {{ $year }}
                                                                                    </option>
                                                                                @endfor
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 mb-4 pt-5">
                                                                    <label class="labelform">
                                                                    <span style="margin: 5px 4px;float: right;">
                                                                        دريافت خبرنامه :
                                                                    </span>

                                                                        <label class="switch">
                                                                            <input type="checkbox"
                                                                                   name="messaging"
                                                                                   value="1"
                                                                                {{ old('messaging', $member->newsletter ?? false) ? 'checked' : '' }}>

                                                                            <span class="slider round"></span>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                                <div class="col-12 mt-4">
                                                                    <label class="avatar-upload-box" id="avatarDropBox">
                                                                        <img src="{{ $avatar }}"
                                                                             class="avatar-upload-preview"
                                                                             id="avatarPreview"
                                                                             alt="avatar"
                                                                             onerror="this.src='{{ $defaultAvatar }}'">

                                                                        <div class="avatar-upload-title">
                                                                            تصویر پروفایل خود را اینجا بکشید یا انتخاب کنید
                                                                        </div>

                                                                        <div class="avatar-upload-text">
                                                                            فرمت مجاز: JPG, PNG, WEBP — حداکثر ۲ مگابایت
                                                                        </div>

                                                                        <input type="file"
                                                                               name="avatar"
                                                                               id="avatarInput"
                                                                               class="avatar-upload-input"
                                                                               accept="image/*">
                                                                    </label>
                                                                </div>

                                                                <div class="col-12 mt-4">
                                                                    <div class="form-element-row text-center">
                                                                        <div class="b-karbar">
                                                                            <button type="submit" class="btn btn-lg">
                                                                                <span>ذخیره اطلاعات</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </form>
                                                    </section>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="comment1" tabindex="-1">
            <div style="top: 19%;" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>افزایش موجودی</h4>

                        <button style="position: absolute;left: 14px;background-color: #9b9b9b;font-size: 12px;"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('front.user.wallet.deposit') }}" method="POST">
                            @csrf

                            <input type="text"
                                   name="amount"
                                   placeholder="مبلغ : 0 ریال"
                                   required>

                            <input class="btn-color" type="submit" value="پرداخت">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'موفقیت',
            text: @json(session('success')),
            confirmButtonText: 'باشه'
        });
        @endif

        @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'خطا در اطلاعات',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonText: 'باشه'
        });
        @endif

        const avatarDropBox = document.getElementById('avatarDropBox');
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');

        function previewAvatar(file) {
            if (!file || !file.type.startsWith('image/')) {
                Swal.fire({
                    icon: 'error',
                    title: 'فایل نامعتبر',
                    text: 'لطفا فقط تصویر انتخاب کنید.',
                    confirmButtonText: 'باشه'
                });

                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                avatarPreview.src = event.target.result;
            };

            reader.readAsDataURL(file);
        }

        avatarInput?.addEventListener('change', function () {
            previewAvatar(this.files[0]);
        });

        avatarDropBox?.addEventListener('dragover', function (event) {
            event.preventDefault();
            event.stopPropagation();
            avatarDropBox.classList.add('dragover');
        });

        avatarDropBox?.addEventListener('dragleave', function (event) {
            event.preventDefault();
            event.stopPropagation();
            avatarDropBox.classList.remove('dragover');
        });

        avatarDropBox?.addEventListener('drop', function (event) {
            event.preventDefault();
            event.stopPropagation();

            avatarDropBox.classList.remove('dragover');

            const file = event.dataTransfer.files[0];

            if (!file) {
                return;
            }

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            avatarInput.files = dataTransfer.files;

            previewAvatar(file);
        });

        document.addEventListener('dragover', function (event) {
            event.preventDefault();
        });

        document.addEventListener('drop', function (event) {
            event.preventDefault();
        });
    </script>
@endpush
