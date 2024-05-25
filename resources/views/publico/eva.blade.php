<div id="divGrafico" class="xl:col-span-3 col-span-3 lg:col-span-3 ">
    <div class="card p-6 h-full">
        <div class="space-y-5">
            <div id="container_conteo_luminaria_pie"></div>
        </div>
    </div>
</div>

<div id="divFormTecnologias" class="xl:col-span-9 col-span-9 lg:col-span-9 ">
    <div class="card p-6 h-full">
        <div class="space-y-5">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">DISTRIBUCION TECNOLOGIAS ACTUALES
                    </div>
                </div>
            </header>
            <div id="formTecnologias" class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-5">

                @foreach ($resultados as $obj )
                <div class="input-area">
                    <label for="input_{{$obj->tipo}}_{{$obj->potencia_nominal}}" class="form-label">{{$obj->tipo }}
                        {{$obj->potencia_nominal }} Vatios <span id="span_{{$obj->tipo}}_{{$obj->potencia_nominal}}"
                            class="badge bg-primary-500 text-white capitalize">0%</span> <span
                            class="badge bg-slate-900 text-white capitalize">{{$obj->consumo_mensual}}
                            kwh</span></label>
                    <input id="input_{{$obj->tipo}}_{{$obj->potencia_nominal}}" type="number"
                        class="form-control iluminaria porcentajeParque" placeholder="{{$obj->tipo}}" value="0" min="0" max="{{$obj->conteo}}">
                    <input id="input_{{$obj->tipo}}_{{$obj->potencia_nominal}}_consumo_mensual_kwh" type="text"
                        class="form-control" value="{{$obj->consumo_mensual}}">
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="xl:col-span-6 col-span-6 lg:col-span-7 ">
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">TECNOLOGIA SUGERIDA A SUSTITUIR
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
                <div class="input-area relative pl-27">
                    <label for="tecnologia_sustituir" class="inputLabel">Tecnologia</label>
                    <input id="tecnologia_sustituir" type="text" class="form-control" placeholder="Tecnologia">
                </div>
                <br>
                <div class="input-area relative pl-27">
                    <label for="tecno_susti_kwh_uso" class="inputLabel">kwh de uso</label>
                    <input id="tecno_susti_kwh_uso" type="number" class="form-control iluminaria"
                        placeholder="kwh de uso">
                </div>
                <br>
                <div class="input-area relative pl-27">
                    <label for="tecno_susti_valor_mercado" class="inputLabel">Valor Mercado por unidad</label>
                    <input id="tecno_susti_valor_mercado" type="number" class="form-control iluminaria"
                        placeholder="Valor Mercado por unidad">
                </div>
                <br>
                <div class="input-area relative pl-27">
                    <label for="tecno_susti_total_iluminarias" class="inputLabel">Total a sustituir</label>
                    <input readonly id="tecno_susti_total_iluminarias" type="number" class="form-control"
                        placeholder="Total a sustituir">
                </div>
                <br>
                <div class="input-area relative pl-27">
                    <label for="tecno_susti_total_inversion" class="inputLabel">Total inversión $</label>
                    <input readonly id="tecno_susti_total_inversion" type="number" class="form-control"
                        placeholder="Total inversión">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xl:col-span-6 col-span-6 lg:col-span-7 ">
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">Analisis Financiero
                    </div>
                </div>
            </header>

            <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                <thead class="">
                    <tr>

                        <th scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">

                        </th>

                        <th scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                            Costo Mensual total
                        </th>

                        <th scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                            Costo Anual
                        </th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                    <tr>
                        <th scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                            Precio energia facturado
                        </th>
                        <td id="precio_facturado_mensual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700"></td>
                        <td id="precio_facturado_anual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 "></td>
                    </tr>

                    <tr>
                        <th scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                            Precio sustituido
                        </th>
                        <td id="precio_sustituido_costo_mensual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700"></td>
                        <td id="precio_sustituido_costo_anual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 "></td>
                    </tr>

                    <tr>
                        <th scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                            Ahorro
                        </th>
                        <td id="ahorro_mensual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700"></td>
                        <td id="ahorro_anual"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 "></td>
                    </tr>
                    <tr>
                        <td class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700"></td>
                        <th scope="col"
                            class=" table-th border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                            PR
                        </th>
                        <td id="pr" class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                        </td>
                    </tr>


                </tbody>
            </table>
