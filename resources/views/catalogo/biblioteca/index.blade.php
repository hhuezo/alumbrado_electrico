@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">Biblioteca
            </h4>
            <a href="{{ url('catalogo/biblioteca/create') }}">
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
                            <thead class=" border-t border-slate-100 dark:border-slate-800">
                                <tr >

                                    <th scope="col" class=" table-th ">Id</td>
                                    <th scope="col" class=" table-th ">Tipo documento</td>
                                    <th scope="col" class=" table-th ">Título</td>
                                    <th scope="col" class=" table-th ">Descripción</td>
                                    <th scope="col" class=" table-th ">Descargable</td>
                                    <th scope="col" class=" table-th ">opciones</td>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @if ($bibliotecas->count() > 0)
                                    @foreach ($bibliotecas as $obj)
                                    <tr>
                                        <td align="center" class="table-td">{{ $obj->id }}</td>
                                        <td class="table-td">{{ $obj->tipo_documento->nombre }}</td>
                                        <td class="table-td">{{ $obj->titulo }}</td>
                                        <td class="table-td">{{ $obj->descripcion }}</td>
                                        <td class="table-td"><input type="checkbox" {{$obj->descargable == '1' ? 'checked':''}}></td>
                                        <td align="center" class="table-td">
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



@endsection
