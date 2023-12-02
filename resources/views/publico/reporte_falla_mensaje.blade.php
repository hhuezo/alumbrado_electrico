<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>Urban Strategies</title>
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
    <script src="assets/js/settings.js" sync></script>
    <!-- END : Theme Config js-->
    <meta http-equiv="refresh" content="10;URL={{url('/')}}" />
</head>

<body class=" font-inter skin-default">
    <div class="min-h-screen flex flex-col justify-center items-center text-center py-20">
        <img src="{{ asset('assets/images/svg') }}/img-2.svg" style="max-width: 600px" alt="">
        <div class="max-w-[546px] mx-auto w-full mt-12">
            <h4 class="text-slate-900 mb-4" style="text-transform: none;">Su informe ha sido enviado. </h4>
            <div class="text-slate-600 dark:text-slate-300 text-base font-normal mb-10">
                {{-- Su iglesia aun no esta, preparada para unirse al programa. --}}
            </div>
        </div>
        <div class="max-w-[300px] mx-auto w-full">
            <a href="{{ url('/') }}" class="btn btn-dark dark:bg-slate-800 block text-center"
                style="text-transform: none;">
               Volver
            </a>
        </div>
    </div>
    <!-- scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/rt-plugins.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
