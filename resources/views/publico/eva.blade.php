
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
                        <label for="input_{{$obj->tipo}}_{{$obj->potencia_nominal}}" class="form-label">{{$obj->tipo }} {{$obj->potencia_nominal }} Vatios <span
                                class="badge bg-primary-500 text-white capitalize">19%</span> <span
                                 class="badge bg-slate-900 text-white capitalize">{{$obj->consumo_mensual}}
                                kwh</span></label>
                        <input id="input_{{$obj->tipo}}_{{$obj->potencia_nominal}}" type="number" class="form-control iluminaria" placeholder="{{$obj->tipo}}" value="0">
                        <input id="input_{{$obj->tipo}}_{{$obj->potencia_nominal}}_consumo_mensual_kwh" type="hidden" class="form-control" value="{{$obj->consumo_mensual}}">
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
                        <input id="tecno_susti_kwh_uso" type="number" class="form-control" placeholder="kwh de uso">
                    </div>
                <br>
                    <div class="input-area relative pl-27">
                        <label for="tecno_susti_valor_mercado" class="inputLabel">Valor Mercado por unidad</label>
                        <input id="tecno_susti_valor_mercado" type="number" class="form-control iluminaria" placeholder="Valor Mercado por unidad">
                    </div>
                <br>
                    <div class="input-area relative pl-27">
                        <label for="tecno_susti_total_iluminarias" class="inputLabel">Total a sustituir</label>
                        <input readonly id="tecno_susti_total_iluminarias" type="number" class="form-control" placeholder="Total a sustituir">
                    </div>
                <br>
                    <div class="input-area relative pl-27">
                        <label for="tecno_susti_total_inversion" class="inputLabel">Total inversión $</label>
                        <input readonly id="tecno_susti_total_inversion" type="number" class="form-control" placeholder="Total inversión">
                    </div>
            </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        //$('#divGrafico').hide();
        //$('#divFormTecnologias').hide();

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
            $('#formTecnologias').find('.input-area').each(function() {
            let numLuminarias = parseFloat($(this).find('input[type="number"]').val());

            if (numLuminarias>0) {
                 consumoMensual = parseFloat($(this).find('input[type="hidden"]').val());
            } else {
                 consumoMensual = 0;
            }

            if (!isNaN(numLuminarias) && !isNaN(consumoMensual)) {
                tecno_susti_total_iluminarias += numLuminarias;
                //total += numLuminarias * consumoMensual;
            }
            });
            totalInversion=tecno_susti_total_iluminarias*parseFloat($('#tecno_susti_valor_mercado').val());

            $('#tecno_susti_total_iluminarias').val(tecno_susti_total_iluminarias);
            $('#tecno_susti_total_inversion').val(totalInversion);
        }
            // Añadir evento 'input' a todos los inputs con la clase 'iluminaria'
            $('.iluminaria').on('input', updateTotal);
    });
</script>
