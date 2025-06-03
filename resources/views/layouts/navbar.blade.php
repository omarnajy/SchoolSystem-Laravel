{{-- resources/views/layouts/navbar.blade.php --}}
<nav class="bg-white shadow-lg border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo et titre -->
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">EduManage</h1>
                    <p class="text-sm text-gray-500">School Management System</p>
                </div>
            </div>

            <!-- Menu utilisateur -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
                        <i class="fas fa-bell text-lg"></i>
                        <span
                            class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                    </button>

                    <!-- Profil utilisateur -->
                    <div class="relative">
                        <button id="user-menu-button"
                            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <img src="{{ asset('images/profile/' . auth()->user()->profile_picture) }}" alt="Avatar"
                                class="w-8 h-8 rounded-full">
                            <div class="text-left">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->roles[0]->name ?? 'User' }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="user-menu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <div class="py-2">
                                <a href="{{ route('profile') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-3"></i>
                                    Profile
                                </a>
                                <a href="#"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-3"></i>
                                    Paramètres
                                </a>
                                <hr class="my-2">
                                <form action="{{ route('logout') }}" method="POST" class="px-4 py-2">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full text-sm text-red-600 hover:text-red-800">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">
                            <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
