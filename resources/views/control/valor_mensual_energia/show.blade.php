@extends('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Censo

                                <a href="{{ url('catalogo/lugar_formacion') }}">
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
                    <form method="POST" action="{{ route('censo_luminaria.update', $censo->id) }}">
                        @method('PUT')
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Departamento</label>
                                <select class="form-control" id="departamento">
                                    @foreach ($departamentos as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->distrito->municipio->departamento_id == $obj->id ? 'selected' : '' }}>
                                            {{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Municipio</label>
                                <select class="form-control" id="departamento">
                                    @foreach ($municipios as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->distrito->municipio_id == $obj->id ? 'selected' : '' }}>
                                            {{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Distrito</label>
                                <select class="form-control" name="distrito_id" id="distrito">
                                    @foreach ($distritos as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->distrito_id == $obj->id ? 'selected' : '' }}>{{ $obj->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-area">
                                <label for="largeInput" class="form-label">Codigo luminaria</label>
                                <input type="text" name="codigo_luminaria" value="{{ $censo->codigo_luminaria }}"
                                    required class="form-control">

                            </div>
                            <div class="input-area">
                                <label for="largeInput" class="form-label">Tipo luminaria</label>
                                <select class="form-control" name="tipo_luminaria_id" id="tipo_luminaria">
                                    @foreach ($tipos as $obj)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->tipo_luminaria_id == $obj->id ? 'selected' : '' }}>
                                            {{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Potencia promedio</label>
                                <select class="form-control" id="potencia_promedio">
                                    @if ($potencias_promedio->count() > 0)
                                        <option value="{{ $obj->id }}"
                                            {{ $censo->tipo_luminaria_id == $obj->id ? 'selected' : '' }}>{{ $obj->nombre }}</option>
                                    @else
                                        <option value="">No aplica</option>
                                    @endif

                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Potencia nominal</label>
                                <input type="number" step="0.001" name="potencia_nominal" id="potencia_nominal"
                                    value="{{ old('potencia_nominal') }}" required class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Consumo mensual</label>
                                <input type="number" step="0.001" readonly name="consumo_mensual" id="consumo_mensual"
                                    value="{{ old('consumo_mensual') }}" required class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Decidad luminicia</label>
                                <input type="number" step="0.001" name="decidad_luminicia"
                                    value="{{ old('decidad_luminicia') }}" required class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Fecha ultimo censo</label>
                                <input type="date" name="fecha_ultimo_censo" value="{{ old('fecha_ultimo_censo') }}"
                                    required class="form-control">
                            </div>

                        </div>
                    </form>


                </div>

            </div>




        </div>
    </div>

@endsection
