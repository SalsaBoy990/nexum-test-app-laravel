<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en" style="overflow:hidden;">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __("Dashboard") }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-serif-text:400|exo:700,800|exo-2:400,500"
        rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer>
    </script>
    <script src="/build/assets/focus-trap.js"></script>
    <script src="/build/assets/init-alpine.js"></script>
</head>

<body class="sans-serif relative" style="display: block !important;">
    <x-jet-banner />
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900"
        :class="{ 'overflow-hidden': isSideMenuOpen }">
        <x-admin.desktop-sidebar></x-admin.desktop-sidebar>
        <!-- Mobile sidebar TODO: component -->
        <!-- Backdrop -->
        <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in-out duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
        </div>
        <x-admin.mobile-sidebar></x-admin.mobile-sidebar>
        <div class="flex flex-col flex-1 w-full">
            <!-- TODO: component -->

            <x-admin.admin-header :header="$header"></x-admin.admin-header>
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    <!-- Page Content -->
                    <div>
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('modals')

    @livewireScripts

</body>

</html>