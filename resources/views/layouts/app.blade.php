{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Ajoutez Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Animation pour les éléments flottants */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        /* Effet de particules en arrière-plan */
        .bg-pattern {
            background-image: radial-gradient(circle at 25% 25%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
        }

        /* Style pour le contenu principal */
        .content-wrapper {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        /* Effet de glassmorphism */
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Fix pour la sidebar et le layout */
        .main-content {
            margin-left: 0;
            padding-top: 64px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        @media (min-width: 768px) {
            .main-content {
                margin-left: 256px;
            }
        }

        /* Style du scroll de la sidebar */
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.5);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.7);
        }

        /* Responsive pour mobile */
        @media (max-width: 767px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }
        }

        /* Animations pour les cartes */
        .card-hover:hover {
            transform: translateY(-4px);
            transition: all 0.3s ease;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Délais d'animation pour un effet échelonné */
        .fade-in:nth-child(1) {
            animation-delay: 0.1s;
        }

        .fade-in:nth-child(2) {
            animation-delay: 0.2s;
        }

        .fade-in:nth-child(3) {
            animation-delay: 0.3s;
        }

        .fade-in:nth-child(4) {
            animation-delay: 0.4s;
        }

        /* Amélioration des performances pour les éléments flottants */
        .pointer-events-none {
            pointer-events: none;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-pattern font-sans antialiased min-h-screen">
    <div id="app">
        @include('layouts.navbar')
        @include('layouts.sidebar')

        <!-- Bouton menu mobile -->
        <button id="mobile-menu-button"
            class="md:hidden fixed top-20 left-4 z-50 bg-white shadow-lg rounded-lg p-3 text-gray-600 hover:text-blue-600 transition-colors">
            <i class="fas fa-bars text-lg"></i>
        </button>

        <!-- Overlay pour mobile -->
        <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/50 z-30 md:hidden"></div>

        <main class="main-content">
            <div class="content-wrapper">
                <div class="container mx-auto p-4 sm:p-6">
                    <!-- Décoration en arrière-plan -->
                    <div
                        class="absolute top-20 left-10 w-20 h-20 bg-blue-200 rounded-full opacity-20 float-animation pointer-events-none">
                    </div>
                    <div class="absolute top-40 right-20 w-16 h-16 bg-purple-200 rounded-full opacity-20 float-animation pointer-events-none"
                        style="animation-delay: -2s;"></div>
                    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-green-200 rounded-full opacity-20 float-animation pointer-events-none"
                        style="animation-delay: -4s;"></div>

                    <!-- Contenu principal avec effet de verre -->
                    <div class="relative z-10">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menu mobile
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (mobileMenuButton && sidebar) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                    if (overlay) {
                        overlay.classList.toggle('hidden');
                    }
                });

                // Fermer avec overlay
                if (overlay) {
                    overlay.addEventListener('click', function() {
                        sidebar.classList.remove('open');
                        overlay.classList.add('hidden');
                    });
                }

                // Fermer avec Escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                        sidebar.classList.remove('open');
                        if (overlay) overlay.classList.add('hidden');
                    }
                });
            }

            // Animation d'entrée pour les cartes
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Animation d'apparition progressive
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'all 0.6s ease';
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
