@extends('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Reporte de falla

                                <a href="{{ url('catalogo/reporte_falla') }}">
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
                                        <form method="POST"
                                            action="{{ route('reporte_falla.update', $reporte_falla->id) }}"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf

                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Latitud</label>
                                                    <input type="text" id="latitud" name="latitud" value="{{$reporte_falla->latitud}}" class="form-control">
                                                </div>
                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Longitud</label>
                                                    <input type="text" id="longitud" name="longitud" value="{{$reporte_falla->longitud}}"  class="form-control">
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Fecha</label>
                                                    <input type="date" name="fecha" value="{{$reporte_falla->fecha}}"
                                                        required class="form-control">
                                                </div>

                                                <div class="input-area">
                                                    <label for="largeInput" class="form-label">Departamento</label>
                                                    <select class="form-control" id="departamento" name="departamento_id">
                                                        <option value="">Seleccione</option>
                                                        @foreach ($departamentos as $obj)
                                                            <option value="{{ $obj->id }}"
                                                                {{ $reporte_falla->distrito->departamento_id == $obj->id ? 'selected' : '' }}>
                                                                {{ $obj->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="input-area">
                                                    <label for="largeInput" class="form-label">Distrito</label>
                                                    <select class="form-control" required  name="distrito_id" id="distrito">
                                                        @foreach ($distritos as $obj)
                                                        <option value="{{ $obj->id }}"
                                                            {{ $reporte_falla->distrito_id == $obj->id ? 'selected' : '' }}>
                                                            {{ $obj->nombre }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Tipo falla</label>
                                                    <select name="tipo_falla_id" class="form-control" required>
                                                        @foreach ($tipos as $obj)
                                                            <option value="{{ $obj->id }}"  {{ $reporte_falla->tipo_falla_id == $obj->id ? 'selected' : '' }} >{{ $obj->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Descripción</label>
                                                    <input type="text" name="descripcion" value="{{$reporte_falla->descripcion}}"  required class="form-control">
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Nombre</label>
                                                    <input type="text" name="nombre_contacto" value="{{$reporte_falla->nombre_contacto}}"  required class="form-control">
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Telefono</label>
                                                    <input type="text" name="telefono_contacto"  value="{{$reporte_falla->telefono_contacto}}" data-inputmask="'mask': ['9999-9999']" class="form-control">
                                                </div>

                                                <div class="input-area">
                                                    <label for="Archivo" class="form-label">Fotografia</label>
                                                    <div class="relative">
                                                        <input type="file" name="Archivo" class="form-control">
                                                        @if ($reporte_falla->url_foto)
                                                            <a href="{{ asset('docs') }}/{{ $reporte_falla->url_foto }}"
                                                                target="_blank">
                                                                <button type="button"
                                                                    class="absolute right-0 top-1/2 -translate-y-1/2 w-9 h-full border-l border-l-slate-200 dark:border-l-slate-700 flex items-center justify-center">
                                                                    <iconify-icon icon="heroicons-solid:eye"></iconify-icon>
                                                                </button>
                                                            </a>
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="largeInput" class="form-label">Estado</label>
                                                    <select name="estado_reporte_id" class="form-control" required>
                                                        @foreach ($estados_reporte as $obj)
                                                            <option value="{{ $obj->id }}"  {{ $reporte_falla->estado_reporte_id == $obj->id ? 'selected' : '' }} >{{ $obj->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                            </div>
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

   <!-- scripts -->
   <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

   <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js'></script>
   <script>
       $(document).ready(function() {
           $(":input").inputmask();
       });
   </script>
@endsection
