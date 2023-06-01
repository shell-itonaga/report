<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p:wght@300&family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
        <!-- tailWind CSS -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
        <!-- custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <!-- Favicons -->
        <link rel="icon" href="{{ asset('img/logo_mark.png') }}" type="image/png">
        <!-- tailWind js -->
        <script src="{{ asset('js/app.js') }}" defer></script>
@if (request()->is('*report*') || request()->is('*summary*') || request()->is('*manage*') || request()->is('*list*'))
        <!-- Select2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
        <!-- スマホ用 tableスクロール -->
        <link rel="stylesheet" href="https://unpkg.com/scroll-hint@latest/css/scroll-hint.css">
        <script src="https://unpkg.com/scroll-hint@latest/js/scroll-hint.min.js"></script>
@endif
    </head>

    <body class="antialiased bg-gray-100">

        <div class="min-h-screen bg-gray-100">
            <!-- navigation Bar -->
            @include('layouts.navigation')
            <!-- Page Heading -->
            <header class="bg-white shadow text-center">
                <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main class="mx-auto">
                {{ $slot }}
            </main>

        </div>

        <!-- jQuery -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@if (request()->is('*report*') || request()->is('*summary*') || request()->is('*manage*') || request()->is('*list*'))
        <!-- Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/i18n/ja.js"></script>
        <script src="{{ asset('js/select2-bootstrap5-theme.js') }}"></script>
@endif
@if ( request()->is('*report*') || request()->is('*work-class/insert*') || request()->is('*work-detail*') || request()->is('*list*') || request()->is('*unit-no*') || request()->is('*employee*'))
        <script src="{{ asset('js/formValidation.js') }}"></script>
        <script src="{{ asset('js/number_selector.js') }}"></script>
        <script src="{{ asset('js/work_selector.js') }}"></script>
@endif
@if (request()->is('*out-soucer*') || request()->is('*complete*') || request()->is('*user-config*') || request()->is('*employee*'))
        <script src="{{ asset('js/password-confirm-check.js') }}" defer></script>
@endif
@if (request()->is('*complete*'))
        <script src="{{ asset('js/no_bower_back.js') }}" defer></script>
@endif
@if (request()->is('*unit-no*') || request()->is('*work-class*') || request()->is('*work-detail*') || request()->is('*report/edit*') || request()->is('*report/manage*'))
        <script src="{{ asset('js/add-table-rows.js') }}" defer></script>
        <script src="{{ asset('js/confirm-dialog.js') }}" defer></script>
@endif
    </body>
</html>
