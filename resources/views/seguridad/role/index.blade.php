@extends ('menu')
@section('contenido')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])


    <div class=" space-y-5">
        <div class="card">
            <header class=" card-header noborder">
                <h4 class="card-title">Listado de roles
                </h4>
                <a href="{{ url('seguridad/role/create') }}">
                    <button class="btn btn-outline-dark">Nuevo</button>
                </a>
            </header>
            <div style="width: 98%;margin-left:1%;">

                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6 dashcode-data-table">
                        <span class=" col-span-8  hidden"></span>
                        <span class="  col-span-4 hidden"></span>
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table
                                    class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                    <thead class=" bg-slate-200 dark:bg-slate-700">
                                        <tr>

                                            <th scope="col" class=" table-th ">Id</th>
                                            <th scope="col" class=" table-th ">Descripción</th>
                                            <th scope="col" class=" table-th ">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                        @if ($roles->count() > 0)
                                            @foreach ($roles as $obj)
                                                <tr>
                                                    <td class="table-td ">{{ $obj->id }}</td>
                                                    <td class="table-td ">{{ $obj->name }}</td>
                                                    <td class="table-td ">

                                                        <a href="{{ url('seguridad/role') }}/{{ $obj->id }}/edit">
                                                            <iconify-icon icon="mdi:pencil-circle" class="success"
                                                                width="40"></iconify-icon>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
                id="usuario_create_modal" tabindex="-1" aria-labelledby="usuario_create_modal" aria-hidden="true">
                <div class="modal-dialog relative w-auto pointer-events-none">
                    <div
                        class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding
                rounded-md outline-none text-current">
                        <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                            <!-- Modal header -->
                            <form action="{{ url('seguridad/role') }}" method="POST" class="forms-sample">
                                @csrf
                                <div
                                    class="flex items-center justify-between p-5 border-b rounded-t dark:border-slate-600 bg-black-500">
                                    <h3 class="text-xl font-medium text-white dark:text-white capitalize">
                                        Nuevo permiso
                                    </h3>
                                    <button type="button"
                                        class="text-slate-400 bg-transparent hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center
                            dark:hover:bg-slate-600 dark:hover:text-white"
                                        data-bs-dismiss="modal">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="#ffffff" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10
                                        11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Nuevo permiso</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-4">
                                    <div class="input-area">
                                        <label for="name" class="form-label">Permiso</label>
                                        <input type="text" class="form-control" required name="name">
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div
                                    class="flex items-center justify-end p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                                    <button type="submit"
                                        class="btn inline-flex justify-center text-white bg-black-500">Aceptar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
