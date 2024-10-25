@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">Valor de la energia
            </h4>
            {{-- data-bs-toggle="modal" data-bs-target="#modal-create" --}}
            <a href="{{url('control/valor_mensual_energia/create')}}">
            <button class="btn btn-dark" >Nuevo</button>
            </a>

        </header>


        <div class="card-body px-6 pb-6">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <br>

            <div style=" margin-left:20px; margin-right:20px; ">
                <span class=" col-span-8  hidden"></span>
                <span class="  col-span-4 hidden"></span>
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden " style=" margin-bottom:20px ">
                        <table id="myTable" class="display" cellspacing="0" width="100%">
                            <thead class=" border-t border-slate-100 dark:border-slate-800">
                                <tr >

                                    <th scope="col" class=" table-th ">Fecha inicio</td>
                                    <th scope="col" class=" table-th ">Fecha final</td>
                                    <th scope="col" class=" table-th ">opciones</td>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                @if ($valor_energia->count() > 0)
                                    @foreach ($valor_energia as $obj)
                                        <tr>
                                            <td class="table-td">{{ $obj->fecha_inicio ?  date('d/m/Y', strtotime($obj->fecha_inicio)) : '' }}</td>
                                            <td class="table-td">{{ $obj->fecha_inicio ?  date('d/m/Y', strtotime($obj->fecha_final)) : '' }}</td>

                                            <td align="center" class="table-td">
                                                <a href="{{url('control/valor_mensual_energia')}}/{{$obj->id}}/edit"
                                                <button>
                                                <iconify-icon icon="mdi:pencil-circle" width="40" data-bs-toggle="modal" data-bs-target="#modal-edit-{{$obj->id}}" style="color: #0d6efd;"></iconify-icon>
                                                </button>
                                                </a>

                                                <button>
                                                <iconify-icon data-bs-toggle="modal"
                                                data-bs-target="#modal-delete-{{ $obj->id }}" icon="mdi:trash"
                                                width="40"></iconify-icon>
                                            </button>
                                            </td>
                                        </tr>
                                        @include('control.valor_mensual_energia.modal')
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
