{{-- resources/views/layouts/sidebar.blade.php --}}
<aside
    class="w-64 bg-white/95 backdrop-blur-md shadow-2xl h-screen fixed left-0 top-16 overflow-y-auto border-r border-gray-200/50">
    <!-- En-tête de la sidebar avec dégradé -->
    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-purple-700 p-6 text-white">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-tachometer-alt text-white"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold">Navigation</h2>
                <p class="text-blue-200 text-xs">Menu principal</p>
            </div>
        </div>
    </div>

    <div class="p-6">
        <nav class="space-y-3">
            <!-- Dashboard -->
            <div class="sidebar-item">
                <a href="{{ route('home') }}"
                    class="flex items-center space-x-3 p-3 rounded-xl group transition-all duration-300 {{ request()->routeIs('home') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700' }}">
                    <div
                        class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('home') ? 'bg-white/20' : 'bg-blue-100 group-hover:bg-blue-200' }} transition-all duration-300">
                        <i class="fas fa-home {{ request()->routeIs('home') ? 'text-white' : 'text-blue-600' }}"></i>
                    </div>
                    <span class="font-semibold">Dashboard</span>
                    @if (request()->routeIs('home'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            </div>

            @role('Admin')
                <!-- Section Gestion -->
                <div class="pt-6">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="flex-1 h-px bg-gradient-to-r from-gray-300 to-transparent"></div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider px-2">Gestion</p>
                        <div class="flex-1 h-px bg-gradient-to-l from-gray-300 to-transparent"></div>
                    </div>

                    <div class="space-y-2">
                        <!-- Enseignants -->
                        <div class="sidebar-item">
                            <a href="{{ route('teacher.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-xl group transition-all duration-300 {{ request()->routeIs('teacher.*') ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-purple-100 hover:text-purple-700' }}">
                                <div
                                    class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('teacher.*') ? 'bg-white/20' : 'bg-purple-100 group-hover:bg-purple-200' }} transition-all duration-300">
                                    <i
                                        class="fas fa-chalkboard-teacher {{ request()->routeIs('teacher.*') ? 'text-white' : 'text-purple-600' }}"></i>
                                </div>
                                <span class="font-medium">Enseignants</span>
                                @if (request()->routeIs('teacher.*'))
                                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                @endif
                            </a>
                        </div>

                        <!-- Étudiants -->
                        <div class="sidebar-item">
                            <a href="{{ route('student.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-xl group transition-all duration-300 {{ request()->routeIs('student.*') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 hover:text-green-700' }}">
                                <div
                                    class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('student.*') ? 'bg-white/20' : 'bg-green-100 group-hover:bg-green-200' }} transition-all duration-300">
                                    <i
                                        class="fas fa-user-graduate {{ request()->routeIs('student.*') ? 'text-white' : 'text-green-600' }}"></i>
                                </div>
                                <span class="font-medium">Étudiants</span>
                                @if (request()->routeIs('student.*'))
                                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                @endif
                            </a>
                        </div>

                        <!-- Parents -->
                        <div class="sidebar-item">
                            <a href="{{ route('parents.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-xl group transition-all duration-300 {{ request()->routeIs('parents.*') ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-orange-100 hover:text-orange-700' }}">
                                <div
                                    class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('parents.*') ? 'bg-white/20' : 'bg-orange-100 group-hover:bg-orange-200' }} transition-all duration-300">
                                    <i
                                        class="fas fa-users {{ request()->routeIs('parents.*') ? 'text-white' : 'text-orange-600' }}"></i>
                                </div>
                                <span class="font-medium">Parents</span>
                                @if (request()->routeIs('parents.*'))
                                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                @endif
                            </a>
                        </div>

                        <!-- Matières -->
                        <div class="sidebar-item">
                            <a href="{{ route('subject.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-xl group transition-all duration-300 {{ request()->routeIs('subject.*') ? 'bg-gradient-to-r from-pink-500 to-pink-600 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-pink-100 hover:text-pink-700' }}">
                                <div
                                    class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('subject.*') ? 'bg-white/20' : 'bg-pink-100 group-hover:bg-pink-200' }} transition-all duration-300">
                                    <i
                                        class="fas fa-book {{ request()->routeIs('subject.*') ? 'text-white' : 'text-pink-600' }}"></i>
                                </div>
                                <span class="font-medium">Matières</span>
                                @if (request()->routeIs('subject.*'))
                                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                @endif
                            </a>
                        </div>

                        <!-- Classes -->
                        <div class="sidebar-item">
                            <a href="{{ route('classes.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-xl group transition-all duration-300 {{ request()->routeIs('classes.*') ? 'bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-indigo-100 hover:text-indigo-700' }}">
                                <div
                                    class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('classes.*') ? 'bg-white/20' : 'bg-indigo-100 group-hover:bg-indigo-200' }} transition-all duration-300">
                                    <i
                                        class="fas fa-door-open {{ request()->routeIs('classes.*') ? 'text-white' : 'text-indigo-600' }}"></i>
                                </div>
                                <span class="font-medium">Classes</span>
                                @if (request()->routeIs('classes.*'))
                                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Section Suivi -->
                <div class="pt-6">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="flex-1 h-px bg-gradient-to-r from-gray-300 to-transparent"></div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider px-2">Suivi</p>
                        <div class="flex-1 h-px bg-gradient-to-l from-gray-300 to-transparent"></div>
                    </div>

                    <div class="space-y-2">
                        <!-- Présences -->
                        <div class="sidebar-item">
                            <a href="{{ route('attendance.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-xl group transition-all duration-300 {{ request()->routeIs('attendance.*') ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-teal-50 hover:to-teal-100 hover:text-teal-700' }}">
                                <div
                                    class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('attendance.*') ? 'bg-white/20' : 'bg-teal-100 group-hover:bg-teal-200' }} transition-all duration-300">
                                    <i
                                        class="fas fa-calendar-check {{ request()->routeIs('attendance.*') ? 'text-white' : 'text-teal-600' }}"></i>
                                </div>
                                <span class="font-medium">Présences</span>
                                @if (request()->routeIs('attendance.*'))
                                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Section Système -->
                <div class="pt-6">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="flex-1 h-px bg-gradient-to-r from-gray-300 to-transparent"></div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider px-2">Système</p>
                        <div class="flex-1 h-px bg-gradient-to-l from-gray-300 to-transparent"></div>
                    </div>

                    <div class="space-y-2">
                        <!-- Rôles -->
                        <div class="sidebar-item">
                            <a href="{{ route('assignrole.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-xl group transition-all duration-300 {{ request()->routeIs('assignrole.*') ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 hover:text-red-700' }}">
                                <div
                                    class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('assignrole.*') ? 'bg-white/20' : 'bg-red-100 group-hover:bg-red-200' }} transition-all duration-300">
                                    <i
                                        class="fas fa-user-tag {{ request()->routeIs('assignrole.*') ? 'text-white' : 'text-red-600' }}"></i>
                                </div>
                                <span class="font-medium">Attribution de rôles</span>
                                @if (request()->routeIs('assignrole.*'))
                                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                @endif
                            </a>
                        </div>

                        <!-- Permissions -->
                        <div class="sidebar-item">
                            <a href="{{ route('roles-permissions') }}"
                                class="flex items-center space-x-3 p-3 rounded-xl group transition-all duration-300 {{ request()->routeIs('roles-permissions') || request()->routeIs('role.*') || request()->routeIs('permission.*') ? 'bg-gradient-to-r from-gray-700 to-gray-800 text-white shadow-lg transform scale-105' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 hover:text-gray-800' }}">
                                <div
                                    class="w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('roles-permissions') || request()->routeIs('role.*') || request()->routeIs('permission.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-gray-200' }} transition-all duration-300">
                                    <i
                                        class="fas fa-cog {{ request()->routeIs('roles-permissions') || request()->routeIs('role.*') || request()->routeIs('permission.*') ? 'text-white' : 'text-gray-600' }}"></i>
                                </div>
                                <span class="font-medium">Rôles & Permissions</span>
                                @if (request()->routeIs('roles-permissions') || request()->routeIs('role.*') || request()->routeIs('permission.*'))
                                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endrole
        </nav>
    </div>

    <!-- Pied de page de la sidebar -->
    <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-gray-50 to-transparent">
        <div class="text-center">
            <p class="text-xs text-gray-500">EduManage v2.0</p>
            <p class="text-xs text-gray-400">© 2025 - Système moderne</p>
        </div>
    </div>
</aside>

<style>
    /* Animation pour les éléments de la sidebar */
    .sidebar-item {
        position: relative;
    }

    .sidebar-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 0;
        background: linear-gradient(to bottom, #3B82F6, #8B5CF6);
        transition: height 0.3s ease;
        border-radius: 0 2px 2px 0;
    }

    .sidebar-item:hover::before {
        height: 60%;
    }

    /* Animation d'entrée pour les éléments du menu */
    .sidebar-item {
        animation: slideInLeft 0.3s ease forwards;
        opacity: 0;
        transform: translateX(-20px);
    }

    .sidebar-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .sidebar-item:nth-child(2) {
        animation-delay: 0.2s;
    }

    .sidebar-item:nth-child(3) {
        animation-delay: 0.3s;
    }

    .sidebar-item:nth-child(4) {
        animation-delay: 0.4s;
    }

    .sidebar-item:nth-child(5) {
        animation-delay: 0.5s;
    }

    .sidebar-item:nth-child(6) {
        animation-delay: 0.6s;
    }

    @keyframes slideInLeft {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
