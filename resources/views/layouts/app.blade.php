<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>المحكمة العامة بالدمام | تقير القضايا الأسبوعي </title>
    <link rel="icon" type="image/x-icon" href="{{asset('src/assets/img/favicon.ico')}}"/>
    <link href="{{asset('layouts/modern-dark-menu/css/light/loader.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('layouts/modern-dark-menu/css/dark/loader.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('layouts/modern-dark-menu/loader.js')}}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Noto+Kufi+Arabic:wght@100..900&family=Noto+Naskh+Arabic:wght@400..700&display=swap" rel="stylesheet">

    <link href="{{asset('src/bootstrap/css/bootstrap.rtl.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('layouts/modern-dark-menu/css/light/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('layouts/modern-dark-menu/css/dark/plugins.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @yield('plugin_styles')
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <style>
        body {
            letter-spacing: normal!important;
        }
        .menu, .breadcrumb, .btn {
            font-family: "Noto Kufi Arabic", sans-serif;
            font-optical-sizing: auto;
            font-weight: bold;
            font-style: normal;
            letter-spacing: normal!important;
        }
        body.dark #sidebar ul.menu-categories li.menu > a span:not(.badge) {
            font-size: 1em;
            letter-spacing: normal!important;

        }

        #content {
            font-family: "Noto Naskh Arabic", serif;
            font-optical-sizing: auto;
            font-weight: bold;
            font-style: normal;
            letter-spacing: normal!important;

       }
        label {
            font-family: "Noto Naskh Arabic", serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-size: 18px!important;
            letter-spacing: normal!important;

       }
        select.form-control {
            padding-right: 25px!important;
        }
        body.dark #sidebar .theme-brand div.theme-logo img {
            width: 180px;
            height: 190px;
            margin-top: -45px;
            margin-bottom: -30px;
            letter-spacing: normal!important;

        }
        body.dark .page-meta .breadcrumb .breadcrumb-item {
            letter-spacing: normal!important;
        }
        body.dark .table > thead > tr > th {
            letter-spacing: normal!important;
        }
    </style>
    @yield('custom_styles')
    @toastifyCss
</head>
<body class=" layout-boxed">
<!-- BEGIN LOADER -->
@include('layouts._loader')
<!--  END LOADER -->

<!--  BEGIN NAVBAR  -->
<div class="d-none">
    <a href="javascript:void(0);" class="nav-link theme-toggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon dark-mode"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun light-mode"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
    </a>
</div>

<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container " id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    @include('layouts._sidebar')
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="middle-content container-xxl p-0">
                @yield('content')
            </div>
        </div>
        <!--  BEGIN FOOTER  -->
        @include('layouts._footer')
        <!--  END CONTENT AREA  -->
    </div>
    <!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->
@toastifyJs
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{asset('src/plugins/src/global/vendors.min.js')}}"></script>
<script src="{{asset('src/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('src/plugins/src/mousetrap/mousetrap.min.js')}}"></script>
<script src="{{asset('src/plugins/src/waves/waves.min.js')}}"></script>
<script src="{{asset('layouts/modern-dark-menu/app.js')}}"></script>
<script src="{{asset('src/assets/js/custom.js')}}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
@yield('plugin_scripts')
@yield('custom_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
</body>
</html>
