<!DOCTYPE html>
<html lang="es" dir="ltr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>DGEHM</title>
    <link rel="icon" type="image/png" href="{{ asset('img/escudo.svg') }}">
    <!-- BEGIN: Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- END: Google Font -->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/SimpleBar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rt-plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <!-- END: Theme CSS-->
    <script src="{{ asset('assets/js/settings.js') }}" sync></script>
    <script src="{{ asset('assets/js/iconify-icon.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}" sync></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

    <!-- select 2 -->
    <link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}">

    <style>
        .sidebar-wrapper {
            height: auto;
        }
    </style>

    <script>
        window.onload = function() {
            // Asegúrate de que el DOM esté completamente cargado
            var sidebar = document.querySelector('.sidebar-wrapper');
            var header = document.querySelector('.app-header');

            // Obtén la altura de .sidebar-wrapper
            var sidebarHeight = sidebar.offsetHeight;

            // Asigna esa altura a .app-header
            header.style.height = sidebarHeight + 'px';
        };

        // Para asegurarte de que la altura se actualice dinámicamente, podrías escuchar cambios de tamaño
        window.onresize = function() {
            var sidebar = document.querySelector('.sidebar-wrapper');
            var header = document.querySelector('.app-header');
            var sidebarHeight = sidebar.offsetHeight;
            header.style.height = sidebarHeight + 'px';
        };
    </script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <style>
        .highcharts-credits {
            display: none;
        }
    </style>


</head>

