@extends('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Distrito

                                <a href="{{ url('catalogo/distrito') }}">
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

                                        <form method="POST" action="{{ route('distrito.update', $distrito->id) }}"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf

                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">

                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Codigo</label>
                                                        <input type="text" value="{{ $distrito->codigo }}" readonly
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Distrito</label>
                                                        <input type="text" value="{{ $distrito->nombre }}" readonly
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Municipio</label>
                                                        <input type="text" value="{{ $distrito->municipio->nombre }}"
                                                            class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Departamento</label>
                                                        <input type="text"
                                                            value="{{ $distrito->municipio->departamento->nombre }}"
                                                            class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area">
                                                        <label for="largeInput" class="form-label">Extension
                                                            territorial</label>
                                                        <div class="relative">
                                                            <input type="number" name="extension_territorial"
                                                                step="0.01"
                                                                value="{{ $distrito->extension_territorial }}"
                                                                class="form-control !pl-12">
                                                            <span
                                                                class="absolute left-0 top-1/2 -translate-y-1/2 w-9 h-full border-r border-r-slate-200 dark:border-r-slate-700 flex items-center justify-center">
                                                                km2
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Población</label>
                                                        <input type="number" name="poblacion" step="1"
                                                            value="{{ $distrito->poblacion }}" class="form-control">
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
