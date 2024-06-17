@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            /* Ajusta el ancho del switch */
            height: 20px;
            /* Ajusta la altura del switch */
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            /* Ajusta la altura del círculo */
            width: 16px;
            /* Ajusta el ancho del círculo */
            left: 2px;
            /* Ajusta la posición izquierda del círculo */
            bottom: 2px;
            /* Ajusta la posición inferior del círculo */
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(20px);
            /* Ajusta la posición cuando está activado */
            -ms-transform: translateX(20px);
            /* Ajusta la posición cuando está activado */
            transform: translateX(20px);
            /* Ajusta la posición cuando está activado */
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 20px;
            /* Ajusta el radio de borde para hacerlo redondo */
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

    <div class="card">
        <header class=" card-header noborder">
            <h4 class="card-title">Municipios
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
                                    <td>Nombre</td>
                                    <td>Departamento</td>
                                    <td>Convenio</td>
                                    <td>opciones</td>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($municipios->count() > 0)
                                    @foreach ($municipios as $obj)
                                        <tr>
                                            <td align="center">{{ $obj->id }}</td>
                                            <td>{{ $obj->nombre }}</td>
                                            <td>{{ $obj->departamento ? $obj->departamento->nombre : '' }}</td>

                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" name="convenio"
                                                        {{ $obj->convenio == 1 ? 'checked' : '' }} id="convenio">
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td align="center">
                                                <a href="{{ url('catalogo/municipio') }}/{{ $obj->id }}/edit">
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
