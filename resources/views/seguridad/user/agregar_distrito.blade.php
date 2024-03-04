<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    aria-hidden="true" role="dialog" tabindex="-1" id="modal-add-distrito">
    <form method="POST" action="{{ url('seguridad/user/attach_distrito') }}">
        <input type="hidden" name='usuario_id' value="{{ $usuarios->id }}">
        @csrf
        <div class="modal-dialog relative w-auto pointer-events-none">
            <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding
                       rounded-md outline-none text-current">
                <div class="relative bg-white rounded-lg shadow black:bg-slate-700">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-5 border-b rounded-t black:border-slate-600 bg-black-500">
                        <h3 class="text-base font-medium text-white black:text-white">
                            Agregar distrito
                        </h3>
                        <button type="button"
                            class="text-slate-400 bg-transparent hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center black:hover:bg-slate-600 black:hover:text-white"
                            data-bs-dismiss="modal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="#ffffff" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10
                                           11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-4">

                        <div class="input-area relative">
                            <label for="largeInput" class="form-label">Departamento</label>
                            <select id="departamento" class="form-control select">
                                <option value="">SELECCIONE</option>
                                @foreach ($departamentos as $obj)
                                    <option value="{{ $obj->id }}">{{ $obj->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-area relative">
                            <label for="largeInput" class="form-label">Municipio</label>
                            <select id="municipio" class="form-control select">
                                <option value="">SELECCIONE</option>

                            </select>
                        </div>


                        <div class="input-area relative">
                            <label for="largeInput" class="form-label">Distrito</label>
                            <select id="distrito" name="distrito_id" class="form-control select" required>
                                <option value="">SELECCIONE</option>

                            </select>
                        </div>


                    </div>
                    <!-- Modal footer -->
                    <div class=" items-center p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                        <button type="submit"
                            class="btn inline-flex justify-center text-white bg-black-500 float-right"
                            style="margin-bottom: 15px">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script type="text/javascript">
        $(document).ready(function() {

            $("#departamento").change(function() {
                // var para la Departamento
                const Departamento = $(this).val();


                $.get("{{ url('censo_luminaria/get_municipios') }}" + '/' + Departamento, function(data) {
                    console.log(data);
                    var _select = '<option value="">SELECCIONE</option>'
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '">' + data[i].nombre +
                        '</option>';
                    $("#municipio").html(_select);

                });
            });


            $("#municipio").change(function() {
                var Municipio = $(this).val();
                $.get("{{ url('censo_luminaria/get_distritos') }}" + '/' + Municipio, function(data) {
                    var _select = ''
                    for (var i = 0; i < data.length; i++)
                        _select += '<option value="' + data[i].id + '"  >' + data[i].nombre +
                        '</option>';

                    $("#distrito").html(_select);
                });
            });


        });
    </script>

</div>
