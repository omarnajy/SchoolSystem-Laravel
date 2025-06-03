{{-- resources/views/layouts/sidebar.blade.php --}}
<aside class="w-64 bg-white shadow-lg h-screen fixed left-0 top-16 overflow-y-auto">
    <div class="p-6">
        <nav class="space-y-2">
            <!-- Dashboard -->
            <div class="sidebar-item">
                <a href="{{ route('home') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
            </div>

            @role('Admin')
                <div class="pt-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Gestion</p>

                    <div class="space-y-1">
                        <!-- Enseignants -->
                        <div class="sidebar-item">
                            <a href="{{ route('teacher.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('teacher.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
                                <i class="fas fa-chalkboard-teacher w-5"></i>
                                <span>Enseignants</span>
                            </a>
                        </div>

                        <!-- Étudiants -->
                        <div class="sidebar-item">
                            <a href="{{ route('student.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('student.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
                                <i class="fas fa-user-graduate w-5"></i>
                                <span>Étudiants</span>
                            </a>
                        </div>

                        <!-- Parents -->
                        <div class="sidebar-item">
                            <a href="{{ route('parents.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('parents.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
                                <i class="fas fa-users w-5"></i>
                                <span>Parents</span>
                            </a>
                        </div>

                        <!-- Matières -->
                        <div class="sidebar-item">
                            <a href="{{ route('subject.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('subject.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
                                <i class="fas fa-book w-5"></i>
                                <span>Matières</span>
                            </a>
                        </div>

                        <!-- Classes -->
                        <div class="sidebar-item">
                            <a href="{{ route('classes.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('classes.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
                                <i class="fas fa-door-open w-5"></i>
                                <span>Classes</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Suivi</p>

                    <div class="space-y-1">
                        <!-- Présences -->
                        <div class="sidebar-item">
                            <a href="{{ route('attendance.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('attendance.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
                                <i class="fas fa-calendar-check w-5"></i>
                                <span>Présences</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Système</p>

                    <div class="space-y-1">
                        <!-- Rôles -->
                        <div class="sidebar-item">
                            <a href="{{ route('assignrole.index') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('assignrole.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
                                <i class="fas fa-user-tag w-5"></i>
                                <span>Attribution de rôles</span>
                            </a>
                        </div>

                        <!-- Permissions -->
                        <div class="sidebar-item">
                            <a href="{{ route('roles-permissions') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('roles-permissions') || request()->routeIs('role.*') || request()->routeIs('permission.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-700' }}">
                                <i class="fas fa-cog w-5"></i>
                                <span>Rôles & Permissions</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endrole
        </nav>
    </div>
</aside>
