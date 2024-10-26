@extends ('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])



    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
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
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        /* Estilos para las etiquetas Sí y No */
        .switch-label {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #fff;
            font-size: 14px;
        }

        .switch-label.yes {
            left: 5px;
            color: #ffff;
            display: none;
            font-size: 14px;
            font-weight: bold;
            /* Inicialmente oculto */
        }

        .switch-label.no {
            right: 5px;
            color: #000000;
            font-size: 14px;
            font-weight: bold;
        }

        /* Ocultar 'No' y mostrar 'Sí' cuando el interruptor está activo */
        input:checked~.switch-label.yes {
            display: block;
            /* Mostrar 'Sí' */
        }

        input:checked~.switch-label.no {
            display: none;
            /* Ocultar 'No' */
        }

        /* Asegurarse de que 'No' se muestre cuando el interruptor no está activo */
        input:not(:checked)~.switch-label.no {
            display: block;
        }

        input:not(:checked)~.switch-label.yes {
            display: none;
            /* Ocultar 'Sí' cuando no está activo */
        }

        .alert-yellow {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }

        .alert-red {
            color: #f4efef;
            background-color: #e27171;
            border-color: #ffeeba;
        }
    </style>




    <div class="card">
        <div class="card-body flex flex-col p-6">
            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                <div class="flex-1">
                    <div class="card-title text-slate-900 dark:text-white">Seguimiento de reporte falla

                        <a href="{{ url('reporte_falla') }}">
                            <button class="btn btn-dark btn-sm float-right">
                                <iconify-icon icon="icon-park-solid:back" style="color: white;" width="18">
                                </iconify-icon>
                            </button>
                        </a>
                    </div>
                </div>
            </header>
            <div class="card-text h-full ">
                <div>
                    <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4"
                        id="tabs-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-home"
                                class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent active dark:text-slate-300"
                                id="tabs-home-tab" data-bs-toggle="pill" data-bs-target="#tabs-home" role="tab"
                                aria-controls="tabs-home" aria-selected="true">Seguimiento</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-profile"
                                class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent dark:text-slate-300"
                                id="tabs-profile-tab" data-bs-toggle="pill" data-bs-target="#tabs-profile" role="tab"
                                aria-controls="tabs-profile" aria-selected="false">General</a>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <a href="#tabs-messages"
                                class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent dark:text-slate-300"
                                id="tabs-messages-tab" data-bs-toggle="pill" data-bs-target="#tabs-messages"
                                role="tab" aria-controls="tabs-messages" aria-selected="false">Messages</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-settings"
                                class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent dark:text-slate-300"
                                id="tabs-settings-tab" data-bs-toggle="pill" data-bs-target="#tabs-settings"
                                role="tab" aria-controls="tabs-settings" aria-selected="false">settings</a>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="tabs-tabContent">
                        <div class="tab-pane fade show active" id="tabs-home" role="tabpanel"
                            aria-labelledby="tabs-home-tab">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if ($reporte_falla->estado_reporte_id != 3)
                            <form method="POST" action="{{ url('reporte_falla/registrar_falla') }}">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">

                                    <input type="hidden" name="censo_id" value="{{ $censo->id }}">
                                    <input type="hidden" name="reporte_falla_id" value="{{ $reporte_falla->id }}">
                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Código luminaria</label>
                                        <input type="text" value="{{ $censo->codigo_luminaria }}" readonly
                                            class="form-control">
                                    </div>
                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Fecha</label>
                                        <input type="date" name="fecha" value="{{ date('Y-m-d') }}"
                                            class="form-control">
                                    </div>


                                    <div class="input-area">
                                        <label for="condicion_lampara" class="form-label">¿Está la lámpara en buenas
                                            condiciones?</label>
                                        <label class="switch">
                                            <input type="checkbox" {{ $censo->condicion_lampara == 1 ? 'checked' : '' }}
                                                id="condicion_lampara" name="condicion_lampara">
                                            <span class="slider round"></span>

                                            <span class="switch-label yes">&nbsp;Sí</span> <!-- Etiqueta para "Sí" -->
                                            <span class="switch-label no">No</span> <!-- Etiqueta para "No" -->
                                        </label>
                                    </div>
                                    <div class="input-area relative" id="div_tipo_falla"
                                        style="display: {{ $censo->condicion_lampara == 1 ? 'none' : 'block' }}">
                                        <label for="largeInput" class="form-label">Tipo de falla</label>
                                        <select name="tipo_falla_id" id="tipo_falla_id" class="form-control">
                                            <option value="">Seleccione</option>
                                            @foreach ($tipos_falla as $tipo_falla)
                                                <option value="{{ $tipo_falla->id }}"
                                                    {{ $censo->tipo_falla_id == $tipo_falla->id ? 'selected' : '' }}>
                                                    {{ $tipo_falla->nombre }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                </div>

                                <div class="input-area relative">
                                    <label for="largeInput" class="form-label">Observación</label>
                                    <textarea class="form-control" name="observacion" required></textarea>
                                </div>
                                <br>
                                <div>

                                    <button type="button" data-bs-toggle="modal"
                                    data-bs-target="#modal-finalizar"
                                        class="btn btn-warning">Finalizar</button>
                                    <button type="submit" style="margin-right: 18px"
                                        class="btn btn-dark float-right">Registrar</button>


                                </div>
                            </form>
                            @endif

                            <header class=" card-header noborder">
                                <h4 class="card-title">Historial
                                </h4>
                            </header>
                            <div class="card-body px-6 pb-6">
                                <div class="overflow-x-auto -mx-6">
                                    <div class="inline-block min-w-full align-middle">
                                        <div class="overflow-hidden ">
                                            <table
                                                class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                                <thead class="bg-slate-200 dark:bg-slate-700">
                                                    <tr>

                                                        <th scope="col" class=" table-th ">
                                                            Fecha
                                                        </th>

                                                        <th scope="col" class=" table-th ">
                                                            ¿Está la lámpara en buenas
                                                            condiciones?
                                                        </th>

                                                        <th scope="col" class=" table-th ">
                                                            Tipo de falla
                                                        </th>

                                                        <th scope="col" class=" table-th ">
                                                            Observación
                                                        </th>


                                                        <th scope="col" class=" table-th ">
                                                            Estado reporte
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody
                                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                                    @if ($reporte_falla->seguimiento->count() > 0)
                                                        @foreach ($reporte_falla->seguimiento as $seguimiento)
                                                            <tr class="even:bg-slate-50 dark:even:bg-slate-700">
                                                                <td class="table-td">
                                                                    {{ date('d/m/Y', strtotime($seguimiento->fecha)) }}
                                                                </td>
                                                                <td class="table-td"> <label class="switch">
                                                                    <input type="checkbox" {{ $seguimiento->condicion_lampara == 1 ? 'checked' : '' }}
                                                                        id="condicion_lampara" name="condicion_lampara">
                                                                    <span class="slider round"></span>

                                                                    <span class="switch-label yes">&nbsp;Sí</span> <!-- Etiqueta para "Sí" -->
                                                                    <span class="switch-label no">No</span> <!-- Etiqueta para "No" -->
                                                                </label></td>
                                                                <td class="table-td ">{{$seguimiento->tipo_falla ? $seguimiento->tipo_falla->nombre : '' }}</td>
                                                                <td class="table-td ">{{$seguimiento->observacion }}</td>
                                                                <td class="table-td ">{{$seguimiento->estado_reporte->nombre }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif




                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>







                        </div>
                        <div class="tab-pane fade" id="tabs-profile" role="tabpanel" aria-labelledby="tabs-profile-tab">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">

                                <div>
                                    <div class="input-area">
                                        <div class="card-title text-slate-900 dark:text-white">Reporte falla</div>
                                    </div>

                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Contacto</label>
                                        <input type="text" value="{{ $reporte_falla->nombre_contacto }}" readonly
                                            class="form-control">
                                    </div>
                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Teléfono</label>
                                        <input type="text" value="{{ $reporte_falla->telefono_contacto }}" readonly
                                            class="form-control">
                                    </div>
                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Correo</label>
                                        <input type="text" value="{{ $reporte_falla->correo_contacto }}" readonly
                                            class="form-control">
                                    </div>

                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Fecha</label>
                                        <input type="date"
                                            value="{{ date('Y-m-d', strtotime($reporte_falla->fecha)) }}" readonly
                                            class="form-control">
                                    </div>

                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Departamento</label>
                                        <input type="text"
                                            value="{{ $reporte_falla->distrito->municipio->departamento->nombre }}"
                                            readonly class="form-control">
                                    </div>

                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Municipio</label>
                                        <input type="text" value="{{ $reporte_falla->distrito->municipio->nombre }}"
                                            readonly class="form-control">
                                    </div>

                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Distrito</label>
                                        <input type="text" value="{{ $reporte_falla->distrito->nombre }}" readonly
                                            class="form-control">

                                    </div>


                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Tipo falla</label>
                                        <input type="text" value="{{ $reporte_falla->tipo_falla->nombre }}" readonly
                                            class="form-control">

                                    </div>

                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Descripción</label>
                                        <input type="text" value="{{ $reporte_falla->descripcion }}" readonly
                                            class="form-control">

                                    </div>

                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Contacto</label>
                                        <input type="text" value="{{ $reporte_falla->nombre_contacto }}" readonly
                                            class="form-control">

                                    </div>
                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Teléfono</label>
                                        <input type="text" value="{{ $reporte_falla->telefono_contacto }}" readonly
                                            class="form-control">

                                    </div>

                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Estado</label>
                                        <input type="text" value="{{ $reporte_falla->estado->nombre }}" readonly
                                            class="form-control">

                                    </div>
                                    <br>
                                    <div class="input-area relative">
                                        @if ($reporte_falla->url_foto)
                                            <img src="{{ asset('docs') }}/{{ $reporte_falla->url_foto }}"
                                                style="max-width: 200px">
                                        @endif

                                    </div>
                                </div>


                                <div class="mb-4">
                                    <div class="input-area">
                                        <div class="card-title text-slate-900 dark:text-white">Información de luminaria
                                        </div>
                                    </div>








                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Código luminaria</label>
                                        <input type="text" value="{{ $censo->codigo_luminaria }}" readonly
                                            class="form-control">
                                    </div>
                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Fecha</label>
                                        <input type="date" value="{{ date('Y-m-d', strtotime($censo->fecha)) }}"
                                            readonly class="form-control">
                                    </div>

                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Tipo luminaria</label>
                                        <input type="text" value="{{ $censo->tipo_luminaria->nombre }}" readonly
                                            class="form-control">
                                    </div>

                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Potencia</label>
                                        <input type="text" value="{{ $censo->potencia_nominal }}" readonly
                                            class="form-control">
                                    </div>

                                    <div class="input-area">
                                        <label for="largeInput" class="form-label">Consumo mensual</label>
                                        <input type="text" value="{{ $censo->consumo_mensual }}" readonly
                                            class="form-control">

                                    </div>


                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Dirección</label>
                                        <textarea readonly class="form-control">{{ $censo->direccion }}</textarea>
                                    </div>

                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Observación</label>
                                        <textarea readonly class="form-control">{{ $censo->observacion }}</textarea>
                                    </div>

                                    <div class="input-area">
                                        <label for="condicion_lampara" class="form-label">¿Está la lámpara en buenas
                                            condiciones?</label>
                                        <label class="switch">
                                            <input type="checkbox" id="condicion_lampara" name="condicion_lampara">
                                            <span class="slider round"></span>

                                            <span class="switch-label yes">&nbsp;Sí</span> <!-- Etiqueta para "Sí" -->
                                            <span class="switch-label no">No</span> <!-- Etiqueta para "No" -->
                                        </label>
                                    </div>
                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Tipo de falla</label>
                                        <input type="text"
                                            value="{{ $censo->tipo_falla ? $censo->tipo_falla->nombre : '' }}" readonly
                                            class="form-control">

                                    </div>

                                    <div class="input-area relative">
                                        <label for="largeInput" class="form-label">Compañia</label>
                                        <input type="text"
                                            value="{{ $censo->compania ? $censo->compania->nombre : '' }}" readonly
                                            class="form-control">

                                    </div>

                                </div>


                            </div>




                        </div>
                        <div class="tab-pane fade" id="tabs-messages" role="tabpanel"
                            aria-labelledby="tabs-messages-tab">
                            <p class="text-sm text-gray-500 dark:text-gray-200">
                                This is some placeholder content the
                                <strong>Messages</strong>
                                tab's associated content. Clicking another tab will toggle the visibility of this one
                                for the next. The tab JavaScript swaps classes to control the content visibility and
                                styling. consectetur adipisicing elit. Ab ipsa!
                            </p>
                        </div>
                        <div class="tab-pane fade" id="tabs-settings" role="tabpanel"
                            aria-labelledby="tabs-settings-tab">
                            <p class="text-sm text-gray-500 dark:text-gray-200">
                                This is some placeholder content the
                                <strong>Settings</strong>
                                tab's associated content. Clicking another tab will toggle the visibility of this one
                                for the next. The tab JavaScript swaps classes to control the content visibility and
                                styling. consectetur adipisicing elit. Ab ipsa!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" aria-hidden="true" role="dialog" tabindex="-1" id="modal-finalizar">

        <form method="POST" action="{{url('reporte_falla/finalizar_falla')}}">
            @csrf
            <input type="hidden" name="censo_id" value="{{ $censo->id }}">
            <input type="hidden" name="reporte_falla_id" value="{{ $reporte_falla->id }}">
            <input type="hidden" name="fecha" value="{{ date('Y-m-d') }}">
            <div class="modal-dialog relative w-auto pointer-events-none">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding
                              rounded-md outline-none text-current">
                  <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-slate-600 bg-black-500">
                      <h3 class="text-base font-medium text-white dark:text-white capitalize">
                        Finalizar reporte
                      </h3>
                      <button type="button" class="text-slate-400 bg-transparent hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center
                                          dark:hover:bg-slate-600 dark:hover:text-white" data-bs-dismiss="modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="#ffffff" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10
                                                  11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                      </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">
                      <h6 class="text-base text-slate-900 dark:text-white leading-6">
                        Confirme si desea finalizar el reporte
                      </h6>
                      <div class="input-area relative">
                        <label for="largeInput" class="form-label">Observación</label>
                        <textarea class="form-control" name="observacion" required></textarea>
                    </div>
                    </div>
                    <!-- Modal footer -->
                    <div class=" items-center p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                      <button type="submit" class="btn inline-flex justify-center text-white bg-black-500 float-right" style="margin-bottom: 15px">Aceptar</button>
                    </div>
                  </div>
                </div>
              </div>
        </form>

    </div>






    <script>
        document.getElementById('condicion_lampara').addEventListener('change', function() {
            const isChecked = this.checked;
            const divTipoFalla = document.getElementById('div_tipo_falla');
            const tipoFallaId = document.getElementById('tipo_falla_id');

            if (isChecked) {
                divTipoFalla.style.display = 'none';
                tipoFallaId.value = '';
            } else {
                divTipoFalla.style.display = 'block';
            }
        });

        // Initialize display based on initial checkbox state
        document.addEventListener('DOMContentLoaded', function() {
            const condicionLampara = document.getElementById('condicion_lampara');
            const divTipoFalla = document.getElementById('div_tipo_falla');
            const tipoFallaId = document.getElementById('tipo_falla_id');

            if (condicionLampara.checked) {
                divTipoFalla.style.display = 'none';
                tipoFallaId.value = '';
            } else {
                divTipoFalla.style.display = 'block';
            }
        });
    </script>
@endsection
