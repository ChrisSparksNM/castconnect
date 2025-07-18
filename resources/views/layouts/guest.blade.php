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
        <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex-shrink-0">
                            <h1 class="text-xl font-bold text-gray-900">📺 TV & Actors</h1>
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('tv-shows.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            Browse Shows
                        </a>
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Sign up
                        </a>
                    </div>
                </div>
            </div>
        </nav>

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