<body class=" font-inter dashcode-app" id="body_class">
    <!-- [if IE]> <p class="browserupgrade"> You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security. </p> <![endif] -->
    <main class="app-wrapper">
        <!-- BEGIN: Sidebar -->
        <!-- BEGIN: Sidebar -->
        <div class="sidebar-wrapper group">
            <div id="bodyOverlay"
                class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden"></div>
            <div class="logo-segment">
                <a class="flex items-center" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo-negro.png') }}" class="black_logo" alt="logo">
                    <img src="{{ asset('img/logo-negro.png') }}" class="white_logo" alt="logo">

                </a>
                <!-- Sidebar Type Button -->
                <div id="sidebar_type" class="cursor-pointer text-slate-900 dark:text-white text-lg">
                </div>
                <button class="sidebarCloseIcon text-2xl">
                    <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line">
                    </iconify-icon>
                </button>
            </div>


        </div>

        <div class="flex flex-col justify-between min-h-screen">


            <div>
                <!-- BEGIN: Header -->
                <!-- BEGIN: Header -->
                <div class="z-[9]" id="app_header">
                    <div class="app-header z-[999]  bg-white dark:bg-slate-800 shadow-sm dark:shadow-slate-700">
                        <div class="flex justify-between items-center">

                            <div
                                class="flex items-center md:space-x-4 space-x-2 xl:space-x-0 rtl:space-x-reverse vertical-box">






                            </div>


                            <div
                                class="nav-tools flex items-center lg:space-x-5 space-x-3 rtl:space-x-reverse leading-0">



                                <div class="md:block hidden w-full">
                                    @auth
                                        <a class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600
                                                    dark:text-white font-normal"
                                            href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            <button
                                                class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center inline-flex items-center"
                                                type="button" aria-expanded="false">
                                                <div
                                                    class="lg:h-8 lg:w-8 h-7 w-7 rounded-full flex-1 ltr:mr-[10px] rtl:ml-[10px]">
                                                    <iconify-icon icon="mdi:account-remove" width="36"
                                                        height="36"></iconify-icon>
                                                </div>
                                                <span
                                                    class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap">
                                                    Cerrar sesión</span>

                                            </button>

                                        </a>
                                    @else
                                        <a href="{{ url('/login') }}">
                                            <button
                                                class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center  inline-flex items-center"
                                                type="button" aria-expanded="false">
                                                <div
                                                    class="lg:h-8 lg:w-8 h-7 w-7 rounded-full flex-1 ltr:mr-[10px] rtl:ml-[10px]">
                                                    <iconify-icon icon="mdi:account-lock" width="36"
                                                        height="36"></iconify-icon>
                                                </div>
                                                <span
                                                    class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap">
                                                    Iniciar sesión</span>

                                            </button>
                                        </a>

                                        @endif


                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>

                                    </div>

                                </div>
                                <!-- end nav tools -->
                            </div>
                        </div>
                    </div>




                    <br>
                    <div class=" md:flex justify-between items-center">
                        <div>



                            <!-- BEGIN: Breadcrumb -->
                            <div class="mb-5">
                                <ul class="m-0 p-0 list-none">
                                    <a href="{{url('publico/reporte_falla_publico')}}">
                                    <button
                                        class="btn btn-white float-left  dark:bg-slate-700 dark:text-slate-300 m-1 active"
                                        id="pills-grid-tab" data-bs-toggle="pill" data-bs-target="#pills-grid"
                                        role="tab" aria-controls="pills-grid" aria-selected="true">
                                        <span class="flex items-center">
                                            <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2"
                                                icon="heroicons-outline:view-grid"></iconify-icon>
                                            <span>Reporte de falla</span>
                                        </span>
                                    </button>
                                    </a>
                                </ul>
                            </div>
                            <!-- END: BreadCrumb -->
                        </div>
                        <div class="flex flex-wrap ">
                            <ul class="nav nav-pills flex items-center flex-wrap list-none pl-0 mr-4" id="pills-tabVertical"
                                role="tablist">


                                <li class="nav-item flex-grow text-center" role="presentation">
                                    <a href="{{ url('/') }}?opcion=1">
                                        <button
                                            class="btn inline-flex justify-center btn-white dark:bg-slate-700 dark:text-slate-300 m-1 active"
                                            id="pills-grid-tab" data-bs-toggle="pill" data-bs-target="#pills-grid"
                                            role="tab" aria-controls="pills-grid" aria-selected="true">
                                            <span class="flex items-center">
                                                <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2"
                                                    icon="heroicons-outline:view-grid"></iconify-icon>
                                                <span>Nacional</span>
                                            </span>
                                        </button>
                                    </a>

                                </li>
                            </ul>
                            <a href="{{ url('/') }}?opcion=2">
                                <button
                                    class="btn inline-flex justify-center btn-white dark:bg-slate-700 dark:text-slate-300 m-1 ">
                                    <span class="flex items-center">
                                        <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2"
                                            icon="heroicons-outline:filter"></iconify-icon>
                                        <span>Departamental</span>
                                    </span>
                                </button>
                            </a>

                        </div>
                    </div>







                    @if ($opcion == 1)
                        <div class="page-content" id="div_nacional">
                            <div class="transition-all duration-150 container-fluid" id="page_layout">
                                <div id="content_layout">


                                    <div class="content-wrapper transition-all duration-150 " id="content_wrapper">
                                        <div class="page-content" style="display: none">
                                            <form method="GET" action="{{ url('home') }}">
                                                <div class="card xl:col-span-2">
                                                    <div class="card-body flex flex-col p-4">
                                                        <div class="space-y-6">
                                                            <div
                                                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                                                                <div class="input-area relative">
                                                                    <label for="largeInput" class="form-label">Año</label>
                                                                    <select class="form-control" name="anio">
                                                                        @for ($i = date('Y'); $i >= 2023; $i--)
                                                                            <option value="{{ $i }}"
                                                                                {{ $anio == $i ? 'selected' : '' }}>
                                                                                {{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="input-area relative">
                                                                    <label for="largeInput" class="form-label">Mes</label>
                                                                    <select class="form-control" name="mes">
                                                                        @foreach ($meses as $key => $value)
                                                                            <option value="{{ $key }}"
                                                                                {{ $mes == $key ? 'selected' : '' }}>
                                                                                {{ $value }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="input-area relative">
                                                                    <label for="largeInput" class="form-label">&nbsp;
                                                                    </label>
                                                                    <button class="btn btn-dark btn-sm"
                                                                        type="submit">Aceptar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="page-content">

                                            <div class="transition-all duration-150 container-fluid" id="page_layout">
                                                <div id="content_layout">



                                                    <div class="space-y-5">
                                                        <div class="grid grid-cols-12 gap-5">
                                                            <div class="xl:col-span-5 col-span-12 lg:col-span-5 ">
                                                                <div class="card p-6 h-full">
                                                                    <div class="space-y-5">
                                                                        <div id="container_tipo_luminaria_pie"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="xl:col-span-7 col-span-12 lg:col-span-7">
                                                                <div class="card p-6 h-full">
                                                                    <div class="space-y-5">
                                                                        <div id="container_tipo_luminaria"></div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="xl:col-span-5 col-span-12 lg:col-span-5 ">
                                                                <div class="card p-6 h-full">
                                                                    <div class="space-y-5">
                                                                        <div id="container_conteo_luminaria_pie"></div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="xl:col-span-7 col-span-12 lg:col-span-7">
                                                                <div class="card p-6 h-full">
                                                                    <div class="space-y-5">
                                                                        <div id="container_conteo_luminaria"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="xl:col-span-12 col-span-12 lg:col-span-12 ">
                                                                <div class="card p-6 h-full">
                                                                    <div class="space-y-5">
                                                                        <div id="container_data_rango_potencia_instalada">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="xl:col-span-12 col-span-12 lg:col-span-12 ">
                                                                <div class="card p-6 h-full">
                                                                    <div class="space-y-5" id="rango_data">

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





                            <script>
                                $(document).ready(function() {
                                    // consumo por tipo luminaria
                                    Highcharts.chart('container_tipo_luminaria', {
                                        chart: {
                                            type: 'column'
                                        },
                                        title: {
                                            align: 'left',
                                            text: 'Consumo por tipo de luminaria (kWh) <br>{{ $meses[$mes] }} {{ $anio }} '
                                        },
                                        subtitle: {
                                            align: 'left',
                                            text: ''
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total de consumo kilovatio hora'
                                            }

                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.2f}'
                                                }
                                            }
                                        },

                                        tooltip: {
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>',
                                            formatter: function() {
                                                return '<span style="font-size:11px">' + this.series.name + '</span><br>' +
                                                    '<span style="color:' + this.point.color + '">' + this.point.name +
                                                    '</span>: <b>' + Highcharts.numberFormat(this.point.y, 2, '.', ',') +
                                                    '</b> kWh<br/>';
                                            }
                                        },

                                        series: [{
                                            name: '',
                                            colorByPoint: true,
                                            data: @json($data_tipo_luminaria)

                                        }]
                                    });

                                    Highcharts.chart('container_tipo_luminaria_pie', {
                                        chart: {
                                            type: 'pie'
                                        },
                                        title: {
                                            align: 'left',
                                            text: 'Consumo por tipo de luminaria  (kWh)<br>{{ $meses[$mes] }} {{ $anio }} '
                                        },
                                        subtitle: {
                                            align: 'left',
                                            text: ''
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Total de consumo kilovatio hora'
                                            }

                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                dataLabels: {
                                                    enabled: true,
                                                    formatter: function() {
                                                        return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this
                                                            .point.y, 2, '.', ',');
                                                    }
                                                },
                                                showInLegend: true
                                            }
                                        },

                                        tooltip: {
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>',
                                            formatter: function() {
                                                return '<span style="color:' + this.point.color + '">' + this.point.name +
                                                    '</span>: <b>' + Highcharts.numberFormat(this.point.y, 2, '.', ',') +
                                                    ' kWh</b>';
                                            }
                                        },

                                        series: [{
                                            name: 'Browsers',
                                            colorByPoint: true,
                                            data: @json($data_tipo_luminaria)

                                        }]
                                    });

                                    // conteo por tipo luminaria

                                    Highcharts.chart('container_conteo_luminaria', {
                                        chart: {
                                            type: 'column'
                                        },
                                        title: {
                                            align: 'left',
                                            text: 'Cantidad por tipo de luminaria<br>{{ $meses[$mes] }} {{ $anio }}'
                                        },
                                        subtitle: {
                                            align: 'left',
                                            text: ''
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Número de luminarias'
                                            }

                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.y:.0f}'
                                                }
                                            }
                                        },

                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b>   <br/>'
                                        },

                                        series: [{
                                            name: 'Browsers',
                                            colorByPoint: true,
                                            data: @json($data_numero_luminaria)

                                        }]
                                    });

                                    Highcharts.chart('container_conteo_luminaria_pie', {
                                        chart: {
                                            type: 'pie'
                                        },
                                        title: {
                                            align: 'left',
                                            text: 'Cantidad por tipo de luminaria<br>{{ $meses[$mes] }} {{ $anio }}'
                                        },
                                        subtitle: {
                                            align: 'left',
                                            text: ''
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Número de luminarias'
                                            }

                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.y:.0f}'
                                                },
                                                showInLegend: true
                                            }
                                        },

                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b>   <br/>'
                                        },

                                        series: [{
                                            name: 'Browsers',
                                            colorByPoint: true,
                                            data: @json($data_numero_luminaria)

                                        }]
                                    });

                                    Highcharts.chart('container_data_rango_potencia_instalada', {
                                        chart: {
                                            type: 'pie',
                                            // height: 1700
                                        },
                                        title: {
                                            align: 'left',
                                            text: 'Potencia nominal por tecnología<br>{{ $meses[$mes] }} {{ $anio }}'
                                        },
                                        subtitle: {
                                            align: 'left',
                                            text: ''
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Número de luminarias'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '{point.name}: {point.y:.0f}'
                                                },
                                                point: {
                                                    events: {
                                                        click: function() {
                                                            //console.log(this.id); // Agregado aquí
                                                            showData(this.id);
                                                        }
                                                    }
                                                }
                                            }
                                        },
                                        tooltip: {
                                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> <br/>'
                                        },
                                        series: [{
                                            name: 'Browsers',
                                            colorByPoint: true,
                                            data: @json($data_rango_potencia_instalada)
                                        }]
                                    });
                                });

                                function showData(id) {
                                    $.ajax({
                                        url: '{{ url('welcome/rango_potencia_data') }}/' + id + '/' + {{ $anio }} + '/' +
                                            {{ $mes }},
                                        type: 'GET',
                                        success: function(response) {
                                            // Aquí manejas la respuesta del servidor
                                            $('#rango_data').html(response);
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            // Aquí manejas los errores de la petición
                                            console.error(textStatus, errorThrown);
                                        }
                                    });
                                }
                            </script>





                        </div>
                    @endif
                    @if ($opcion == 2)
                        <div class="page-content" id="div_departamental">
                            <div class=" md:flex justify-between items-center">
                                <div>



                                    <!-- BEGIN: Breadcrumb -->
                                    <div class="mb-5">
                                        <ul class="m-0 p-0 list-none">

                                        </ul>
                                    </div>
                                    <!-- END: BreadCrumb -->
                                </div>
                                <div class="flex flex-wrap ">
                                    <ul class="nav nav-pills flex items-center flex-wrap list-none pl-0 mr-4"
                                        id="pills-tabVertical" role="tablist">
                                        <select class="form-control" name="departamento" id="departamento"
                                            onchange="get_data_dep(this.value)">
                                            @foreach ($departamentos as $departamento)
                                                <option value="{{ $departamento->id }}"
                                                    {{ $departamento_id == $departamento->id ? 'selected' : '' }}>
                                                    {{ $departamento->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </ul>



                                </div>
                            </div>

                        </div>

                        <div class="transition-all duration-150 container-fluid" id="page_layout">
                            <div id="content_layout">


                                <div class="content-wrapper transition-all duration-150 " id="content_wrapper">
                                    <div class="page-content" style="display: none">
                                        <form method="GET" action="{{ url('home') }}">
                                            <div class="card xl:col-span-2">
                                                <div class="card-body flex flex-col p-4">
                                                    <div class="space-y-6">
                                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                                                            <div class="input-area relative">
                                                                <label for="largeInput" class="form-label">Año</label>
                                                                <select class="form-control" name="anio">
                                                                    @for ($i = date('Y'); $i >= 2023; $i--)
                                                                        <option value="{{ $i }}"
                                                                            {{ $anio == $i ? 'selected' : '' }}>
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <div class="input-area relative">
                                                                <label for="largeInput" class="form-label">Mes</label>
                                                                <select class="form-control" name="mes">
                                                                    @foreach ($meses as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ $mes == $key ? 'selected' : '' }}>
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="input-area relative">
                                                                <label for="largeInput" class="form-label">&nbsp;
                                                                </label>
                                                                <button class="btn btn-dark btn-sm"
                                                                    type="submit">Aceptar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="page-content">

                                        <div class="transition-all duration-150 container-fluid" id="page_layout">
                                            <div id="content_layout">



                                                <div class="space-y-5">
                                                    <div class="grid grid-cols-12 gap-5">
                                                        <div class="xl:col-span-5 col-span-12 lg:col-span-5 ">
                                                            <div class="card p-6 h-full">
                                                                <div class="space-y-5">
                                                                    <div id="container_tipo_luminaria_pie"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="xl:col-span-7 col-span-12 lg:col-span-7">
                                                            <div class="card p-6 h-full">
                                                                <div class="space-y-5">
                                                                    <div id="container_tipo_luminaria"></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="xl:col-span-5 col-span-12 lg:col-span-5 ">
                                                            <div class="card p-6 h-full">
                                                                <div class="space-y-5">
                                                                    <div id="container_conteo_luminaria_pie"></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="xl:col-span-7 col-span-12 lg:col-span-7">
                                                            <div class="card p-6 h-full">
                                                                <div class="space-y-5">
                                                                    <div id="container_conteo_luminaria"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="xl:col-span-12 col-span-12 lg:col-span-12 ">
                                                            <div class="card p-6 h-full">
                                                                <div class="space-y-5">
                                                                    <div id="container_data_rango_potencia_instalada">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="xl:col-span-12 col-span-12 lg:col-span-12 ">
                                                            <div class="card p-6 h-full">
                                                                <div class="space-y-5" id="rango_data">

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





                        <script>
                            $(document).ready(function() {
                                // consumo por tipo luminaria
                                Highcharts.chart('container_tipo_luminaria', {
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        align: 'left',
                                        text: 'Consumo por tipo de luminaria (kWh) <br>{{ $meses[$mes] }} {{ $anio }} '
                                    },
                                    subtitle: {
                                        align: 'left',
                                        text: ''
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Total de consumo kilovatio hora'
                                        }

                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.2f}'
                                            }
                                        }
                                    },

                                    tooltip: {
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>',
                                        formatter: function() {
                                            return '<span style="font-size:11px">' + this.series.name + '</span><br>' +
                                                '<span style="color:' + this.point.color + '">' + this.point.name +
                                                '</span>: <b>' + Highcharts.numberFormat(this.point.y, 2, '.', ',') +
                                                '</b> kWh<br/>';
                                        }
                                    },

                                    series: [{
                                        name: '',
                                        colorByPoint: true,
                                        data: @json($data_tipo_luminaria)

                                    }]
                                });

                                Highcharts.chart('container_tipo_luminaria_pie', {
                                    chart: {
                                        type: 'pie'
                                    },
                                    title: {
                                        align: 'left',
                                        text: 'Consumo por tipo de luminaria  (kwh)<br>{{ $meses[$mes] }} {{ $anio }} '
                                    },
                                    subtitle: {
                                        align: 'left',
                                        text: ''
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Total de consumo kilovatio hora'
                                        }

                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                formatter: function() {
                                                    return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this
                                                        .point.y, 2, '.', ',');
                                                }
                                            },
                                            showInLegend: true
                                        }
                                    },

                                    tooltip: {
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>',
                                        formatter: function() {
                                            return '<span style="color:' + this.point.color + '">' + this.point.name +
                                                '</span>: <b>' + Highcharts.numberFormat(this.point.y, 2, '.', ',') +
                                                ' kWh</b>';
                                        }
                                    },

                                    series: [{
                                        name: 'Browsers',
                                        colorByPoint: true,
                                        data: @json($data_tipo_luminaria)

                                    }]
                                });

                                // conteo por tipo luminaria

                                Highcharts.chart('container_conteo_luminaria', {
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        align: 'left',
                                        text: 'Cantidad por tipo de luminaria<br>{{ $meses[$mes] }} {{ $anio }}'
                                    },
                                    subtitle: {
                                        align: 'left',
                                        text: ''
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Número de luminarias'
                                        }

                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.y:.0f}'
                                            }
                                        }
                                    },

                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b>   <br/>'
                                    },

                                    series: [{
                                        name: 'Browsers',
                                        colorByPoint: true,
                                        data: @json($data_numero_luminaria)

                                    }]
                                });

                                Highcharts.chart('container_conteo_luminaria_pie', {
                                    chart: {
                                        type: 'pie'
                                    },
                                    title: {
                                        align: 'left',
                                        text: 'Cantidad por tipo de luminaria<br>{{ $meses[$mes] }} {{ $anio }}'
                                    },
                                    subtitle: {
                                        align: 'left',
                                        text: ''
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Número de luminarias'
                                        }

                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b>{point.name}</b>: {point.y:.0f}'
                                            },
                                            showInLegend: true
                                        }
                                    },

                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b>   <br/>'
                                    },

                                    series: [{
                                        name: 'Browsers',
                                        colorByPoint: true,
                                        data: @json($data_numero_luminaria)

                                    }]
                                });

                                Highcharts.chart('container_data_rango_potencia_instalada', {
                                    chart: {
                                        type: 'pie',
                                        // height: 1700
                                    },
                                    title: {
                                        align: 'left',
                                        text: 'Potencia nominal por tecnología<br>{{ $meses[$mes] }} {{ $anio }}'
                                    },
                                    subtitle: {
                                        align: 'left',
                                        text: ''
                                    },
                                    accessibility: {
                                        announceNewData: {
                                            enabled: true
                                        }
                                    },
                                    xAxis: {
                                        type: 'category'
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Número de luminarias'
                                        }
                                    },
                                    legend: {
                                        enabled: false
                                    },
                                    plotOptions: {
                                        series: {
                                            borderWidth: 0,
                                            dataLabels: {
                                                enabled: true,
                                                format: '{point.name}: {point.y:.0f}'
                                            },
                                            point: {
                                                events: {
                                                    click: function() {
                                                        //console.log(this.id); // Agregado aquí
                                                        showData(this.id);
                                                    }
                                                }
                                            }
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> <br/>'
                                    },
                                    series: [{
                                        name: 'Browsers',
                                        colorByPoint: true,
                                        data: @json($data_rango_potencia_instalada)
                                    }]
                                });
                            });

                            function showData(id) {
                                $.ajax({
                                    url: '{{ url('welcome/rango_potencia_data') }}/' + id + '/' + {{ $anio }} + '/' +
                                        {{ $mes }} + '?departamento_id=' + {{ $departamento_id }},
                                    type: 'GET',
                                    success: function(response) {
                                        // Aquí manejas la respuesta del servidor
                                        $('#rango_data').html(response);
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        // Aquí manejas los errores de la petición
                                        console.error(textStatus, errorThrown);
                                    }
                                });
                            }
                        </script>
                    @endif

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

        <!-- Select2 -->
        <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>


        <script>
            function get_data_dep(id) {
                var url = "{{ url('/') }}?opcion=2&departamento=" + id;
                window.location.href = url;
            }
        </script>

    </body>

    </html>
