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
                    <table id="censo_tabla" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr class="filters">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class="td-table">
                                <td style="text-align: center">#</td>
                                <td style="text-align: center">Codigo</td>
                                <td style="text-align: center">Tipo luminaria</td>
                                <td style="text-align: center">Fecha</td>
                                <td style="text-align: center">Consumo mensual</td>
                                <td style="text-align: center">Distrito</td>
                                <td style="text-align: center">Condición</td>
                                <td style="text-align: center">Opciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($censo_luminarias->count() > 0)
                            @php($i = 1)
                            @foreach ($censo_luminarias as $obj)
                            <tr>
                                <td align="center">{{ $i }}</td>
                                <td align="center">{{ $obj->codigo_luminaria }}</td>
                                <td>{{ $obj->tipo_luminaria->nombre }}</td>

                                <td align="center">{{ date('d/m/Y', strtotime($obj->fecha_ingreso)) }}</td>

                                <td align="center">{{ $obj->consumo_mensual }} (kWh)</td>
                                <td>{{ $obj->distrito->nombre }}</td>
                                <td>{{ $obj->tipo_falla ? $obj->tipo_falla->nombre : 'En buen estado' }}</td>
                                <td align="center">
                                    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;">

                                        <a href="{{ url('control/censo_luminaria') }}/{{ $obj->id }}">
                                            <iconify-icon icon="pepicons-pencil:eye-circle-filled" width="40"
                                                height="40"></iconify-icon>
                                        </a>

                                        <a href="{{ url('control/censo_luminaria') }}/{{ $obj->id }}/edit">
                                            <iconify-icon icon="el:pencil-alt" width="40" height="40"></iconify-icon>
                                        </a>


                                        @if ($obj->countCodigo($obj->codigo_luminaria) == 1)
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-{{ $obj->id }}">
                                            <iconify-icon icon="f7:trash-circle-fill" width="45" height="45">
                                            </iconify-icon>
                                        </a>
                                        @else
                                        <iconify-icon disabled="disabled" icon="f7:trash-circle-fill" width="45"
                                            height="45"></iconify-icon>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @php($i++)
                            @include('control.censo_luminaria.modal')
                            @endforeach
                            @endif
                            </thead>
                        <tbody>
                       <!-- <tfoot>
                            <tr>
                                <th></th>
                                <th>Codigo</th>
                                <th>Tipo luminaria</th>
                                <th>Fecha</th>
                                <th>Consumo mensual</th>
                                <th>Distrito</th>
                                <th>Condición</th>
                                <th></th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#censo_tabla')) {
                $('#censo_tabla').DataTable().destroy();
            }
            $('#censo_tabla').DataTable({

                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },

                initComplete: function () {
                var api = this.api();
                var numColumns = api.columns().nodes().length;

                api.columns().every(function (index) {
                    // Exclude the last column
                    if (index > 0 && index < numColumns - 1) {
                        var column = this;
                        var header = $(column.header());
                        var filterCell = $('.filters td').eq(index);


                        // Create select element and listener
                        var select = $('<select><option value="">Todos</option></select>')
                            .appendTo(filterCell)
                            .on('change', function () {
                                column
                                    .search($(this).val(), { exact: true })
                                    .draw();
                            });

                        // Add list of options
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' + d + '">' + d + '</option>'
                                );
                            });
                    }
                });
            }
            });
        });
</script>
@endsection
