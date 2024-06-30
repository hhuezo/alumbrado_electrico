<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>Dashcode - HTML Template</title>
    <link rel="icon" type="image/png" href="assets/images/logo/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/rt-plugins.css') }}">
    <link href="https://unpkg.com/aos@2.3.0/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <!-- START : Theme Config js-->
    <script src="{{ asset('assets/js/settings.js') }}" sync></script>
    <!-- END : Theme Config js-->
</head>

<body class=" font-inter skin-default">
    <!-- END : Theme Config js-->
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="loginwrapper bg-cover bg-no-repeat bg-center"
        style="background-image: url({{ asset('img/image.jpg') }}">
        {{-- style="background-image: url(img/familia_dashboard.jpg);" --}}
        <div class="lg-inner-column">
            <div class="left-columns lg:w-1/2 lg:block hidden">
                <div class="logo-box-3">
                    <a heref="index.html" class="">
                        {{-- <img src="assets/images/logo/logo-white.svg" alt=""> --}}
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2 w-full flex flex-col items-center justify-center">
                <div class="auth-box-3">
                    <div class="mobile-logo text-center mb-6 lg:hidden block">
                        <a heref="index.html">
                            <img src="assets/images/logo/logo.svg" alt="" class="mb-10 dark_logo">
                            <img src="assets/images/logo/logo-white.svg" alt="" class="mb-10 white_logo">
                        </a>
                    </div>
                    <div class="text-center 2xl:mb-10 mb-5">
                        <h4 class="font-medium">Verificación</h4>

                        <div class="text-slate-500 dark:text-slate-400 text-base">
                            Se ha enviado un pin a su correo
                            <br>
                            duración de 3 minutos
                        </div>
                    </div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- BEGIN: Login Form -->
                    <form class="d-inline" method="POST" action="{{ url('verificacion_dos_pasos') }}">
                        @csrf
                        <input type="hidden" value="{{ $user->id }}" name="id">
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Pin</label>

                            <div class="col-md-6">
                                <input id="pin" type="number"
                                    class="form-control @error('password') is-invalid @enderror" name="pin"
                                    required>

                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-between">
                            <a href="{{ url('/login') }}">
                                <button type="button" class="btn btn-secondary p-0 m-0 align-baseline">Volver</button>
                            </a>
                            <button type="submit" class="btn btn-dark p-0 m-0 float-right">Verificación</button>
                        </div>


                    </form>
                    <!-- END: Login Form -->



                </div>
            </div>
        </div>
        {{-- <div class="auth-footer3 text-white py-5 px-5 text-xl w-full">
            Unlock your Project performance
        </div> --}}
    </div>
    </div>
    <!-- Core Js -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/rt-plugins.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
