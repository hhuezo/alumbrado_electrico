
@extends ('menu')
@section('contenido')
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])


<div class="grid grid-cols-12 gap-5 mb-5">

    <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
        <div class="card">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Crear Rol
                            <a href="{{ url('seguridad/role')}}">
                                <button class="btn btn-dark btn-sm float-right">
                                    <iconify-icon icon="icon-park-solid:back" style="color: white;" width="18">
                                    </iconify-icon>
                                </button>
                            </a>
                        </div>
                    </div>
                </header>

                <div class="space-y-4">
                    <form method="POST" action="{{ url('seguridad/role') }}">
                        @csrf
                        <div class="input-area relative pl-28">
                            <label for="largeInput" class="inline-inputLabel">Nombre</label>
                            <input type="text" name="name" id="name"  required class="form-control">
                        </div> &nbsp;

                                                    <div></div>
                            &nbsp;
                            <div style="text-align: right;">
                                <button type="submit"
                                    class="btn inline-flex justify-center btn-dark">Aceptar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<div>&nbsp;</div>
@endsection
