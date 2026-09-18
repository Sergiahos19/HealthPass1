<!DOCTYPE html>
<html lang="fr" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthPass - {{ $title ?? 'Accueil' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ request()->routeIs('home') ? 'hp-public hp-home' : '' }} bg-background text-on-background min-h-screen flex flex-col antialiased overflow-x-hidden">

    <x-navbar />

    <main class="grow flex flex-col">
        @yield('content')
    </main>

    @if (request()->routeIs('home'))
        <x-footer />
    @endif

</body>
</html>
