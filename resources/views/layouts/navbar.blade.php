{{-- resources/views/layouts/navbar.blade.php --}}
<nav class="bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-200/50 fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo et titre avec effet moderne -->
            <div class="flex items-center space-x-3 group">
                <div class="flex-shrink-0 relative">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 via-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-all duration-300">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                        <!-- Effet de brillance -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -skew-x-12 opacity-0 group-hover:opacity-100 group-hover:animate-pulse transition-opacity duration-300">
                        </div>
                    </div>
                </div>
                <div class="group-hover:translate-x-1 transition-transform duration-300">
                    <h1
                        class="text-2xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        EduManage
                    </h1>
                    <p class="text-sm text-gray-500 font-medium">Système de Gestion Scolaire</p>
                </div>
            </div>

            <!-- Menu utilisateur avec style moderne -->
            <div class="flex items-center space-x-6">
                @auth

                    <!-- Profil utilisateur avec dropdown moderne -->
                    <div class="relative">
                        <button id="user-menu-button"
                            class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 group border border-transparent hover:border-blue-200">
                            <div class="relative">
                                <img src="{{ asset('images/profile/' . auth()->user()->profile_picture) }}" alt="Avatar"
                                    class="w-10 h-10 rounded-full border-2 border-gray-200 group-hover:border-blue-400 transition-all duration-300 shadow-md">
                                <!-- Indicateur de statut en ligne -->
                                <div
                                    class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full">
                                </div>
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs font-medium">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800">
                                        {{ auth()->user()->roles[0]->name ?? 'User' }}
                                    </span>
                                </p>
                            </div>
                            <i
                                class="fas fa-chevron-down text-gray-400 text-sm group-hover:text-blue-600 transform group-hover:rotate-180 transition-all duration-300"></i>
                        </button>

                        <!-- Dropdown menu avec effet glassmorphism -->
                        <div id="user-menu"
                            class="hidden absolute right-0 mt-3 w-56 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-200/50 z-50 transform origin-top-right scale-95 opacity-0 transition-all duration-200">
                            <div class="py-3">
                                <!-- En-tête du profil -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'Utilisateur connecté' }}
                                    </p>
                                </div>

                                <!-- Liens du menu -->
                                <div class="py-2">
                                    <a href="{{ route('profile') }}"
                                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 transition-all duration-200 group">
                                        <div
                                            class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-user text-blue-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium">Mon Profil</span>
                                    </a>

                                    <a href="#"
                                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-purple-100 hover:text-purple-700 transition-all duration-200 group">
                                        <div
                                            class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors">
                                            <i class="fas fa-cog text-purple-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium">Paramètres</span>
                                    </a>

                                    <hr class="my-2 border-gray-100">

                                    <form action="{{ route('logout') }}" method="POST" class="px-4 py-2">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full text-sm text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 hover:text-red-700 rounded-lg p-2 transition-all duration-200 group">
                                            <div
                                                class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors">
                                                <i class="fas fa-sign-out-alt text-red-600 text-sm"></i>
                                            </div>
                                            <span class="font-medium">Déconnexion</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}"
                            class="flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Connexion</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();

                if (userMenu.classList.contains('hidden')) {
                    userMenu.classList.remove('hidden');
                    setTimeout(() => {
                        userMenu.classList.remove('scale-95', 'opacity-0');
                        userMenu.classList.add('scale-100', 'opacity-100');
                    }, 10);
                } else {
                    userMenu.classList.add('scale-95', 'opacity-0');
                    userMenu.classList.remove('scale-100', 'opacity-100');
                    setTimeout(() => {
                        userMenu.classList.add('hidden');
                    }, 200);
                }
            });

            // Fermer le menu en cliquant ailleurs
            document.addEventListener('click', function() {
                if (!userMenu.classList.contains('hidden')) {
                    userMenu.classList.add('scale-95', 'opacity-0');
                    userMenu.classList.remove('scale-100', 'opacity-100');
                    setTimeout(() => {
                        userMenu.classList.add('hidden');
                    }, 200);
                }
            });

            userMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>
