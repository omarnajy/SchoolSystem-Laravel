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
        }

        .sidebar-item:hover {
            transform: translateX(4px);
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen">
    <div id="app">
        @include('layouts.navbar')

        <div class="flex pt-16">
            @include('layouts.sidebar')

            <main class="flex-1 ml-64">
                <div class="p-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        // Animation d'entrée pour les cartes
        document.addEventListener('DOMContentLoaded', function() {
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
        });

        // Menu dropdown
        document.getElementById('user-menu-button')?.addEventListener('click', function() {
            document.getElementById('user-menu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>

</html>
