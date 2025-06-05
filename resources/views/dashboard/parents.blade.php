{{-- resources/views/parent/dashboard.blade.php ou home.blade.php pour les parents --}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 p-4">
        <!-- En-tête de bienvenue -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-pink-500 to-pink-600 p-6 text-white">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-heart text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">Espace Parent</h1>
                            <p class="text-pink-100">Bienvenue {{ auth()->user()->name }}</p>
                            <p class="text-pink-200 text-sm">Suivi parental personnalisé</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Nombre d'enfants -->
            <div
                class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Mes Enfants</p>
                        <p class="text-3xl font-bold mt-2">{{ $childrenCount ?? 0 }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-child text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Présences aujourd'hui -->
            <div
                class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Présents Aujourd'hui</p>
                        <p class="text-3xl font-bold mt-2">{{ $presentToday ?? 0 }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-calendar-check text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Taux de présence -->
            <div
                class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">Taux de Présence</p>
                        <p class="text-3xl font-bold mt-2">{{ $attendanceRate ?? 95 }}%</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des enfants -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-pink-500 to-pink-600 p-6">
                <h3 class="text-white text-xl font-bold flex items-center">
                    <i class="fas fa-heart mr-3"></i>
                    Mes Enfants
                </h3>
            </div>

            <div class="p-6">
                @if (isset($children) && count($children) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($children as $child)
                            <div
                                class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-pink-300 group">
                                <div class="p-6">
                                    <!-- Photo et infos de base -->
                                    <div class="text-center mb-4">
                                        <div
                                            class="w-20 h-20 bg-gradient-to-br from-pink-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-user-graduate text-white text-2xl"></i>
                                        </div>
                                        <h4
                                            class="text-gray-800 font-bold text-lg group-hover:text-pink-600 transition-colors">
                                            {{ $child->name ?? 'Nom Enfant' }}
                                        </h4>
                                        <p class="text-gray-600 text-sm">{{ $child->email ?? 'email@exemple.com' }}</p>
                                    </div>

                                    <!-- Informations académiques -->
                                    <div class="space-y-3 mb-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">Classe:</span>
                                            <span
                                                class="font-medium text-gray-800">{{ $child->class_name ?? 'Non assignée' }}</span>
                                        </div>

                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">Statut:</span>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                                                Actif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('student.show', $child->id ?? 1) }}"
                                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-200">
                                            <i class="fas fa-eye mr-1"></i>
                                            Voir Profil
                                        </a>
                                        <a href="{{ route('attendance.index') }}"
                                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-semibold rounded-lg hover:from-green-600 hover:to-green-700 transform hover:scale-105 transition-all duration-200">
                                            <i class="fas fa-calendar-check mr-1"></i>
                                            Présences
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Message si aucun enfant -->
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-child text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun enfant trouvé</h3>
                        <p class="text-gray-600 mb-6">Aucun enfant n'est actuellement associé à votre compte.</p>
                        <button
                            onclick="alert('Veuillez contacter l\'administration pour associer vos enfants à votre compte.')"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-500 to-pink-600 text-white font-semibold rounded-lg hover:from-pink-600 hover:to-pink-700 transition-all duration-200">
                            <i class="fas fa-envelope mr-2"></i>
                            Contacter l'Administration
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Section conseils et informations -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6">
                <h3 class="text-white text-xl font-bold flex items-center">
                    <i class="fas fa-lightbulb mr-3"></i>
                    Conseils pour un Suivi Efficace
                </h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Conseil 1 -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-calendar-alt text-white"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Vérifiez Régulièrement</h4>
                        <p class="text-gray-600 text-sm">Consultez les présences de vos enfants chaque semaine pour un suivi
                            optimal.</p>
                    </div>

                    <!-- Conseil 2 -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-comments text-white"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Communiquez</h4>
                        <p class="text-gray-600 text-sm">N'hésitez pas à échanger avec les enseignants sur le parcours de
                            vos enfants.</p>
                    </div>

                    <!-- Conseil 3 -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-trophy text-white"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Encouragez</h4>
                        <p class="text-gray-600 text-sm">Félicitez et encouragez vos enfants pour maintenir leur motivation
                            scolaire.</p>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <p class="text-gray-500 text-sm">
                        <i class="fas fa-info-circle mr-1"></i>
                        Dernière mise à jour: {{ now()->format('d/m/Y à H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styles pour améliorer l'affichage */
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

        /* Animation d'apparition échelonnée */
        .fade-in:nth-child(1) {
            animation-delay: 0.1s;
        }

        .fade-in:nth-child(2) {
            animation-delay: 0.2s;
        }

        .fade-in:nth-child(3) {
            animation-delay: 0.3s;
        }

        /* Améliorations responsives */
        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        /* Effet hover pour les cartes */
        .group:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
