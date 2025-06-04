@extends('layouts.app')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes sparkle {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.7;
                transform: scale(1.1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.6s ease-out;
        }

        .animate-bounceIn {
            animation: bounceIn 0.8s ease-out;
        }

        .animate-sparkle {
            animation: sparkle 2s ease-in-out infinite;
        }

        .glass {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.9);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .teacher-card {
            transition: all 0.3s ease;
        }

        .teacher-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-emerald-100 via-teal-50 to-cyan-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header avec animation -->
            <div class="flex items-center justify-between mb-8 animate-fadeIn">
                <div class="relative">
                    <h1
                        class="text-5xl font-extrabold bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                        Corps Enseignant
                    </h1>
                    <div
                        class="absolute -bottom-2 left-0 w-36 h-1 bg-gradient-to-r from-emerald-600 to-cyan-600 rounded-full">
                    </div>
                    <p class="mt-4 text-gray-600 font-medium">Gérez votre équipe pédagogique avec excellence</p>
                </div>

                <div class="animate-bounceIn">
                    <a href="{{ route('teacher.create') }}"
                        class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-2xl shadow-xl hover:from-green-600 hover:to-emerald-700 transition-all duration-300 hover:scale-105 hover:shadow-2xl animate-sparkle">
                        <svg class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Ajouter un Enseignant
                        <div
                            class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                </div>
            </div>

            <!-- Statistiques des enseignants -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-slideUp">
                <div
                    class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 teacher-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Enseignants</p>
                            <p class="text-3xl font-bold">{{ $teachers->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center animate-sparkle">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 teacher-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Enseignants Actifs</p>
                            <p class="text-3xl font-bold">{{ $teachers->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center animate-sparkle">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 teacher-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Matières Enseignées</p>
                            <p class="text-3xl font-bold">
                                {{ $teachers->sum(function ($teacher) {return $teacher->subjects->count();}) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center animate-sparkle">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 715.5 16c1.526 0 2.924-.39 4.5-.804zm7-4v10a7.969 7.969 0 01-4.5.804c-1.255 0-2.443-.29-3.5-.804V4.804A7.968 7.968 0 0114.5 4c1.526 0 2.924.39 4.5.804z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 teacher-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Nouveaux ce mois</p>
                            <p class="text-3xl font-bold">
                                {{ $teachers->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center animate-sparkle">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table moderne des enseignants -->
            <div
                class="glass rounded-3xl shadow-2xl border border-white/20 overflow-hidden hover:shadow-3xl transition-all duration-500">
                <!-- Header de la table -->
                <div class="bg-gradient-to-r from-gray-800 via-slate-800 to-gray-900 px-8 py-6">
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-2">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-emerald-400 rounded-full mr-3 animate-pulse"></div>
                                Enseignant
                            </h3>
                        </div>
                        <div class="col-span-3">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-blue-400 rounded-full mr-3 animate-pulse"></div>
                                Contact
                            </h3>
                        </div>
                        <div class="col-span-3">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-purple-400 rounded-full mr-3 animate-pulse"></div>
                                Matières Enseignées
                            </h3>
                        </div>
                        <div class="col-span-2">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-cyan-400 rounded-full mr-3 animate-pulse"></div>
                                Téléphone
                            </h3>
                        </div>
                        <div class="col-span-2 text-right">
                            <h3 class="text-white font-bold text-lg flex items-center justify-end">
                                <div class="w-3 h-3 bg-pink-400 rounded-full mr-3 animate-pulse"></div>
                                Actions
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Corps de la table -->
                <div class="divide-y divide-gray-100">
                    @foreach ($teachers as $index => $teacher)
                        <div class="group hover:bg-gradient-to-r hover:from-emerald-50 hover:to-cyan-50 transition-all duration-300 hover-scale teacher-card"
                            style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="grid grid-cols-12 gap-4 items-center px-8 py-6">
                                <!-- Enseignant avec photo -->
                                <div class="col-span-2">
                                    <div class="flex items-center space-x-4">
                                        @php
                                            $colors = [
                                                'from-emerald-500 to-teal-600',
                                                'from-blue-500 to-indigo-600',
                                                'from-purple-500 to-pink-600',
                                                'from-cyan-500 to-blue-600',
                                                'from-green-500 to-emerald-600',
                                                'from-teal-500 to-cyan-600',
                                            ];
                                            $colorClass = $colors[$index % count($colors)];
                                        @endphp
                                        <div class="relative">
                                            <div
                                                class="w-14 h-14 bg-gradient-to-br {{ $colorClass }} rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300 animate-sparkle">
                                                {{ strtoupper(substr($teacher->user->name, 0, 2)) }}
                                            </div>
                                            <div
                                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full animate-pulse">
                                            </div>
                                        </div>
                                        <div>
                                            <p
                                                class="font-bold text-gray-800 group-hover:text-emerald-700 transition-colors text-lg">
                                                {{ $teacher->user->name }}
                                            </p>
                                            <p class="text-sm text-gray-500 font-medium">
                                                @if ($teacher->gender === 'female')
                                                    Enseignante
                                                @else
                                                    Enseignant
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact -->
                                <div class="col-span-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                            <span
                                                class="text-gray-700 font-medium text-sm">{{ $teacher->user->email }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-gray-600 text-xs">
                                                {{ $teacher->dateofbirth ? \Carbon\Carbon::parse($teacher->dateofbirth)->age . ' ans' : 'Non renseigné' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Matières enseignées -->
                                <div class="col-span-3">
                                    <div class="flex flex-wrap gap-1">
                                        @if ($teacher->subjects && $teacher->subjects->count() > 0)
                                            @foreach ($teacher->subjects as $subjectIndex => $subject)
                                                @php
                                                    $subjectColors = [
                                                        'bg-gradient-to-r from-blue-500 to-blue-600',
                                                        'bg-gradient-to-r from-green-500 to-green-600',
                                                        'bg-gradient-to-r from-purple-500 to-purple-600',
                                                        'bg-gradient-to-r from-pink-500 to-pink-600',
                                                        'bg-gradient-to-r from-indigo-500 to-indigo-600',
                                                        'bg-gradient-to-r from-cyan-500 to-cyan-600',
                                                        'bg-gradient-to-r from-orange-500 to-orange-600',
                                                        'bg-gradient-to-r from-red-500 to-red-600',
                                                    ];
                                                    $subjectColorClass =
                                                        $subjectColors[$subjectIndex % count($subjectColors)];
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2 py-1 {{ $subjectColorClass }} text-white text-xs font-bold rounded-full shadow-md hover:scale-110 transition-transform duration-200 cursor-pointer">
                                                    {{ $subject->subject_code }}
                                                </span>
                                            @endforeach

                                            @if ($teacher->subjects->count() > 3)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 bg-gray-200 text-gray-600 text-xs rounded-full">
                                                    +{{ $teacher->subjects->count() - 3 }}
                                                </span>
                                            @endif
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-600 text-xs rounded-full">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Aucune matière
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Téléphone -->
                                <div class="col-span-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                        <span
                                            class="text-gray-700 font-medium">{{ $teacher->phone ?: 'Non renseigné' }}</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="col-span-2 flex justify-end space-x-2">
                                    <!-- Modifier -->
                                    <a href="{{ route('teacher.edit', $teacher->id) }}"
                                        class="group relative p-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 hover:scale-110 hover:shadow-xl"
                                        title="Modifier">
                                        <svg class="w-4 h-4 transition-transform group-hover:rotate-12"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>

                                        <!-- Tooltip -->
                                        <div
                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                            Modifier l'enseignant
                                            <div
                                                class="absolute top-full left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45">
                                            </div>
                                        </div>
                                    </a>

                                    <!-- Supprimer -->
                                    <button onclick="deleteTeacher('{{ route('teacher.destroy', $teacher->id) }}')"
                                        class="group relative p-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl shadow-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 hover:scale-110 hover:shadow-xl deletebtn"
                                        data-url="{{ route('teacher.destroy', $teacher->id) }}" title="Supprimer">
                                        <svg class="w-4 h-4 transition-transform group-hover:scale-110"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"
                                                clip-rule="evenodd" />
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 012 0v4a1 1 0 11-2 0V7zM12 7a1 1 0 012 0v4a1 1 0 11-2 0V7z"
                                                clip-rule="evenodd" />
                                        </svg>

                                        <!-- Tooltip -->
                                        <div
                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                            Supprimer l'enseignant
                                            <div
                                                class="absolute top-full left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45">
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($teachers->count() === 0)
                    <div class="text-center py-16">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-600 mb-3">Aucun enseignant trouvé</h3>
                        <p class="text-gray-500 mb-6 text-lg">Commencez par ajouter votre premier enseignant pour
                            construire votre équipe pédagogique.</p>
                        <a href="{{ route('teacher.create') }}"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold text-lg rounded-2xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Ajouter le premier enseignant
                        </a>
                    </div>
                @endif
            </div>

            <!-- Pagination moderne -->
            @if ($teachers->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-lg px-6 py-4 border border-gray-200">
                        {{ $teachers->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de suppression moderne -->
    <div id="deleteModal"
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-3xl p-8 max-w-md mx-4 shadow-2xl transform transition-all duration-300 scale-95">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Supprimer l'enseignant</h3>
                <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer cet enseignant ? Cette action est
                    irréversible et supprimera toutes les données associées.</p>

                <div class="flex space-x-4">
                    <button id="cancelDelete"
                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                        Annuler
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Conseils de gestion -->
    <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200 animate-slideUp">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd" />
            </svg>
            Conseils de Gestion du Corps Enseignant
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-700">
            <div class="bg-white p-4 rounded-xl border border-blue-200 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-2">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                    <p class="font-semibold">Profils Complets</p>
                </div>
                <p>Assurez-vous que chaque enseignant a un profil complet avec photo et coordonnées.</p>
            </div>
            <div class="bg-white p-4 rounded-xl border border-emerald-200 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-2">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                    <p class="font-semibold">Attribution des Matières</p>
                </div>
                <p>Assignez les matières selon les spécialisations et compétences de chaque enseignant.</p>
            </div>
            <div class="bg-white p-4 rounded-xl border border-purple-200 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-2">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-2"></div>
                    <p class="font-semibold">Communication</p>
                </div>
                <p>Maintenez les coordonnées à jour pour faciliter la communication institutionnelle.</p>
            </div>
            <div class="bg-white p-4 rounded-xl border border-orange-200 hover:shadow-md transition-shadow">
                <div class="flex items-center mb-2">
                    <div class="w-2 h-2 bg-orange-500 rounded-full mr-2"></div>
                    <p class="font-semibold">Suivi Régulier</p>
                </div>
                <p>Effectuez des révisions périodiques des informations et performances de l'équipe.</p>
            </div>
        </div>
    </div>

    @include('backend.modals.delete', ['name' => 'teacher'])
@endsection

@push('scripts')
    <script>
        // Fonction pour ouvrir le modal de suppression
        function deleteTeacher(url) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');

            form.action = url;
            modal.classList.remove('hidden');

            // Animation d'ouverture
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        }

        // Fermer le modal
        document.getElementById('cancelDelete').addEventListener('click', function() {
            const modal = document.getElementById('deleteModal');
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        });

        // Fermer en cliquant en dehors
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                document.getElementById('cancelDelete').click();
            }
        });

        // Code jQuery existant
        $(function() {
            $(".deletebtn").on("click", function(event) {
                event.preventDefault();
                $("#deletemodal").toggleClass("hidden");
                var url = $(this).attr('data-url');
                $(".remove-record").attr("action", url);
            });

            $("#deletemodelclose").on("click", function(event) {
                event.preventDefault();
                $("#deletemodal").toggleClass("hidden");
            });
        });
    </script>
@endpush
