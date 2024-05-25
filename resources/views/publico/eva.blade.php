<style>
    table {
        border-collapse: collapse;
        width: 100%;
        padding: 10px !important;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    td {
        background-color: #ffffff;
    }

    .editable {
        cursor: pointer;
    }
</style>

<div class="xl:col-span-3 col-span-3 lg:col-span-3">
    <div class="h-full card">
        <div class="p-0  h-full relative card-body">
            <div class="card-header">
                <h4 class="card-title">Evaluación de proyectos</h4>
            </div>
            <!-- END: Todo Header -->
            <div class="h-full all-todos overflow-x-hidden" data-simplebar="data-simplebar">
                <ul class="divide-y divide-slate-100 dark:divide-slate-700 -mb-6 h-full todo-list">
                    <!-- BEGIN: Todos -->

                    @foreach ($tipos as $tipo)
                        <li data-status="team" data-stared="false" data-complete="false"
                            class="flex items-center px-6 space-x-4 py-6 hover:-translate-y-1 hover:shadow-todo transition-all duration-200 rtl:space-x-reverse">
                            <input type="checkbox" id="checkboxTipo{{ $tipo->id }}" class="table-checkbox"
                                onchange="showDivTipo('{{ $tipo->id }}')" name="todo-checkbox">
                            <span
                                class="flex-1 text-sm text-slate-600 dark:text-slate-300 truncate bar-active transition-all duration-150">
                                {{ $tipo->nombre }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>


@foreach ($tipos as $tipo)
    <div class="xl:col-span-3 col-span-3 lg:col-span-3" style="display: none" id="divTipo{{ $tipo->id }}">
        <div class="h-full card">
            <div class="card-header">
                <h5 class="card-title">{{ $tipo->nombre }}</h5>
            </div>

            <div class="card-body flex flex-col p-6">
                <table>
                    <thead>
                        <tr>
                            {{-- <th>Tecnología</th> --}}
                            <th>Potencia</th>
                            <th>Consumo mensual</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resultados->where('tipo_id', $tipo->id) as $resultado)
                            <tr>
                                {{-- <td class="editable">{{ $tipo->nombre }}</td> --}}
                                <td class="editable">{{ $resultado->potencia_nominal }} Vatios</td>
                                <td class="editable">{{ $resultado->consumo_mensual }} kwh {{ $resultado->conteo }}</td>
                                <td class="editable"
                                    id="input_{{ $resultado->tipo }}_{{ $resultado->potencia_nominal }}"
                                    contenteditable="true" style="text-align: right !important"
                                    onblur="updateInput(this.textContent,
                                    'input_{{ $resultado->tipo }}_{{ $resultado->potencia_nominal }}',{{ $resultado->conteo }})"
                                    onkeypress="return isDecimalKey(event)">0</td>
                            </tr>
                            <input
                                id="input_{{ $resultado->tipo }}_{{ $resultado->potencia_nominal }}_consumo_mensual_kwh"
                                type="hidden" class="form-control" value="{{ $resultado->consumo_mensual }}">
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endforeach



