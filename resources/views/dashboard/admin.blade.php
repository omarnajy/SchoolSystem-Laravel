@extends('layouts.app')

@section('content')
    <!-- Coller ici le contenu modernisé du dashboard -->
    <!-- Dashboard Admin Modernisé avec style cohérent -->
    <div class="p-6 space-y-8">
        <!-- Titre principal -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                Tableau de Bord Administrateur
            </h1>
            <p class="text-gray-600 text-lg">Vue d'ensemble de votre établissement scolaire</p>
        </div>

        <!-- Grille des statistiques principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card Étudiants -->
            <div
                class="group bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 group-hover:translate-x-full transition-transform duration-1000">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-user-graduate text-2xl"></i>
                        </div>
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    </div>
                    <div class="text-3xl font-bold mb-2">{{ sprintf('%02d', count($students ?? [])) }}</div>
                    <div class="text-blue-100 font-semibold uppercase tracking-wide text-sm">Étudiants</div>
                    <div class="mt-3 text-xs text-blue-200 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i>
                        Actifs dans le système
                    </div>
                </div>
            </div>

            <!-- Card Enseignants -->
            <div
                class="group bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 group-hover:translate-x-full transition-transform duration-1000">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-chalkboard-teacher text-2xl"></i>
                        </div>
                        <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                    </div>
                    <div class="text-3xl font-bold mb-2">{{ sprintf('%02d', count($teachers ?? [])) }}</div>
                    <div class="text-purple-100 font-semibold uppercase tracking-wide text-sm">Enseignants</div>
                    <div class="mt-3 text-xs text-purple-200 flex items-center">
                        <i class="fas fa-users mr-1"></i>
                        Corps professoral
                    </div>
                </div>
            </div>

            <!-- Card Parents -->
            <div
                class="group bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 group-hover:translate-x-full transition-transform duration-1000">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="w-3 h-3 bg-orange-400 rounded-full animate-pulse"></div>
                    </div>
                    <div class="text-3xl font-bold mb-2">{{ sprintf('%02d', count($parents ?? [])) }}</div>
                    <div class="text-green-100 font-semibold uppercase tracking-wide text-sm">Parents</div>
                    <div class="mt-3 text-xs text-green-200 flex items-center">
                        <i class="fas fa-heart mr-1"></i>
                        Communauté familiale
                    </div>
                </div>
            </div>

            <!-- Card Classes -->
            <div
                class="group bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 group-hover:translate-x-full transition-transform duration-1000">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-door-open text-2xl"></i>
                        </div>
                        <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse"></div>
                    </div>
                    <div class="text-3xl font-bold mb-2">{{ sprintf('%02d', count($classes ?? [])) }}</div>
                    <div class="text-orange-100 font-semibold uppercase tracking-wide text-sm">Classes</div>
                    <div class="mt-3 text-xs text-orange-200 flex items-center">
                        <i class="fas fa-building mr-1"></i>
                        Organisation scolaire
                    </div>
                </div>
            </div>
        </div>

        <!-- Deuxième rangée - Cards plus larges -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Card Matières -->
            <div
                class="group bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl shadow-xl p-8 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 group-hover:translate-x-full transition-transform duration-1000">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-4xl font-bold">{{ sprintf('%02d', count($subjects ?? [])) }}</div>
                            <div class="text-indigo-100 font-semibold uppercase tracking-wide">Matières</div>
                        </div>
                    </div>
                    <div class="text-indigo-200 flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Programme académique complet
                    </div>
                </div>
            </div>

            <!-- Card Résumé Global -->
            <div
                class="group bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-xl p-8 text-white transform hover:scale-105 hover:shadow-2xl transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -skew-x-12 group-hover:translate-x-full transition-transform duration-1000">
                </div>
                <div class="relative z-10">
                    <div class="text-center mb-6">
                        <h3
                            class="text-2xl font-bold mb-2 bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                            Système Global
                        </h3>
                        <p class="text-gray-400">Vue d'ensemble</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-white/5 rounded-xl">
                            <div class="text-2xl font-bold text-blue-400">
                                {{ count($students ?? []) + count($teachers ?? []) + count($parents ?? []) }}</div>
                            <div class="text-xs text-gray-400">Total Utilisateurs</div>
                        </div>
                        <div class="text-center p-3 bg-white/5 rounded-xl">
                            <div class="text-2xl font-bold text-green-400">100%</div>
                            <div class="text-xs text-gray-400">Système Actif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Actions Rapides -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <div
                    class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-bolt text-white text-sm"></i>
                </div>
                Actions Rapides
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('student.create') }}"
                    class="group p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 hover:shadow-md transform hover:scale-105">
                    <div
                        class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-gray-800 group-hover:text-blue-700">Nouvel Étudiant</div>
                    </div>
                </a>

                <a href="{{ route('teacher.create') }}"
                    class="group p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-300 hover:shadow-md transform hover:scale-105">
                    <div
                        class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chalkboard-teacher text-white"></i>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-gray-800 group-hover:text-purple-700">Nouvel Enseignant</div>
                    </div>
                </a>

                <a href="{{ route('classes.create') }}"
                    class="group p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 hover:shadow-md transform hover:scale-105">
                    <div
                        class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-gray-800 group-hover:text-green-700">Nouvelle Classe</div>
                    </div>
                </a>

                <a href="{{ route('attendance.index') }}"
                    class="group p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl hover:from-orange-100 hover:to-orange-200 transition-all duration-300 hover:shadow-md transform hover:scale-105">
                    <div
                        class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-gray-800 group-hover:text-orange-700">Voir Présences</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Animations personnalisées */
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
        }

        /* Animation d'apparition */
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
    </style>
@endsection
