<!DOCTYPE html>
<!-- Template Name: DashCode - HTML, React, Vue, Tailwind Admin Dashboard Template Author: Codeshaper Website: https://codeshaper.net Contact: support@codeshaperbd.net Like: https://www.facebook.com/Codeshaperbd Purchase: https://themeforest.net/item/dashcode-admin-dashboard-template/42600453 License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project. -->
<html lang="zxx" dir="ltr" class="light semiDark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>DGEHM</title>
    <link rel="icon" type="image/png" href="{{ asset('img/escudo.svg') }}">
    <!-- BEGIN: Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- END: Google Font -->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/SimpleBar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rt-plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">

    <!-- END: Theme CSS-->
    <script src="{{ asset('assets/js/settings.js') }}" sync></script>
    <script src="{{ asset('assets/js/iconify-icon.min.js') }}"></script>
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}"> --}}
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}" sync></script>
    {{-- <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script> --}}

    <style>
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

    <style>
        .card-title,
        .form-label,
        .table-td {
            text-transform: none;
        }
    </style>

    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable().destroy();
            }
            $('#myTable').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });
    </script>
</head>

<body class=" font-inter dashcode-app" id="body_class">
    <!-- [if IE]> <p class="browserupgrade"> You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security. </p> <![endif] -->
    <main class="app-wrapper">
        <!-- BEGIN: Sidebar -->
        <!-- BEGIN: Sidebar -->
        <div class="sidebar-wrapper group">
            <div id="bodyOverlay" class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden"></div>
            <div class="logo-segment">
                <a class="flex items-center" href="{{ url('/home') }}">
                    <img src="{{ asset('img/logo-blanco.png') }}" class="black_logo" alt="logo">
                    <img src="{{ asset('img/logo-blanco.png') }}" class="white_logo" alt="logo">
                    {{-- <span
                        class="ltr:ml-3 rtl:mr-3 text-xl font-Inter font-bold text-slate-900 dark:text-white">DGEHM</span> --}}
                </a>
                <!-- Sidebar Type Button -->
                <div id="sidebar_type" class="cursor-pointer text-slate-900 dark:text-white text-lg">
                    <iconify-icon class="sidebarDotIcon extend-icon text-white" icon="fa-regular:dot-circle"></iconify-icon>
                    <iconify-icon class="sidebarDotIcon collapsed-icon text-white" icon="material-symbols:circle-outline"></iconify-icon>

                </div>
                <button class="sidebarCloseIcon text-2xl">
                    <iconify-icon class="text-slate-900 dark:text-slate-200 text-white" icon="clarity:window-close-line">
                    </iconify-icon>
                </button>
            </div>
            <div id="nav_shadow" class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none opacity-0">
            </div>
            <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] overflow-y-auto z-50" id="sidebar_menus">

                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ url('home') }}" class="navItem">
                            <span class="flex items-center">

                                <iconify-icon class=" nav-icon" icon="heroicons-outline:home"></iconify-icon>
                                <span>Home</span>
                            </span>
                        </a>
                    </li>

                    <li class="">


                        <a href="#" class="navItem">
                            <span class="flex items-center">
                                <iconify-icon class=" nav-icon" icon="heroicons-outline:user-group"></iconify-icon>
                                <span>Información pública</span>
                            </span>
                            <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                        </a>
                        <ul class="sidebar-submenu">
                            @can('importacion')
                            <li>
                                <a href="{{ url('importacion/base_datos') }}">Importación de censo<br>general</a>
                            </li>
                            @endcan

                            {{-- <li>
                                    <a href="#">Gráficos</a>
                                </li> --}}
                            <li>
                                <a href="{{ url('publico/evaluacion_proyectos') }}">Evaluación de proyectos</a>
                            </li>
                            <li>
                                <a href="{{ url('publico/biblioteca_publica') }}">Biblioteca / Info general</a>
                            </li>
                        </ul>
                    </li>
                    {{-- @can('read menu informacion publica')
                    @endcan --}}

                    @if (Session::has('convenio') && Session::get('convenio') == 1)
                    <li class="">
                        <a href="#" class="navItem">
                            <span class="flex items-center">
                                <iconify-icon class=" nav-icon" icon="heroicons-outline:user-group"></iconify-icon>
                                <span>Elaboración censo</span>
                            </span>
                            <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ url('control/censo_luminaria/show_map') }}">Creación nuevo registro</a>
                            </li>
                            {{-- <li>
                                    <a href="#">Importacion de censo</a>
                                </li> --}}
                        </ul>
                    </li>
                    @endif

                    @can('read menu gestion parque')
                    <li class="">
                        <a href="#" class="navItem">
                            <span class="flex items-center">
                                <iconify-icon class=" nav-icon" icon="heroicons-outline:user-group"></iconify-icon>
                                <span>Gestión parque AP</span>
                            </span>
                            <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ url('control/censo_luminaria') }}">Inventario actual AP</a>
                            </li>
                            <li>
                                <a href="{{ url('control/comparacion_censos') }}">Comparación de censos</a>
                            </li>
                            <li>
                                <a href="{{ url('publico/evaluacion_proyectos/evaluacionProyectosCensoIndex') }}">Evaluación
                                    de proyectos<br>censo</a>
                            </li>
                            <li>
                                <a href="{{ url('control/EstimacionFacturaGeneral') }}">Estimación de factura<br>general</a>
                            </li>
                        </ul>


                    </li>
                    @endcan

                    @can('read menu fallas')
                    <li class="">
                        <a href="#" class="navItem">
                            <span class="flex items-center">
                                <iconify-icon class=" nav-icon" icon="heroicons-outline:user-group"></iconify-icon>
                                <span>Reportes y seguimiento de fallas</span>
                            </span>
                            <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ url('reporte_falla/show_map') }}">Crear reporte de falla</a>
                            </li>
                            <li>
                                <a href="{{ url('reporte_falla') }}">Seguimiento de reportes</a>
                            </li>
                            {{-- <li>
                                    <a href="#">Informes</a>
                                </li> --}}
                        </ul>
                    </li>
                    @endcan




                    @can('read menu catalogo')
                    <li class="">
                        <a href="#" class="navItem">
                            <span class="flex items-center">
                                <iconify-icon class=" nav-icon" icon="heroicons-outline:clipboard-list">
                                </iconify-icon>
                                <span>Catálogos</span>
                            </span>
                            <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ url('catalogo/biblioteca') }}">Biblioteca</a>
                            </li>
                            {{--
                                <li>
                                    <a href="{{ url('catalogo/reporte_falla') }}">Reporte falla</a>
                    </li> --}}
                    <li>
                        <a href="{{ url('catalogo/municipio') }}">Municipio</a>
                    </li>
                    <li>
                        <a href="{{ url('catalogo/distrito') }}">Distritos</a>
                    </li>

                    <li>
                        <a href="{{ url('catalogo/tipo_luminaria') }}">Tipo luminaria</a>
                    </li>


                    <li>
                        <a href="{{ url('catalogo/tipo_falla') }}">Tipos de falla</a>
                    </li>
                    @can('menu precio energia')
                    <li>
                        <a href="{{ url('control/valor_mensual_energia') }}">Precio energía mensual(kWh)</a>
                    </li>
                    <li>
                        <a href="{{ url('catalogo/valorkwh') }}">Valor kWh (precio ref para<br>evaluación de
                            proyectos)</a>
                    </li>
                    @endcan
                </ul>
                </li>
                @endcan

                @can('edit users')
                <li class="">
                    <a href="#" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="heroicons-outline:user-group"></iconify-icon>
                            <span>Seguridad</span>
                        </span>
                        <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ url('seguridad/user') }}">Usuario</a>
                        </li>
                        <li>
                            <a href="{{ url('seguridad/role') }}">Rol</a>
                        </li>
                        <li>
                            <a href="{{ url('configuracion/correo') }}">Configuración</a>
                        </li>

                        {{-- <li>
                                    <a href="{{ url('seguridad/permission') }}">Permisos</a>
                </li> --}}
                </ul>
                </li>
                @endcan

                {{-- <li>
                        <a href="{{ url('importar_luminarias') }}" class="navItem">
                <span class="flex items-center">
                    <iconify-icon class="nav-icon" icon="material-symbols:add-notes" style="color: white;"></iconify-icon>
                    <span>Importar de Excel</span>
                </span>
                </a>
                </li> --}}

                @can('menu mapa')
                <li>
                    <a href="{{ url('importacion/base_datos') }}/1" target="_blank" class="navItem">
                        <span class="flex items-center">
                            <iconify-icon class=" nav-icon" icon="material-symbols:add-notes" style="color: white;"></iconify-icon>
                            <span>Visualización Luminarias</span>
                        </span>
                    </a>
                </li>
                @endcan







                </ul>



                <!-- Upgrade Your Business Plan Card Start -->

                <!-- Upgrade Your Business Plan Card Start -->
            </div>
        </div>
        <!-- End: Sidebar -->
        <!-- End: Sidebar -->
        <!-- BEGIN: Settings -->

        <!-- BEGIN: Settings -->
        <!-- Settings Toggle Button -->
        <button style="display:none" class="fixed ltr:md:right-[-29px] ltr:right-0 rtl:left-0 rtl:md:left-[-29px] top-1/2 z-[888] translate-y-1/2 bg-slate-800 text-slate-50 dark:bg-slate-700 dark:text-slate-300 cursor-pointer transform rotate-90 flex items-center text-sm font-medium px-2 py-2 shadow-deep ltr:rounded-b rtl:rounded-t" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas">
            <iconify-icon class="text-slate-50 text-lg animate-spin" icon="material-symbols:settings-outline-rounded">
            </iconify-icon>
            <span class="hidden md:inline-block ltr:ml-2 rtl:mr-2">Settings</span>
        </button>

        <!-- BEGIN: Settings Modal -->
        <div class="offcanvas offcanvas-end fixed bottom-0 flex flex-col max-w-full bg-white dark:bg-slate-800 invisible bg-clip-padding shadow-sm outline-none transition duration-300 ease-in-out text-gray-700 top-0 ltr:right-0 rtl:left-0 border-none w-96" tabindex="-1" id="offcanvas" aria-labelledby="offcanvas">
            <div class="offcanvas-header flex items-center justify-between p-4 pt-3 border-b border-b-slate-300">
                <div>
                    <h3 class="block text-xl font-Inter text-slate-900 font-medium dark:text-[#eee]">
                        Theme customizer
                    </h3>
                    <p class="block text-sm font-Inter font-light text-[#68768A] dark:text-[#eee]">Customize & Preview
                        in Real Time</p>
                </div>
                <button type="button" class="box-content text-2xl w-4 h-4 p-2 pt-0 -my-5 -mr-2 text-black dark:text-white border-none rounded-none opacity-100 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="offcanvas">
                    <iconify-icon icon="line-md:close"></iconify-icon>
                </button>
            </div>
            <div class="offcanvas-body flex-grow overflow-y-auto">
                <div class="settings-modal">
                    <div class="p-6">

                        <h3 class="mt-4">Theme</h3>
                        <form class="input-area flex items-center space-x-8 rtl:space-x-reverse" id="themeChanger">
                            <div class="input-group flex items-center">
                                <input type="radio" id="light" name="theme" value="light" class="themeCustomization-checkInput">
                                <label for="light" class="themeCustomization-checkInput-label">Light</label>
                            </div>
                            <div class="input-group flex items-center">
                                <input type="radio" id="dark" name="theme" value="dark" class="themeCustomization-checkInput">
                                <label for="dark" class="themeCustomization-checkInput-label">Dark</label>
                            </div>
                            <div class="input-group flex items-center">
                                <input type="radio" id="semiDark" name="theme" value="semiDark" class="themeCustomization-checkInput">
                                <label for="semiDark" class="themeCustomization-checkInput-label">Semi Dark</label>
                            </div>
                        </form>
                    </div>
                    <div class="divider"></div>
                    <div class="p-6">

                        <div class="flex items-center justify-between mt-5">
                            <h3 class="!mb-0">Rtl</h3>
                            <label id="rtl_ltr" class="relative inline-flex h-6 w-[46px] items-center rounded-full transition-all duration-150 cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer">
                                <span class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-black-600"></span>
                            </label>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="p-6">
                        <h3>Content Width</h3>
                        <div class="input-area flex items-center space-x-8 rtl:space-x-reverse">
                            <div class="input-group flex items-center">
                                <input type="radio" id="fullWidth" name="content-width" value="fullWidth" class="themeCustomization-checkInput">
                                <label for="fullWidth" class="themeCustomization-checkInput-label ">Full Width</label>
                            </div>
                            <div class="input-group flex items-center">
                                <input type="radio" id="boxed" name="content-width" value="boxed" class="themeCustomization-checkInput">
                                <label for="boxed" class="themeCustomization-checkInput-label ">Boxed</label>
                            </div>
                        </div>
                        <h3 class="mt-4">Menu Layout</h3>
                        <div class="input-area flex items-center space-x-8 rtl:space-x-reverse">
                            <div class="input-group flex items-center">
                                <input type="radio" id="vertical_menu" name="menu_layout" value="vertical" class="themeCustomization-checkInput">
                                <label for="vertical_menu" class="themeCustomization-checkInput-label ">Vertical</label>
                            </div>
                            <div class="input-group flex items-center">
                                <input type="radio" id="horizontal_menu" name="menu_layout" value="horizontal" class="themeCustomization-checkInput">
                                <label for="horizontal_menu" class="themeCustomization-checkInput-label ">Horizontal</label>
                            </div>
                        </div>
                        <div id="menuCollapse" class="flex items-center justify-between mt-5">
                            <h3 class="!mb-0">Menu Collapsed</h3>
                            <label class="relative inline-flex h-6 w-[46px] items-center rounded-full transition-all duration-150 cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer">
                                <span class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-black-500"></span>
                            </label>
                        </div>
                        <div id="menuHidden" class="!flex items-center justify-between mt-5">
                            <h3 class="!mb-0">Menu Hidden</h3>
                            <label id="menuHide" class="relative inline-flex h-6 w-[46px] items-center rounded-full transition-all duration-150 cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer">
                                <span class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-black-500"></span>
                            </label>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="p-6">
                        <h3>Navbar Type</h3>
                        <div class="input-area flex flex-wrap items-center space-x-4 rtl:space-x-reverse">
                            <div class="input-group flex items-center">
                                <input type="radio" id="nav_floating" name="navbarType" value="floating" class="themeCustomization-checkInput">
                                <label for="nav_floating" class="themeCustomization-checkInput-label ">Floating</label>
                            </div>
                            <div class="input-group flex items-center">
                                <input type="radio" id="nav_sticky" name="navbarType" value="sticky" class="themeCustomization-checkInput">
                                <label for="nav_sticky" class="themeCustomization-checkInput-label ">Sticky</label>
                            </div>
                            <div class="input-group flex items-center">
                                <input type="radio" id="nav_static" name="navbarType" value="static" class="themeCustomization-checkInput">
                                <label for="nav_static" class="themeCustomization-checkInput-label ">Static</label>
                            </div>
                            <div class="input-group flex items-center">
                                <input type="radio" id="nav_hidden" name="navbarType" value="hidden" class="themeCustomization-checkInput">
                                <label for="nav_hidden" class="themeCustomization-checkInput-label ">Hidden</label>
                            </div>
                        </div>
                        <h3 class="mt-4">Footer Type</h3>
                        <div class="input-area flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="input-group flex items-center">
                                <input type="radio" id="footer_sticky" name="footerType" value="sticky" class="themeCustomization-checkInput">
                                <label for="footer_sticky" class="themeCustomization-checkInput-label ">Sticky</label>
                            </div>
                            <div class="input-group flex items-center">
                                <input type="radio" id="footer_static" name="footerType" value="static" class="themeCustomization-checkInput">
                                <label for="footer_static" class="themeCustomization-checkInput-label ">Static</label>
                            </div>
                            <div class="input-group flex items-center">
                                <input type="radio" id="footer_hidden" name="footerType" value="hidden" class="themeCustomization-checkInput">
                                <label for="footer_hidden" class="themeCustomization-checkInput-label ">Hidden</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Settings Modal -->
        <!-- END: Settings -->

        <!-- End: Settings -->
        <div class="flex flex-col justify-between min-h-screen">
            <div>
                <!-- BEGIN: Header -->
                <!-- BEGIN: Header -->
                <div class="z-[9]" id="app_header">
                    <div class="app-header z-[999] ltr:ml-[248px] rtl:mr-[248px] bg-white dark:bg-slate-800 shadow-sm dark:shadow-slate-700">
                        <div class="flex justify-between items-center h-full">
                            <div class="flex items-center md:space-x-4 space-x-2 xl:space-x-0 rtl:space-x-reverse vertical-box">
                                <a href="index.html" class="mobile-logo xl:hidden inline-block">
                                    <img src="{{ asset('assets/images/logo/logo-c.svg') }}" class="black_logo" alt="logo">
                                    <img src="{{ asset('img/logo-negro.png') }}" class="white_logo" alt="logo" width="35%">
                                </a>
                                <button class="smallDeviceMenuController hidden md:inline-block xl:hidden">
                                    <iconify-icon class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white" icon="heroicons-outline:menu-alt-3"></iconify-icon>
                                </button>


                            </div>
                            <!-- end vertcial -->
                            <div class="items-center space-x-4 rtl:space-x-reverse horizental-box">
                                <a href="index.html">
                                    <span class="xl:inline-block hidden">
                                        <img src="{{ asset('assets/images/logo/logo.svg') }}" class="black_logo " alt="logo">
                                        <img src="{{ asset('assets/images/logo/logo-white.svg') }}" class="white_logo" alt="logo">
                                    </span>
                                    <span class="xl:hidden inline-block">
                                        <img src="{{ asset('assets/images/logo/logo-c.svg') }}" class="black_logo " alt="logo">
                                        <img src="{{ asset('assets/images/logo/logo-c-white.svg') }}" class="white_logo " alt="logo">
                                    </span>
                                </a>
                                <button class="smallDeviceMenuController  open-sdiebar-controller xl:hidden inline-block">
                                    <iconify-icon class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white" icon="heroicons-outline:menu-alt-3"></iconify-icon>
                                </button>

                            </div>
                            <!-- end horizental -->



                            <div class="main-menu">
                                <ul>

                                    <li class="menu-item-has-children">
                                        <!--  Single menu -->

                                        <!-- has dropdown -->



                                        <a href="javascript:void()">
                                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                                <span class="icon-box">
                                                    <iconify-icon icon=heroicons-outline:home> </iconify-icon>
                                                </span>
                                                <div class="text-box">Dashboard</div>
                                            </div>
                                            <div class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                                <iconify-icon icon="heroicons-outline:chevron-down"> </iconify-icon>
                                            </div>
                                        </a>

                                        <!-- Dropdown menu -->



                                        <ul class="sub-menu">



                                            <li>
                                                <a href=index.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons:presentation-chart-line class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Analytics Dashboard
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=ecommerce-dashboard.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons:shopping-cart class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Ecommerce Dashboard
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=project-dashboard.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons:briefcase class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Project Dashboard
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=crm-dashboard.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=ri:customer-service-2-fill class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            CRM Dashboard
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=banking-dashboard.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons:wrench-screwdriver class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Banking Dashboard
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>

                                        <!-- Megamenu -->


                                    </li>

                                    <li class="menu-item-has-children">
                                        <!--  Single menu -->

                                        <!-- has dropdown -->



                                        <a href="javascript:void()">
                                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                                <span class="icon-box">
                                                    <iconify-icon icon=heroicons-outline:chip> </iconify-icon>
                                                </span>
                                                <div class="text-box">App</div>
                                            </div>
                                            <div class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                                <iconify-icon icon="heroicons-outline:chevron-down"> </iconify-icon>
                                            </div>
                                        </a>

                                        <!-- Dropdown menu -->



                                        <ul class="sub-menu">



                                            <li>
                                                <a href=chat.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:chat class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            ChatAA
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=email.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:mail class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Email
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=calender>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:calendar class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Calendar
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=kanban>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:view-boards class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Kanban
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=todo>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:clipboard-check class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Todo
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=projects>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:document class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Projects
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>

                                        <!-- Megamenu -->


                                    </li>

                                    <li class="menu-item-has-children has-megamenu">
                                        <!--  Single menu -->

                                        <!-- has dropdown -->



                                        <a href="javascript:void()">
                                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                                <span class="icon-box">
                                                    <iconify-icon icon=heroicons-outline:view-boards> </iconify-icon>
                                                </span>
                                                <div class="text-box">Pages</div>
                                            </div>
                                            <div class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                                <iconify-icon icon="heroicons-outline:chevron-down"> </iconify-icon>
                                            </div>
                                        </a>

                                        <!-- Dropdown menu -->


                                        <!-- Megamenu -->



                                        <div class="rt-mega-menu">
                                            <div class="flex flex-wrap space-x-8 justify-between rtl:space-x-reverse">



                                                <div>
                                                    <!-- mega menu title -->
                                                    <div class="text-sm font-medium text-slate-900 dark:text-white mb-2 flex space-x-1 items-center">

                                                        <span> Authentication</span>
                                                    </div>
                                                    <!-- single menu item* -->



                                                    <a href=signin-one.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signin One
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=signin-two.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signin Two
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=signin-three.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signin Three
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=signup-one.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signup One
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=signup-two.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signup Two
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=signup-three.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signup Three
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=forget-password-one.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Forget Password One
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=forget-password-two.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Forget Password Two
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=forget-password-three.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Forget Password Three
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=lock-screen-one.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Lock Screen One
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=lock-screen-two.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Lock Screen Two
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=lock-screen-three.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Lock Screen Three
                                                            </span>
                                                        </div>

                                                    </a>

                                                </div>



                                                <div>
                                                    <!-- mega menu title -->
                                                    <div class="text-sm font-medium text-slate-900 dark:text-white mb-2 flex space-x-1 items-center">

                                                        <span> Components</span>
                                                    </div>
                                                    <!-- single menu item* -->



                                                    <a href=typography.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                typography
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=colors.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                colors
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=alert.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                alert
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=button.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                button
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=card.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                card
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=carousel.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                carousel
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=dropdown.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                dropdown
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=image.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                image
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=modal.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                modal
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=progress-bar.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Progress bar
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=placeholder.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Placeholder
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=tab-accordion.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Tab &amp; Accordion
                                                            </span>
                                                        </div>

                                                    </a>

                                                </div>



                                                <div>
                                                    <!-- mega menu title -->
                                                    <div class="text-sm font-medium text-slate-900 dark:text-white mb-2 flex space-x-1 items-center">

                                                        <span> Forms</span>
                                                    </div>
                                                    <!-- single menu item* -->



                                                    <a href=input.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Input
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=input-group.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Input group
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=input-layout.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Input layout
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=form-validation.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Form validation
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=form-wizard.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Wizard
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=input-mask.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Input mask
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=file-input>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                File input
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=form-repeater.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Form repeater
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=textarea.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Textarea
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=checkbox.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Checkbox
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=radio-button.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Radio button
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=switch.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Switch
                                                            </span>
                                                        </div>

                                                    </a>

                                                </div>



                                                <div>
                                                    <!-- mega menu title -->
                                                    <div class="text-sm font-medium text-slate-900 dark:text-white mb-2 flex space-x-1 items-center">

                                                        <span> Utility</span>
                                                    </div>
                                                    <!-- single menu item* -->



                                                    <a href=invoice.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Invoice
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=pricing.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Pricing
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=faq.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                FAQ
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=blank-page.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Blank page
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=blog.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Blog
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=404.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                404 page
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=comming-soon.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Coming Soon
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=under-maintanance.html>

                                                        <div class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span class="capitalize text-slate-600 dark:text-slate-300">
                                                                Under Maintanance page
                                                            </span>
                                                        </div>

                                                    </a>

                                                </div>

                                            </div>
                                        </div>

                                    </li>

                                    <li class="menu-item-has-children">
                                        <!--  Single menu -->

                                        <!-- has dropdown -->



                                        <a href="javascript:void()">
                                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                                <span class="icon-box">
                                                    <iconify-icon icon=heroicons-outline:view-grid-add> </iconify-icon>
                                                </span>
                                                <div class="text-box">Widgets</div>
                                            </div>
                                            <div class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                                <iconify-icon icon="heroicons-outline:chevron-down"> </iconify-icon>
                                            </div>
                                        </a>

                                        <!-- Dropdown menu -->



                                        <ul class="sub-menu">



                                            <li>
                                                <a href=basic-widgets.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:document-text class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Basic
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=statistics-widgets.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:document-text class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Statistic
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>

                                        <!-- Megamenu -->


                                    </li>

                                    <li class="menu-item-has-children">
                                        <!--  Single menu -->

                                        <!-- has dropdown -->



                                        <a href="javascript:void()">
                                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                                <span class="icon-box">
                                                    <iconify-icon icon=heroicons-outline:template> </iconify-icon>
                                                </span>
                                                <div class="text-box">Extra</div>
                                            </div>
                                            <div class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                                <iconify-icon icon="heroicons-outline:chevron-down"> </iconify-icon>
                                            </div>
                                        </a>

                                        <!-- Dropdown menu -->



                                        <ul class="sub-menu">



                                            <li>
                                                <a href=basic-table.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:table class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Basic Table
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=advance-table.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:table class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Advanced table
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=apex-chart.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:chart-bar class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Apex chart
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=chartjs.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:chart-bar class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Chart js
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=map.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:map class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Map
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>

                                        <!-- Megamenu -->


                                    </li>

                                </ul>
                            </div>
                            <!-- end top menu -->
                            <div class="nav-tools flex items-center lg:space-x-5 space-x-3 rtl:space-x-reverse leading-0">





                                <!-- END: Notification Dropdown -->

                                <!-- BEGIN: Profile Dropdown -->
                                <!-- Profile DropDown Area -->
                                <div class="md:block hidden w-full">
                                    <button class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center  inline-flex items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="lg:h-8 lg:w-8 h-7 w-7 rounded-full flex-1 ltr:mr-[10px] rtl:ml-[10px]">
                                            <img src="{{ asset('img/usuario.svg') }}" alt="user" class="block w-full h-full object-cover rounded-full">
                                        </div>
                                        @php
                                        //dd(session()->all(),auth()->user())
                                        @endphp
                                        <span class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap">{{ auth()->user()->email }}
                                        </span>
                                        <svg class="w-[16px] h-[16px] dark:text-white hidden lg:inline-block text-base inline-block ml-[10px] rtl:mr-[10px]" aria-hidden="true" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div class="dropdown-menu z-10 hidden bg-white divide-y divide-slate-100 shadow w-44 dark:bg-slate-800 border dark:border-slate-700 !top-[23px] rounded-md    overflow-hidden">
                                        <ul class="py-1 text-sm text-slate-800 dark:text-slate-200">
                                            @can('edit perfil')
                                            <li>
                                                <a href="{{ url('seguridad/perfil') }}" class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                    <iconify-icon icon="heroicons-outline:user" class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                    </iconify-icon>
                                                    <span class="font-Inter">Perfil</span>
                                                </a>
                                            </li>
                                            @endcan
                                            @can('edit password')
                                            <li>
                                                <a href="{{ url('seguridad/perfil/cambio_clave') }}" class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                    <iconify-icon icon="mdi:password-outline" class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1"></iconify-icon>
                                                    <span class="font-Inter">Cambio de contraseña</span>
                                                </a>
                                            </li>
                                            @endcan
                                            {{-- <li>
                                                <a href="email.html"
                                                    class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600  dark:text-white font-normal">
                                                    <iconify-icon icon="heroicons-outline:mail"
                                                        class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                    </iconify-icon>
                                                    <span class="font-Inter">Email</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="todo.html"
                                                    class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600  dark:text-white font-normal">
                                                    <iconify-icon icon="heroicons-outline:clipboard-check"
                                                        class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                    </iconify-icon>
                                                    <span class="font-Inter">Todo</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="settings.html"
                                                    class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600  dark:text-white font-normal">
                                                    <iconify-icon icon="heroicons-outline:cog"
                                                        class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                    </iconify-icon>
                                                    <span class="font-Inter">Settings</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="pricing.html"
                                                    class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                    <iconify-icon icon="heroicons-outline:credit-card"
                                                        class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                    </iconify-icon>
                                                    <span class="font-Inter">Price</span>
                                                </a>
                                            </li>
                                            <li> --}}
                                            <a class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600
                                                    dark:text-white font-normal" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                <iconify-icon icon="heroicons-outline:login" class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                </iconify-icon>
                                                <span class="font-Inter">Cerrar sesión</span>
                                            </a>

                                            </li>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </ul>
                                    </div>
                                </div>
                                <!-- END: Header -->
                                <button class="smallDeviceMenuController md:hidden block leading-0">
                                    <iconify-icon class="cursor-pointer text-slate-900 dark:text-white text-2xl" icon="heroicons-outline:menu-alt-3"></iconify-icon>
                                </button>
                                <!-- end mobile menu -->
                            </div>
                            <!-- end nav tools -->
                        </div>
                    </div>
                </div>

                <!-- END: Header -->
                <div class="content-wrapper transition-all duration-150 ltr:ml-[248px] rtl:mr-[248px]" id="content_wrapper">
                    <div class="page-content">
                        <div class="transition-all duration-150 container-fluid" id="page_layout">
                            <div id="content_layout">
                                @yield('contenido')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BEGIN: Footer For Desktop and tab -->
            {{-- <footer class="md:block hidden" id="footer">
                <div
                    class="site-footer px-6 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-300 py-4 ltr:ml-[248px] rtl:mr-[248px]">
                    <div class="grid md:grid-cols-2 grid-cols-1 md:gap-5">
                        <div class="text-center ltr:md:text-start rtl:md:text-right text-sm">
                            COPYRIGHT ©
                            <span id="thisYear"></span>
                            DGEHM, All rights Reserved
                        </div>
                        <div class="ltr:md:text-right rtl:md:text-end text-center text-sm">
                            Hand-crafted &amp; Made by
                            <a href="https://codeshaper.net" target="_blank" class="text-primary-500 font-semibold">
                                DGEHM
                            </a>
                        </div>
                    </div>
                </div>
            </footer> --}}
            <!-- END: Footer For Desktop and tab -->
            <div class="bg-white bg-no-repeat custom-dropshadow footer-bg dark:bg-slate-700 flex justify-around items-center backdrop-filter backdrop-blur-[40px] fixed left-0 bottom-0 w-full z-[9999] bothrefm-0 py-[12px] px-4 md:hidden">
                <a href="chat.html">
                    <div>
                        <span class="relative cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center mb-1 dark:text-white text-slate-900 ">
                            <iconify-icon icon="carbon:home"></iconify-icon>

                        </span>
                        <span class="block text-[11px] text-slate-600 dark:text-slate-300">
                            Inicio
                        </span>
                    </div>
                </a>
                <!-- <a href="{{url('/')}}"
                    class="relative bg-white bg-no-repeat backdrop-filter backdrop-blur-[40px] rounded-full footer-bg dark:bg-slate-700  h-[65px] w-[65px] z-[-1] -mt-[40px] flex justify-center items-center">
                    <div class="h-[50px] w-[50px] rounded-full relative left-[0px] hrefp-[0px] custom-dropshadow">
        
                            <iconify-icon icon="mdi:home-circle" width="3em" height="3em"></iconify-icon>
                    </div>
                </a> -->
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                    <div>
                        <span class=" relative cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center mb-1 dark:text-white text-slate-900">
                            <iconify-icon icon="material-symbols-light:logout"></iconify-icon>

                        </span>
                        <span class=" block text-[11px] text-slate-600 dark:text-slate-300">
                            Cerrar Sesión
                        </span>
                    </div>
                </a>

            </div>
        </div>
    </main>
    <!-- scripts -->

    <!-- Core Js -->
    {{-- <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/rt-plugins.js') }}"></script>
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/SimpleBar.js') }}"></script>

    <script src="{{ asset('assets/js/iconify.js') }}"></script>
    <!-- Jquery Plugins -->


    <!-- app js -->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": ">",
                        "previous": "<"
                    }
                }
            });
        });
    </script>




</body>










</html>