@extends ('menu')
@section('contenido')
    <div class="content-wrapper transition-all duration-150" id="content_wrapper">
        <div class="page-content">
            <div class="transition-all duration-150 container-fluid" id="page_layout">
                <div id="content_layout">

                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6 card-header">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Biblioteca
                            </div>
                        </div>
                    </header>

                    <!-- END: BreadCrumb -->
                    <div class=" space-y-5">
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">

                            @foreach ($biblioteca as $obj)
                                <div class="card" style="background-color: #c9c9cb;">
                                    <div class="card-body p-6">
                                        <div class="space-y-6">
                                            <div class="flex space-x-3 items-center rtl:space-x-reverse">
                                                <div
                                                    class="flex-none h-8 w-8 rounded-full bg-slate-800 dark:bg-slate-700 text-slate-300 flex flex-col items-center justify-center text-lg">
                                                    <iconify-icon icon="heroicons:building-office-2"></iconify-icon>
                                                </div>
                                                <div class="flex-1 text-base text-slate-900 dark:text-white font-medium">
                                                    {{$obj->titulo}}
                                                </div>
                                            </div>
                                            <div class="text-slate-600 dark:text-slate-300 text-sm">
                                                {{$obj->descripcion}}
                                            </div>
                                            <a target="_blank" href="{{ asset('docs') }}/{{$obj->archivo}}"
                                                class="inline-flex items-center space-x-3 rtl:space-x-reverse text-sm capitalize font-medium text-slate-600 dark:text-slate-300">
                                                <span>Descargar</span>
                                                <iconify-icon icon="heroicons:arrow-right"></iconify-icon>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
