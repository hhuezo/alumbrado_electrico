<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Script de Iconify -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}" sync></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <style>
        .highcharts-credits {
            display: none;
        }
    </style>

    <style>
        .navbar {
            background-color: #0F172A;
            /* Fondo oscuro */
        }

        .navbar-brand img {
            height: 40px;
        }

        body {
            padding-top: 70px;
            background-color: #F8F9FA;
            /* Fondo general claro */
        }

        .nav-link {
            color: white;
        }

        .dashboard-options {
            margin-top: 20px;
        }

        .dashboard-option {
            display: flex;
            align-items: center;
            padding: 12px;
            /* Ajuste del padding */
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
            /* Sombra ligera */
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            height: 100%;
        }

        .dashboard-option:hover {
            transform: translateY(-3px);
            /* Elevación más sutil */
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            /* Sombra más ligera */

            background-color: transparent;
        }

        .dashboard-option span {
            margin-right: 8px;
            /* Margen más pequeño */
            font-size: 16px;
            /* Texto ligeramente más pequeño */
            color: #0F172A;
        }

        .dashboard-option a {
            text-decoration: none !important;
            /* Quitar subrayado */
            color: inherit !important;
            /* Mantener el color del texto del padre */
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/logo-blanco.png') }}" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    @auth
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"
                                class="nav-link">
                                <span class="iconify" data-icon="mdi:logout" data-width="30" data-height="30"
                                    style="color: white; margin-right: 5px;"></span>
                                Cerrar sesión
                            </a>
                        </li>
                    @else
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ url('/login') }}" class="nav-link">
                                <span class="iconify" data-icon="mdi:login" data-width="30" data-height="30"
                                    style="color: white; margin-right: 5px;"></span>
                                Iniciar sesión
                            </a>
                        </li>
                        @endif
                    </ul>


                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>


        </nav>

        <!-- Contenido principal -->
        <div class="container-fluid mt-4">
            <div class="row dashboard-options">
                <div class="col-lg-6 col-sm-12 mb-3"></div>

                <div class="col-lg-2 col-sm-12 mb-3">
                    <div class="dashboard-option">
                        <a href="{{ url('publico/reporte_falla_publico') }}"
                            style="display: flex; width: 100%; height: 100%;">
                            <span class="iconify" data-icon="mdi:alert-circle-outline" data-width="25"
                                data-height="25"></span>
                            <span>&nbsp;Reporte de Falla</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-12 mb-3">
                    <div class="dashboard-option">
                        <a href="{{ url('/') }}?opcion=1" style="display: flex; width: 100%; height: 100%;">
                            <span class="iconify" data-icon="mdi:filter-outline" data-width="25" data-height="25"></span>
                            <span>Nacional</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-12 mb-3">
                    <div class="dashboard-option">
                        <a href="{{ url('/') }}?opcion=2" style="display: flex; width: 100%; height: 100%;">
                            <span class="iconify" data-icon="mdi:filter-outline" data-width="25" data-height="25"></span>
                            <span>Departamental</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>




        @if ($opcion == 1)
            <div class="page-content" id="div_nacional">
                <div class="container-fluid py-4" id="page_layout">
                    <div id="content_layout">
                        <div class="content-wrapper">


                            <!-- Contenido principal -->
                            <div class="container-fluid">
                                <div class="row g-4">
                                    <div class="col-lg-5">
                                        <div class="card h-100 p-4">
                                            <div id="container_tipo_luminaria_pie"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="card h-100 p-4">
                                            <div id="container_tipo_luminaria"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="card h-100 p-4">
                                            <div id="container_conteo_luminaria_pie"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="card h-100 p-4">
                                            <div id="container_conteo_luminaria"></div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="card h-100 p-4">
                                            <div id="container_data_rango_potencia_instalada"></div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="card h-100 p-4">
                                            <div id="rango_data"></div>
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

                            }],
                            colors: [
                                '#004291', // Color for the first segment
                                '#0067b6', // Color for the second segment
                                '#088bda', // Color for the third segment
                                '#2caffe', // Color for the fourth segment
                                '#50d3ff', // Color for the fifth segment
                                '#74f7ff', // Color for the sixth segment
                                '#74f7ff', // Color for the seventh segment

                                // Add more colors as needed
                            ]
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

                            }],
                            colors: [
                                '#f88f1f', // Color for the first segment
                                '#f79e3f', // Color for the second segment
                                '#f3b475', // Color for the sixth segment
                                '#fbbf7f', // Color for the third segment
                                '#f3c891', // Color for the fourth segment
                                '#ffeccc', // Color for the fifth segment
                                '#74f7ff', // Color for the seventh segment

                                // Add more colors as needed
                            ]
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

                            }],
                            colors: [
                                '#cf108c', // Color for the first segment
                                '#d54d9d', // Color for the second segment
                                '#da6ea9', // Color for the sixth segment
                                '#df8cba', // Color for the third segment
                                '#e7a8cd', // Color for the fourth segment
                                '#f0c7e0', // Color for the fifth segment
                                '#f0c7e0', // Color for the seventh segment

                                // Add more colors as needed
                            ]
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

                            }],
                            colors: [
                                '#3ab44b', // Color for the first segment
                                '#63bb5e', // Color for the second segment
                                '#83c678', // Color for the sixth segment
                                '#9bd093', // Color for the third segment
                                '#b7deaf', // Color for the fourth segment
                                '#b6f7a4', // Color for the fifth segment
                                '#74f7ff', // Color for the seventh segment

                                // Add more colors as needed
                            ]
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
                            }],
                            colors: [
                                '#131a7b', // Color for the first segment
                                '#383fa0', // Color for the second segment
                                '#5c63c4', // Color for the third segment
                                '#8087e8', // Color for the fourth segment
                                '#a4abff', // Color for the fifth segment
                                '#c8cfff', // Color for the sixth segment
                                '#c8cfff', // Color for the seventh segment

                                // Add more colors as needed
                            ]
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
            <div class="transition-all duration-150 container-fluid" id="div_departamental">

                <div class="row">
                    <div class="col-lg-8 col-sm-12"></div>
                    <div class="col-lg-4 col-sm-12">
                        <select class="form-select" name="departamento" id="departamento"
                            onchange="get_data_dep(this.value)">
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}"
                                    {{ $departamento_id == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>


            <div class="container-fluid" id="page_layout">
                <br>
                <div id="content_layout">




                    <div class="container-fluid">
                        <div class="row g-4">
                            <div class="col-lg-5">
                                <div class="card h-100 p-4">
                                    <div id="container_tipo_luminaria_pie"></div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card h-100 p-4">
                                    <div id="container_tipo_luminaria"></div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="card h-100 p-4">
                                    <div id="container_conteo_luminaria_pie"></div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card h-100 p-4">
                                    <div id="container_conteo_luminaria"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card h-100 p-4">
                                    <div id="container_data_rango_potencia_instalada"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card h-100 p-4">
                                    <div id="rango_data"></div>
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



        <br>








        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            function get_data_dep(id) {
                var url = "{{ url('/') }}?opcion=2&departamento=" + id;
                window.location.href = url;
            }
        </script>

    </body>

    </html>
