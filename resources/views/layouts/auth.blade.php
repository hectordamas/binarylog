<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - BinaryLog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/png" href="{{ asset('adminAssets/images/icon/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/slicknav.min.css') }}">

    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />

    <!-- others css -->
    <link rel="stylesheet" href="{{ asset('adminAssets/css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/default-css.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/responsive.css') }}">

    <!-- modernizr js -->
    <script src="{{ asset('adminAssets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
    <!--[if lt IE 8]>
    <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please 
        <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
    </p>
    <![endif]-->

    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->

    @yield('content')

    <!-- jquery latest version -->
    <script src="{{ asset('adminAssets/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <!-- bootstrap 4 js -->
    <script src="{{ asset('adminAssets/js/popper.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/jquery.slicknav.min.js') }}"></script>

    <!-- others plugins -->
    <script src="{{ asset('adminAssets/js/plugins.js') }}"></script>
    <script src="{{ asset('adminAssets/js/scripts.js') }}"></script>
</body>

</html>