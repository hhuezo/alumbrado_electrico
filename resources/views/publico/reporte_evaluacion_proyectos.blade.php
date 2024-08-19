<!DOCTYPE html>
<html lang="zxx" dir="ltr" class="light semiDark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <title>Evaluación de proyectos</title>

    <style>
        .dataTable {
            border-collapse: collapse;
            width: 100%;
            padding: 10px !important;
        }

        .th_td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .backgroundth {
            background-color: #f2f2f2;
        }

        .backgroundtd {
            background-color: #ffffff;
        }

        .editable {
            cursor: pointer;
        }

         /* body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        h4 {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }

        .card {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            page-break-inside: avoid;
            /* Evita que la tarjeta se corte dentro de una página */
            break-inside: avoid;
            /* Alternativa en caso de que `page-break-inside` no funcione */
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 10px;
        }

        .dataTable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

      .dataTable th,
        .dataTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .dataTable th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .dataTable td {
            background-color: #fff;
        }

        .input-area {
            margin-bottom: 10px;
        }

        .inputLabel {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border: none;
            margin: 0;
            padding: 0;
            display: block;
        }*/
    </style>
</head>

<body class=" font-inter dashcode-app" id="body_class">
    <main class="app-wrapper">

        <div class="space-y-5">



            <div class="grid grid-cols-12 gap-5">
                <div class="xl:col-span-6 col-span-12 lg:col-span-7">
                    <div class="card h-full">
                        <div class="card-header">
                            <h4 class="card-title">Evaluación de proyectos</h4>
                        </div>
                        <div class="card-body p-6">
                            <input type="hidden" id="tipo" value="1">
                            @csrf
                            <div class="input-area">
                                <label for="largeInput" class="inputLabel">Departamento:</label>
                                <h4>{{ $jsonUbicacion[0]['departamento'] }}</h4>
                            </div>
                            <br>
                            <div class="input-area">
                                <label for="largeInput" class="inputLabel">Municipio:</label>
                                <h4>{{ $jsonUbicacion[0]['municipio'] }}</h4>
                            </div>
                            <br>
                            <div class="input-area">
                                <label for="largeInput" class="inputLabel">Distrito:</label>
                                <h4>{{ $jsonUbicacion[0]['distrito'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-6 col-span-12 lg:col-span-12">
                    <div class="card h-full">
                        <div class="card-body p-6">
                            <div id="divGrafico">
                                <img src="data:image/svg+xml;base64,{{ $jsonGrafico }}" alt="Gráfico"
                                    style="margin: 0 auto; " />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-5" id="render">

                <div class="xl:col-span-12 col-span-12 lg:col-span-12">
                    <div class="card">
                        <div class="card-body flex flex-col p-6">
                            <header
                                class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                <div class="flex-1">
                                    <div class="card-title text-slate-900 dark:text-white">Luminarias que se desean
                                        sustituir
                                    </div>
                                </div>
                            </header>
                            <div class="card-text h-full ">
                                <div id="divFormTecnologias">
                                    <br>
                                    <table class="dataTable">
                                        <thead>
                                            <tr>
                                                <th class="th_td backgroundth">Tecnología</th>
                                                <th class="th_td backgroundth">Potencia</th>
                                                <th class="th_td backgroundth">kWh</th>
                                                <th class="th_td backgroundth">N° Luminarias</th>
                                                <th class="th_td backgroundth">Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jsonTablaSustituir as $resultado)
                                            <tr>
                                                <td class="th_td backgroundtd">
                                                    {{ $resultado['tecnologia'] }}
                                                </td>
                                                <td class="th_td backgroundtd">
                                                    {{ $resultado['potenciaNominal'] }} Vatios
                                                </td>
                                                <td class="th_td backgroundtd">
                                                    {{ $resultado['consumoMensual'] }}
                                                </td>
                                                <td class="th_td backgroundtd">
                                                    {{ $resultado['totalLuminarias'] }}
                                                </td>
                                                <td class="th_td backgroundtd">
                                                    {{ $resultado['luminariasSustituir'] }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="xl:col-span-6 col-span-12 lg:col-span-6">
                    <div class="card">
                        <div class="card-body flex flex-col p-6">
                            <header
                                class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                <div class="flex-1">
                                    <div class="card-title text-slate-900 dark:text-white">TECNOLOGÍA SUGERIDA A
                                        SUSTITUIR
                                    </div>
                                </div>
                            </header>
                            <div class="space-y-4">
                                <div class="input-area relative pl-27">
                                    <label for="largeInput" class="inputLabel">Tecnología a sustituir:</label>
                                    <h4>{{ $jsonTecnologiaSustituir[0]['tecnologia_sustituir'] }}</h4>
                                </div>
                                <br>
                                <div class="input-area relative pl-27">
                                    <label for="tecno_susti_kwh_uso" class="inputLabel">kWh de uso:</label>
                                    <h4>{{ $jsonTecnologiaSustituir[0]['tecno_susti_kwh_uso'] }}</h4>
                                </div>
                                <br>
                                <div class="input-area relative pl-27">
                                    <label for="tecno_susti_valor_mercado" class="inputLabel">Precio Mercado por unidad
                                        ($):</label>
                                    <h4>${{ $jsonTecnologiaSustituir[0]['tecno_susti_valor_mercado'] }}</h4>
                                </div>
                                <br>
                                <div class="input-area relative pl-27">
                                    <label for="tecno_susti_total_iluminarias" class="inputLabel">Total a
                                        sustituir:</label>
                                    <h4>{{ $jsonTecnologiaSustituir[0]['tecno_susti_total_iluminarias'] }}</h4>

                                </div>
                                <br>
                                <div class="input-area relative pl-27">
                                    <label for="tecno_susti_total_inversion" class="inputLabel">Total inversión
                                        ($):</label>
                                    <h4>{{ $jsonTecnologiaSustituir[0]['tecno_susti_total_inversion'] }}</h4>

                                </div>
                            </div>
                            <br>
                        </div>

                    </div>

                </div>

                <div class="xl:col-span-6 col-span-12 lg:col-span-6">
                    <div class="card">
                        <div class="card-body flex flex-col p-6">
                            <header
                                class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                <div class="flex-1">
                                    <div class="card-title text-slate-900 dark:text-white">Analisis Financiero
                                    </div>
                                </div>
                            </header>
                            <label for="" class="card-title dark:bg-slate-800 dark:border-slate-700 text-primary-500">
                                Valor
                                kWh:
                                ${{ rtrim($configuracion->valor_kwh, '0') }}</label></br>
                            <table
                                class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 dataTable">
                                <thead class="">
                                    <tr>

                                        <th class="th_td" scope="col"
                                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 text-primary-500">
                                        </th>
                                        <th class="th_td" scope="col"
                                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                                            Costo Mensual total
                                        </th>

                                        <th class="th_td" scope="col"
                                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                                            Costo Anual
                                        </th>

                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                    <tr>
                                        <th class="th_td" scope="col"
                                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                                            Precio energia facturado
                                        </th>
                                        <td class="th_td" id="precio_facturado_mensual"
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $jsonAnalisisFinanciero[0]['precio_facturado_mensual'] }}
                                        </td>
                                        <td class="th_td" id="precio_facturado_anual"
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                                            {{ $jsonAnalisisFinanciero[0]['precio_facturado_anual'] }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="th_td" scope="col"
                                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                                            Precio sustituido
                                        </th>
                                        <td class="th_td" id="precio_sustituido_costo_mensual"
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $jsonAnalisisFinanciero[0]['precio_sustituido_costo_mensual'] }}
                                        </td>
                                        <td class="th_td" id="precio_sustituido_costo_anual"
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                                            {{ $jsonAnalisisFinanciero[0]['precio_sustituido_costo_anual'] }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="th_td" scope="col"
                                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                                            Ahorro
                                        </th>
                                        <td class="th_td" id="ahorro_mensual"
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                            {{ $jsonAnalisisFinanciero[0]['ahorro_mensual'] }}
                                        </td>
                                        <td class="th_td" id="ahorro_anual"
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                                            {{ $jsonAnalisisFinanciero[0]['ahorro_anual'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="th_td"
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700">
                                        </td>
                                        <th class="th_td" scope="col"
                                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                                            PR
                                        </th>
                                        <td class="th_td" id="pr"
                                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                                            {{ $jsonAnalisisFinanciero[0]['pr'] }}
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                            <br>
                            <div class="flex-1">
                                <div class="text-slate-900 dark:text-white">PR: Periodo de recuperacion simple es la
                                    inversion entre el
                                    ahorro anual.</div>
                            </div>
                            <br>
                            @if ($jsonAnalisisFinanciero[0]['pr'] <= 3 && $jsonAnalisisFinanciero[0]['pr']>= 0)
                                <div id="recomendable" class="py-[18px] px-6 font-normal font-Inter text-sm rounded-md bg-success-500 text-white dark:bg-success-500
                      dark:text-slate-300">
                                    <div class="flex items-start space-x-3 rtl:space-x-reverse">
                                        <div class="flex-1">
                                            El Proyecto Es viable.
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div id="noRecomendable" class="py-[18px] px-6 font-normal font-Inter text-sm rounded-md bg-danger-500 text-white dark:bg-danger-500
                                            dark:text-slate-300">
                                    <div class="flex items-start space-x-3 rtl:space-x-reverse">
                                        <div class="flex-1">
                                            Revisar condiciones para su ejecución
                                        </div>
                                    </div>
                                </div>
                                @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="xl:col-span-12 col-span-12 lg:col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">

                    <div class="card-text h-full ">
                        <div id="nuevo_grafico">
                            <img src="data:image/svg+xml;base64,{{ $jsonGraficoSustituir }}" alt="Gráfico"
                                style="margin: 0 auto;" />
                        </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </main>
</body>

</html>
