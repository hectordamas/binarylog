<!doctype html>
<html class="no-js" lang="en">

<head> 
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    @yield('metadata')

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('adminAssets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>    
    <link rel="stylesheet" href="{{ asset('adminAssets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/slicknav.min.css') }}">

    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />

    <!-- Otros estilos -->

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('adminAssets/css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/default-css.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/customAssets/css/style.css') }}">

    <!-- modernizr -->
    <script src="{{ asset('adminAssets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('adminAssets/images/logo-light.png') }}" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li>
                                <a href="{{ route('home') }}">
                                    <i class="ti-dashboard"></i> <span>Inicio</span>
                                </a>
                            </li>
                        
                            <li>
                                <a href="{{ route('trades.index') }}">
                                    <i class="ti-pulse"></i> <span>Trades</span>
                                </a>
                            </li>
                        
                            <li>
                                <a href="{{ url('capital.index') }}">
                                    <i class="ti-wallet"></i> <span>Gestión de Capital</span>
                                </a>
                            </li>
                        
                            <li>
                                <a href="{{ url('diario.index') }}">
                                    <i class="ti-notepad"></i> <span>Diario de Trading</span>
                                </a>
                            </li>
                        
                            <li>
                                <a href="{{ url('estrategias.index') }}">
                                    <i class="ti-target"></i> <span>Estrategias</span>
                                </a>
                            </li>
                        
                            <li>
                                <a href="{{ url('galeria.index') }}">
                                    <i class="ti-gallery"></i> <span>Galería</span>
                                </a>
                            </li>
                        
                            <li>
                                <a href="{{ url('export.index') }}">
                                    <i class="ti-export"></i> <span>Exportar</span>
                                </a>
                            </li>
                        
                            <li>
                                <a href="{{ url('configuracion.index') }}">
                                    <i class="ti-settings"></i> <span>Configuración</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->

        <div class="main-content">
            <div class="page-title-area bg-white d-flex justify-content-between align-items-center shadow-sm rounded">
                <div class="d-flex align-items-center">
                    <div class="nav-btn pull-left">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="breadcrumbs-area mb-0">
                        <h4 class="page-title d-inline-block mb-0">@yield('title')</h4>
                        <ul class="breadcrumbs d-inline-block pl-3 mb-0">
                            <li><a href="{{ route('home') }}">Inicio</a></li>
                            @yield('breadcrumb')
                        </ul>
                    </div>
                </div>

            
                <div class="user-profile dropdown">
                    <a class="dropdown-toggle d-flex align-items-center text-white" href="#" role="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user-circle fa-3x mr-3"></i>
                        <span class="user-name">{{ Auth::user()->name ?? 'Usuario' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>



            <div class="main-content-inner">
                @yield('content')
            </div>
        </div>


    </div>

    <script src="{{ asset('adminAssets/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <!-- bootstrap 4 js -->
    <script src="{{ asset('adminAssets/js/popper.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/jquery.slicknav.min.js') }}"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
        zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
        ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>

    <!-- all line chart activation -->
    <script src="{{ asset('adminAssets/js/line-chart.js') }}"></script>
    <!-- all pie chart -->
    <script src="{{ asset('adminAssets/js/pie-chart.js') }}"></script>
    <!-- others plugins -->
    <script src="{{ asset('adminAssets/js/plugins.js') }}"></script>
    <script src="{{ asset('adminAssets/js/scripts.js') }}"></script>


    <!-- jQuery (ya incluido si usas Bootstrap) -->
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>   

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script src="{{ asset('adminAssets/customAssets/js/script.js') }}"></script>

    @yield('scripts')

    @if(session()->has('success'))
    <script>
        swal({
            text: "{{ session('success') }}",
            icon: "success",
            button: "Aceptar",
        });
    </script>
    @endif
</body>
</html>
