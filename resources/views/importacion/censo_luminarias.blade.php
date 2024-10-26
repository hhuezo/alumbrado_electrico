@extends ('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Importacion de Censo Luminarias

                                <a href="{{ url('dowload_censo') }}" target="_blank">
                                    <button class="btn btn-dark btn-sm float-right">
                                        <iconify-icon icon="line-md:download-loop" style="color: white;" width="18"> </iconify-icon> Descarga base excel

                                    </button>
                                </a>
                            </div>
                        </div>
                    </header>



                    <div class="transition-all duration-150 container-fluid" id="page_layout">
                        <div id="content_layout">
                            <div class="space-y-5">
                                <div class="grid grid-cols-12 gap-5">

                                    <div class="xl:col-span-8 col-span-12 lg:col-span-8">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ url('importar_censo_luminaria') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card h-full">
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Distrito</label>
                                                        <select name="distrito_id" class="form-control" required>
                                                            @foreach ($distritos as $obj)
                                                                <option value="{{ $obj->id }}">{{ $obj->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="grid pt-4 pb-3 px-4">
                                                    <div class="input-area relative">
                                                        <label for="largeInput" class="form-label">Archivo</label>
                                                        <input type="file" name="archivo" value="{{ old('archivo') }}"
                                                            required class="form-control">
                                                    </div>
                                                </div>
                                                <div style="text-align: right;">
                                                    <button type="submit" style="margin-right: 18px"
                                                        class="btn btn-dark">Aceptar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="xl:col-span-4 col-span-12 lg:col-span-4 ">

                                        <li style="color: #ec0a11;">En el archivo en la pestaña 2 se encuentran los catálogos con los cuales tendra que completar las columnas del censo</li>
                                        <li style="color: #ec0a11;">El formato de la fecha debe ser dd/mm/yyyy</li>
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
