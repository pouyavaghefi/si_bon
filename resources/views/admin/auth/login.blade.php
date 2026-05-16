<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="/adm/assets/images/favicon.ico">

    <script src="/adm/assets/js/config.js"></script>

    <link href="/adm/assets/css/vendors.min.css" rel="stylesheet" type="text/css">
    <link href="/adm/assets/css/app.min.css" rel="stylesheet" type="text/css">

    <script src="/adm/assets/plugins/lucide/lucide.min.js"></script>
</head>

<body>

<div class="auth-box overflow-hidden align-items-center d-flex min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-md-5 col-sm-7">

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        @php
                            $siteConfig = \App\Models\Configuration::first();
                        @endphp

                        <div class="text-center mb-4">

                            <a href="{{ $siteConfig?->site_url ?? '/' }}"
                               class="logo-dark text-decoration-none"
                               target="_blank">

                                <span class="d-inline-flex align-items-center justify-content-center">

                                    <span class="avatar avatar-md rounded-circle overflow-hidden bg-light border shadow-sm">

                                        @if(!empty($siteConfig?->site_logo))
                                            <img src="{{ asset($siteConfig->site_logo) }}"
                                                 alt="site-logo"
                                                 class="w-100 h-100 object-fit-cover">
                                        @else
                                            <span class="avatar-title text-bg-dark">
                                                <i data-lucide="sparkles"></i>
                                            </span>
                                        @endif

                                    </span>

                                </span>

                            </a>

                        </div>

                        <form method="POST" action="{{ route('admin.login.submit') }}">

                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div class="mb-3">
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Username"
                                    required>

                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Password"
                                    required>

                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark py-2">
                                    Login
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="/adm/assets/js/vendors.min.js"></script>
<script src="/adm/assets/js/app.js"></script>
<script>
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });
</script>
</body>

</html>
