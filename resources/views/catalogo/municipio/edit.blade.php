@extends('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <script src="{{ asset('assets/js/inputmask.min.js') }}"></script>

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
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
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
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
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>




    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">MUNICIPIO: {{ $municipio->nombre }}

                                <a href="{{ url('catalogo/municipio') }}">
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
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="xl:col-span-12 col-span-12 lg:col-span-12">

                                        <form method="POST" action="{{ route('municipio.update', $municipio->id) }}"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf

                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">


                                                {{-- <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">municipio</label>
                                                    <input type="text" value="{{ $municipio->nombre }}" readonly
                                                        class="form-control">
                                                </div>



                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Departamento</label>
                                                    <input type="text" value="{{ $municipio->departamento->nombre }}"
                                                        class="form-control" readonly>
                                                </div> --}}



                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Convenio firmado</label>
                                                    <label class="switch">
                                                        <input type="checkbox" name="convenio"
                                                            {{ $municipio->convenio == 1 ? 'checked' : '' }} id="convenio">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">&nbsp;</label>
                                                </div>



                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Nombre responsable </label>
                                                    <input type="text" name="nombre_responsable" id="nombre_responsable"
                                                     value="{{ $municipio->nombre_responsable }}"
                                                        class="form-control">
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Puesto/Funciones encargado </label>
                                                    <input type="text" name="puesto_responsable" id="puesto_responsable"
                                                     value="{{ $municipio->puesto_responsable }}"
                                                        class="form-control">
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Correo</label>
                                                    <input type="email" name="correo_responsable" id="correo_responsable"
                                                     value="{{ $municipio->correo_responsable }}"
                                                        class="form-control">
                                                </div>



                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Teléfono</label>
                                                    <input type="text" name="telefono_responsable"
                                                        id="telefono_responsable"
                                                        value="{{ $municipio->telefono_responsable }}"
                                                        class="form-control">
                                                </div>



                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Dirección</label>
                                                    <input type="text" name="direccion_responsable"
                                                        id="direccion_responsable"
                                                        value="{{ $municipio->direccion_responsable }}"
                                                        class="form-control">
                                                </div>


                                            </div>
                                            <br>
                                            <div style="text-align: right;">
                                                <button type="submit" style="margin-right: 18px"
                                                    class="btn btn-dark">Aceptar</button>
                                            </div>
                                        </form>
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
            Inputmask("9999-9999").mask(telefonoResponsable);
        });
    </script>

@endsection
