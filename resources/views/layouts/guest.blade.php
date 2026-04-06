<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} - Tirage au sort certifié</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-green-50 via-white to-blue-50">
        <div class="min-h-screen flex flex-col">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xl font-bold text-gray-900">Sortio</span>
                                <span class="text-xs text-gray-500 block">Tirage certifié</span>
                            </div>
                        </a>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                                Se connecter
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                                Essayer gratuitement
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center text-sm text-gray-600">
                        <p>&copy; 2024 Sortio Intelligent. Tous droits réservés.</p>
                        <div class="flex space-x-6">
                            <a href="#" class="hover:text-gray-900">CGU</a>
                            <a href="#" class="hover:text-gray-900">Confidentialité</a>
                            <a href="{{ route('verify') }}" class="hover:text-gray-900">Vérifier un tirage</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        @livewireScripts
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @stack('scripts')
    </body>
</html>
