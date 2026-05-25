<!--
* Author: Pouya Vaghefi
* Product Name:
* Version: 1.0.0
* Contact: info@pouyait.nl
-->
<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.includes.init.head')
    <title>@yield('pageTitle')</title>
</head>

<body>
<!-- Begin page -->
<div class="wrapper">
    <!-- Topbar Start -->
    @include('admin.layouts.includes.header')
    <!-- Topbar End -->

    <!-- Sidenav Menu Start -->
    @include('admin.layouts.includes.overalls.sidenav')
    <!-- Sidenav Menu End -->

    <!-- ============================================================== -->
    <!-- Start Main Content -->
    <!-- ============================================================== -->

    <div class="content-page">
        @yield('wrapper')

        <!-- Footer Start -->
        @include('admin.layouts.includes.overalls.footer')
        <!-- end Footer -->

    </div>
    <!-- ============================================================== -->
    <!-- End of Main Content -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->

@include('admin.layouts.includes.init.js')

@yield('scripts')
</body>
</html>
