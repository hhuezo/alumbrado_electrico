@extends ('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        .editable {
            /*background-color: #f3f3f3;*/
        }
    </style>

    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Valo de la energía

                                <a href="{{ url('control/valor_mensual_energia') }}">
                                    <button class="btn btn-dark btn-sm float-right">
                                        <iconify-icon icon="icon-park-solid:back" style="color: white;" width="18">
                                        </iconify-icon>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </header>



                    <div class="transition-all duration-150 container-fluid" id="page_layout">
                        <div id="content_layout">
                            <div class="space-y-5">
                                <div class="grid grid-cols-12 gap-5">

                                    <div class="xl:col-span-12 col-span-12 lg:col-span-12">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ url('control/valor_mensual_energia') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card h-full">
                                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-7">

                                                    <div class="grid pt-4 pb-3 px-4">
                                                        <div class="input-area relative">
                                                            <label for="largeInput" class="form-label">Fecha inicio</label>
                                                            <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                                                                required class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="grid pt-4 pb-3 px-4">
                                                        <div class="input-area relative">
                                                            <label for="largeInput" class="form-label">Fecha final</label>
                                                            <input type="date" name="fecha_final"
                                                                value="{{ old('fecha_final') }}" required
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-7">

                                                    <table id="editableTable">
                                                        <tr>
                                                            <th>Alumbrado público</th>
                                                            @foreach ($compañias as $compañia)
                                                                <th>{{ $compañia->nombre }}</th>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            <td class="editable">Cargo de comercialización: Cargo fijo</td>
                                                            @foreach ($compañias as $compañia)
                                                                <td id="comercializacion_{{ $compañia->id }}"
                                                                    contenteditable="true" class="editable">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            <td class="editable">Cargo de energia: Cargo variable</td>
                                                            @foreach ($compañias as $compañia)
                                                                <td id="energia_{{ $compañia->id }}" contenteditable="true"
                                                                    class="editable">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            <td class="editable">Cargo de Distribución: Cargo variable</td>
                                                            @foreach ($compañias as $compañia)
                                                                <td id="distribucion_{{ $compañia->id }}"
                                                                    contenteditable="true" class="editable">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        <!-- Agrega más filas según sea necesario -->
                                                    </table>
                                                </div>

                                                <div id="div_form" style="display: none">
                                                    @foreach ($compañias as $compañia)
                                                        <input type="text"
                                                            id="compania_comercializacion_{{ $compañia->id }}"
                                                            name="compania_comercializacion_{{ $compañia->id }}">
                                                        <input type="text" name="compania_energia_{{ $compañia->id }}"
                                                            id="compania_energia_{{ $compañia->id }}"
                                                            placeholder="compania_energia_{{ $compañia->id }}">
                                                        <input type="text"
                                                            name="compania_distribucion_{{ $compañia->id }}"
                                                            id="compania_distribucion_{{ $compañia->id }}"
                                                            placeholder="compania_distribucion_{{ $compañia->id }}">
                                                    @endforeach
                                                </div>

                                                <div>&nbsp;</div>
                                                <div style="text-align: right;">
                                                    <button type="submit" style="margin-right: 18px"
                                                        class="btn btn-dark">Aceptar</button>
                                                </div>
                                        </form>
                                    </div>
                                    <div class="xl:col-span-3 col-span-12 lg:col-span-3 ">
                                        <div class="card p-6 h-full">
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>

                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todas las celdas editables
            var editableCells = document.querySelectorAll('#editableTable td.editable[contenteditable="true"]');

            // Añade el controlador de eventos a cada celda editable
            editableCells.forEach(function(cell) {
                cell.addEventListener('input', function(e) {
                    // Permite solo números, comas y puntos
                    const regex = /^[0-9,.]*$/;
                    if (!regex.test(e.target.innerText)) {
                        // Elimina caracteres no permitidos
                        e.target.innerText = e.target.innerText.replace(/[^0-9,.]/g, '');
                        // Mueve el cursor al final (útil para navegadores que reubican el cursor al principio después de la limpieza)
                        setCaretAtEnd(e.target);
                    }
                    updateInputs(cell.id);
                });
            });
        });

        // Función para colocar el cursor al final del contenido editable
        function setCaretAtEnd(element) {
            const range = document.createRange();
            const selection = window.getSelection();
            range.selectNodeContents(element);
            range.collapse(false);
            selection.removeAllRanges();
            selection.addRange(range);
            element.focus();
        }

        function updateInputs(id) {
            var $input = $("#" + id).text().replace(/,/g, '');
            var input_final = $("#compania_" + id).val($input);
            console.log(id, $input, input_final);
        }
    </script>

@endsection
