@extends ('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <style>
        #loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        #loading img {
            width: 50px;
            /* ajusta el tamaño de la imagen según sea necesario */
            height: 50px;
        }
    </style>

    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Importación de base de datos


                            </div>
                        </div>
                    </header>




                    <div class="transition-all duration-150 container-fluid" id="page_layout">
                        <div id="content_layout">
                            <div class="space-y-5">
                                <div class="grid grid-cols-12 gap-5">
                                    <div class="xl:col-span-3 col-span-12 lg:col-span-3 ">
                                        <div class="card p-6 h-full">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="xl:col-span-6 col-span-12 lg:col-span-6">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ url('importacion/base_datos') }}"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div id="loading">
                                                <img src="{{ asset('img/loading.gif') }}" style="width: 100px; height:100px"
                                                    alt="Cargando...">
                                            </div>


                                            <div class="card h-full">
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Año</label>
                                                        <select name="anio" class="form-control">
                                                            @for ($i = date('Y'); $i >= 2023; $i--)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Mes</label>
                                                        <select name="mes" class="form-control">
                                                            @foreach ($meses as $numero => $nombre)
                                                                <option value="{{ $numero }}"
                                                                    {{ date('m') == $numero ? 'selected' : '' }}>
                                                                    {{ $nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Archivo</label>
                                                        <input type="file" name="file" accept=".xlsx,.xls"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div style="text-align: right;">
                                                    <button type="submit" style="margin-right: 18px"
                                                        class="btn btn-dark">Aceptar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="xl:col-span-3 col-span-12 lg:col-span-3 ">
                                        <div class="card p-6 h-full">
                                            &nbsp;
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

    <!-- scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js'></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $(":input").inputmask();
            $("#departamento").change(function() {
                // var para la Departamento
                const Departamento = $(this).val();


                $.get("{{ url('censo_luminaria/get_distritos') }}" + '/' + Departamento, function(data) {
                    console.log(data);
                    var _select = ''
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '">' + data[i].nombre +
                        '</option>';
                    $("#distrito").html(_select);

                });
            });

        });


        function obtenerUbicacion() {
            // Mostrar la imagen de carga
            toggleLoading(true);

            // Verificar si el navegador soporta la geolocalización
            if (navigator.geolocation) {
                // Obtener la ubicación actual
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Extraer latitud y longitud
                    var latitud = position.coords.latitude;
                    var longitud = position.coords.longitude;

                    // Mostrar latitud y longitud en los campos de texto
                    $("#latitud").val(latitud);
                    $("#longitud").val(longitud);
                    $("#localizacion").val(latitud + ' ' + longitud);

                    // Ocultar la imagen de carga
                    toggleLoading(false);
                });
            } else {
                alert("Tu navegador no soporta la geolocalización.");
                // Ocultar la imagen de carga en caso de error
                toggleLoading(false);
            }
        }

        function toggleLoading(show) {
            if (show) {
                $("#loading").show();
            } else {
                $("#loading").hide();
            }
        }
    </script>


