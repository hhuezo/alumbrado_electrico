@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">Listado de censos
            </h4>
            <a href="{{ url('control/censo_luminaria/create') }}">
                <button class="btn btn-dark">Nuevo</button>
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

                                    <td style="text-align: center">Id</td>
                                    <td style="text-align: center">Nombre</td>
                                    <td style="text-align: center">Activo</td>
                                    <td style="text-align: center">opciones</td>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($censo_luminarias->count() > 0)
                                    @foreach ($censo_luminarias as $obj)
                                    <tr>
                                        <td align="center">{{ $obj->Id }}</td>
                                        <td>{{ $obj->Nombre }}</td>
                                        <td align="center"><input type="checkbox" {{$obj->Activo == 1 ? 'checked':''}}></td>
                                        <td align="center">
                                            <a href="{{ url('catalogo/lugar_formacion') }}/{{ $obj->Id }}/edit">
                                                <iconify-icon icon="mdi:pencil-box" width="40"></iconify-icon>
                                            </a>
                                            &nbsp;&nbsp;

                                            @if ($obj->Activo == 1)
                                            <iconify-icon data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-{{ $obj->Id }}" icon="mdi:trash"
                                            width="40"></iconify-icon>
                                            @else
                                            <iconify-icon data-bs-toggle="modal"
                                            data-bs-target="#modal-active-{{ $obj->Id }}"
                                            icon="fontisto:checkbox-active" style="color: #1769aa;"
                                            width="30"></iconify-icon>
                                            @endif

                                        </td>
                                    </tr>

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
