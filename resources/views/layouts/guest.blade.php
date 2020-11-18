<!DOCTYPE html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ mix('js/app.js') }}" defer></script>
<link rel="icon" href="{{ asset('favicon.png') }}">
<link rel="stylesheet" href="{{ mix('css/app.css') }}">

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>

<title>{{ config('app.name') }}</title>

<div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
</div>
