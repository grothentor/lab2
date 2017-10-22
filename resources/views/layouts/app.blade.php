@include('js-localization::head')
@php
    if (!isset($base)) $base = request()->path();
    if (!starts_with($base, '/')) $base = '/' . $base;
@endphp
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="{{$base}}"/>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        {{ Html::style(mix('css/app.css')) }}
        {{ Html::style(mix('css/style.css')) }}
        {{ Html::style(mix('css/admin.css')) }}
        @stack('styles')
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
        @yield('js-localization.head')
    </head>
    <body class="admin-body">
        @include('admin.navigation')
        <div ng-app="App" class="admin-container">
            @yield('content')
        </div>
    </body>

    {{ Html::script(mix('js/app.js')) }}
    {{ Html::script(mix('js/admin.js')) }}

    @stack('scripts')

</html>