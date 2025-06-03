@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header avec animation -->
            <div class="flex items-center justify-between mb-8 animate-fade-in">
                <div class="relative">
                    <h1
                        class="text-4xl font-extrabold bg-gradient-to-r from-slate-700 to-blue-600 bg-clip-text text-transparent">
                        Rôles & Permissions
                    </h1>
                    <div class="absolute -bottom-2 left-0 w-32 h-1 bg-gradient-to-r from-slate-700 to-blue-600 rounded-full">
                    </div>
                    <p class="mt-3 text-gray-600 font-medium">Gérez les rôles et permissions de votre système</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('role.create') }}"
                        class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 hover:scale-105 hover:shadow-xl glow-on-hover">
                        <svg class="w-4 h-4 mr-2 transition-transform group-hover:rotate-90" fill="currentColor"
                            viewBox="0 0 448 512">
                            <path
                                d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0-32-14.33-32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
                        </svg>
                        Nouveau Rôle
                        <div
                            class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>

                    <a href="{{ route('permission.create') }}"
                        class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-xl shadow-lg hover:from-purple-600 hover:to-pink-700 transition-all duration-300 hover:scale-105 hover:shadow-xl glow-on-hover">
                        <svg class="w-4 h-4 mr-2 transition-transform group-hover:rotate-90" fill="currentColor"
                            viewBox="0 0 448 512">
                            <path
                                d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0-32-14.33-32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
                        </svg>
                        Nouvelle Permission
                        <div
                            class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                </div>
            </div>

            <!-- Statistiques colorées -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-slide-up">
                <div
                    class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total des Rôles</p>
                            <p class="text-3xl font-bold">{{ count($roles) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">Permissions Actives</p>
                            <p class="text-3xl font-bold">
                                {{ $roles->sum(function ($role) {return $role->permissions->count();}) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Système Sécurisé</p>
                            <p class="text-3xl font-bold">100%</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table moderne avec couleurs vibrantes -->
            <div
                class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 overflow-hidden hover:shadow-3xl transition-all duration-500">
                <!-- Header de la table -->
                <div class="bg-gradient-to-r from-slate-800 via-gray-800 to-slate-900 px-8 py-6">
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-3">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-cyan-400 rounded-full mr-3 animate-pulse"></div>
                                Nom du Rôle
                            </h3>
                        </div>
                        <div class="col-span-7">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-pink-400 rounded-full mr-3 animate-pulse"></div>
                                Permissions Associées
                            </h3>
                        </div>
                        <div class="col-span-2 text-right">
                            <h3 class="text-white font-bold text-lg flex items-center justify-end">
                                <div class="w-3 h-3 bg-green-400 rounded-full mr-3 animate-pulse"></div>
                                Actions
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Corps de la table -->
                <div class="divide-y divide-gray-100">
                    @foreach ($roles as $index => $role)
                        <div class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 animate-fade-in-item"
                            style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="grid grid-cols-12 gap-4 items-center px-8 py-6">
                                <!-- Nom du rôle avec badge coloré -->
                                <div class="col-span-3">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-{{ ['blue', 'green', 'purple', 'pink', 'indigo', 'cyan'][array_rand(['blue', 'green', 'purple', 'pink', 'indigo', 'cyan'])] }}-500 to-{{ ['blue', 'green', 'purple', 'pink', 'indigo', 'cyan'][array_rand(['blue', 'green', 'purple', 'pink', 'indigo', 'cyan'])] }}-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                            {{ strtoupper(substr($role->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800 group-hover:text-blue-700 transition-colors">
                                                {{ $role->name }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $role->permissions->count() }} permission(s)
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Permissions avec badges colorés -->
                                <div class="col-span-7">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($role->permissions as $permissionIndex => $permission)
                                            @php
                                                $colors = [
                                                    'bg-gradient-to-r from-blue-500 to-blue-600',
                                                    'bg-gradient-to-r from-green-500 to-green-600',
                                                    'bg-gradient-to-r from-purple-500 to-purple-600',
                                                    'bg-gradient-to-r from-pink-500 to-pink-600',
                                                    'bg-gradient-to-r from-indigo-500 to-indigo-600',
                                                    'bg-gradient-to-r from-cyan-500 to-cyan-600',
                                                    'bg-gradient-to-r from-orange-500 to-orange-600',
                                                    'bg-gradient-to-r from-red-500 to-red-600',
                                                    'bg-gradient-to-r from-teal-500 to-teal-600',
                                                    'bg-gradient-to-r from-yellow-500 to-yellow-600',
                                                ];
                                                $colorClass = $colors[$permissionIndex % count($colors)];
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-3 py-1 {{ $colorClass }} text-white text-sm font-medium rounded-full shadow-lg hover:scale-110 transition-transform duration-200 cursor-pointer">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach

                                        @if ($role->permissions->count() === 0)
                                            <span
                                                class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-600 text-sm rounded-full">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Aucune permission
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions avec animation -->
                                <div class="col-span-2 flex justify-end">
                                    <a href="{{ route('role.edit', $role->id) }}"
                                        class="group relative p-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 hover:scale-110 hover:shadow-xl">
                                        <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        <div
                                            class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>

                                        <!-- Tooltip -->
                                        <div
                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                            Modifier ce rôle
                                            <div
                                                class="absolute top-full left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($roles->count() === 0)
                    <div class="text-center py-16">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-600 mb-2">Aucun rôle trouvé</h3>
                        <p class="text-gray-500 mb-6">Commencez par créer votre premier rôle pour organiser les
                            permissions.</p>
                        <a href="{{ route('role.create') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Créer le premier rôle
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-item {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }

        .animate-slide-up {
            animation: slide-up 0.6s ease-out 0.2s both;
        }

        .animate-fade-in-item {
            animation: fade-in-item 0.5s ease-out both;
        }

        .hover\:shadow-3xl:hover {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
        }

        .glow-on-hover:hover {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }

        /* Animation pour les badges de permissions */
        .group:hover .permission-badge {
            transform: translateY(-2px);
        }
    </style>
@endsection
