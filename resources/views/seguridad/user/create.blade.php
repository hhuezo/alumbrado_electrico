
@extends ('menu')
@section('contenido')
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])


<div class="grid grid-cols-12 gap-5 mb-5">

    <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
        <div class="card">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Nuevo usuario
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
                    <form method="POST" action="{{ url('seguridad/user') }}"
                        enctype="multipart/form-data">

                        @csrf
                        <div class="input-area relative pl-28">
                            <label for="largeInput" class="inline-inputLabel">Nombre</label>
                            <input type="text" name="name" id="name" required class="form-control">
                        </div> &nbsp;
                        <div class="input-area relative pl-28">
                            <label for="largeInput" class="inline-inputLabel">Email</label>
                            <input type="email" name="email" id="email" required class="form-control">
                        </div> &nbsp;

                        <div class="input-area relative pl-28">
                            <label for="largeInput" class="inline-inputLabel">Contraseña</label>
                            <input type="text" name="password" id="password"   required class="form-control">
                        </div> &nbsp;


                            <div></div>
                            &nbsp;
                            <div class=" items-center p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                                <button style="margin-bottom: 15px" class="btn inline-flex justify-center btn-dark ml-28 float-right">Aceptar</button>
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
