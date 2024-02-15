@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">Valor de la energia
            </h4>
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal-create">Nuevo</button>

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
                            <thead>
                                <tr class="td-table">

                                    <td style="text-align: center">Año</td>
                                    <td style="text-align: center">Mes</td>
                                    <td style="text-align: center">Valor</td>
                                    <td style="text-align: center">opciones</td>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($valor_mesual_energia->count() > 0)
                                    @foreach ($valor_mesual_energia as $obj)
                                        <tr>
                                            <td align="center">{{ $obj->anio }}</td>
                                            <td align="center">{{ $meses[$obj->mes] }}</td>
                                            <td align="right">${{ number_format($obj->valor, 2, '.', ',') }}</td>

                                            <td align="center">

                                                <iconify-icon icon="mdi:pencil-box" width="40" data-bs-toggle="modal" data-bs-target="#modal-edit-{{$obj->id}}"></iconify-icon>


                                                <iconify-icon data-bs-toggle="modal"
                                                data-bs-target="#modal-delete-{{ $obj->id }}" icon="mdi:trash"
                                                width="40"></iconify-icon>
                                            </td>
                                        </tr>
                                        @include('control.valor_mensual_energia.modal_edit')
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

    @include('control.valor_mensual_energia.modal_create')

@endsection
