<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @stack('styles')



    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ URL::asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app" >
        <nav class="navbar navbar-expand-md navbar-light  shadow-sm" style="background-color:purple">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse mx-2"  id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav me-auto mx-5 text-white" style=" ">
                        <li class="nav-item mx-3">
                            <a class="nav-link text-white" style=""  href="{{ route('plans') }}">{{ __('Plans') }}</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link text-white" style="" href="{{ route('languages') }}">{{ __('Langage exams') }}</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link text-white" style="" href="{{ route('covers') }}">{{ __('Cover Letter') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" style="" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Historiques') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" style="background-color:purple"  aria-labelledby="navbarDropdown">
                                <a class="dropdown-item text-white" style="background-color:purple" href="{{ route('historiqueslanguages') }}">
                                    {{ __('Languages') }}
                                </a>
                                <a class="dropdown-item text-white" style="background-color:purple" href="{{ route('historiquescovers') }}">
                                    {{ __('Covers') }}
                                </a>


                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav  text-white">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white"  href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end text-center" >
                            <a class="dropdown-item text-white mb-3" style="background-color:purple" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <a class="dropdown-item text-white" style="background-color:purple">TCF: {{ $user->available_tcf }}</a>
                            <a class="dropdown-item text-white" style="background-color:purple">IELTS: {{ $user->available_ielts }}</a>
                            <a class="dropdown-item text-white" style="background-color:purple">Letters: {{ $user->available_lettres }}</a>
                        </div>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>


                    </li>
                </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->

                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Inclure jQuery -->
@stack('scripts')
</html>
