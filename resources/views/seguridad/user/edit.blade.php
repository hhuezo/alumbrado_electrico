@extends ('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])


    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
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
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
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

                                    <header
                                        class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                        <div class="flex-1">
                                            <div class="card-title text-slate-900 dark:text-white">
                                                <button class="btn inline-flex justify-center btn-outline-dark float-right"
                                                    data-bs-toggle="modal" data-bs-target="#modal-add-distrito">Agregar
                                                    distrito
                                                </button>
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
                                                                                data-bs-target="#modal-delete-{{ $obj->id }}"></iconify-icon></button>

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
                                    @include('seguridad.user.agregar_distrito')
                                </div>
                                <div class="tab-pane fade" id="tabs-profile" role="tabpanel"
                                    aria-labelledby="tabs-profile-tab">
                                    <header
                                        class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                        <div class="flex-1">
                                            <div class="card-title text-slate-900 dark:text-white">
                                                <button class="btn inline-flex justify-center btn-outline-dark float-right"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-add-{{ $usuarios->id }}">Agregar rol
                                            </div>
                                        </div>
                                    </header>

                                    @if ($roles->count() > 0)
                                        <table
                                            class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                            <thead class=" bg-slate-200 dark:bg-slate-700">
                                                <tr>
                                                    <th scope="col" class=" table-th ">Id</th>
                                                    <th scope="col" class=" table-th ">Rol</th>
                                                    <th scope="col" class=" table-th ">opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                                @foreach ($roles as $obj)
                                                    <tr>
                                                        <td class="table-td ">{{ $obj->id }}</td>
                                                        <td class="table-td ">{{ $obj->name }}</td>
                                                        <td class="table-td ">
                                                            <iconify-icon icon="mdi:delete-circle" class="danger"
                                                                width="40" data-bs-toggle="modal"
                                                                data-bs-target="#modal-delete-{{ $obj->id }}"></iconify-icon>

                                                        </td>
                                                    </tr>
                                                    @include('seguridad.user.modal')
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    @include('seguridad.user.agrega_roles')
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div>&nbsp;</div>
@endsection
