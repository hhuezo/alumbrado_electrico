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

                                        <form method="POST"
                                            action="{{ route('tipo_luminaria.update', $tipo_luminaria->id) }}"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf

                                            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-7">

                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Nombre</label>
                                                        <input type="text" name="nombre" value="{{ $tipo_luminaria->nombre }}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Ícono</label>
                                                        <input type="file" name="icono"  class="form-control">
                                                    </div>
                                                </div>

                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        @if ($tipo_luminaria->icono)
                                                            <img src="{{ asset('img/') }}/{{ $tipo_luminaria->icono }}" style="max-width: 100px"  id="icono">
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
    </div>


@endsection
