@extends ('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Nuevo censo

                                <a href="{{ url('control/censo_luminaria/') }}">
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
                    <form method="POST" action="{{ url('control/censo_luminaria') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Departamento</label>
                                <select class="form-control" id="departamento">
                                    <option value="">Seleccione</option>
                                    @foreach ($departamentos as $obj)
                                        <option value="{{ $obj->id }}">{{ $obj->nombre }}</option>
                                    @endforeach
                                </select>
                              </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Municipio</label>
                                <select class="form-control" id="municipio">
                                </select>
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Distrito</label>
                                <select class="form-control" name="distrito_id" id="distrito">
                                </select>
                            </div>
                            <div class="input-area">
                                <label for="largeInput" class="form-label">Codigo luminaria</label>
                                <input type="text"  name="codigo_luminaria" value="{{ old('codigo_luminaria') }}" required
                                    class="form-control">

                            </div>
                            <div class="input-area">

                                <label for="largeInput" class="form-label">Tipo luminaria</label>
                                <select class="form-control" id="departamento">
                                    @foreach ($tipos as $obj)
                                        <option value="{{ $obj->id }}">{{ $obj->nombre }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="input-area">
                                <label for="largeInput" class="form-label">Potencia nominal</label>
                                <input type="number" step="0.001" name="potencia_nominal" value="{{ old('potencia_nominal') }}" required
                                    class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Consumo mensual</label>
                                <input type="number" step="0.001" name="consumo_mensual" value="{{ old('consumo_mensual') }}" required
                                    class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Decidad luminicia</label>
                                <input type="number" step="0.001" name="decidad_luminicia" value="{{ old('decidad_luminicia') }}" required
                                    class="form-control">
                            </div>

                            <div class="input-area">
                                <label for="largeInput" class="form-label">Fecha ultimo censo</label>
                                <input type="date" name="fecha_ultimo_censo" value="{{ old('fecha_ultimo_censo') }}" required
                                    class="form-control">
                            </div>

                        </div>
                        <div style="text-align: right;">
                            <button type="submit" style="margin-right: 18px" class="btn btn-dark">Aceptar</button>
                        </div>
                    </form>


                </div>






            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#departamento").change(function() {
                // var para la Departamento
                const Departamento = $(this).val();

                //funcionpara las municipios
                $.get("{{ url('censo_luminaria/get_municipios') }}" + '/' + Departamento, function(data) {
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    console.log(data);
                    var _select = '<option value="">Seleccione</option>'
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '">' + data[i].nombre +
                        '</option>';
                    $("#municipio").html(_select);

                });
            });

             //combo para municipios
             $("#municipio").change(function() {
                var Municipio = $(this).val();
                $.get("{{ url('censo_luminaria/get_distritos') }}" + '/' + Municipio, function(data) {
                    //console.log(data);
                    var _select = ''
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                        '</option>';

                    $("#distrito").html(_select);
                });
            });
        });
        </script>

@endsection
