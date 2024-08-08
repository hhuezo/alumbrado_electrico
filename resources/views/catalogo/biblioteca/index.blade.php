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
                                            <td><input type="checkbox" {{ $obj->descargable == '1' ? 'checked' : '' }}></td>
                                            <td align="center">
                                                <a href="{{ url('catalogo/biblioteca') }}/{{ $obj->id }}/edit">
                                                <iconify-icon icon="mdi:pencil-circle" width="40"></iconify-icon>
                                                </a>
                                                

                                                @if ($obj->activo == '1')
                                                    <iconify-icon data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete-{{ $obj->id }}" icon="f7:trash-circle-fill"
                                                        width="40"></iconify-icon>
                                                        
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
