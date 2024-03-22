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
                            <div class="card-title text-slate-900 dark:text-white">Biblioteca

                                <a href="{{ url('catalogo/biblioteca') }}">
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
                                        <form method="POST" action="{{ url('catalogo/biblioteca') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card h-full">
                                                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-7">

                                                    <div class="grid pt-4 pb-3 px-4">
                                                        <div class="input-area relative">
                                                            <label for="largeInput" class="form-label">Fecha inicio</label>
                                                            <input type="date" name="titulo" value="{{ old('titulo') }}"
                                                                required class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="grid pt-4 pb-3 px-4">
                                                        <div class="input-area relative">
                                                            <label for="largeInput" class="form-label">Fecha final</label>
                                                            <input type="date" name="descripcion"
                                                                value="{{ old('descripcion') }}" required
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
                                                                <td id="1-{{ $compañia->id }}" contenteditable="true"
                                                                    class="editable">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            <td class="editable">Cargo de energia: Cargo variable</td>
                                                            @foreach ($compañias as $compañia)
                                                                <td id="2-{{ $compañia->id }}" contenteditable="true"
                                                                    class="editable">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            <td class="editable">Cargo de Distribución: Cargo variable</td>
                                                            @foreach ($compañias as $compañia)
                                                                <td id="3-{{ $compañia->id }}" contenteditable="true"
                                                                    class="editable">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        <!-- Agrega más filas según sea necesario -->
                                                    </table>
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
    </script>

@endsection
