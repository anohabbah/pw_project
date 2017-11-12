<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      @auth() class="has-navbar-fixed-top" @endauth>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ page_title($title ?? '') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @auth()
            @include('layouts._includes.nav')
            @include('layouts._includes.nav.sidebar')

            <div id="content">
                <section class="hero page-header">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">{{ $title }}</h1>
                            <h2 class="subtitle">{{ $subtitle }}</h2>
                        </div>
                    </div>
                </section>
                @yield('content')
            </div>
        @else
            @yield('content')
        @endauth

        @if(session('flash'))
            <flash message="{{ session('flash') }}"></flash>
        @endif
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
