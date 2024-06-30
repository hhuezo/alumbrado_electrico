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

<div class="xl:col-span-12 col-span-12 lg:col-span-12">
    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">Evaluación de proyectos</div>
                </div>
            </header>
            <div class="flex-1">
                <div class="text-slate-900 dark:text-white">Digitar la cantidad de luminarias que desea sustituir por
                    cada una de las tecnologías
                    y luego precionar el botón "Obtener tecnologías sugeridas"</div>
            </div>
            <div class="card-text h-full ">

                <div id="divFormTecnologias">
                    <br>
                    <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4"
                        id="tabs-tab" role="tablist">
                        @php($i = 1)
                        @foreach ($tipos as $tipo)
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-{{ $tipo->id }}"
                                    class="nav-link w-full {{ $i == 1 ? 'active' : '' }}  block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent  dark:text-slate-300"
                                    id="tabs-home-tab" data-bs-toggle="pill" data-bs-target="#tabs-{{ $tipo->id }}"
                                    role="tab" aria-controls="tabs-home"
                                    aria-selected="true">{{ $tipo->nombre }}</a>
                            </li>
                            @php($i++)
                        @endforeach
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        @php($i = 1)
                        @foreach ($tipos as $tipo)
                            <div class="tab-pane fade show {{ $i == 1 ? 'active' : '' }}" id="tabs-{{ $tipo->id }}"
                                role="tabpanel" aria-labelledby="tabs-home-tab">
                                <div class="card-body flex flex-col p-6">
                                    <table class="dataTable">
                                        <thead>
                                            <tr>
                                                <th class="th_td backgroundth">Potencia</th>
                                                <th class="th_td backgroundth">kWh</th>
                                                <th class="th_td backgroundth">N° Luminarias</th>
                                                <th class="th_td backgroundth">Cantidad</th>
                                                <th class="th_td backgroundth">Porcentaje</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($resultados->where('tipo_id', $tipo->id) as $resultado)
                                                <tr>
                                                    <td class="editable th_td backgroundtd">
                                                        {{ $resultado->potencia_nominal }} Vatios
                                                    </td>
                                                    <td class="editable th_td backgroundtd">
                                                        {{ $resultado->consumo_mensual }}</td>
                                                    <td class="editable th_td backgroundtd">{{ $resultado->conteo }}
                                                    </td>
                                                    <td class="editable th_td backgroundtd"
                                                        id="celda_{{ $resultado->tipo_id }}_{{ $resultado->potencia_nominal }}"
                                                        contenteditable="true" style="text-align: right !important"
                                                        onclick="clearCellIfZero(this)" onblur="fillCellIfEmpty(this)"
                                                        oninput="updateInput(this.textContent,
                                                        '{{ $resultado->tipo_id }}_{{ $resultado->potencia_nominal }}',{{ $resultado->conteo }})"
                                                        onkeypress="return isIntegerKey(event)">0</td>
                                                    <td class="editable th_td backgroundtd"><span
                                                            id="span_{{ $resultado->tipo_id }}_{{ $resultado->potencia_nominal }}"
                                                            class="badge bg-primary-500 text-white capitalize">0%</span>

                                                    </td>
                                                </tr>
                                                <input style="display: none"
                                                    id="input_{{ $resultado->tipo_id }}_{{ $resultado->potencia_nominal }}"
                                                    type="number" class="form-control iluminaria porcentajeParque"
                                                    placeholder="{{ $resultado->tipo }}" value="0" min="0"
                                                    max="{{ $resultado->conteo }}">
                                                <input style="display: none"
                                                    id="input_{{ $resultado->tipo_id }}_{{ $resultado->potencia_nominal }}_consumo_mensual_kwh"
                                                    type="text" class="form-control"
                                                    value="{{ $resultado->consumo_mensual }}">
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                </p>
                                @php($i++)
                            </div>
                        @endforeach
                        <button id="btnGetTecnologiasSustituir" style=" float: right;"
                            class="btn inline-flex justify-center btn-dark">Obtener tecnologías sugeridas</button>

                    </div>
                </div>
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
                <div class="input-area relative pl-27">
                    <ul>
                        <li>* Elegir la tecnología a sustituir</li>
                        <li>* Ingresar el precio de mercado</li>
                        <li>* Presionar el botón "Calcular análisis financiero"</li>
                    </ul>
                </div>
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
                <div class="text-slate-900 dark:text-white">PR: Periodo de recuperacion simple es la inversion entre el ahorro anual.</div>
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
            {{-- <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">Nuevo grafico
                    </div>
                </div>
            </header> --}}

            <div id="nuevo_grafico"></div>


        </div>
    </div>
</div>


