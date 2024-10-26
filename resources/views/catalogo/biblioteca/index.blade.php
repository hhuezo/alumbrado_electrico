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

                                    <th>Id</th>
                                    <th>Tipo documento</th>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Descargable</th>
                                    <th width="10%">Opciones</th>

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
                                            <td>
                                        
                                            <label class="relative inline-flex h-6 w-[46px] items-center rounded-full transition-all duration-150 cursor-pointer">
                                                <input type="checkbox" value="" {{ $obj->descargable == '1' ? 'checked' : '' }} class="sr-only peer">
                                                <div class="w-14 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:z-10 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-secondary-500"></div>
                                            </label></td>
                                            <td align="center">
                                                <a href="{{ url('catalogo/biblioteca') }}/{{ $obj->id }}/edit" >
                                                <iconify-icon icon="mdi:pencil-circle" width="40" style="color: #0d6efd;"></iconify-icon>
                                                </a>
                                                

                                                @if ($obj->activo == '1')
                                                    <iconify-icon data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete-{{ $obj->id }}" icon="f7:trash-circle-fill"
                                                        width="40" style="color:#dc3545;"></iconify-icon>
                                                        
                                                @else
                                                    <iconify-icon data-bs-toggle="modal"
                                                        data-bs-target="#modal-active-{{ $obj->id }}"
                                                        icon="material-symbols:check-active" style="color: #1769aa;"
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

   
@endsection
