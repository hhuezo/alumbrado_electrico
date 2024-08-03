@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">


    <div class=" space-y-5">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title">Solicitudes
                </h4>
            </div>

            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto -mx-6">
                    <div class="inline-block min-w-full align-middle" style="padding: 10px">


                        <table id="example" class="display" style="width:100%">
                            <thead class=" border-t border-slate-100 dark:border-slate-800">
                                <tr>

                                    <th>Id</td>
                                    <th>Tipo documento</td>
                                    <th>Título</td>
                                    <th>Descripción</td>
                                    <th>Descargable</td>
                                    <th>opciones</td>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($bibliotecas->count() > 0)
                                    @foreach ($bibliotecas as $obj)
                                        <tr>
                                            <td align="center">{{ $obj->id }}</td>
                                            <td>{{ $obj->tipo_documento->nombre }}</td>
                                            <td>{{ $obj->titulo }}</td>
                                            <td>{{ $obj->descripcion }}</td>
                                            <td><input type="checkbox" {{ $obj->descargable == '1' ? 'checked' : '' }}></td>
                                            <td align="center">
                                                <a href="{{ url('catalogo/biblioteca') }}/{{ $obj->id }}/edit">
                                                    <iconify-icon icon="mdi:pencil-box" width="40"></iconify-icon>
                                                </a>
                                                &nbsp;&nbsp;

                                                @if ($obj->activo == '1')
                                                    <iconify-icon data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete-{{ $obj->id }}" icon="mdi:trash"
                                                        width="40"></iconify-icon>
                                                @else
                                                    <iconify-icon data-bs-toggle="modal"
                                                        data-bs-target="#modal-active-{{ $obj->id }}"
                                                        icon="fontisto:checkbox-active" style="color: #1769aa;"
                                                        width="30"></iconify-icon>
                                                @endif

                                            </td>
                                        </tr>

                                        @include('catalogo.biblioteca.modal')
                                        @include('catalogo.biblioteca.modal_active')
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

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": ">",
                        "previous": "<"
                    }
                }
            });
        });
    </script>

@endsection