<script type="text/javascript">
    var totalParque = {{ $resultados->sum('conteo') }};
    var tecnologia_sustituir = [];
    $(document).ready(function() {
        //tecnologia_sustituir tecno_susti_kwh_uso

        function cambiarValorMercadoUnidadSusti() {
            console.log("test ");
            var select = document.getElementById('tecnologia_sustituir');
            var selectedOption = select.options[select.selectedIndex];
            var consumoPromedio = selectedOption.getAttribute('data-consumo');
            $("#tecno_susti_kwh_uso").val(consumoPromedio);
        }


        $('#recomendable').hide();
        $('#noRecomendable').hide();




        // Añadir evento 'click' a botón btnCalcular
        $('#btnCalcular').on('click', imprimirValoresInputs);
        $('#btnGetTecnologiasSustituir').on('click', getTecnologiaSustituir);
        $('#tecnologia_sustituir').on('change', cambiarValorMercadoUnidadSusti);

    });

    function updateTotal(tecno_susti_total_iluminarias, precioEnergiaMensualTotal, VALORKWH) {
        let ahorro_mensual = 0;
        let totalInversion = 0;
        let costoMensualSustituido = 0;

        if ($('#tecno_susti_kwh_uso').val() === "" || $('#tecno_susti_kwh_uso').val() == 0) {
            $('#tecno_susti_kwh_uso').val(0);
            Swal.fire({
                title: 'Oops...',
                text: 'Digite el kwh de uso de la tenologia a sustituir',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            })
            $("#tecno_susti_kwh_uso").focus();
            return;
        }
        if ($('#tecno_susti_valor_mercado').val() === "" || $('#tecno_susti_valor_mercado').val() == 0) {

            $('#tecno_susti_valor_mercado').val(0);
            Swal.fire({
                title: 'Oops...',
                text: 'Digite el valor Mercado por unidad de la tenologia a sustituir',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            })
            $("#tecno_susti_valor_mercado").focus();

            return;
        }




        totalInversion = tecno_susti_total_iluminarias * parseFloat($('#tecno_susti_valor_mercado').val());

        //console.log(numLuminarias," ",consumoMensual," ",tecno_susti_total_iluminarias," ",precioEnergiaMensualTotal);

        $('#tecno_susti_total_iluminarias').val(tecno_susti_total_iluminarias);
        $('#tecno_susti_total_inversion').val(new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(totalInversion));

        //precio_facturado_mensual precio_facturado_anual
        $('#precio_facturado_mensual').text(new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(precioEnergiaMensualTotal));
        $('#precio_facturado_anual').text(new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(precioEnergiaMensualTotal * 12));


        //(VALORKWH*tecno_susti_kwh_uso)*tecno_susti_total_iluminarias
        //precio_sustituido_costo_mensual precio_sustituido_costo_anual
        costoMensualSustituido = (VALORKWH * parseFloat($('#tecno_susti_kwh_uso').val())) * parseFloat(
            tecno_susti_total_iluminarias);
        $('#precio_sustituido_costo_mensual').text(new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(costoMensualSustituido));
        $('#precio_sustituido_costo_anual').text(new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(costoMensualSustituido * 12));

        //ahorro_mensual ahorro_anual
        ahorro_mensual = precioEnergiaMensualTotal - costoMensualSustituido;
        $('#ahorro_mensual').text(new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(parseFloat(ahorro_mensual)));
        $('#ahorro_anual').text(new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(parseFloat(ahorro_mensual) * 12));

        //pr
        console.log(totalInversion, ahorro_mensual);

        var pr = (parseFloat(totalInversion) / parseFloat(ahorro_mensual * 12)).toFixed(2);

        $('#pr').text(pr);

        if (pr < 3.00) {
            $('#pr').css('background-color', '#28a745')
                .css('color', '#fff'); // Verde
        } else {
            $('#pr').css('background-color', '#ff9800')
                .css('color', '#fff'); // Naranja
        }


        if (totalInversion !== 0 && parseFloat(ahorro_mensual) !== 0) {
            if (parseFloat($('#pr').text()) <= 3 && parseFloat($('#pr').text()) >= 0) {
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


        nuevoGrafico();

    }

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

    function clearCellIfZero(cell) {
        if (cell.textContent.trim() === '0') {
            cell.textContent = '';
        }
    }

    function fillCellIfEmpty(cell) {
        if (cell.textContent.trim() === '') {
            cell.textContent = '0';
        }
    }

    function isIntegerKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        // Permitir números del 0 al 9
        if (charCode >= 48 && charCode <= 57) {
            return true;
        }

        return false; // Bloquear cualquier otro carácter
    }

    function updateInput(valor, input, conteo) {
        if (valor != "") {
            var valorInt = parseInt(valor);
            var conteoInt = parseInt(conteo);
            var element = document.getElementById("input_" + input);

            if (valorInt > conteoInt) {
                Swal.fire({
                    title: 'Oops...',
                    text: 'La cantidad de iluminarias no puede ser mayor de ' + conteoInt,
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                })
                //document.getElementById(input).value = 0;
                $('#celda_' + input).text('0');
                document.getElementById("input_" + input).value = 0;
                $('#span_' + input).text("0");
            } else {
                document.getElementById("input_" + input).value = valor;
                $('#span_' + input).text((new Intl.NumberFormat('en-US', {
                    maximumSignificantDigits: 2
                }).format((valorInt * 100) / totalParque)) + '%');
            }

            console.log("esta es la tecnologia: ", tecnologia_sustituir);
        } else {
            $('#celda_' + input).text('0');
            document.getElementById("input_" + input).value = 0;
            $('#span_' + input).text("0");
        }
        //imprimirValoresInputs();
        //input
        console.log(valorInt, input, conteo);
    }

    function getTecnologiaSustituir() {
        //alert('hola');
        var tecno_susti_total_iluminarias = 0;
        var tecnologia_actual_array = [];
        @foreach ($resultados as $resultado)

            var luminarias = $('#input_{{ $resultado->tipo_id }}_{{ $resultado->potencia_nominal }}').val();
            var luminariasInt = parseInt(luminarias);

            if (luminariasInt > 0) {
                tecnologia_actual_array.push({{ $resultado->id }});
            }
        @endforeach

        console.log("tecnologia_actual_array: " + tecnologia_actual_array);

        let parametros = {
            "tecnologia_actual_array": tecnologia_actual_array,
            "tipo": document.getElementById("tipo").value
        };
        $.ajax({
            type: "get",
            url: "{{ URL::to('publico/getTecnologiasSugeridas') }}",
            data: parametros,
            success: function(response) {
                console.log(response);
                let cBXtecnologia_sustituir = $('#tecnologia_sustituir');
                cBXtecnologia_sustituir.empty();
                $('#tecno_susti_kwh_uso').val(0);
                if (response !== null && !$.isEmptyObject(response)) {
                    cBXtecnologia_sustituir.html(response);
                }
            }
        });

        // updateTecnologia_sustituirCBX(tecnologia_actual_array);

    }

    function updateTecnologia_sustituirCBX(tecnologia_actual_array) {
        let parametros = {
            "tecnologia_actual_array": tecnologia_actual_array
        };
        $.ajax({
            type: "get",
            url: "{{ URL::to('publico/getTecnologiasSugeridas') }}",
            data: parametros,
            success: function(response) {
                console.log(response);
                let cBXtecnologia_sustituir = $('#tecnologia_sustituir');
                cBXtecnologia_sustituir.empty();
                $('#tecno_susti_kwh_uso').val(0);
                if (response !== null && !$.isEmptyObject(response)) {
                    cBXtecnologia_sustituir.html(response);
                }
            }
        });
    }

    function imprimirValoresInputs() {
        var tecno_susti_total_iluminarias = 0;
        var precioEnergiaMensualTotal = 0;
        const VALORKWH = {{ $configuracion->valor_kwh }};
        @foreach ($resultados as $resultado)
            // Utiliza jQuery para obtener el valor del input _consumo_mensual_kwh
            var luminarias = $('#input_{{ $resultado->tipo_id }}_{{ $resultado->potencia_nominal }}').val();
            console.log("luminarias: " + luminarias);
            var consumoMensual = $(
                '#input_{{ $resultado->tipo_id }}_{{ $resultado->potencia_nominal }}_consumo_mensual_kwh').val();
            console.log("consumoMensual: " + consumoMensual);
            var luminariasInt = parseInt(luminarias);
            var consumoMensualDecimal = parseFloat(consumoMensual);

            if (luminariasInt > 0) {
                tecno_susti_total_iluminarias += luminariasInt;
                precioEnergiaMensualTotal += (VALORKWH * consumoMensualDecimal) * luminariasInt;

            }
        @endforeach

        console.log("total luminarias: " + tecno_susti_total_iluminarias);
        console.log("precioEnergiaMensualTotal: " + precioEnergiaMensualTotal);

        updateTotal(tecno_susti_total_iluminarias, precioEnergiaMensualTotal, VALORKWH);

    }


    function nuevoGrafico() {
        var tecnologia_sustituir = [];
        @foreach ($resultados as $resultado)
            var luminarias = $('#input_{{ $resultado->tipo_id }}_{{ $resultado->potencia_nominal }}').val();
            var luminariasInt = parseInt(luminarias);
            if (luminariasInt > 0) {
                let data_array = {
                    "tipo_luminaria_id": {{ $resultado->tipo_id }},
                    "potencia_nominal": {{ $resultado->potencia_nominal }},
                    "numero_luminarias": luminariasInt
                };
                tecnologia_sustituir.push(data_array);
            }
        @endforeach

        console.log("luminarias: " + JSON.stringify(tecnologia_sustituir));

        let distrito = $('#distrito').val();

        let tecnologia_sustituir_id = document.getElementById('tecnologia_sustituir').value;

        let parametros = {
            "tecnologia_sustituir": JSON.stringify(tecnologia_sustituir),
            "distrito": distrito,
            "tecnologia_sustituir_id": tecnologia_sustituir_id,
            "tipo": document.getElementById("tipo").value
        };
        $.ajax({
            type: "get",
            url: "{{ URL::to('publico/evaluacion_proyectos/get_grafico_sugerido') }}",
            data: parametros,
            success: function(response) {
                console.log("nuevo_grafico ", response);
                $('#nuevo_grafico').html(response);
            }
        });

    }
</script>
