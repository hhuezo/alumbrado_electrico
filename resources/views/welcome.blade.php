{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <svg viewBox="0 0 651 192" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto text-gray-700 sm:h-20">
                        <g clip-path="url(#clip0)" fill="#EF3B2D">
                            <path d="M248.032 44.676h-16.466v100.23h47.394v-14.748h-30.928V44.676zM337.091 87.202c-2.101-3.341-5.083-5.965-8.949-7.875-3.865-1.909-7.756-2.864-11.669-2.864-5.062 0-9.69.931-13.89 2.792-4.201 1.861-7.804 4.417-10.811 7.661-3.007 3.246-5.347 6.993-7.016 11.239-1.672 4.249-2.506 8.713-2.506 13.389 0 4.774.834 9.26 2.506 13.459 1.669 4.202 4.009 7.925 7.016 11.169 3.007 3.246 6.609 5.799 10.811 7.66 4.199 1.861 8.828 2.792 13.89 2.792 3.913 0 7.804-.955 11.669-2.863 3.866-1.908 6.849-4.533 8.949-7.875v9.021h15.607V78.182h-15.607v9.02zm-1.431 32.503c-.955 2.578-2.291 4.821-4.009 6.73-1.719 1.91-3.795 3.437-6.229 4.582-2.435 1.146-5.133 1.718-8.091 1.718-2.96 0-5.633-.572-8.019-1.718-2.387-1.146-4.438-2.672-6.156-4.582-1.719-1.909-3.032-4.152-3.938-6.73-.909-2.577-1.36-5.298-1.36-8.161 0-2.864.451-5.585 1.36-8.162.905-2.577 2.219-4.819 3.938-6.729 1.718-1.908 3.77-3.437 6.156-4.582 2.386-1.146 5.059-1.718 8.019-1.718 2.958 0 5.656.572 8.091 1.718 2.434 1.146 4.51 2.674 6.229 4.582 1.718 1.91 3.054 4.152 4.009 6.729.953 2.577 1.432 5.298 1.432 8.162-.001 2.863-.479 5.584-1.432 8.161zM463.954 87.202c-2.101-3.341-5.083-5.965-8.949-7.875-3.865-1.909-7.756-2.864-11.669-2.864-5.062 0-9.69.931-13.89 2.792-4.201 1.861-7.804 4.417-10.811 7.661-3.007 3.246-5.347 6.993-7.016 11.239-1.672 4.249-2.506 8.713-2.506 13.389 0 4.774.834 9.26 2.506 13.459 1.669 4.202 4.009 7.925 7.016 11.169 3.007 3.246 6.609 5.799 10.811 7.66 4.199 1.861 8.828 2.792 13.89 2.792 3.913 0 7.804-.955 11.669-2.863 3.866-1.908 6.849-4.533 8.949-7.875v9.021h15.607V78.182h-15.607v9.02zm-1.432 32.503c-.955 2.578-2.291 4.821-4.009 6.73-1.719 1.91-3.795 3.437-6.229 4.582-2.435 1.146-5.133 1.718-8.091 1.718-2.96 0-5.633-.572-8.019-1.718-2.387-1.146-4.438-2.672-6.156-4.582-1.719-1.909-3.032-4.152-3.938-6.73-.909-2.577-1.36-5.298-1.36-8.161 0-2.864.451-5.585 1.36-8.162.905-2.577 2.219-4.819 3.938-6.729 1.718-1.908 3.77-3.437 6.156-4.582 2.386-1.146 5.059-1.718 8.019-1.718 2.958 0 5.656.572 8.091 1.718 2.434 1.146 4.51 2.674 6.229 4.582 1.718 1.91 3.054 4.152 4.009 6.729.953 2.577 1.432 5.298 1.432 8.162 0 2.863-.479 5.584-1.432 8.161zM650.772 44.676h-15.606v100.23h15.606V44.676zM365.013 144.906h15.607V93.538h26.776V78.182h-42.383v66.724zM542.133 78.182l-19.616 51.096-19.616-51.096h-15.808l25.617 66.724h19.614l25.617-66.724h-15.808zM591.98 76.466c-19.112 0-34.239 15.706-34.239 35.079 0 21.416 14.641 35.079 36.239 35.079 12.088 0 19.806-4.622 29.234-14.688l-10.544-8.158c-.006.008-7.958 10.449-19.832 10.449-13.802 0-19.612-11.127-19.612-16.884h51.777c2.72-22.043-11.772-40.877-33.023-40.877zm-18.713 29.28c.12-1.284 1.917-16.884 18.589-16.884 16.671 0 18.697 15.598 18.813 16.884h-37.402zM184.068 43.892c-.024-.088-.073-.165-.104-.25-.058-.157-.108-.316-.191-.46-.056-.097-.137-.176-.203-.265-.087-.117-.161-.242-.265-.345-.085-.086-.194-.148-.29-.223-.109-.085-.206-.182-.327-.252l-.002-.001-.002-.002-35.648-20.524a2.971 2.971 0 00-2.964 0l-35.647 20.522-.002.002-.002.001c-.121.07-.219.167-.327.252-.096.075-.205.138-.29.223-.103.103-.178.228-.265.345-.066.089-.147.169-.203.265-.083.144-.133.304-.191.46-.031.085-.08.162-.104.25-.067.249-.103.51-.103.776v38.979l-29.706 17.103V24.493a3 3 0 00-.103-.776c-.024-.088-.073-.165-.104-.25-.058-.157-.108-.316-.191-.46-.056-.097-.137-.176-.203-.265-.087-.117-.161-.242-.265-.345-.085-.086-.194-.148-.29-.223-.109-.085-.206-.182-.327-.252l-.002-.001-.002-.002L40.098 1.396a2.971 2.971 0 00-2.964 0L1.487 21.919l-.002.002-.002.001c-.121.07-.219.167-.327.252-.096.075-.205.138-.29.223-.103.103-.178.228-.265.345-.066.089-.147.169-.203.265-.083.144-.133.304-.191.46-.031.085-.08.162-.104.25-.067.249-.103.51-.103.776v122.09c0 1.063.568 2.044 1.489 2.575l71.293 41.045c.156.089.324.143.49.202.078.028.15.074.23.095a2.98 2.98 0 001.524 0c.069-.018.132-.059.2-.083.176-.061.354-.119.519-.214l71.293-41.045a2.971 2.971 0 001.489-2.575v-38.979l34.158-19.666a2.971 2.971 0 001.489-2.575V44.666a3.075 3.075 0 00-.106-.774zM74.255 143.167l-29.648-16.779 31.136-17.926.001-.001 34.164-19.669 29.674 17.084-21.772 12.428-43.555 24.863zm68.329-76.259v33.841l-12.475-7.182-17.231-9.92V49.806l12.475 7.182 17.231 9.92zm2.97-39.335l29.693 17.095-29.693 17.095-29.693-17.095 29.693-17.095zM54.06 114.089l-12.475 7.182V46.733l17.231-9.92 12.475-7.182v74.537l-17.231 9.921zM38.614 7.398l29.693 17.095-29.693 17.095L8.921 24.493 38.614 7.398zM5.938 29.632l12.475 7.182 17.231 9.92v79.676l.001.005-.001.006c0 .114.032.221.045.333.017.146.021.294.059.434l.002.007c.032.117.094.222.14.334.051.124.088.255.156.371a.036.036 0 00.004.009c.061.105.149.191.222.288.081.105.149.22.244.314l.008.01c.084.083.19.142.284.215.106.083.202.178.32.247l.013.005.011.008 34.139 19.321v34.175L5.939 144.867V29.632h-.001zm136.646 115.235l-65.352 37.625V148.31l48.399-27.628 16.953-9.677v33.862zm35.646-61.22l-29.706 17.102V66.908l17.231-9.92 12.475-7.182v33.841z"/>
                        </g>
                    </svg>
                </div>

                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold"><a href="https://laravel.com/docs" class="underline text-gray-900 dark:text-white">Documentation</a></div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel, we recommend reading all of the documentation from beginning to end.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500"><path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" /></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold"><a href="https://laracasts.com" class="underline text-gray-900 dark:text-white">Laracasts</a></div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" /></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold"><a href="https://laravel-news.com/" class="underline text-gray-900 dark:text-white">Laravel News</a></div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Laravel News is a community driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500"><path stroke-linecap="round" stroke-linejoin="round" d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64" /></svg>
                                <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Vibrant Ecosystem</div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Laravel's robust library of first-party tools and libraries, such as <a href="https://forge.laravel.com" class="underline">Forge</a>, <a href="https://vapor.laravel.com" class="underline">Vapor</a>, <a href="https://nova.laravel.com" class="underline">Nova</a>, and <a href="https://envoyer.io" class="underline">Envoyer</a> help you take your projects to the next level. Pair them with powerful open source libraries like <a href="https://laravel.com/docs/billing" class="underline">Cashier</a>, <a href="https://laravel.com/docs/dusk" class="underline">Dusk</a>, <a href="https://laravel.com/docs/broadcasting" class="underline">Echo</a>, <a href="https://laravel.com/docs/horizon" class="underline">Horizon</a>, <a href="https://laravel.com/docs/sanctum" class="underline">Sanctum</a>, <a href="https://laravel.com/docs/telescope" class="underline">Telescope</a>, and more.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 sm:text-left">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-px w-5 h-5 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>

                            <a href="https://laravel.bigcartel.com" class="ml-1 underline">
                                Shop
                            </a>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-4 -mt-px w-5 h-5 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>

                            <a href="https://github.com/sponsors/taylorotwell" class="ml-1 underline">
                                Sponsor
                            </a>
                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </body>
</html> --}}


