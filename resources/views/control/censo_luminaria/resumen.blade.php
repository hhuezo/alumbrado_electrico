@extends('menu')
@section('contenido')
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
<div class="space-y-5 profile-page">
    <div class="profiel-wrap px-[35px] pb-10 md:pt-[84px] pt-10 rounded-lg bg-white dark:bg-slate-800 lg:flex lg:space-y-0
      space-y-6 justify-between items-end relative z-[1]">
      <div class="bg-slate-900 dark:bg-slate-700 absolute left-0 top-0 md:h-1/2 h-[150px] w-full z-[-1] rounded-t-lg"></div>
      <div class="profile-box flex-none md:text-start text-center">
        <div class="md:flex items-end md:space-x-6 rtl:space-x-reverse">
          <div class="flex-none">
            <div class="md:h-[186px] md:w-[186px] h-[140px] w-[140px] md:ml-0 md:mr-0 ml-auto mr-auto md:mb-0 mb-4 rounded-full ring-4
                  ring-slate-100 relative">
              <img src="{{ asset('qr') }}/{{$censo->codigo_luminaria}}.png" alt="" class="w-full h-full object-cover rounded-full">
              <a href="profile-setting" class="absolute right-2 h-8 w-8 bg-slate-50 text-slate-600 rounded-full shadow-sm flex flex-col items-center
                      justify-center md:top-[140px] top-[100px]">

              </a>
            </div>
          </div>
          <div class="flex-1">
            <div class="text-2xl font-medium text-slate-900 dark:text-slate-200 mb-[3px]">
               {{$censo->codigo_luminaria}}
            </div>
            <div class="text-sm font-light text-slate-600 dark:text-slate-400">
                Codigo
            </div>
          </div>
        </div>
      </div>
      <!-- end profile box -->
      <div class="profile-info-500 md:flex md:text-start text-center flex-1 max-w-[516px] md:space-y-0 space-y-4">
        <div class="flex-1">
          <div class="text-base text-slate-900 dark:text-slate-300 font-medium mb-1">
            {{$censo->distrito->municipio->departamento->nombre}}
          </div>
          <div class="text-sm text-slate-600 font-light dark:text-slate-300">
            Departamento
          </div>
        </div>
        <!-- end single -->
        <div class="flex-1">
          <div class="text-base text-slate-900 dark:text-slate-300 font-medium mb-1">
            {{$censo->distrito->municipio->nombre}}
          </div>
          <div class="text-sm text-slate-600 font-light dark:text-slate-300">
            Municipio
          </div>
        </div>
        <!-- end single -->
        <div class="flex-1">
          <div class="text-base text-slate-900 dark:text-slate-300 font-medium mb-1">
            {{$censo->distrito->nombre}}
          </div>
          <div class="text-sm text-slate-600 font-light dark:text-slate-300">
           Distrito
          </div>
        </div>
        <!-- end single -->


      </div>
      <!-- profile info-500 -->

    </div>
    <br>
    <a href="{{url('control/censo_luminaria')}}">
    <button class="btn btn-dark float-right">Volver</button>
    </a>
  </div>
@endsection
