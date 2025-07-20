<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen font-['Inter']">
        <!-- Navigation -->
        @include('components.global-navigation')

        <!-- Main Content -->
        <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">
                        {{ $title ?? 'Welcome Back' }}
                    </h2>
                    <p class="text-gray-600">
                        {{ $subtitle ?? 'Sign in to your account to continue' }}
                    </p>
                </div>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow-xl rounded-xl sm:px-10 border border-gray-100">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
