@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">Tipo luminaria
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
                                    <th scope="col" class=" table-th ">Nombre</td>

                                    <th scope="col" class=" table-th ">opciones</td>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @if ($tipos_luminaria->count() > 0)
                                    @foreach ($tipos_luminaria as $obj)
                                    <tr>
                                        <td align="center" class="table-td">{{ $obj->id }}</td>
                                        <td class="table-td">{{ $obj->nombre }}</td>

                                        <td align="center" class="table-td">
                                            <a href="{{ url('catalogo/tipo_luminaria') }}/{{ $obj->id }}/edit">
                                                <iconify-icon icon="mdi:pencil-circle" width="40" style="color: #0d6efd;"></iconify-icon>
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
