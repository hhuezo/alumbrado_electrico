@extends('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Tipo luminaria

                                <a href="{{ url('catalogo/tipo_luminaria') }}">
                                    <button class="btn btn-dark btn-sm float-right">
                                        <iconify-icon icon="icon-park-solid:back" style="color: white;" width="18">
                                        </iconify-icon>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </header>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="transition-all duration-150 container-fluid" id="page_layout">
                        <div id="content_layout">
                            <div class="space-y-5">
                                <div class="grid grid-cols-12 gap-5">

                                    <div class="xl:col-span-12 col-span-12 lg:col-span-12">

                                        <form method="POST"
                                            action="{{ route('tipo_luminaria.update', $tipo_luminaria->id) }}"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf

                                            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-7">

                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Nombre</label>
                                                        <input type="text" name="nombre"
                                                            value="{{ $tipo_luminaria->nombre }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Ícono</label>
                                                        <input type="file" name="icono" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        @if ($tipo_luminaria->icono)
                                                        <div class="md:h-[140px] md:w-[140px] h-[100px] w-[100px] md:ml-0 md:mr-0 ml-auto mr-auto md:mb-0 mb-4 rounded-full ring-4 ring-slate-100 relative">
                                                            <img src="{{ asset('img/') }}/{{ $tipo_luminaria->icono }}" alt="" class="w-full h-full object-cover rounded-full">

                                                        </div>

                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
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


        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Potencias
                                <button type="button" class="btn btn-dark btn-sm float-right" data-bs-toggle="modal"
                                    data-bs-target="#modal-create">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </header>

                    @include('catalogo.tipo_luminaria.modal_create')
                    <div class="transition-all duration-150 container-fluid" id="page_layout">
                        <div id="content_layout">
                            <div class="space-y-5">
                                <div class="grid grid-cols-12 gap-5">
                                    @if ($tipo_luminaria->potenciaPromedio->count() > 0)
                                        <div class="xl:col-span-12 col-span-12 lg:col-span-12">
                                            <table class="display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr class="td-table">
                                                        <td>Id</td>
                                                        <td>Potencia</td>
                                                        <td>Consumo promedio</td>
                                                        <td>opciones</td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($tipo_luminaria->potenciaPromedio as $obj)
                                                        <tr>
                                                            <td align="center">{{ $obj->id }}</td>
                                                            <td>{{ $obj->potencia }}</td>
                                                            <td>{{ $obj->consumo_promedio }} kwH</td>
                                                            <td align="center">
                                                                <iconify-icon icon="mdi:trash" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-delete-{{ $obj->id }}"
                                                                    width="40"></iconify-icon>
                                                            </td>
                                                        </tr>
                                                        @include('catalogo.tipo_luminaria.modal')
                                                    @endforeach

                                                    </thead>
                                                <tbody>

                                            </table>

                                        </div>
                                    @endif

                                </div>

                            </div>




                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