{{--

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

                @foreach ($resultados as $obj)
                    <div class="input-area">
                        <label for="input_{{ $obj->tipo }}_{{ $obj->potencia_nominal }}"
                            class="form-label">{{ $obj->tipo }}
                            {{ $obj->potencia_nominal }} Vatios <span
                                id="span_{{ $obj->tipo }}_{{ $obj->potencia_nominal }}"
                                class="badge bg-primary-500 text-white capitalize">0%</span> <span
                                class="badge bg-slate-900 text-white capitalize">{{ $obj->consumo_mensual }}
                                kwh</span></label>
                        <input id="input_{{ $obj->tipo }}_{{ $obj->potencia_nominal }}" type="number"
                            class="form-control iluminaria porcentajeParque" placeholder="{{ $obj->tipo }}"
                            value="0" min="0" max="{{ $obj->conteo }}">
                        <input id="input_{{ $obj->tipo }}_{{ $obj->potencia_nominal }}_consumo_mensual_kwh"
                            type="text" class="form-control" value="{{ $obj->consumo_mensual }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



 --}}








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
                        <td id="pr"
                            class="table-td border border-slate-100 dark:bg-slate-800 dark:border-slate-700 ">
                        </td>
                    </tr>


                </tbody>
            </table>
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
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $(document).ready(function() {
            totalParque = {{ $resultados->sum('conteo') }};
            // Evento input para todos los inputs de clase .iluminaria
            $('.porcentajeParque').on('input', function() {
                var inputId = $(this).attr('id'); // Obtener el id del input
                var nuevoValor = $(this).val(); // Obtener el valor ingresado
                var tipo = inputId.split('_')[1]; // Obtener tipo del id
                var potencia_nominal = inputId.split('_')[2]; // Obtener potencia_nominal del id

                // Construir el id del span correspondiente
                var spanId = '#span_' + tipo + '_' + potencia_nominal;

                // Cambiar el texto del span correspondiente
                $(spanId).text(((nuevoValor * 100) / totalParque) + '%');
            });
        });

        $('#recomendable').hide();
        $('#noRecomendable').hide();



        function updateTotal() {
            let tecno_susti_total_iluminarias = 0;
            let consumoMensual = 0;
            let totalInversion = 0;
            let costoMensualSustituido = 0;
            let precioEnergiaMensualTotal = 0;
            const VALORKWH = 0.14;
            $('#formTecnologias').find('.input-area').each(function() {
                let numLuminarias = parseFloat($(this).find('input[type="number"]').val());

                if (numLuminarias > 0) {
                    consumoMensual = parseFloat($(this).find('input[type="hidden"]').val());
                } else {
                    consumoMensual = 0;
                }

                if (!isNaN(numLuminarias) && !isNaN(consumoMensual)) {
                    tecno_susti_total_iluminarias += numLuminarias;
                    precioEnergiaMensualTotal += (VALORKWH * consumoMensual) * numLuminarias;
                }
            });

            if ($('#tecno_susti_valor_mercado').val() === "") {
                $('#tecno_susti_valor_mercado').val(0);
            }

            totalInversion = tecno_susti_total_iluminarias * parseFloat($('#tecno_susti_valor_mercado').val());

            console.log(numLuminarias," ",consumoMensual," ",tecno_susti_total_iluminarias," ",precioEnergiaMensualTotal);

            $('#tecno_susti_total_iluminarias').val(tecno_susti_total_iluminarias);
            $('#tecno_susti_total_inversion').val(totalInversion);

            //precio_facturado_mensual precio_facturado_anual
            $('#precio_facturado_mensual').text(precioEnergiaMensualTotal);
            $('#precio_facturado_anual').text(precioEnergiaMensualTotal * 12);

            if ($('#tecno_susti_kwh_uso').val() === "") {
                $('#tecno_susti_kwh_uso').val(0);
            }

            //(VALORKWH*tecno_susti_kwh_uso)*tecno_susti_total_iluminarias
            //precio_sustituido_costo_mensual precio_sustituido_costo_anual
            costoMensualSustituido = (VALORKWH * parseFloat($('#tecno_susti_kwh_uso').val())) * parseFloat($(
                '#tecno_susti_total_iluminarias').val());
            $('#precio_sustituido_costo_mensual').text(costoMensualSustituido);
            $('#precio_sustituido_costo_anual').text(costoMensualSustituido * 12);

            //ahorro_mensual ahorro_anual
            $('#ahorro_mensual').text(precioEnergiaMensualTotal - costoMensualSustituido);
            $('#ahorro_anual').text(parseFloat($('#ahorro_mensual').text()) * 12);

            //pr
            $('#pr').text(parseFloat(totalInversion) / parseFloat($('#ahorro_anual').text()));

            if (totalInversion !== 0 && parseFloat($('#ahorro_anual').text()) !== 0) {
                if (parseFloat($('#pr').text()) <= 3) {
                    $('#recomendable').show();
                    $('#noRecomendable').hide();
                } else {
                    $('#recomendable').hide();
                    $('#noRecomendable').show();
                }
            } else {
                $('#recomendable').hide();
                $('#noRecomendable').hide();
            }

        }
        // Añadir evento 'input' a todos los inputs con la clase 'iluminaria'
        $('.iluminaria').on('input', updateTotal);
    });

    function showDivTipo(control) {
        var checkbox = document.getElementById("checkboxTipo" + control).checked;
        var div = document.getElementById("divTipo" + control);

        if (checkbox) {
            div.style.display = "block";
        } else {
            div.style.display = "none";
        }
        console.log(checkbox);
    }

    function isDecimalKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        // Permitir números del 0 al 9
        if (charCode >= 48 && charCode <= 57) {
            return true;
        }

        // Permitir solo un punto decimal y verificar si ya hay uno presente
        if (charCode === 46 && evt.target.value.indexOf('.') === -1) {
            return true;
        }

        return false; // Bloquear cualquier otro carácter
    }

    function updateInput(valor, input, conteo) {
        var valorInt = parseInt(valor);
        var conteoInt = parseFloat(conteo);
        var element = document.getElementById(input);

        if (valorInt > conteoInt) {
            alert("cantidad no válida");
            //document.getElementById(input).value = 0;
            $('#'+input).text('0');
        }
        //
        //input
        console.log(valorInt, input, conteo);
    }
</script>
