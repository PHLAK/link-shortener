<!DOCTYPE html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ mix('js/app.js') }}" defer></script>
<link rel="icon" href="{{ asset('favicon.png') }}">
<link rel="stylesheet" href="{{ mix('css/app.css') }}">

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>

<title>{{ config('app.name') }}</title>

<div class="relative flex items-center justify-center min-h-screen bg-yellow-300">

    <div class="text-center">
        <h1 class="font-montserrat">
            <span class="text-6xl md:text-8xl lg:text-10xl bg-yellow-300">
                PHLAK
            </span>

            <span class="font-extrabold text-6xl md:text-8xl lg:text-10xl">
                Links
            </span>
        </h1>

        <h2>
            A link shortener by
            <a href="https://www.chriskankiewicz.com" class="inline-block underline">
                Chris Kankiewicz
            </a>
        </h2>
    </div>

    @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                @endif
            @endif
        </div>
    @endif
</div>
