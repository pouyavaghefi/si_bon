<header class="page-header">
    <div style="padding: 0; max-width: 100%;" class="container">

        <div class="bottom-page-header">
            <div class="d-flex align-items-center">

                <div class="user-items">

                    <div class="user-item cart-list">

                        <div data-toggle="modal" data-target="#modal-search" class="ps-cart">
                            <a data-bs-toggle="modal" data-bs-target="#SearchModal" class="ps-cart__toggle" href="#">
                                <i style="color:#ffffff;font-size:20px;position:relative;top:-4px;left:10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                                    </svg>
                                </i>
                            </a>
                        </div>

                        <div style="float:right;" class="col-md-2 col-sm-6 col-xs-12">
                            <div class="search-top-cart f-right">
                                <div class="total-cart f-right">
                                    <div class="total-cart-in">

                                        <div class="cart-toggler">
                                            <a href="{{ route('front.cart.index') }}">
                                                <span class="cart-quantity">{{ $cartCount ?? 0 }}</span>
                                                <br>
                                                <span class="cart-icon">
                                                    <img src="{{ asset('theme/images/cart.svg') }}" style="max-width:250%;" alt="cart">
                                                </span>
                                            </a>
                                        </div>

                                        <ul>
                                            <li>
                                                <div class="top-cart-inner your-cart">
                                                    <h5 class="text-capitalize">خریدهای شما</h5>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="total-cart-pro">

                                                    @forelse(($cartItems ?? []) as $key => $item)
                                                        <div class="single-cart clearfix">

                                                            <div class="cart-img f-right">
                                                                <a href="#">
                                                                    <img src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : asset('theme/image/624.jpg') }}"
                                                                         alt="{{ $item['title'] ?? $item['name'] ?? 'محصول' }}">
                                                                </a>
                                                            </div>

                                                            <div class="cart-info f-right">

                                                                <h6 class="text-capitalize">
                                                                    <a href="#" class="carttitle">
                                                                        {{ $item['title'] ?? $item['name'] ?? 'محصول' }}
                                                                    </a>

                                                                    <div class="del-icon del-icon-cart">
                                                                        <form action="{{ route('front.cart.remove', $key) }}" method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')

                                                                            <button type="submit" style="border:none;background:none;padding:0;color:inherit;">
                                                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                                <span class="d-cart">حذف</span>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </h6>

                                                                @if(!empty($item['type']))
                                                                    <p style="padding:0 4px;">
                                                                        <span>نوع محصول</span>
                                                                        <strong>:</strong>
                                                                        {{ $item['type'] === 'print' ? 'چاپی' : 'تکی' }}
                                                                    </p>
                                                                @endif

                                                                @if(!empty($item['width']) && !empty($item['height']))
                                                                    <p style="padding:0 4px;">
                                                                        <span>ابعاد</span>
                                                                        <strong>:</strong>
                                                                        {{ $item['width'] }} × {{ $item['height'] }}
                                                                    </p>
                                                                @endif

                                                                @if(!empty($item['area']))
                                                                    <p style="padding:0 4px;">
                                                                        <span>متراژ</span>
                                                                        <strong>:</strong>
                                                                        {{ $item['area'] }}
                                                                    </p>
                                                                @endif

                                                                <p style="padding:0 4px;">
                                                                    <span>تعداد</span>
                                                                    <strong>:</strong>
                                                                    {{ $item['quantity'] ?? $item['qty'] ?? 1 }} عدد
                                                                </p>

                                                                @if(!empty($item['options']))
                                                                    <p style="padding:0 4px;">
                                                                        <span>گزینه‌ها</span>
                                                                        <strong>:</strong>
                                                                        @if(is_array($item['options']))
                                                                            {{ implode(' ، ', $item['options']) }}
                                                                        @else
                                                                            {{ $item['options'] }}
                                                                        @endif
                                                                    </p>
                                                                @endif

                                                                @if(!empty($item['services']))
                                                                    <p style="padding:0 4px;">
                                                                        <span>خدمات</span>
                                                                        <strong>:</strong>
                                                                        @if(is_array($item['services']))
                                                                            {{ implode(' ، ', $item['services']) }}
                                                                        @else
                                                                            {{ $item['services'] }}
                                                                        @endif
                                                                    </p>
                                                                @endif

                                                                <p style="padding:0 4px;">
                                                                    <span>مبلغ</span>
                                                                    <strong>:</strong>
                                                                    <span style="color:#e30000;padding:0;">
                                                                        {{ number_format($item['total'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? $item['qty'] ?? 1))) }}
                                                                        تومان
                                                                    </span>
                                                                </p>

                                                            </div>

                                                        </div>
                                                    @empty
                                                        <div style="padding:20px;text-align:center;">
                                                            سبد خرید شما خالی است.
                                                        </div>
                                                    @endforelse

                                                </div>
                                            </li>

                                            @if(count($cartItems ?? []))
                                                <li>
                                                    <div class="top-cart-inner subtotal">
                                                        <h4 class="text-uppercase g-font-2">
                                                            جمع کل =
                                                            <span>{{ number_format($cartTotal ?? 0) }} تومان</span>
                                                        </h4>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="top-cart-inner view-cart">
                                                        <h4 class="text-uppercase View-cart-hana">
                                                            <a href="{{ route('front.cart.index') }}">مشاهده سبد خرید</a>
                                                        </h4>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div style="margin-bottom:15px;" class="top-cart-inner check-out">
                                                        <h4 class="text-uppercase View-cart-hana">
                                                            <a href="#">پرداخت</a>
                                                        </h4>
                                                    </div>
                                                </li>
                                            @endif

                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="user-item pl-1 pr-1">
                        <a href="#">
                            <div class="language">
                                <ul class="language-lr">
                                    <li class="nav-item-language">
                                        <img src="{{ asset('theme/images/fa.jpg') }}" alt="fa">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>

                                        <div class="dropdown-menu">
                                            <ul>
                                                <li class="dropdown-menu-item">
                                                    <a href="#" class="dropdown-item">
                                                        <img style="width:38px;padding:0 4px;margin-left:6px;" src="{{ asset('theme/images/fa.jpg') }}" alt="fa">
                                                        فارسی
                                                    </a>
                                                </li>

                                                <li class="dropdown-menu-item">
                                                    <a href="#" class="dropdown-item">
                                                        <img src="{{ asset('theme/images/en.jpg') }}" style="width:38px;padding:0 4px;margin-left:6px;" alt="en">
                                                        انگلیسی
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </a>
                    </div>

                    <div class="user-item account">
                        <a href="#" class="btn-auth">
                            <span style="font-size:22px;margin-top:7px;color:#6a6a6a;" class="pc-user-mobile">
                                <span class="fa fa-user-o"></span>
                            </span>

                            <div class="pc-user-pc">
                                @auth
                                    {{ auth()->user()->name ?? explode('@', auth()->user()->email)[0] }}
                                @else
                                    ورود
                                    <svg style="margin-top:2px;transform:rotate(90deg)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8Z"></path>
                                    </svg>
                                    عضویت
                                @endauth
                            </div>
                        </a>

                        <ul class="dropdown--wrapper">

                            @auth
                                <li class="header-profile-dropdown-account-container">
                                    <a href="{{ url('/user/profile') }}" class="d-block">

                                        <div class="header-profile-dropdown-user">
                                            @php
                                                $headerAvatar = !empty(auth()->user()->avatar)
                                                    ? asset(auth()->user()->avatar)
                                                    : asset('theme/images/avatar/user.jpg');
                                            @endphp

                                            <span class="header-profile-dropdown-user-img">
                                                <img src="{{ $headerAvatar }}"
                                                     alt="{{ auth()->user()->name ?? 'user' }}"
                                                     onerror="this.src='{{ asset('theme/images/avatar/user.jpg') }}'">
                                            </span>

                                            <div class="header-profile-dropdown-user-info">
                                                <p class="header-profile-dropdown-user-name">
                                                    {{ auth()->user()->name ?? auth()->user()->email }}
                                                </p>

                                                <span class="header-profile-dropdown-user-profile-link">
                                                    مشاهده حساب کاربری
                                                </span>
                                            </div>
                                        </div>

                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('user/orders') }}">سفارشات من</a>
                                </li>

                                <li>
                                    <a href="{{ url('user/profile') }}">پروفایل من</a>
                                </li>

                                <li>
                                    <a href="{{ url('user/orders/tracking') }}">پیگیری سفارش</a>
                                </li>

                                <li>
                                    <form action="{{ route('auth.logout') }}" method="POST">
                                        @csrf

                                        <button type="submit" class="dropdown--btn-primary border-0 bg-transparent" style="color:black">
                                            خروج از حساب کاربری
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('auth.login') }}" class="dropdown--btn-primary">
                                        وارد شوید
                                    </a>
                                </li>

                                <li>
                                    <span>کاربر جدید هستید؟</span>
                                    <a href="{{ route('auth.register') }}" class="border-bottom-dt">
                                        ثبت نام
                                    </a>
                                </li>
                            @endauth

                        </ul>
                    </div>

                </div>

                <div class="search-box search-box-pc">
                    <form action="{{ route('front.shop.categories') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="نام محصول یا برند را جستجو کنید...">
                        <i>
                            <svg style="color:#c3c1c1;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                            </svg>
                        </i>
                    </form>

                    <div class="search-result">
                        <ul class="search-result-list">
                            <li>
                                <a href="#">
                                    <img src="{{ asset('theme/images/2-color.jpg') }}" alt="alt-images">
                                    چاپ استیکر
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="pic-1" src="{{ asset('theme/images/2-color-2.jpg---5f3fb80ae20ab.jpg') }}" alt="alt-images">
                                    چاپ مش
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="pic-1" src="{{ asset('theme/images/2-color.jpg') }}" alt="alt-images">
                                    چاپ شبرنگ
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="pic-1" src="{{ asset('theme/images/2-color-2.jpg---5f3fb80ae20ab.jpg') }}" alt="alt-images">
                                    چاپ کاغذ دیواری
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('front.shop.categories') }}" style="color:#f10000;border:none;">
                                    نمایش بیشتر...
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="contact-list dis-non-mobile">
                <ul>
                    <li>
                        <a href="tel:02177638179" style="color:#717171;">تلفن : 02177638179</a>
                    </li>
                </ul>
            </div>

            <div class="site-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('theme/images/logo.svg.svg') }}" alt="logo">
                </a>
            </div>

        </div>

        <div class="site-mobile-menu">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="js-menu-toggle">
                        <svg style="color:rgb(255,0,0);" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="site-mobile-menu-body"></div>
        </div>

        <div class="nav-wrapper">

            <div style="color:black;position:absolute;right:20px;z-index:1666;" class="site-navigation position-relative text-md-right" role="navigation">
                <div class="d-inline-block ml-md-0 mr-auto py-2">
                    <a href="#" style="color:black;" class="site-menu-toggle js-menu-toggle">
                        <span class="h3">
                            <svg style="color:#FFFFFF;" xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </span>
                    </a>
                </div>

                <ul class="site-menu js-clone-nav d-none">
                    <li class="has-children">
                        <a href="{{ url('/') }}">Home</a>
                        <ul class="dropdown arrow-top">
                            <li><a href="{{ url('/') }}">صفحه اصلی</a></li>
                            <li><a href="{{ route('front.shop.categories') }}">محصولات</a></li>
                            <li><a href="{{ url('contact') }}">تماس با ما</a></li>
                        </ul>
                    </li>

                    <li class="active">
                        <a href="{{ url('about') }}">About</a>
                    </li>

                    <li>
                        <a href="{{ url('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>

            <ul class="category-list-main">
                <li>
                    <a href="{{ route('front.shop.categories') }}">
                        <span>
                            <svg style="transform:rotate(45deg);margin-left:6px;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-x-diamond-fill" viewBox="0 0 16 16">
                                <path d="M9.05.435c-.58-.58-1.52-.58-2.1 0L4.047 3.339 8 7.293l3.954-3.954L9.049.435zm3.61 3.611L8.708 8l3.954 3.954 2.904-2.905c.58-.58.58-1.519 0-2.098l-2.904-2.905zm-.706 8.614L8 8.708l-3.954 3.954 2.905 2.904c.58.58 1.519.58 2.098 0l2.905-2.904zm-8.614-.706L7.292 8 3.339 4.046.435 6.951c-.58.58-.58 1.519 0 2.098l2.904 2.905z"/>
                            </svg>
                        </span>
                        محصولات
                    </a>

                    <ul>
                        @forelse(($frontendCategories ?? []) as $category)
                            <li>
                                <a href="{{ route('front.shop.category', $category->slug) }}">
                                    {{ $category->title }}
                                </a>

                                @if($category->children->count())
                                    <ul>
                                        @foreach($category->children as $child)
                                            <li>
                                                <a href="{{ route('front.shop.category', $child->slug) }}">
                                                    {{ $child->title }}
                                                </a>

                                                @if($child->children->count())
                                                    <ul>
                                                        @foreach($child->children as $subChild)
                                                            <li>
                                                                <a href="{{ route('front.shop.category', $subChild->slug) }}">
                                                                    {{ $subChild->title }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                            </li>
                        @empty
                            <li>
                                <a href="#">چاپ Out door</a>
                                <ul>
                                    <li>
                                        <a href="#">چاپ اکوسالونت</a>
                                        <ul>
                                            <li><a href="#">چاپ استیکر</a></li>
                                            <li><a href="#">چاپ مش</a></li>
                                            <li><a href="#">چاپ سولیت</a></li>
                                            <li><a href="#">چاپ کاغذ دیواری</a></li>
                                            <li><a href="#">چاپ پرده شید</a></li>
                                            <li><a href="#">چاپ شبرنگ</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#">چاپ Indoor</a>
                                <ul>
                                    <li>
                                        <a href="#">چاپ کتد و لمینت</a>
                                        <ul>
                                            <li><a href="#">شاسی ساعت دار</a></li>
                                            <li><a href="#">چاپ فوم برد</a></li>
                                            <li><a href="#">چاپ بک لایت</a></li>
                                            <li><a href="#">چاپ گلاسه</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#">برچسب های تزیینی شیشه</a>
                            </li>
                        @endforelse
                    </ul>
                </li>
            </ul>

            <div class="main-menu2 mean-menu2">
                <ul>
                    <li>
                        <a class="link-amenu" href="{{ url('/') }}">صفحه اصلی</a>
                    </li>

                    <li>
                        <a class="link-amenu" href="{{ route('front.shop.categories') }}">
                            محصولات
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>

                        <ul>
                            @forelse(($frontendCategories ?? []) as $category)
                                <li>
                                    <a href="{{ route('front.shop.category', $category->slug) }}">
                                        {{ $category->title }}

                                        @if($category->children->count())
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        @endif
                                    </a>

                                    @if($category->children->count())
                                        <ul>
                                            @foreach($category->children as $child)
                                                <li>
                                                    <a href="{{ route('front.shop.category', $child->slug) }}">
                                                        {{ $child->title }}

                                                        @if($child->children->count())
                                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                        @endif
                                                    </a>

                                                    @if($child->children->count())
                                                        <ul>
                                                            @foreach($child->children as $subChild)
                                                                <li>
                                                                    <a href="{{ route('front.shop.category', $subChild->slug) }}">
                                                                        {{ $subChild->title }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif

                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                </li>
                            @empty
                                <li>
                                    <a href="#">چاپ استیکر <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                    <ul>
                                        <li><a href="#">چاپ استیکر فروشگاه‌ها</a></li>
                                        <li><a href="#">چاپ روی کامیون و خودرو</a></li>
                                        <li><a href="#">برچسب تردد و عوارض خودرو</a></li>
                                        <li><a href="#">چاپ و برش استیکر</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#">چاپ مش <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                    <ul>
                                        <li><a href="#">چاپ مش پشت چسبدار</a></li>
                                        <li><a href="#">چاپ مش بدون چسب</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#">شیشه مات کن <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                    <ul>
                                        <li><a href="#">شیشه مات کن ساده</a></li>
                                        <li><a href="#">شیشه مات کن طرح دار</a></li>
                                        <li><a href="#">چاپ شیشه مات کن</a></li>
                                    </ul>
                                </li>
                            @endforelse
                        </ul>
                    </li>

                    <li>
                        <a class="link-amenu" href="#">استعلام قیمت اختصاصی</a>
                    </li>

                    <li>
                        <a class="link-amenu" href="#">لیست قیمت</a>
                    </li>

                    <li>
                        <a class="link-amenu" href="{{ url('contact') }}">تماس با ما</a>
                    </li>
                </ul>
            </div>

            <div class="contact-list contact-list-mobile">
                <ul>
                    <li>
                        <a style="color:#fff;" href="tel:02177638179">02177638179</a>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</header>
