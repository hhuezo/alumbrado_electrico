@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">Listado de censos
            </h4>
            <a href="{{ url('control/censo_luminaria/show_map') }}">
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

                                    <td style="text-align: center">Codigo</td>
                                    <td style="text-align: center">Tipo luminaria</td>
                                    <td style="text-align: center">Fecha</td>
                                    <td style="text-align: center">Consumo mensual</td>
                                    <td style="text-align: center">Distrito</td>
                                    <td style="text-align: center">opciones</td>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($censo_luminarias->count() > 0)
                                    @foreach ($censo_luminarias as $obj)
                                        <tr>
                                            <td align="center">{{ $obj->codigo_luminaria }}</td>
                                            <td>{{ $obj->tipo_luminaria->nombre }}</td>

                                            <td align="center">{{ date('d/m/Y', strtotime($obj->fecha_ingreso)) }}</td>

                                            <td align="center">{{ $obj->consumo_mensual }} (kWh)</td>
                                            <td>{{ $obj->distrito->nombre }}</td>
                                            <td align="center">

                                                <a href="{{ url('control/censo_luminaria') }}/{{ $obj->id }}">
                                                    <button class="btn inline-flex justify-center btn-primary">
                                                        <iconify-icon icon="ic:outline-remove-red-eye" width="24"
                                                            height="24"></iconify-icon>
                                                    </button>
                                                </a>

                                                @if ($obj->countCodigo($obj->codigo_luminaria) == 1)
                                                    <button class="btn inline-flex justify-center btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete-{{ $obj->id }}">
                                                        <iconify-icon icon="mdi:trash" width="24"></iconify-icon>
                                                    </button>
                                                @else
                                                    <button
                                                        class="btn inline-flex justify-center btn-danger cursor-not-allowed light"
                                                        disabled="disabled"><iconify-icon icon="mdi:trash"
                                                            width="24"></iconify-icon> </button>
                                                @endif

                                            </td>
                                        </tr>
                                        @include('control.censo_luminaria.modal')
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
