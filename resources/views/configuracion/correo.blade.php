@extends('menu')
@section('contenido')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="grid grid-cols-12 gap-5 mb-5">

        <div class="2xl:col-span-12 lg:col-span-12 col-span-12">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Configuración de correo


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
                                            <br>
                                        @endif

                                        <form method="POST" action="{{ url('configuracion/correo') }}">
                                            @csrf

                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7">
                                                <div class="input-area relative">
                                                    <input type="hidden" name="Id" value="{{$configuracion->Id}}">
                                                    <label for="Descipcion" class="form-label">Host</label>
                                                    <input type="text" name="smtp_host" value="{{ $configuracion->smtp_host }}"   class="form-control" required>
                                                </div>
                                                <div class="input-area relative">
                                                    <label for="Alcance" class="form-label">Puerto</label>
                                                    <input type="number" name="smtp_port" value="{{ $configuracion->smtp_port }}"   class="form-control" required>
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="Descipcion" class="form-label">Usuario</label>
                                                    <input type="text" name="smtp_username" value="{{ $configuracion->smtp_username }}"   class="form-control" required>
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="Descipcion" class="form-label">Password</label>
                                                    <input type="text" name="smtp_password" value="{{ $configuracion->smtp_password }}"   class="form-control" required>
                                                </div>


                                                <div class="input-area relative">
                                                    <label for="Descipcion" class="form-label">Correo destinatario</label>
                                                    <input type="text" name="from_address" value="{{ $configuracion->from_address }}"   class="form-control" required>
                                                </div>
                                                <div class="input-area relative">
                                                    <label for="Descipcion" class="form-label">Nombre destinatario</label>
                                                    <input type="text" name="smtp_from_name" value="{{ $configuracion->smtp_from_name }}"   class="form-control">
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="Descipcion" class="form-label">Cifrado</label>
                                                    <select name="smtp_encryption" class="form-control">
                                                        <option value="SSL" {{$configuracion->smtp_encryption == 'SSL' ? 'selected':''}}>SSL</option>
                                                        <option value="TLS" {{$configuracion->smtp_encryption == 'TLS' ? 'selected':''}}>TLS</option>
                                                        <option value="PGP" {{$configuracion->smtp_encryption == 'PGP' ? 'selected':''}}>PGP</option>
                                                        <option value="PGP" {{$configuracion->smtp_encryption == 'NONE' ? 'selected':''}}>NONE</option>
                                                    </select>
                                                </div>

                                                <div class="input-area relative">
                                                    <label for="Descipcion" class="form-label">Key google maps</label>
                                                    <input type="text" name="api_key_maps" value="{{ $configuracion_key->api_key_maps }}"   class="form-control" required>
                                                </div>
                                            </div>
                                            <br>
                                            <div style="text-align: right;">
                                                <button type="submit"
                                                    class="btn inline-flex justify-center btn-dark">Guardar</button>
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


@endsection
