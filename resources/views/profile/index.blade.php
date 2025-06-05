@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <!-- En-tête de profil moderne -->
        <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-purple-700 rounded-2xl shadow-2xl p-8 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center space-x-4 mb-6 sm:mb-0">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-user text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Mon Profil</h1>
                        <p class="text-blue-200 font-medium">Gérez vos informations personnelles</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('profile.edit') }}"
                        class="group inline-flex items-center px-6 py-3 bg-white/20 text-white font-semibold rounded-xl hover:bg-white/30 transition-all duration-300 hover:scale-105 backdrop-blur-sm border border-white/30">
                        <div class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </div>
                        <span>Modifier le Profil</span>
                        <div
                            class="absolute inset-0 bg-white/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Carte de profil principale -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-id-card text-white text-sm"></i>
                    </div>
                    Informations Personnelles
                </h2>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Informations de base -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Nom -->
                        <div
                            class="group p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-blue-600 uppercase tracking-wide">Nom
                                            Complet</label>
                                        <p class="text-xl font-bold text-gray-800 mt-1">{{ auth()->user()->name }}</p>
                                    </div>
                                </div>
                                <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div
                            class="group p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-green-600 uppercase tracking-wide">Adresse
                                            Email</label>
                                        <p class="text-xl font-bold text-gray-800 mt-1">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            </div>
                        </div>

                        <!-- Rôle -->
                        <div
                            class="group p-6 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl border border-purple-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-user-tag text-white"></i>
                                    </div>
                                    <div>
                                        <label
                                            class="text-sm font-medium text-purple-600 uppercase tracking-wide">Rôle</label>
                                        <div class="mt-1">
                                            <span
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-lg font-bold rounded-full shadow-lg">
                                                <i class="fas fa-crown mr-2"></i>
                                                {{ auth()->user()->roles[0]->name ?? 'Utilisateur' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-3 h-3 bg-purple-500 rounded-full animate-pulse"></div>
                            </div>
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-info-circle text-gray-600 mr-3"></i>
                                Informations Système
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div
                                    class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                                    <span class="text-sm font-medium text-gray-600">Date de création</span>
                                    <span
                                        class="text-sm font-bold text-gray-800">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div
                                    class="flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200">
                                    <span class="text-sm font-medium text-gray-600">Dernière connexion</span>
                                    <span class="text-sm font-bold text-gray-800">{{ now()->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section photo de profil -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-8">
                            <div
                                class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl p-6 text-center border border-gray-300 shadow-lg">
                                <div class="relative inline-block mb-6">
                                    <div
                                        class="w-40 h-40 mx-auto rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                                        <img class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500"
                                            src="{{ asset('images/profile/' . auth()->user()->profile_picture) }}"
                                            alt="Photo de profil">
                                    </div>
                                    <!-- Indicateur de statut -->
                                    <div
                                        class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 border-4 border-white rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                </div>

                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ auth()->user()->name }}</h3>
                                <p class="text-gray-600 font-medium mb-4">
                                    {{ auth()->user()->roles[0]->name ?? 'Utilisateur' }}</p>

                                <!-- Badge de vérification -->
                                <div
                                    class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    <i class="fas fa-shield-check mr-2"></i>
                                    Compte Vérifié
                                </div>

                                <!-- Statistiques rapides -->
                                <div class="mt-6 pt-6 border-t border-gray-300">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-800">
                                            {{ auth()->user()->created_at->diffInDays(now()) }}</div>
                                        <div class="text-sm text-gray-600">Jours d'ancienneté</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <div
                    class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-bolt text-white text-sm"></i>
                </div>
                Actions Rapides
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('profile.edit') }}"
                    class="group p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 hover:shadow-lg transform hover:scale-105 border border-blue-200">
                    <div
                        class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                    <div class="text-center">
                        <h4 class="font-bold text-gray-800 group-hover:text-blue-700 mb-2">Modifier le Profil</h4>
                        <p class="text-sm text-gray-600">Mettez à jour vos informations</p>
                    </div>
                </a>

                <a href="#"
                    class="group p-6 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-300 hover:shadow-lg transform hover:scale-105 border border-purple-200">
                    <div
                        class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-key text-white"></i>
                    </div>
                    <div class="text-center">
                        <h4 class="font-bold text-gray-800 group-hover:text-purple-700 mb-2">Changer le Mot de Passe</h4>
                        <p class="text-sm text-gray-600">Sécurisez votre compte</p>
                    </div>
                </a>

                <a href="#"
                    class="group p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 hover:shadow-lg transform hover:scale-105 border border-green-200">
                    <div
                        class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <div class="text-center">
                        <h4 class="font-bold text-gray-800 group-hover:text-green-700 mb-2">Préférences</h4>
                        <p class="text-sm text-gray-600">Personnalisez l'interface</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Animations personnalisées */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: slideInUp 0.6s ease forwards;
        }

        /* Effet de hover sur les cartes */
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Animation des badges */
        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
@endsection