<!DOCTYPE html>
<html lang="es" dir="ltr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>DGEHM</title>
    <link rel="icon" type="image/png" href="{{ asset('img/escudo.svg') }}">
    <!-- BEGIN: Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- END: Google Font -->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/SimpleBar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/rt-plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <!-- END: Theme CSS-->
    <script src="{{ asset('assets/js/settings.js') }}" sync></script>
    <script src="{{ asset('assets/js/iconify-icon.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}" sync></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

    <style>
        .sidebar-wrapper {
            height: auto;
        }
    </style>

    <script>
        window.onload = function() {
            // Asegúrate de que el DOM esté completamente cargado
            var sidebar = document.querySelector('.sidebar-wrapper');
            var header = document.querySelector('.app-header');

            // Obtén la altura de .sidebar-wrapper
            var sidebarHeight = sidebar.offsetHeight;

            // Asigna esa altura a .app-header
            header.style.height = sidebarHeight + 'px';
        };

        // Para asegurarte de que la altura se actualice dinámicamente, podrías escuchar cambios de tamaño
        window.onresize = function() {
            var sidebar = document.querySelector('.sidebar-wrapper');
            var header = document.querySelector('.app-header');
            var sidebarHeight = sidebar.offsetHeight;
            header.style.height = sidebarHeight + 'px';
        };
    </script>
