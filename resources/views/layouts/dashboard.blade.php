<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Multikart admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Multikart admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('assets/images/dashboard/favicon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/dashboard/favicon.png')}}" type="image/x-icon">
    <title>Multikart - Premium Admin Template</title>

    <!-- Google font-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&amp;display=swap">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap">


    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/font-awesome.css')}}">

    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/flag-icon.css')}}">

    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/icofont.css')}}">

    <!-- Prism css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/prism.css')}}">

    <!-- Chartist css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/chartist.css')}}">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/bootstrap.css')}}">

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <style type="text/css">
        .jqstooltip {
            position: absolute;
            left: 0px;
            top: 0px;
            visibility: hidden;
            background: rgb(0, 0, 0) transparent;
            background-color: rgba(0, 0, 0, 0.6);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
            color: white;
            font: 10px arial, san serif;
            text-align: left;
            white-space: nowrap;
            padding: 5px;
            border: 1px solid white;
            z-index: 10000;
        }

        .jqsfield {
            color: white;
            font: 10px arial, san serif;
            text-align: left;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/new.css')}}">
    <script src="chrome-extension://mooikfkahbdckldjjndioackbalphokd/assets/prompt.js"></script>
    @stack('styles')
</head>

<body>
     <!-- page-wrapper Start-->
    <div class="page-wrapper">

        <!-- Page Header Start-->
            <x-dashboard.dashboard-header/>
        <!-- Page Header Ends -->

        <!-- Alert Message Start -->
            <x-alert-message />
        <!-- Alert Message End -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->

                <x-dashboard.dashboard-sidebar/>

            <!-- Page Sidebar Ends-->

            <!-- Right sidebar Start-->

                <x-dashboard.dashboard-right-sidebar/>

            <!-- Right sidebar Ends-->
            <div class="page-body">
                <!-- Container-fluid starts-->
                <!-- breadcrumb starts-->

                    @yield('breadcrumbs')

                <!-- breadcrumb Ends-->
                <!-- Container-fluid Ends-->
                <!-- Content start-->

                    @yield('content')

                <!-- Content Ends-->
            </div>
            <!-- footer start-->
                <x-dashboard.dashboard-footer/>
            <!-- footer end-->
        </div>

    </div>
    <!-- latest jquery-->
    <script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <!-- feather icon js-->
    <script src="{{asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>

    <!-- Sidebar jquery-->
    <script src="{{asset('assets/js/sidebar-menu.js')}}"></script>

    <!--chartist js-->
    <script src="{{asset('assets/js/chart/chartist/chartist.js')}}"></script>

    <!--chartjs js-->
    <script src="{{asset('assets/js/chart/chartjs/chart.min.js')}}"></script>

    <!-- lazyload js-->
    <script src="{{asset('assets/js/lazysizes.min.js')}}"></script>

    <!--copycode js-->
    <script src="{{asset('assets/js/prism/prism.min.js')}}"></script>
    <script src="{{asset('assets/js/clipboard/clipboard.min.js')}}"></script>
    <script src="{{asset('assets/js/custom-card/custom-card.js')}}"></script>

    <!--counter js-->
    <script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>

    <!--peity chart js-->
    <script src="{{asset('assets/js/chart/peity-chart/peity.jquery.js')}}"></script>

    <!-- Apex Chart Js -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!--sparkline chart js-->
    <script src="{{asset('assets/js/chart/sparkline/sparkline.js')}}"></script>

    <!--Customizer admin-->
    <script src="{{asset('assets/js/admin-customizer.js')}}"></script>
    <ul class="custom-theme">
        <li class="demo-li"><a href="{{asset('../front-end/index.html')}}" target="_blank">Front end</a></li>
        <li class="btn-rtl">RTL</li>
        <li class="btn-dark-setting">Dark</li>
    </ul>

    <!--dashboard custom js-->
    <script src="{{asset('assets/js/dashboard/default.js')}}"></script>

    <!--right sidebar js-->
    <script src="{{asset('assets/js/chat-menu.js')}}"></script>

    <!--height equal js-->
    <script src="{{asset('assets/js/height-equal.js')}}"></script>

    <!-- lazyload js-->
    <script src="{{asset('assets/js/lazysizes.min.js')}}"></script>

    <!--script admin-->
    <script src="{{asset('assets/js/admin-script.js')}}"></script>


    <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1002"></defs>
        <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
        <path id="SvgjsPath1004" d="M0 0 "></path>
    </svg>
    @stack('scripts')
</body>

</html>