@endsection
{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <title id='Description'>JavaScript PivotGrid - Pivot Table Designer</title>
    <link rel="stylesheet" href="{{ asset('jqwidgets/jqwidgets/styles/jqx.base.css') }}" type="text/css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />

    <link rel="stylesheet" href="{{ asset('jqwidgets/jqwidgets/styles/jqx.light.css') }}" type="text/css" />
    <script type="text/javascript" src="{{ asset('jqwidgets/scripts/jquery-1.11.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxcore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxdata.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxbuttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxcheckbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxinput.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxscrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxmenu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxwindow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxlistbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxdropdownlist.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxdragdrop.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxpivot.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxpivotgrid.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/jqwidgets/jqxpivotdesigner.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets/scripts/demos.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // prepare sample data
            var data = new Array();
            var firstNames = [
                "Andrew", "Nancy", "Shelley", "Regina", "Yoshi", "Antoni", "Mayumi", "Ian", "Peter", "Lars",
                "Petra", "Martin", "Sven", "Elio", "Beate", "Cheryl", "Michael", "Guylene"
            ];
            var lastNames = [
                "Fuller", "Davolio", "Burke", "Murphy", "Nagase", "Saavedra", "Ohno", "Devling", "Wilson",
                "Peterson", "Winkler", "Bein", "Petersen", "Rossi", "Vileid", "Saylor", "Bjorn", "Nodier"
            ];
            var productNames = [
                "Black Tea", "Green Tea", "Caffe Espresso", "Doubleshot Espresso", "Caffe Latte",
                "White Chocolate Mocha", "Cramel Latte", "Caffe Americano", "Cappuccino", "Espresso Truffle",
                "Espresso con Panna", "Peppermint Mocha Twist"
            ];
            var priceValues = [
                "2.25", "1.5", "3.0", "3.3", "4.5", "3.6", "3.8", "2.5", "5.0", "1.75", "3.25", "4.0"
            ];
            for (var i = 0; i < 500; i++) {
                var row = {};
                var productindex = Math.floor(Math.random() * productNames.length);
                var price = parseFloat(priceValues[productindex]);
                var quantity = 1 + Math.round(Math.random() * 10);
                row["firstname"] = firstNames[Math.floor(Math.random() * firstNames.length)];
                row["lastname"] = lastNames[Math.floor(Math.random() * lastNames.length)];
                row["productname"] = productNames[productindex];
                row["price"] = price;
                row["quantity"] = quantity;
                row["total"] = price * quantity;
                data[i] = row;
            }
            // create a data source and data adapter
            var source = {
                localdata: data,
                datatype: "array",
                datafields:
                 [{
                        name: 'firstname',
                        type: 'string'
                    },
                    {
                        name: 'lastname',
                        type: 'string'
                    },
                    {
                        name: 'productname',
                        type: 'string'
                    },
                    {
                        name: 'quantity',
                        type: 'number'
                    },
                    {
                        name: 'price',
                        type: 'number'
                    },
                    {
                        name: 'total',
                        type: 'number'
                    }
                ]
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            dataAdapter.dataBind();
            // create a pivot data source from the dataAdapter
            var pivotDataSource = new $.jqx.pivot(
                dataAdapter, {
                    customAggregationFunctions: {
                        'var': function(values) {
                            if (values.length <= 1)
                                return 0;
                            // sample's mean
                            var mean = 0;
                            for (var i = 0; i < values.length; i++)
                                mean += values[i];
                            mean /= values.length;
                            // calc squared sum
                            var ssum = 0;
                            for (var i = 0; i < values.length; i++)
                                ssum += Math.pow(values[i] - mean, 2)
                            // calc the variance
                            var variance = ssum / values.length;
                            return variance;
                        }
                    },
                    pivotValuesOnRows: false,
                    fields: [{
                            dataField: 'firstname',
                            text: 'First Name'
                        },
                        {
                            dataField: 'lastname',
                            text: 'Last Name'
                        },
                        {
                            dataField: 'productname',
                            text: 'Product Name'
                        },
                        {
                            dataField: 'quantity',
                            text: 'Quantity'
                        },
                        {
                            dataField: 'price',
                            text: 'Price'
                        },
                        {
                            dataField: 'total',
                            text: 'Total'
                        }
                    ],
                    rows: [{
                            dataField: 'firstname',
                            text: 'First Name'
                        },
                        {
                            dataField: 'lastname',
                            text: 'Last Name'
                        }
                    ],
                    columns: [{
                        dataField: 'productname',
                        align: 'left'
                    }],
                    filters: [{
                        dataField: 'productname',
                        text: 'Product name',
                        filterFunction: function(value) {
                            if (value == "Black Tea" || value == "Green Tea")
                                return true;
                            return false;
                        }
                    }],
                    values: [{
                            dataField: 'price',
                            'function': 'sum',
                            text: 'Sum',
                            align: 'left',
                            formatSettings: {
                                prefix: '$',
                                decimalPlaces: 2,
                                align: 'center'
                            },
                            cellsClassName: 'myItemStyle',
                            cellsClassNameSelected: 'myItemStyleSelected'
                        },
                        {
                            dataField: 'price',
                            'function': 'count',
                            text: 'Count',
                            className: 'myItemStyle',
                            classNameSelected: 'myItemStyleSelected'
                        }
                    ]
                });
            var localization = {
                'var': 'Variance'
            };
            // create a pivot grid
            $('#divPivotGrid').jqxPivotGrid({
                localization: localization,
                source: pivotDataSource,
                treeStyleRows: false,
                autoResize: false,
                multipleSelectionEnabled: true
            });
            var pivotGridInstance = $('#divPivotGrid').jqxPivotGrid('getInstance');
            // create a pivot grid
            $('#divPivotGridDesigner').jqxPivotDesigner({
                type: 'pivotGrid',
                target: pivotGridInstance
            });
        });
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-2FX5PV9DNT"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-2FX5PV9DNT');
    </script>
</head>
<!-- CSS de Bootstrap 5 -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Qt9Hug5NfnQDGMoaQYXN1+PiQvda7poO7/6kEduZTtF3EhCv7Sj5hJf3JvNQJbB6" crossorigin="anonymous">
<!-- JavaScript Bundle con Popper de Bootstrap 5 -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"
    integrity="sha384-kQtW33rZJAHj6MNi6OnkEO2F7YsF5v/T6KZK4uLNLq5yNQb6v4jRWtBc3J0MdK+L" crossorigin="anonymous">
</script>


<body class='default'>
    <div class="table-responsive">
        <table class="data-table">
            <tr>
                <td>
                    <div id="divPivotGridDesigner" style="height: 400px; width: 450px;">
                    </div>
                </td>
                <td>
                    <div id="divPivotGrid" style="height: 400px; width: 1400px;">
                    </div>
                </td>
            </tr>
        </table>
    </div>




{{--
<!DOCTYPE html>
<html>

<head>
    <title>Pivot Demo</title>
    <!-- external libs from cdnjs -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <!-- PivotTable.js libs from ../dist -->
    <link rel="stylesheet" type="text/css" href="{{ asset('pivot/pivot.css') }}">
    <script type="text/javascript" src="{{ asset('pivot/pivot.js') }}"></script>
    <style>
        body {
            font-family: Verdana;
        }
    </style>


    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>


</head>

<body>
    <script type="text/javascript">
        $(function() {
            $("#output").pivotUI(
                    @json($data)
                , {
                    rows: ["Tipo"],
                    cols: @json($datafields)
                }
            );
        });
    </script>

    <div id="output" style="margin: 30px;"></div>

</body>

</html> --}}
