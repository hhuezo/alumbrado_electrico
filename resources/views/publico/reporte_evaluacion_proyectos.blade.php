<!DOCTYPE html>
<html lang="zxx" dir="ltr" class="light semiDark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/SimpleBar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rt-plugins.css') }}">
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
    </style>
</head>

<body class=" font-inter dashcode-app" id="body_class">
    <main class="app-wrapper">

        <div class="space-y-5">
            <h4 class="card-title">Evaluación de proyectos</h4>

            <div class="grid grid-cols-12 gap-5">
                <div class="xl:col-span-6 col-span-12 lg:col-span-12">
                    <div class="card h-full">
                        <div class="card-body p-6">
                            <header
                                class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                <div class="flex-1">
                                    <div class="card-title text-slate-900 dark:text-white">Luminarias que se desean
                                        sustituir
                                    </div>
                                </div>
                            </header>
                            <div id="divGrafico">
                                <img src="data:image/svg+xml;base64,{{ $jsonGrafico }}" alt="Gráfico" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-5" id="render"></div>
        </div>

        <div class="xl:col-span-12 col-span-12 lg:col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header
                        class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Luminarias que se desean sustituir
                            </div>
                        </div>
                    </header>
                    <div class="card-text h-full ">
                        <div id="divFormTecnologias">
                            <br>
                            <table class="datatable">
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
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">TECNOLOGÍA SUGERIDA A SUSTITUIR
                    </div>
                </div>
            </header>




            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="space-y-4">
                <br>
                <div class="input-area relative pl-27">
                    <label for="largeInput" class="form-label">Tecnología a sustituir</label>
                    <select class="form-control select2" id="tecnologia_sustituir">
                        <option value="" selected disabled>Seleccione...</option>
                    </select>
                </div>
                <br>
                <div class="input-area relative pl-27">
                    <label for="tecno_susti_kwh_uso" class="inputLabel">kWh de uso</label>
                    <input readonly id="tecno_susti_kwh_uso" type="number" class="form-control iluminaria"
                        placeholder="kwh de uso">
                </div>
                <br>
                <div class="input-area relative pl-27">
                    <label for="tecno_susti_valor_mercado" class="inputLabel">Precio Mercado por unidad ($)</label>
                    <input id="tecno_susti_valor_mercado" type="number" class="form-control iluminaria"
                        placeholder="Valor Mercado por unidad">
                </div>
                <br>
                <div class="input-area relative pl-27">
                    <label for="tecno_susti_total_iluminarias" class="inputLabel">Total a sustituir</label>
                    <input readonly id="tecno_susti_total_iluminarias" type="text" class="form-control"
                        placeholder="Total a sustituir">
                </div>
                <br>
                <div class="input-area relative pl-27">
                    <label for="tecno_susti_total_inversion" class="inputLabel">Total inversión ($)</label>
                    <input readonly id="tecno_susti_total_inversion" type="text" class="form-control"
                        placeholder="Total inversión">
                </div>
            </div>
            <br>
            <button id="btnCalcular" style=" float: right;" class="btn inline-flex justify-center btn-dark">Calcular
                Analisis Financiero</button>

        </div>

    </div>

</div>
<div class="xl:col-span-6 col-span-12 lg:col-span-6">
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">Analisis Financiero
                    </div>
                </div>
            </header>
            <label for="" class="card-title dark:bg-slate-800 dark:border-slate-700 text-primary-500"> Valor
                kWh:
                ${{ rtrim($configuracion->valor_kwh, '0') }}</label></br>
            <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
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
                <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                    <tr>
                        <th class="th_td" scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                            Precio energia facturado
                        </th>
                        <td class="th_td" id="precio_facturado_mensual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700"></td>
                        <td class="th_td" id="precio_facturado_anual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 "></td>
                    </tr>

                    <tr>
                        <th class="th_td" scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                            Precio sustituido
                        </th>
                        <td class="th_td" id="precio_sustituido_costo_mensual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700"></td>
                        <td class="th_td" id="precio_sustituido_costo_anual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 "></td>
                    </tr>

                    <tr>
                        <th class="th_td" scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                            Ahorro
                        </th>
                        <td class="th_td" id="ahorro_mensual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700"></td>
                        <td class="th_td" id="ahorro_anual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 "></td>
                    </tr>
                    <tr>
                        <td class="th_td"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700"></td>
                        <th class="th_td" scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                            PR
                        </th>
                        <td class="th_td" id="pr"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                        </td>
                    </tr>


                </tbody>
            </table>
            <br>
            <div class="flex-1">
                <div class="text-slate-900 dark:text-white">PR: Periodo de recuperacion simple es la inversion entre el
                    ahorro anual.</div>
            </div>
            <br>
            <div id="recomendable"
                class="py-[18px] px-6 font-normal font-Inter text-sm rounded-md bg-success-500 text-white dark:bg-success-500
              dark:text-slate-300">
                <div class="flex items-start space-x-3 rtl:space-x-reverse">
                    <div class="flex-1">
                        El Proyecto Es viable.
                    </div>
                </div>
            </div>

            <div id="noRecomendable"
                class="py-[18px] px-6 font-normal font-Inter text-sm rounded-md bg-danger-500 text-white dark:bg-danger-500
                                    dark:text-slate-300">
                <div class="flex items-start space-x-3 rtl:space-x-reverse">
                    <div class="flex-1">
                        Revisar condiciones para su ejecución
                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="card">
        <div class="card-body flex flex-col p-6">
            <div id="nuevo_grafico"></div>
        </div>
    </div>
</div>

    </main>
</body>
</html>
