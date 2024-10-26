@extends('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
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
                                    <div class="xl:col-span-3 col-span-12 lg:col-span-2 ">
                                        <div class="card p-6 h-full">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="xl:col-span-6 col-span-12 lg:col-span-8">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ route('biblioteca.update', $biblioteca->id) }}"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf

                                            <div class="card h-full">
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Tipo documento</label>
                                                        <select name="tipo_documento_id" class="form-control" required>
                                                            @foreach ($tipos_documento as $obj)
                                                                <option value="{{ $obj->id }}"
                                                                    {{ $biblioteca->tipo_documento_id == $obj->id ? 'selected' : '' }}>
                                                                    {{ $obj->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Titulo</label>
                                                        <input type="text" name="titulo"
                                                            value="{{ $biblioteca->titulo }}" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Descripción</label>
                                                        <input type="text" name="descripcion"
                                                            value="{{ $biblioteca->descripcion }}" required
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Descargable</label>
                                                        <label class="switch">
                                                            <input type="checkbox" name="descargable" value="1"
                                                                {{ $biblioteca->descargable == '1' ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="input-area">
                                                    <label for="Archivo" class="form-label">Archivo</label>
                                                    <div class="relative">
                                                        <input type="file" name="archivo" class="form-control">
                                                        @if ($biblioteca->archivo)
                                                            <a href="{{ asset('docs') }}/{{ $biblioteca->archivo }}"
                                                                target="_blank">
                                                                <button type="button"
                                                                    class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-full border-l border-l-slate-200 dark:border-l-slate-700 flex items-center justify-center">
                                                                    <iconify-icon icon="heroicons-solid:eye"></iconify-icon>
                                                                </button>
                                                            </a>
                                                        @endif

                                                    </div>
                                                </div>
                                                <br>
                                                <div style="text-align: right;">
                                                    <button type="submit" style="margin-right: 18px"
                                                        class="btn btn-dark">Aceptar</button>
                                                </div>

                                                <div align="center">
                                                    <img src="" alt="Preview" id="imagePreview"
                                                        style="display:none; max-width: 200px; max-height: 200px;">
                                                </div>
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


@endsection