<br>
            <div id="recomendable" class="py-[18px] px-6 font-normal font-Inter text-sm rounded-md bg-success-500 text-white dark:bg-success-500
              dark:text-slate-300">
                <div class="flex items-start space-x-3 rtl:space-x-reverse">
                    <div class="flex-1">
                        El Proyecto Es viable.
                    </div>
                </div>
            </div>

            <div id="noRecomendable" class="py-[18px] px-6 font-normal font-Inter text-sm rounded-md bg-danger-500 text-white dark:bg-danger-500
                                    dark:text-slate-300">
                <div class="flex items-start space-x-3 rtl:space-x-reverse">
                    <div class="flex-1">
                        Revisar condiciones para su ejecución
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $(document).ready(function() {
            totalParque= {{$resultados->sum('conteo')}};
            // Evento input para todos los inputs de clase .iluminaria
            $('.porcentajeParque').on('input', function() {
                var inputId = $(this).attr('id'); // Obtener el id del input
                var nuevoValor = $(this).val(); // Obtener el valor ingresado
                var tipo = inputId.split('_')[1]; // Obtener tipo del id
                var potencia_nominal = inputId.split('_')[2]; // Obtener potencia_nominal del id

                // Construir el id del span correspondiente
                var spanId = '#span_' + tipo + '_' + potencia_nominal;

                 console.log("nuevoValor ",nuevoValor);
                console.log("inputId ",inputId);
                console.log("tipo ",tipo);
                console.log("potencia_nominal ",potencia_nominal);
                console.log("spanId ",spanId);

                // Cambiar el texto del span correspondiente
                $(spanId).text(((nuevoValor*100)/totalParque) + '%');
            });
        });

        $('#recomendable').hide();
        $('#noRecomendable').hide();

        let chart;
        chart= Highcharts.chart('container_conteo_luminaria_pie', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            align: 'left',
                            text: 'Cantidad por tipo de luminaria'
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
                            data:  @json($data_numero_luminaria)

                        }]
        });

        function updateTotal() {
            let tecno_susti_total_iluminarias = 0;
            let consumoMensual = 0;
            let totalInversion=0;
            let costoMensualSustituido=0;
            let precioEnergiaMensualTotal=0;
            const VALORKWH=0.14;
            $('#formTecnologias').find('.input-area').each(function() {
            let numLuminarias = parseFloat($(this).find('input[type="number"]').val());

            if (numLuminarias>0) {
                 consumoMensual = parseFloat($(this).find('input[type="hidden"]').val());
            } else {
                 consumoMensual = 0;
            }

            if (!isNaN(numLuminarias) && !isNaN(consumoMensual)) {
                tecno_susti_total_iluminarias += numLuminarias;
                precioEnergiaMensualTotal += (VALORKWH*consumoMensual)*numLuminarias;
            }
            });

            if ($('#tecno_susti_valor_mercado').val() === "") {
                $('#tecno_susti_valor_mercado').val(0);
            }

            totalInversion=tecno_susti_total_iluminarias*parseFloat($('#tecno_susti_valor_mercado').val());

            $('#tecno_susti_total_iluminarias').val(tecno_susti_total_iluminarias);
            $('#tecno_susti_total_inversion').val(totalInversion);

            //precio_facturado_mensual precio_facturado_anual
            $('#precio_facturado_mensual').text(precioEnergiaMensualTotal);
            $('#precio_facturado_anual').text(precioEnergiaMensualTotal*12);

            if ($('#tecno_susti_kwh_uso').val() === "") {
                $('#tecno_susti_kwh_uso').val(0);
            }

            //(VALORKWH*tecno_susti_kwh_uso)*tecno_susti_total_iluminarias
            //precio_sustituido_costo_mensual precio_sustituido_costo_anual
            costoMensualSustituido=(VALORKWH*parseFloat($('#tecno_susti_kwh_uso').val()))*parseFloat($('#tecno_susti_total_iluminarias').val());
            $('#precio_sustituido_costo_mensual').text(costoMensualSustituido);
            $('#precio_sustituido_costo_anual').text(costoMensualSustituido*12);

            //ahorro_mensual ahorro_anual
            $('#ahorro_mensual').text(precioEnergiaMensualTotal-costoMensualSustituido);
            $('#ahorro_anual').text(parseFloat($('#ahorro_mensual').text())*12);

            //pr
            $('#pr').text(parseFloat(totalInversion)/parseFloat($('#ahorro_anual').text()));

        if (totalInversion!==0 && parseFloat($('#ahorro_anual').text())!==0) {
            if (parseFloat($('#pr').text())<=3) {
                $('#recomendable').show();
                $('#noRecomendable').hide();
            } else {
                $('#recomendable').hide();
                $('#noRecomendable').show();
            }
        }else{
            $('#recomendable').hide();
            $('#noRecomendable').hide();
        }

        }
            // Añadir evento 'input' a todos los inputs con la clase 'iluminaria'
            $('.iluminaria').on('input', updateTotal);
    });
</script>
