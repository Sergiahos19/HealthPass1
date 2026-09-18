<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Tableau de Bord Administration - HealthPass')</title>

    
    <!-- Material Symbols & Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #F8FAFC;
            color: #0d1c2f;
        }
        .card-level-1 {
            background-color: #FFFFFF;
            box-shadow: 0px 4px 12px rgba(51, 65, 85, 0.05);
            border: 1px solid #E2E8F0;
        }
        .card-level-2:hover {
            box-shadow: 0px 8px 20px rgba(51, 65, 85, 0.08);
        }
        .btn-primary {
            background: linear-gradient(135deg, #006398 0%, #005a71 100%);
            color: #ffffff;
            font-weight: 600;
            border: none;
        }
        .btn-ghost {
            background: transparent;
            border: 1.5px solid #005a71;
            color: #005a71;
            font-weight: 600;
        }
        .biometric-indicator {
            animation: pulse-soft 2s infinite;
        }
        @keyframes pulse-soft {
            0% { box-shadow: 0 0 0 0 rgba(0, 122, 84, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(0, 122, 84, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 122, 84, 0); }
        }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="hp-workspace hp-workspace-superadmin bg-background text-on-background font-corps-md h-screen overflow-hidden flex">

    <!-- Inclusion de la Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Zone de contenu principal -->
    <main class="flex-1 md:ml-64 h-screen overflow-y-auto bg-[#F8FAFC]">
        <!-- Top Bar Mobile -->
        <header class="md:hidden sticky top-0 w-full z-50 flex justify-between items-center px-marge-page py-gouttiere bg-surface-container-lowest border-b border-outline-variant shadow-sm">
            <div class="font-titre-md text-titre-md text-primary font-bold">HealthPass Admin</div>
            <button class="text-on-surface">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </header>

        <!-- Dynamic Content -->
        @yield('content')
    </main>

</body>
</html>
