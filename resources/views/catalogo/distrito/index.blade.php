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
                        <thead class=" border-t border-slate-100 dark:border-slate-800">
                                <tr >

                                    <th scope="col" class=" table-th ">Id</td>
                                    <th scope="col" class=" table-th ">Codigo</td>
                                    <th scope="col" class=" table-th ">Nombre</td>
                                    <th scope="col" class=" table-th ">Extensión territorial</td>
                                    <th scope="col" class=" table-th ">Población</td>
                                    <th scope="col" class=" table-th ">Municipio</td>
                                    <th scope="col" class=" table-th ">Departamento</td>
                                    <th scope="col" class=" table-th ">opciones</td>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @if ($distritos->count() > 0)
                                    @foreach ($distritos as $obj)
                                    <tr>
                                        <td align="center" class="table-td">{{ $obj->id }}</td>
                                        <td class="table-td">{{ $obj->codigo }}</td>
                                        <td class="table-td">{{ $obj->nombre }}</td>
                                        <td class="table-td">{{ $obj->extension_territorial ? $obj->extension_territorial .' km2':'' }}</td>
                                        <td class="table-td">{{ $obj->poblacion }}</td>
                                        <td class="table-td">{{ $obj->municipio->nombre }}</td>
                                        <td class="table-td">{{ $obj->municipio->departamento->nombre }}</td>
                                        <td align="center" class="table-td">
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
