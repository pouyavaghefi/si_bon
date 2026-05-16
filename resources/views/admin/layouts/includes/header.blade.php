@php
    $notifications = auth()->check()
        ? auth()->user()->unreadNotifications
        : collect();
@endphp

<header class="app-topbar">
    <div class="container-fluid topbar-menu">
        <div class="d-flex align-items-center justify-content-between w-100">

            <div class="d-flex align-items-center gap-2">

                <div class="topbar-item nav-user">
                    <div class="dropdown">
                        <a class="topbar-link dropdown-toggle drop-arrow-none px-2"
                           data-bs-toggle="dropdown"
                           data-bs-offset="0,13"
                           href="#!">

                            <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('/adm/img/admin.png') }}"
                                 width="34"
                                 class="rounded-circle d-flex object-fit-cover"
                                 alt="admin-image">

                            <span class="d-none d-lg-inline-block me-2 fw-semibold">
                                مدیر سیستم
                            </span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end text-end">

                            <div class="dropdown-header border-bottom py-3 text-end">
                                <h6 class="m-0 fw-bold">خوش آمدید 👋</h6>
                                <small class="text-muted">به پنل مدیریت خوش آمدید</small>
                            </div>

                            <a href="/admin/profile" class="dropdown-item text-end py-2">
                                <i class="ti ti-user-circle ms-2 fs-17 align-middle"></i>
                                <span>پروفایل کاربری</span>
                            </a>

                            <a href="/admin/settings" class="dropdown-item text-end py-2">
                                <i class="ti ti-settings ms-2 fs-17 align-middle"></i>
                                <span>تنظیمات حساب</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf

                                <button type="submit"
                                        class="dropdown-item text-danger fw-semibold text-end py-2 border-0 bg-transparent w-100">

                                    <i class="ti ti-logout-2 ms-2 fs-17 align-middle"></i>

                                    <span>خروج از حساب</span>

                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="topbar-item d-none d-sm-flex">
                    <button class="topbar-link" id="light-dark-mode" type="button">
                        <i data-lucide="moon" class="fs-xxl mode-light-moon"></i>
                        <i data-lucide="sun" class="fs-xxl mode-light-sun"></i>
                    </button>
                </div>

                <div class="topbar-item">
                    <div class="dropdown notification-dropdown">

                        <button class="topbar-link dropdown-toggle drop-arrow-none"
                                data-bs-toggle="dropdown"
                                data-bs-offset="0,19"
                                type="button"
                                data-bs-auto-close="outside">

                            <i data-lucide="bell" class="fs-xxl"></i>

                            @if ($notifications->count() > 0)
                                <span class="badge badge-square text-bg-danger topbar-badge">
                                    {{ $notifications->count() }}
                                </span>
                            @endif
                        </button>

                        <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg text-end">
                            @if ($notifications->count() > 0)
                            <div class="px-3 py-3 border-bottom d-flex align-items-center justify-content-between">
                                <form action="{{ route('admin.notifications.readAll') }}" method="POST">
                                    @csrf

                                    <button type="submit"
                                            class="btn btn-link p-0 text-decoration-none small">
                                        خوانده شدن همه
                                    </button>
                                </form>

                                <h6 class="m-0 fw-bold">اعلان‌های جدید</h6>
                            </div>
                            @endif

                            <div style="max-height: 320px;" data-simplebar>

                                @forelse ($notifications as $notification)
                                    <div class="dropdown-item notification-item py-3 text-wrap text-end">
                                    <span class="d-flex align-items-start gap-3">

                                        <span class="flex-grow-1">
                                            <span class="fw-semibold text-dark d-block mb-1">
                                                {{ $notification->data['title'] ?? 'اعلان جدید' }}
                                            </span>

                                            <span class="text-muted small">
                                                {{ $notification->data['message'] ?? '' }}
                                            </span>
                                        </span>

                                        <span class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle text-success rounded-circle">
                                                <i data-lucide="{{ $notification->data['icon'] ?? 'bell' }}"></i>
                                            </span>
                                        </span>

                                    </span>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted">
                                        اعلان جدیدی وجود ندارد
                                    </div>
                                @endforelse

                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <div class="d-flex align-items-center gap-2">

                <button class="button-collapse-toggle d-xl-none">
                    <i data-lucide="menu" class="fs-22 align-middle"></i>
                </button>

                @php
                    $siteConfig = \App\Models\Configuration::first();
                @endphp

                <div class="logo-topbar">
                    <a href="{{ $siteConfig?->site_url ?? env('APP_URL') }}"
                       class="logo-dark text-decoration-none"
                       target="_blank">

                        <span class="d-flex align-items-center gap-2">

                            <span class="logo-text text-body fw-bold fs-xl">
                                {{ $siteConfig?->site_name ?? 'پنل مدیریت' }}
                            </span>
                        </span>

                    </a>
                </div>

            </div>

        </div>
    </div>
</header>

<style>
    .notification-counter {
        transition: all .2s ease;
    }

    .notification-counter.is-hidden {
        opacity: 0;
        visibility: hidden;
        transform: scale(.7);
        pointer-events: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationDropdown = document.querySelector('.notification-dropdown');
        const notificationCounter = document.querySelector('.notification-counter');

        if (notificationDropdown && notificationCounter) {
            notificationDropdown.addEventListener('show.bs.dropdown', function () {
                notificationCounter.classList.add('is-hidden');
            });
        }
    });
</script>
