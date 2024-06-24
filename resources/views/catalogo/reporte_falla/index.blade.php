@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">Reporte de fallas
            </h4>
            <a href="{{ url('catalogo/reporte_falla/create') }}">
                <button class="btn btn-outline-dark">Nuevo</button>
            </a>
        </header>
        <div class="card-body px-6 pb-6">
            <div style=" margin-left:20px; margin-right:20px; ">
                <span class=" col-span-8  hidden"></span>
                <span class="  col-span-4 hidden"></span>
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden " style=" margin-bottom:20px ">
                        <table id="myTable" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr class="td-table">

                                    <td>Id</td>
                                    <td>Fecha</td>
                                    <td>Distrito</td>
                                    <td>Tipo falla</td>
                                    <td>Nombre</td>
                                    <td>Telefono</td>
                                    <td>opciones</td>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($reporte_fallas->count() > 0)
                                    @foreach ($reporte_fallas as $obj)
                                        <tr>
                                            <td align="center">{{ $obj->id }}</td>
                                            @if ($obj->fecha)
                                                <td>{{ date('d/m/Y', strtotime($obj->fecha)) }}</td>
                                            @else
                                                <td></td>
                                            @endif

                                            <td>{{ $obj->distrito->nombre }}</td>
                                            <td>{{ $obj->tipo_falla->nombre }}</td>
                                            <td>{{ $obj->nombre_contacto }}</td>
                                            <td>{{ $obj->telefono_contacto }}</td>
                                            <td align="center">
                                                <a href="{{ url('reporte_falla') }}/{{ $obj->id }}">
                                                    <iconify-icon icon="pepicons-pop:eye-circle-filled" width="40" height="40"></iconify-icon>
                                                </a>
                                                &nbsp;&nbsp;
                                                <a href="{{ url('catalogo/reporte_falla') }}/{{ $obj->id }}/edit">
                                                    <iconify-icon icon="mdi:pencil-box" width="40"></iconify-icon>
                                                </a>
                                                &nbsp;&nbsp;
                                                <iconify-icon data-bs-toggle="modal"
                                                    data-bs-target="#modal-delete-{{ $obj->id }}" icon="mdi:trash"
                                                    width="40"></iconify-icon>


                                            </td>
                                        </tr>

                                        @include('catalogo.reporte_falla.modal')
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



@endsection
