@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">Distritos
            </h4>

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
                                    <td>Codigo</td>
                                    <td>Nombre</td>
                                    <td>Extensión territorial</td>
                                    <td>Poblacion</td>
                                    <td>Departamento</td>
                                    <td>opciones</td>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($distritos->count() > 0)
                                    @foreach ($distritos as $obj)
                                    <tr>
                                        <td align="center">{{ $obj->id }}</td>
                                        <td>{{ $obj->codigo }}</td>
                                        <td>{{ $obj->nombre }}</td>
                                        <td>{{ $obj->extension_territorial }}</td>
                                        <td>{{ $obj->poblacion }}</td>
                                        <td>{{ $obj->departamento->nombre }}</td>

                                        <td align="center">
                                            <a href="{{ url('catalogo/distrito') }}/{{ $obj->id }}/edit">
                                                <iconify-icon icon="mdi:pencil-box" width="40"></iconify-icon>
                                            </a>

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