</head>

<body class=" font-inter dashcode-app" id="body_class">
    <!-- [if IE]> <p class="browserupgrade"> You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security. </p> <![endif] -->
    <main class="app-wrapper">
        <!-- BEGIN: Sidebar -->
        <!-- BEGIN: Sidebar -->
        <div class="sidebar-wrapper group">
            <div id="bodyOverlay"
                class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden"></div>
            <div class="logo-segment">
                <a class="flex items-center" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo-negro.png') }}" class="black_logo" alt="logo">
                    <img src="{{ asset('img/logo-negro.png') }}" class="white_logo" alt="logo">

                </a>
                <!-- Sidebar Type Button -->
                <div id="sidebar_type" class="cursor-pointer text-slate-900 dark:text-white text-lg">
                    <iconify-icon class="sidebarDotIcon extend-icon text-slate-900 dark:text-slate-200"
                        icon="fa-regular:dot-circle"></iconify-icon>
                    <iconify-icon class="sidebarDotIcon collapsed-icon text-slate-900 dark:text-slate-200"
                        icon="material-symbols:circle-outline"></iconify-icon>
                </div>
                <button class="sidebarCloseIcon text-2xl">
                    <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line">
                    </iconify-icon>
                </button>
            </div>


        </div>

        <div class="flex flex-col justify-between min-h-screen">
            <div>
                <!-- BEGIN: Header -->
                <!-- BEGIN: Header -->
                <div class="z-[9]" id="app_header">
                    <div class="app-header z-[999]  bg-white dark:bg-slate-800 shadow-sm dark:shadow-slate-700">
                        <div class="flex justify-between items-center">

                            <div
                                class="flex items-center md:space-x-4 space-x-2 xl:space-x-0 rtl:space-x-reverse vertical-box">
                                <a href="index.html" class="mobile-logo xl:hidden inline-block">
                                    <img src="{{ asset('assets/images/logo/logo-c.svg') }}" class="black_logo"
                                        alt="logo">
                                    <img src="{{ asset('assets/images/logo/logo-c-white.svg') }}" class="white_logo"
                                        alt="logo">
                                </a>
                                <button class="smallDeviceMenuController hidden md:inline-block xl:hidden">
                                    <iconify-icon
                                        class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white"
                                        icon="heroicons-outline:menu-alt-3"></iconify-icon>
                                </button>


                            </div>
                            <!-- end vertcial -->
                            <div class="items-center space-x-4 rtl:space-x-reverse horizental-box">
                                <a href="index.html">
                                    <span class="xl:inline-block hidden">
                                        <img src="{{ asset('assets/images/logo/logo.svg') }}" class="black_logo "
                                            alt="logo">
                                        <img src="{{ asset('assets/images/logo/logo-white.svg') }}" class="white_logo"
                                            alt="logo">
                                    </span>
                                    <span class="xl:hidden inline-block">
                                        <img src="{{ asset('assets/images/logo/logo-c.svg') }}" class="black_logo "
                                            alt="logo">
                                        <img src="{{ asset('assets/images/logo/logo-c-white.svg') }}"
                                            class="white_logo " alt="logo">
                                    </span>
                                </a>
                                <button
                                    class="smallDeviceMenuController  open-sdiebar-controller xl:hidden inline-block">
                                    <iconify-icon
                                        class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white"
                                        icon="heroicons-outline:menu-alt-3"></iconify-icon>
                                </button>

                            </div>
                            <!-- end horizental -->



                            <div class="main-menu">
                                <ul>

                                    <li class="menu-item-has-children">
                                        <!--  Single menu -->

                                        <!-- has dropdown -->



                                        <a href="javascript:void()">
                                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                                <span class="icon-box">
                                                    <iconify-icon icon=heroicons-outline:home> </iconify-icon>
                                                </span>
                                                <div class="text-box">Dashboard</div>
                                            </div>
                                            <div class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                                <iconify-icon icon="heroicons-outline:chevron-down"> </iconify-icon>
                                            </div>
                                        </a>

                                        <!-- Dropdown menu -->



                                        <ul class="sub-menu">



                                            <li>
                                                <a href=index.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons:presentation-chart-line
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Analytics Dashboard
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=ecommerce-dashboard.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons:shopping-cart
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Ecommerce Dashboard
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=project-dashboard.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons:briefcase
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Project Dashboard
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=crm-dashboard.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=ri:customer-service-2-fill
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            CRM Dashboard
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=banking-dashboard.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons:wrench-screwdriver
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Banking Dashboard
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>

                                        <!-- Megamenu -->


                                    </li>

                                    <li class="menu-item-has-children">
                                        <!--  Single menu -->

                                        <!-- has dropdown -->



                                        <a href="javascript:void()">
                                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                                <span class="icon-box">
                                                    <iconify-icon icon=heroicons-outline:chip> </iconify-icon>
                                                </span>
                                                <div class="text-box">App</div>
                                            </div>
                                            <div
                                                class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                                <iconify-icon icon="heroicons-outline:chevron-down"> </iconify-icon>
                                            </div>
                                        </a>

                                        <!-- Dropdown menu -->



                                        <ul class="sub-menu">



                                            <li>
                                                <a href=chat.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:chat
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            ChatAA
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=email.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:mail
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Email
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=calender>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:calendar
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Calendar
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=kanban>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:view-boards
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Kanban
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=todo>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:clipboard-check
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Todo
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=projects>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:document
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Projects
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>

                                        <!-- Megamenu -->


                                    </li>

                                    <li class="menu-item-has-children has-megamenu">
                                        <!--  Single menu -->

                                        <!-- has dropdown -->



                                        <a href="javascript:void()">
                                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                                <span class="icon-box">
                                                    <iconify-icon icon=heroicons-outline:view-boards> </iconify-icon>
                                                </span>
                                                <div class="text-box">Pages</div>
                                            </div>
                                            <div
                                                class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                                <iconify-icon icon="heroicons-outline:chevron-down"> </iconify-icon>
                                            </div>
                                        </a>

                                        <!-- Dropdown menu -->


                                        <!-- Megamenu -->



                                        <div class="rt-mega-menu">
                                            <div class="flex flex-wrap space-x-8 justify-between rtl:space-x-reverse">



                                                <div>
                                                    <!-- mega menu title -->
                                                    <div
                                                        class="text-sm font-medium text-slate-900 dark:text-white mb-2 flex space-x-1 items-center">

                                                        <span> Authentication</span>
                                                    </div>
                                                    <!-- single menu item* -->



                                                    <a href=signin-one.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signin One
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=signin-two.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signin Two
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=signin-three.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signin Three
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=signup-one.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signup One
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=signup-two.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signup Two
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=signup-three.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Signup Three
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=forget-password-one.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Forget Password One
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=forget-password-two.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Forget Password Two
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=forget-password-three.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Forget Password Three
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=lock-screen-one.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Lock Screen One
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=lock-screen-two.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Lock Screen Two
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=lock-screen-three.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Lock Screen Three
                                                            </span>
                                                        </div>

                                                    </a>

                                                </div>



                                                <div>
                                                    <!-- mega menu title -->
                                                    <div
                                                        class="text-sm font-medium text-slate-900 dark:text-white mb-2 flex space-x-1 items-center">

                                                        <span> Components</span>
                                                    </div>
                                                    <!-- single menu item* -->



                                                    <a href=typography.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                typography
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=colors.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                colors
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=alert.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                alert
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=button.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                button
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=card.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                card
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=carousel.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                carousel
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=dropdown.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                dropdown
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=image.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                image
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=modal.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                modal
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=progress-bar.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Progress bar
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=placeholder.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Placeholder
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=tab-accordion.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Tab &amp; Accordion
                                                            </span>
                                                        </div>

                                                    </a>

                                                </div>



                                                <div>
                                                    <!-- mega menu title -->
                                                    <div
                                                        class="text-sm font-medium text-slate-900 dark:text-white mb-2 flex space-x-1 items-center">

                                                        <span> Forms</span>
                                                    </div>
                                                    <!-- single menu item* -->



                                                    <a href=input.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Input
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=input-group.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Input group
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=input-layout.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Input layout
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=form-validation.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Form validation
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=form-wizard.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Wizard
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=input-mask.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Input mask
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=file-input>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                File input
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=form-repeater.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Form repeater
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=textarea.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Textarea
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=checkbox.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Checkbox
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=radio-button.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Radio button
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=switch.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Switch
                                                            </span>
                                                        </div>

                                                    </a>

                                                </div>



                                                <div>
                                                    <!-- mega menu title -->
                                                    <div
                                                        class="text-sm font-medium text-slate-900 dark:text-white mb-2 flex space-x-1 items-center">

                                                        <span> Utility</span>
                                                    </div>
                                                    <!-- single menu item* -->



                                                    <a href=invoice.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Invoice
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=pricing.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Pricing
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=faq.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                FAQ
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=blank-page.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Blank page
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=blog.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Blog
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=404.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                404 page
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=comming-soon.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Coming Soon
                                                            </span>
                                                        </div>

                                                    </a>



                                                    <a href=under-maintanance.html>

                                                        <div
                                                            class="flex items-center space-x-2 text-[15px] leading-6 rtl:space-x-reverse">
                                                            <span
                                                                class="h-[6px] w-[6px] rounded-full border border-slate-600 dark:border-white inline-block flex-none"></span>
                                                            <span
                                                                class="capitalize text-slate-600 dark:text-slate-300">
                                                                Under Maintanance page
                                                            </span>
                                                        </div>

                                                    </a>

                                                </div>

                                            </div>
                                        </div>

                                    </li>

                                    <li class="menu-item-has-children">
                                        <!--  Single menu -->

                                        <!-- has dropdown -->



                                        <a href="javascript:void()">
                                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                                <span class="icon-box">
                                                    <iconify-icon icon=heroicons-outline:view-grid-add> </iconify-icon>
                                                </span>
                                                <div class="text-box">Widgets</div>
                                            </div>
                                            <div
                                                class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                                <iconify-icon icon="heroicons-outline:chevron-down"> </iconify-icon>
                                            </div>
                                        </a>

                                        <!-- Dropdown menu -->



                                        <ul class="sub-menu">



                                            <li>
                                                <a href=basic-widgets.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:document-text
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Basic
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=statistics-widgets.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:document-text
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Statistic
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>

                                        <!-- Megamenu -->


                                    </li>

                                    <li class="menu-item-has-children">
                                        <!--  Single menu -->

                                        <!-- has dropdown -->



                                        <a href="javascript:void()">
                                            <div class="flex flex-1 items-center space-x-[6px] rtl:space-x-reverse">
                                                <span class="icon-box">
                                                    <iconify-icon icon=heroicons-outline:template> </iconify-icon>
                                                </span>
                                                <div class="text-box">Extra</div>
                                            </div>
                                            <div
                                                class="flex-none text-sm ltr:ml-3 rtl:mr-3 leading-[1] relative top-1">
                                                <iconify-icon icon="heroicons-outline:chevron-down"> </iconify-icon>
                                            </div>
                                        </a>

                                        <!-- Dropdown menu -->



                                        <ul class="sub-menu">



                                            <li>
                                                <a href=basic-table.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:table
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Basic Table
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=advance-table.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:table
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Advanced table
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=apex-chart.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:chart-bar
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Apex chart
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=chartjs.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:chart-bar
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Chart js
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>



                                            <li>
                                                <a href=map.html>
                                                    <div class="flex space-x-2 items-start rtl:space-x-reverse">
                                                        <iconify-icon icon=heroicons-outline:map
                                                            class="leading-[1] text-base"> </iconify-icon>
                                                        <span class="leading-[1]">
                                                            Map
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>

                                        </ul>

                                        <!-- Megamenu -->


                                    </li>

                                </ul>
                            </div>
                            <!-- end top menu -->
                            <div
                                class="nav-tools flex items-center lg:space-x-5 space-x-3 rtl:space-x-reverse leading-0">





                                <!-- END: Notification Dropdown -->

                                <!-- BEGIN: Profile Dropdown -->
                                <!-- Profile DropDown Area -->
                                <div class="md:block hidden w-full">
                                    <button
                                        class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center  inline-flex items-center"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div
                                            class="lg:h-8 lg:w-8 h-7 w-7 rounded-full flex-1 ltr:mr-[10px] rtl:ml-[10px]">
                                            <img src="{{ asset('assets/images/all-img/user.png') }}" alt="user"
                                                class="block w-full h-full object-cover rounded-full">
                                        </div>
                                        @php
                                            //dd(session()->all(),auth()->user())
                                        @endphp
                                        <span
                                            class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap">
                                        </span>
                                        <svg class="w-[16px] h-[16px] dark:text-white hidden lg:inline-block text-base inline-block ml-[10px] rtl:mr-[10px]"
                                            aria-hidden="true" fill="none" stroke="currentColor"
                                            viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div
                                        class="dropdown-menu z-10 hidden bg-white divide-y divide-slate-100 shadow w-44 dark:bg-slate-800 border dark:border-slate-700 !top-[23px] rounded-md    overflow-hidden">
                                        <ul class="py-1 text-sm text-slate-800 dark:text-slate-200">
                                            @can('edit perfil')
                                                <li>
                                                    <a href="{{ url('seguridad/perfil') }}"
                                                        class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                        <iconify-icon icon="heroicons-outline:user"
                                                            class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                        </iconify-icon>
                                                        <span class="font-Inter">Perfil</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('edit password')
                                                <li>
                                                    <a href="{{ url('seguridad/perfil/cambio_clave') }}"
                                                        class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                        <iconify-icon icon="mdi:password-outline"
                                                            class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1"></iconify-icon>
                                                        <span class="font-Inter">Cambio de contraseña</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            {{--  <li>
                                                <a href="email.html"
                                                    class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600  dark:text-white font-normal">
                                                    <iconify-icon icon="heroicons-outline:mail"
                                                        class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                    </iconify-icon>
                                                    <span class="font-Inter">Email</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="todo.html"
                                                    class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600  dark:text-white font-normal">
                                                    <iconify-icon icon="heroicons-outline:clipboard-check"
                                                        class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                    </iconify-icon>
                                                    <span class="font-Inter">Todo</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="settings.html"
                                                    class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600  dark:text-white font-normal">
                                                    <iconify-icon icon="heroicons-outline:cog"
                                                        class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                    </iconify-icon>
                                                    <span class="font-Inter">Settings</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="pricing.html"
                                                    class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                                    <iconify-icon icon="heroicons-outline:credit-card"
                                                        class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                    </iconify-icon>
                                                    <span class="font-Inter">Price</span>
                                                </a>
                                            </li>
                                            <li> --}}
                                            <a class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600
                                                    dark:text-white font-normal"
                                                href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                <iconify-icon icon="heroicons-outline:login"
                                                    class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1">
                                                </iconify-icon>
                                                <span class="font-Inter">Cerrar sesión</span>
                                            </a>

                                            </li>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </ul>
                                    </div>
                                </div>
                                <!-- END: Header -->
                                <button class="smallDeviceMenuController md:hidden block leading-0">
                                    <iconify-icon class="cursor-pointer text-slate-900 dark:text-white text-2xl"
                                        icon="heroicons-outline:menu-alt-3"></iconify-icon>
                                </button>
                                <!-- end mobile menu -->
                            </div>
                            <!-- end nav tools -->
                        </div>
                    </div>
                </div>

                <!-- END: Header -->
                <div class="content-wrapper transition-all duration-150 ltr:ml-[248px] rtl:mr-[248px]"
                    id="content_wrapper">
                    <div class="page-content">
                        <div class="transition-all duration-150 container-fluid" id="page_layout">
                            <div id="content_layout">
                                @yield('contenido')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BEGIN: Footer For Desktop and tab -->
            {{-- <footer class="md:block hidden" id="footer">
                <div
                    class="site-footer px-6 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-300 py-4 ltr:ml-[248px] rtl:mr-[248px]">
                    <div class="grid md:grid-cols-2 grid-cols-1 md:gap-5">
                        <div class="text-center ltr:md:text-start rtl:md:text-right text-sm">
                            COPYRIGHT ©
                            <span id="thisYear"></span>
                            DGEHM, All rights Reserved
                        </div>
                        <div class="ltr:md:text-right rtl:md:text-end text-center text-sm">
                            Hand-crafted &amp; Made by
                            <a href="https://codeshaper.net" target="_blank" class="text-primary-500 font-semibold">
                                DGEHM
                            </a>
                        </div>
                    </div>
                </div>
            </footer> --}}
            <!-- END: Footer For Desktop and tab -->
            <div
                class="bg-white bg-no-repeat custom-dropshadow footer-bg dark:bg-slate-700 flex justify-around items-center backdrop-filter backdrop-blur-[40px] fixed left-0 bottom-0 w-full z-[9999] bothrefm-0 py-[12px] px-4 md:hidden">
                <a href="chat.html">
                    <div>
                        <span
                            class="relative cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center mb-1 dark:text-white text-slate-900 ">
                            <iconify-icon icon="heroicons-outline:mail"></iconify-icon>
                            <span
                                class="absolute right-[5px] lg:hrefp-0 -hrefp-2 h-4 w-4 bg-red-500 text-[8px] font-semibold flex flex-col items-center justify-center rounded-full text-white z-[99]">
                                10
                            </span>
                        </span>
                        <span class="block text-[11px] text-slate-600 dark:text-slate-300">
                            Messages
                        </span>
                    </div>
                </a>
                <a href="profile.html"
                    class="relative bg-white bg-no-repeat backdrop-filter backdrop-blur-[40px] rounded-full footer-bg dark:bg-slate-700  h-[65px] w-[65px] z-[-1] -mt-[40px] flex justify-center items-center">
                    <div class="h-[50px] w-[50px] rounded-full relative left-[0px] hrefp-[0px] custom-dropshadow">
                        <img src="{{ asset('assets/images/users/user-1.jpg') }}" alt=""
                            class="w-full h-full rounded-full border-2 border-slate-100">
                    </div>
                </a>
                <a href="#">
                    <div>
                        <span
                            class=" relative cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center mb-1 dark:text-white text-slate-900">
                            <iconify-icon icon="heroicons-outline:bell"></iconify-icon>
                            <span
                                class="absolute right-[17px] lg:hrefp-0 -hrefp-2 h-4 w-4 bg-red-500 text-[8px] font-semibold flex flex-col items-center justify-center rounded-full text-white z-[99]">
                                2
                            </span>
                        </span>
                        <span class=" block text-[11px] text-slate-600 dark:text-slate-300">
                            Notifications
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </main>
    <!-- scripts -->

    <!-- Core Js -->
    {{-- <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/rt-plugins.js') }}"></script>
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/SimpleBar.js') }}"></script>

    <script src="{{ asset('assets/js/iconify.js') }}"></script>
    <!-- Jquery Plugins -->


    <!-- app js -->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>



</body>

</html>
