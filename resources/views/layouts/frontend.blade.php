<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
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
            min-height: calc(100vh - 4rem);
        }

        /* Effet de glassmorphism */
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>

</head>

<body class="bg-pattern font-sans antialiased">
    <div id="app-2">

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="main flex flex-wrap justify-end mt-16 ml-64">

            <div class="content w-full">
                <div class="content-wrapper">
                    <div class="container mx-auto p-4 sm:p-6">
                        <!-- Décoration en arrière-plan -->
                        <div
                            class="absolute top-20 left-10 w-20 h-20 bg-blue-200 rounded-full opacity-20 float-animation">
                        </div>
                        <div class="absolute top-40 right-20 w-16 h-16 bg-purple-200 rounded-full opacity-20 float-animation"
                            style="animation-delay: -2s;"></div>
                        <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-green-200 rounded-full opacity-20 float-animation"
                            style="animation-delay: -4s;"></div>

                        <!-- Contenu principal avec effet de verre -->
                        <div class="relative z-10">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script pour les interactions utilisateur
        document.addEventListener('DOMContentLoaded', function() {
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

</body>

</html>
<!-- EduManage - Modern School Management System -->
