@extends ('menu')
@section('contenido')
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="grid grid-cols-12 gap-5 mb-5">

    <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
        <div class="card">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Usuario
                            <a href="{{ url('seguridad/user') }}">
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
                <div class="space-y-4">
                    <form method="POST" action="{{ route('user.update', $usuarios->id) }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="input-area relative pl-28">
                            <label for="largeInput" class="inline-inputLabel">Nombre</label>
                            <input type="text" name="name" value="{{ $usuarios->name }}" required
                                class="form-control">
                        </div> &nbsp;
                        <div class="input-area relative pl-28">
                            <label for="largeInput" class="inline-inputLabel">Email</label>
                            <input type="email" name="email" value="{{ $usuarios->email }}" required
                                class="form-control">
                        </div> &nbsp;

                        <div class="input-area relative pl-28">
                            <label for="largeInput" class="inline-inputLabel">Contraseña</label>
                            <input type="password" name="password" class="form-control">
                        </div> &nbsp;



                        &nbsp;
                        <div
                            class=" items-center p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                            <button style="margin-bottom: 15px"
                                class="btn inline-flex justify-center btn-dark ml-28 float-right">Aceptar</button>
                        </div>
                    </form>
                </div>
                <div>

                </div>

            </div>
        </div>


    </div>


</div>





<div class="grid grid-cols-12 gap-5 mb-5">
    <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
        <div class="card">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Administración</div>
                    </div>
                </header>
                <div class="card-text h-full ">
                    <div class="active">
                        <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4 menu-open"
                            id="tabs-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-home"
                                    class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent active dark:text-slate-300"
                                    id="tabs-home-tab" data-bs-toggle="pill" data-bs-target="#tabs-home" role="tab"
                                    aria-controls="tabs-home" aria-selected="true">Distritos</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-profile"
                                    class="nav-link w-full block font-medium text-sm font-Inter leading-tight capitalize border-x-0 border-t-0 border-b border-transparent px-4 pb-2 my-2 hover:border-transparent focus:border-transparent dark:text-slate-300"
                                    id="tabs-profile-tab" data-bs-toggle="pill" data-bs-target="#tabs-profile"
                                    role="tab" aria-controls="tabs-profile" aria-selected="false">Roles</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="tabs-tabContent">
                            <div class="tab-pane fade show active" id="tabs-home" role="tabpanel"
                                aria-labelledby="tabs-home-tab">

                                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                                    <div class="flex-1">
                                        <div class="card-title text-slate-900 dark:text-white">
                                            <form method="POST" action="{{ url('seguridad/user/attach_distrito') }}">
                                                <input type="hidden" name='usuario_id' value="{{ $usuarios->id }}">
                                                @csrf
                                                <div class="p-6 space-y-4">
                                                    <div class="grid xl:grid-cols-3 md:grid-cols-1 grid-cols-3 gap-5">
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
                                                </div>

                                                <button class="btn inline-flex justify-center btn-outline-dark float-right">Agregar
                                                    distrito
                                                </button>
                                            </form>
                                        </div>
                                    </div>


                                </header>

                                @if ($usuarios->distritos->count() > 0)
                                <div style="width: 98%;margin-left:1%;">
                                    <div class="overflow-x-auto -mx-6 dashcode-data-table">

                                        <div class="inline-block min-w-full align-middle">
                                            <div class="overflow-hidden ">
                                                <table
                                                    class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                                    <thead class=" bg-slate-200 dark:bg-slate-700">
                                                        <tr>
                                                            <th scope="col" class=" table-th ">Id</th>
                                                            <th scope="col" class=" table-th ">Distrito</th>
                                                            <th scope="col" class=" table-th ">opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody
                                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                                        @foreach ($usuarios->distritos as $obj)
                                                        <tr>
                                                            <td class="table-td ">{{ $obj->id }}</td>
                                                            <td class="table-td ">{{ $obj->nombre }}</td>
                                                            <td class="table-td ">
                                                                <button>
                                                                    <iconify-icon icon="mdi:delete-circle"
                                                                        class="danger" width="40"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal-delete-{{ $obj->id }}" style="color:#dc3545;"></iconify-icon></button>

                                                            </td>
                                                        </tr>
                                                        @include('seguridad.user.modal_distrito')
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endif
                                
                            </div>
                            <div class="tab-pane fade" id="tabs-profile" role="tabpanel"
                                aria-labelledby="tabs-profile-tab">




                                @include('seguridad.user.agrega_roles')
                                <br><br>
                                <div class="grid xl:grid-cols-4 md:grid-cols-1 grid-cols-4 gap-5">
                                    @foreach($roles_all as $obj)
                                    <div style="border: 1px lightblue solid; padding: 1.5rem 1rem; border-radius: 2px;">
                                        <div class="card-body text-slate-900 dark:text-white" style="font-size: 1rem;">
                                            {{ $obj->name }}

                                            @php
                                            $isChecked = $obj->user_has_role->isNotEmpty()
                                            && $usuarios->user_rol->isNotEmpty()
                                            && $obj->user_has_role->first()->id == $usuarios->user_rol->first()->id;
                                            @endphp

                                            <label class="float-right relative inline-flex h-6 w-[46px] items-center rounded-full transition-all duration-150 cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" id="asignar_rol-{{$obj->id}}"
                                                    {{ $isChecked ? 'checked' : '' }} onchange="attach_rol({{ $obj->id }})">
                                                <div class="w-14 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer dark:bg-gray-900 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:z-10 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-success-500"></div>
                                            </label>
                                            <br>

                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div>&nbsp;</div>

<script>
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


    function attach_rol(roleId) {
        //alert('holi');
        // Obtener el estado actual del checkbox
        const checkbox = document.getElementById(`asignar_rol-${roleId}`);
        const isChecked = checkbox.checked;
        const userId = {{$usuarios->id}};

        fetch("{{url('seguridad/user/attach_roles')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    model_id: userId,
                    rol_id: roleId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    // Si hay un error, revertir el estado del checkbox
                    checkbox.checked = !isChecked;
                    alert(data.message || 'An error occurred while updating the role.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // En caso de error, revertir el estado del checkbox
                checkbox.checked = !isChecked;
                alert('An error occurred. Please try again later.');
            });
    }
</script>
@endsection