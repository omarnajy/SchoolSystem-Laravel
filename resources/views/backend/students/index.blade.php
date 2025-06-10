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

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.6s ease-out;
        }

        .animate-bounceIn {
            animation: bounceIn 0.8s ease-out;
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

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            to {
                opacity: 0;
                transform: translateY(-50px) scale(0.95);
            }
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.3s ease-out;
        }

        .file-upload-area {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s ease;
        }

        .file-upload-area.dragover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        .progress-bar {
            width: 0%;
            transition: width 0.3s ease;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-emerald-100 via-blue-50 to-purple-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header avec animation -->
            <div class="flex items-center justify-between mb-8 animate-fadeIn">
                <div class="relative">
                    <h1
                        class="text-5xl font-extrabold bg-gradient-to-r from-emerald-600 via-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                        Gestion des Étudiants
                    </h1>
                    <div
                        class="absolute -bottom-2 left-0 w-40 h-1 bg-gradient-to-r from-emerald-600 to-purple-600 rounded-full">
                    </div>
                    <p class="mt-4 text-gray-600 font-medium">Gérez tous les étudiants de votre établissement</p>
                </div>

                <div class="animate-bounceIn space-x-4">
                    <a href="{{ route('student.create') }}"
                        class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold rounded-2xl shadow-xl hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <svg class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Ajouter un Étudiant
                        <div
                            class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                    <button id="openBulkImport"
                        class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <svg class="w-5 h-5 mr-3 transition-transform group-hover:scale-110" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Import en Lot
                        <div
                            class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </button>
                </div>
            </div>

            <!-- Statistiques des étudiants -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-slideUp">
                <div
                    class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Étudiants</p>
                            <p class="text-3xl font-bold">{{ $students->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Étudiants Actifs</p>
                            <p class="text-3xl font-bold">{{ $students->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Classes Actives</p>
                            <p class="text-3xl font-bold">{{ $students->unique('class_id')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Nouveaux ce mois</p>
                            <p class="text-3xl font-bold">
                                {{ $students->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table moderne des étudiants -->
            <div
                class="glass rounded-3xl shadow-2xl border border-white/20 overflow-hidden hover:shadow-3xl transition-all duration-500">
                <!-- Header de la table -->
                <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black px-8 py-6">
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-3">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-blue-400 rounded-full mr-3 animate-pulse"></div>
                                Nom de l'Étudiant
                            </h3>
                        </div>
                        <div class="col-span-3">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-green-400 rounded-full mr-3 animate-pulse"></div>
                                Email
                            </h3>
                        </div>
                        <div class="col-span-2">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-purple-400 rounded-full mr-3 animate-pulse"></div>
                                Classe
                            </h3>
                        </div>
                        <div class="col-span-2">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-orange-400 rounded-full mr-3 animate-pulse"></div>
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
                    @foreach ($students as $index => $student)
                        <div class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 hover-scale"
                            style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="grid grid-cols-12 gap-4 items-center px-8 py-6">
                                <!-- Nom avec avatar -->
                                <div class="col-span-3">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-{{ ['blue', 'green', 'purple', 'pink', 'indigo', 'cyan', 'orange', 'red'][array_rand(['blue', 'green', 'purple', 'pink', 'indigo', 'cyan', 'orange', 'red'])] }}-500 to-{{ ['blue', 'green', 'purple', 'pink', 'indigo', 'cyan', 'orange', 'red'][array_rand(['blue', 'green', 'purple', 'pink', 'indigo', 'cyan', 'orange', 'red'])] }}-600 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                                {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                            </div>
                                            <div
                                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full">
                                            </div>
                                        </div>
                                        <div>
                                            <p
                                                class="font-bold text-gray-800 group-hover:text-blue-700 transition-colors text-lg">
                                                {{ $student->user->name }}
                                            </p>
                                            <p class="text-sm text-gray-500 font-medium">
                                                Matricule: {{ $student->roll_number }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-span-3">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        <span class="text-gray-700 font-medium">{{ $student->user->email }}</span>
                                    </div>
                                </div>

                                <!-- Classe -->
                                <div class="col-span-2">
                                    @if ($student->class)
                                        <span
                                            class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-sm font-bold rounded-full shadow-lg">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $student->class->class_name }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 bg-gray-200 text-gray-600 text-sm rounded-full">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Non assigné
                                        </span>
                                    @endif
                                </div>

                                <!-- Téléphone -->
                                <div class="col-span-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                        <span
                                            class="text-gray-700 font-medium">{{ $student->phone ?: 'Non renseigné' }}</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="col-span-2 flex justify-end space-x-2">
                                    <!-- Voir -->
                                    <a href="{{ route('student.show', $student->id) }}"
                                        class="group relative p-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 hover:scale-110 hover:shadow-xl"
                                        title="Voir le profil">
                                        <svg class="w-4 h-4 transition-transform group-hover:scale-110"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>

                                        <!-- Tooltip -->
                                        <div
                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                            Voir le profil
                                            <div
                                                class="absolute top-full left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45">
                                            </div>
                                        </div>
                                    </a>

                                    <!-- Modifier -->
                                    <a href="{{ route('student.edit', $student->id) }}"
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
                                            Modifier l'étudiant
                                            <div
                                                class="absolute top-full left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45">
                                            </div>
                                        </div>
                                    </a>

                                    <!-- Supprimer -->
                                    <button onclick="deleteStudent('{{ route('student.destroy', $student->id) }}')"
                                        class="group relative p-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl shadow-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 hover:scale-110 hover:shadow-xl deletestudent"
                                        data-url="{{ route('student.destroy', $student->id) }}" title="Supprimer">
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
                                            Supprimer l'étudiant
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

                @if ($students->count() === 0)
                    <div class="text-center py-16">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-600 mb-3">Aucun étudiant trouvé</h3>
                        <p class="text-gray-500 mb-6 text-lg">Commencez par ajouter votre premier étudiant pour démarrer la
                            gestion.</p>
                        <a href="{{ route('student.create') }}"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold text-lg rounded-2xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Ajouter le premier étudiant
                        </a>
                    </div>
                @endif
            </div>

            <!-- Pagination moderne -->
            @if ($students->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-lg px-6 py-4">
                        {{ $students->links() }}
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
                <h3 class="text-xl font-bold text-gray-900 mb-2">Supprimer l'étudiant</h3>
                <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer cet étudiant ? Cette action est
                    irréversible.</p>

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

    @include('backend.modals.delete', ['name' => 'student'])

    <!-- Modal d'import en lot -->
    <div id="bulkImportModal"
        class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="glass rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl animate-slideDown">
            <!-- Header du modal -->
            <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-600 px-8 py-6 rounded-t-3xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Import en Lot d'Étudiants</h3>
                            <p class="text-blue-100 font-medium">Importez plusieurs étudiants depuis un fichier Excel ou
                                CSV</p>
                        </div>
                    </div>
                    <button id="closeBulkImport" class="p-2 hover:bg-white/20 rounded-xl transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Corps du modal -->
            <div class="p-8">
                <!-- Étapes du processus -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div id="step1" class="flex items-center step active">
                            <div
                                class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                1</div>
                            <span class="font-semibold text-gray-700">Télécharger le modèle</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 mx-4 rounded-full">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full step1-progress"
                                style="width: 0%"></div>
                        </div>
                        <div id="step2" class="flex items-center step">
                            <div
                                class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-bold mr-3">
                                2</div>
                            <span class="font-semibold text-gray-500">Importer le fichier</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 mx-4 rounded-full">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full step2-progress"
                                style="width: 0%"></div>
                        </div>
                        <div id="step3" class="flex items-center step">
                            <div
                                class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-bold mr-3">
                                3</div>
                            <span class="font-semibold text-gray-500">Validation</span>
                        </div>
                    </div>
                </div>

                <!-- Contenu principal -->
                <div class="space-y-6">
                    <!-- Section 1: Télécharger le modèle -->
                    <div id="downloadSection"
                        class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
                        <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                    clip-rule="evenodd" />
                            </svg>
                            Étape 1: Télécharger le modèle de fichier
                        </h4>
                        <p class="text-gray-600 mb-4">Téléchargez le modèle Excel avec les colonnes requises et
                            remplissez-le avec les données des étudiants.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white rounded-xl p-4 border border-blue-200">
                                <h5 class="font-bold text-gray-800 mb-2">Colonnes requises :</h5>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>nom (obligatoire)</li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>email (obligatoire)</li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>mot_de_passe (obligatoire)
                                    </li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>numero_matricule</li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>telephone</li>
                                </ul>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-blue-200">
                                <h5 class="font-bold text-gray-800 mb-2">Colonnes optionnelles :</h5>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>genre (male/female)
                                    </li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>date_naissance
                                        (AAAA-MM-JJ)</li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>adresse_actuelle</li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>adresse_permanente</li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>nom_classe</li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <a href="{{ route('students.download-template', 'excel') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                        clip-rule="evenodd" />
                                </svg>
                                Télécharger Modèle Excel
                            </a>
                            <a href="{{ route('students.download-template', 'csv') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                        clip-rule="evenodd" />
                                </svg>
                                Télécharger Modèle CSV
                            </a>
                        </div>
                    </div>

                    <!-- Section 2: Zone d'upload -->
                    <div id="uploadSection"
                        class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-200">
                        <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Étape 2: Importer votre fichier
                        </h4>

                        <form id="importForm" action="{{ route('students.bulk-import') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="file-upload-area bg-white rounded-xl p-8 text-center border-2 border-dashed border-gray-300 hover:border-purple-400 transition-all duration-300 cursor-pointer"
                                id="fileDropArea">
                                <div id="uploadContent">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 48 48">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                                    </svg>
                                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Glissez-déposez votre fichier ici
                                    </h3>
                                    <p class="text-gray-500 mb-4">ou cliquez pour sélectionner un fichier</p>
                                    <p class="text-sm text-gray-400">Formats acceptés: .xlsx, .xls, .csv (max 10MB)</p>
                                </div>
                                <input type="file" id="fileInput" name="import_file" accept=".xlsx,.xls,.csv"
                                    class="hidden">
                            </div>

                            <!-- Informations du fichier sélectionné -->
                            <div id="fileInfo" class="hidden mt-4 bg-white rounded-xl p-4 border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p id="fileName" class="font-semibold text-gray-800"></p>
                                            <p id="fileSize" class="text-sm text-gray-500"></p>
                                        </div>
                                    </div>
                                    <button type="button" id="removeFile"
                                        class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Barre de progression -->
                            <div id="progressSection" class="hidden mt-4">
                                <div class="bg-gray-200 rounded-full h-3 mb-2">
                                    <div id="progressBar"
                                        class="bg-gradient-to-r from-purple-500 to-blue-600 h-3 rounded-full progress-bar">
                                    </div>
                                </div>
                                <p id="progressText" class="text-sm text-gray-600 text-center">Importation en cours...</p>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex justify-end space-x-4 mt-6">
                                <button type="button" id="cancelImport"
                                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                                    Annuler
                                </button>
                                <button type="submit" id="startImport" disabled
                                    class="px-8 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                                    <svg class="w-5 h-5 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Commencer l'Import
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Section 3: Résultats -->
                    <div id="resultsSection"
                        class="hidden bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-200">
                        <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Résultat de l'importation
                        </h4>
                        <div id="importResults" class="space-y-4">
                            <!-- Les résultats seront affichés ici -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer du modal -->
            <div class="bg-gray-50 px-8 py-4 rounded-b-3xl border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-500">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Assurez-vous que votre fichier respecte le format du modèle téléchargé
                    </p>
                    <button id="closeModalFooter" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Variables globales
        let selectedFile = null;

        // Éléments DOM
        const modal = document.getElementById('bulkImportModal');
        const openBtn = document.getElementById('openBulkImport');
        const closeBtns = [document.getElementById('closeBulkImport'), document.getElementById('closeModalFooter')];
        const fileDropArea = document.getElementById('fileDropArea');
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const removeFileBtn = document.getElementById('removeFile');
        const startImportBtn = document.getElementById('startImport');
        const cancelImportBtn = document.getElementById('cancelImport');
        const progressSection = document.getElementById('progressSection');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const resultsSection = document.getElementById('resultsSection');
        const importResults = document.getElementById('importResults');

        // Ouvrir le modal
        openBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        // Fermer le modal
        closeBtns.forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        cancelImportBtn.addEventListener('click', closeModal);

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            resetForm();
        }

        // Fermer en cliquant en dehors
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Gestion du drag & drop
        fileDropArea.addEventListener('click', () => fileInput.click());

        fileDropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        fileDropArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        fileDropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelect(files[0]);
            }
        });

        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });

        // Gérer la sélection de fichier
        function handleFileSelect(file) {
            // Vérifier le type de fichier
            const allowedTypes = [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-excel',
                'text/csv'
            ];

            if (!allowedTypes.includes(file.type)) {
                alert('Type de fichier non supporté. Veuillez sélectionner un fichier Excel (.xlsx, .xls) ou CSV.');
                return;
            }

            // Vérifier la taille (10MB max)
            if (file.size > 10 * 1024 * 1024) {
                alert('Le fichier est trop volumineux. Taille maximale: 10MB');
                return;
            }

            selectedFile = file;
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);

            fileInfo.classList.remove('hidden');
            startImportBtn.disabled = false;

            // Mettre à jour les étapes
            updateStep(1, true);
        }

        // Supprimer le fichier sélectionné
        removeFileBtn.addEventListener('click', function() {
            selectedFile = null;
            fileInput.value = '';
            fileInfo.classList.add('hidden');
            startImportBtn.disabled = true;
            updateStep(1, false);
        });

        // Formater la taille du fichier
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Mettre à jour les étapes
        function updateStep(stepNumber, completed) {
            const steps = document.querySelectorAll('.step');
            const progressBars = document.querySelectorAll('[class*="step"][class*="-progress"]');

            steps.forEach((step, index) => {
                const stepNum = index + 1;
                const circle = step.querySelector('div');
                const text = step.querySelector('span');

                if (stepNum <= stepNumber && completed) {
                    circle.className =
                        'w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-3';
                    text.className = 'font-semibold text-gray-700';

                    if (stepNum < stepNumber) {
                        circle.innerHTML =
                            `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>`;
                    }
                } else if (stepNum > stepNumber || !completed) {
                    circle.className =
                        'w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-bold mr-3';
                    text.className = 'font-semibold text-gray-500';
                    circle.textContent = stepNum;
                }
            });

            // Mettre à jour les barres de progression
            progressBars.forEach((bar, index) => {
                const stepNum = index + 1;
                if (stepNum < stepNumber && completed) {
                    bar.style.width = '100%';
                } else {
                    bar.style.width = '0%';
                }
            });
        }

        // Gérer la soumission du formulaire
        document.getElementById('importForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (!selectedFile) return;

            startImport();
        });

        // Démarrer l'importation
        function startImport() {
            updateStep(2, true);
            progressSection.classList.remove('hidden');
            startImportBtn.disabled = true;

            // Faire l'appel AJAX réel
            const formData = new FormData();
            formData.append('import_file', selectedFile);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            $.ajax({
                url: '{{ route('students.bulk-import') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total * 100;
                            progressBar.style.width = percentComplete + '%';
                            progressText.textContent =
                                `Importation en cours... ${Math.round(percentComplete)}%`;
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    completeImport(response);
                },
                error: function(xhr) {
                    let errorMessage = 'Erreur lors de l\'importation';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert(errorMessage);
                    resetForm();
                }
            });
        }


        // Finaliser l'importation
        function completeImport(response) {
            updateStep(3, true);
            progressSection.classList.add('hidden');
            resultsSection.classList.remove('hidden');

            // Utiliser les vraies données de la réponse serveur
            showImportResults(response);
        }

        // Afficher les résultats d'importation
        function showImportResults(results) {
            // S'assurer que les données sont correctes
            const successCount = results.success || 0;
            const errorCount = results.errors || 0;
            const totalCount = results.total || 0;
            const errorDetails = results.errorDetails || [];

            const resultsHTML = `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl p-4 border border-green-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-600">${successCount}</p>
                        <p class="text-sm text-gray-600">Importés avec succès</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-4 border border-red-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-red-600">${errorCount}</p>
                        <p class="text-sm text-gray-600">Erreurs</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-4 border border-blue-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-blue-600">${totalCount}</p>
                        <p class="text-sm text-gray-600">Total traité</p>
                    </div>
                </div>
            </div>
        </div>

        ${errorCount > 0 && errorDetails.length > 0 ? `
                                    <div class="bg-white rounded-xl p-4 border border-red-200">
                                        <h5 class="font-bold text-red-600 mb-3 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Détail des erreurs
                                        </h5>
                                        <div class="space-y-2">
                                            ${errorDetails.map(error => `
                    <div class="flex items-start p-3 bg-red-50 rounded-lg">
                        <span class="inline-flex items-center px-2 py-1 bg-red-200 text-red-800 text-xs font-bold rounded-full mr-3">
                            Ligne ${error.ligne || error.row || 'N/A'}
                        </span>
                        <span class="text-sm text-red-700">${error.erreur || error.message || error}</span>
                    </div>
                `).join('')}
                                        </div>
                                    </div>
                                    ` : ''}

        <div class="flex justify-end space-x-4 mt-6">
            <button onclick="closeModal()" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                Fermer
            </button>
            <button onclick="window.location.reload()" class="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 hover:scale-105">
                <svg class="w-5 h-5 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
                Actualiser la page
            </button>
        </div>
    `;

            importResults.innerHTML = resultsHTML;
        }

        // Réinitialiser le formulaire
        function resetForm() {
            selectedFile = null;
            fileInput.value = '';
            fileInfo.classList.add('hidden');
            progressSection.classList.add('hidden');
            resultsSection.classList.add('hidden');
            startImportBtn.disabled = true;

            // Réinitialiser les étapes
            updateStep(1, false);

            // Réinitialiser les classes des étapes
            document.getElementById('step1').querySelector('div').textContent = '1';
            document.getElementById('step2').querySelector('div').textContent = '2';
            document.getElementById('step3').querySelector('div').textContent = '3';
        }

        // Télécharger les modèles (à implémenter côté serveur)
        document.getElementById('downloadTemplate').addEventListener('click', function(e) {
            e.preventDefault();
            // Ici vous pouvez ajouter la logique pour télécharger le modèle Excel
            // window.location.href = '/download-template/excel';
            alert('Fonctionnalité de téléchargement à implémenter côté serveur');
        });

        document.getElementById('downloadCSVTemplate').addEventListener('click', function(e) {
            e.preventDefault();
            // Ici vous pouvez ajouter la logique pour télécharger le modèle CSV
            // window.location.href = '/download-template/csv';
            alert('Fonctionnalité de téléchargement à implémenter côté serveur');
        });

        // Fonction pour ouvrir le modal de suppression
        function deleteStudent(url) {
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
            $(".deletestudent").on("click", function(event) {
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
