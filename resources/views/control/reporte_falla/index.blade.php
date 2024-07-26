@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">Reporte de fallas
            </h4>
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#default_modal">Filtrar</button>
        </header>
        <div class="card-body px-6 pb-6">
            <div style=" margin-left:20px; margin-right:20px; ">
                <span class=" col-span-8  hidden"></span>
                <span class="  col-span-4 hidden"></span>
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden " style=" margin-bottom:20px ">
                        <table id="myTable" class="display" cellspacing="0" width="100%">
                            <thead class=" border-t border-slate-100 dark:border-slate-800">
                                <tr >

                                    <th scope="col" class=" table-th ">Id</td>
                                    <th scope="col" class=" table-th ">Fecha</td>
                                    <th scope="col" class=" table-th ">Distrito</td>
                                    <th scope="col" class=" table-th ">Tipo falla</td>
                                    <th scope="col" class=" table-th ">Nombre</td>
                                    <th scope="col" class=" table-th ">Telefono</td>
                                    <th scope="col" class=" table-th ">Estado</td>
                                    <th scope="col" class=" table-th ">opciones</td>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @if ($reporte_fallas->count() > 0)
                                    @foreach ($reporte_fallas as $obj)
                                        <tr>
                                            <td align="center" class="table-td">{{ $obj->id }}</td>
                                            @if ($obj->fecha)
                                                <td class="table-td">{{ date('d/m/Y', strtotime($obj->fecha)) }}</td>
                                            @else
                                                <td class="table-td"></td>
                                            @endif

                                            <td class="table-td">{{ $obj->distrito->nombre }}</td>
                                            <td class="table-td">{{ $obj->tipo_falla->nombre }}</td>
                                            <td class="table-td">{{ $obj->nombre_contacto }}</td>
                                            <td class="table-td">{{ $obj->telefono_contacto }}</td>
                                            <td class="table-td">{{ $obj->estado->nombre }}</td>
                                            <td align="center" class="table-td">
                                                <a href="{{ url('reporte_falla') }}/{{ $obj->id }}">
                                                    <iconify-icon icon="pepicons-pop:eye-circle-filled" width="40"
                                                        height="40"></iconify-icon>
                                                </a>
                                                &nbsp;&nbsp;
                                                <a href="{{ url('control/reporte_falla') }}/{{ $obj->id }}/edit">
                                                    <iconify-icon icon="mdi:pencil-box" width="40"></iconify-icon>
                                                </a>
                                                &nbsp;&nbsp;
                                                <iconify-icon data-bs-toggle="modal"
                                                    data-bs-target="#modal-delete-{{ $obj->id }}" icon="mdi:trash"
                                                    width="40"></iconify-icon>


                                            </td>
                                        </tr>

                                        @include('control.reporte_falla.modal')
                                    @endforeach
                                @endif
                                </thead>
                            <tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
        id="default_modal" tabindex="-1" aria-labelledby="default_modal" aria-hidden="true">
        <form method="GET" action="{{ url('reporte_falla') }}">
            <div class="modal-dialog relative w-auto pointer-events-none">
                <div
                    class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-paddingrounded-md outline-none text-current">
                    <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-5 border-b rounded-t dark:border-slate-600 bg-black-500">
                            <h3 class="text-xl font-medium text-white dark:text-white capitalize">
                                Seleccione distrito
                            </h3>
                            <button type="button"
                                class="text-slate-400 bg-transparent hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center
                        dark:hover:bg-slate-600 dark:hover:text-white"
                                data-bs-dismiss="modal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="#ffffff" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10
                                                    11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->

                        <div class="p-6 space-y-4">

                            <div>
                                <label for="basicSelect" class="form-label">Departamento</label>
                                <select name="departamento_id" id="departamento" class="form-control w-full mt-2"
                                    onchange="getMunicipio(this.value)">
                                    <option value="">Todo</option>
                                    @foreach ($departamentos as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $departamento_id == $obj->id ? 'selected' : '' }}>
                                            {{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="basicSelect" class="form-label">Municipio</label>
                                <select name="municipio_id" id="municipio" class="form-control w-full mt-2"
                                    onchange="getDistrito(this.value)">
                                    <option value="">Seleccione</option>
                                    @if ($municipios)
                                        @foreach ($municipios as $obj)
                                            <option value="{{ $obj->id }}"
                                                {{ $municipio_id == $obj->id ? 'selected' : '' }}>
                                                {{ $obj->nombre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div>
                                <label for="basicSelect" class="form-label">Distrito</label>
                                <select id="distrito" name="distrito_id" class="form-control w-full mt-2">
                                    <option value="">Seleccione</option>
                                    @if ($municipios)
                                        @foreach ($distritos as $obj)
                                            <option value="{{ $obj->id }}"
                                                {{ $distrito_id == $obj->id ? 'selected' : '' }}>
                                                {{ $obj->nombre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div>
                                <label for="basicSelect" class="form-label">Estado</label>
                                <select id="distrito" name="distrito_id" class="form-control w-full mt-2">
                                    <option value="">Todos</option>
                                    @if ($estados)
                                        @foreach ($estados as $obj)
                                            <option value="{{ $obj->id }}"
                                                {{ $estado_id == $obj->id ? 'selected' : '' }}>
                                                {{ $obj->nombre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div
                            class="flex items-center justify-end p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                            <button type="submit"
                                class="btn inline-flex justify-center text-white bg-black-500">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function getMunicipio(id) {
            var Departamento = id;

            if (Departamento == "") {
                document.getElementById('municipio').value = "";
                document.getElementById('distrito').value = "";
            } else {

                //funcionpara las municipios
                $.get("{{ url('get_municipios') }}" + '/' + Departamento, function(data) {

                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    console.log(data);
                    var _select = '<option value="">Seleccione...</option>'
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                        '</option>';

                    $("#municipio").html(_select);

                });
            }
        }

        function getDistrito(id) {
            var Municipio = id;


            //funcionpara las municipios
            $.get("{{ url('get_distritos') }}" + '/' + Municipio, function(data) {

                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                console.log(data);
                var _select = '<option value="">Seleccione...</option>'
                for (var i = 0; i < data.length; i++)
                    _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                    '</option>';

                $("#distrito").html(_select);

            });
        }
    </script>

@endsection
