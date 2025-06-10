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

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
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

        .animate-shimmer {
            animation: shimmer 2s ease-in-out infinite;
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

        .shimmer {
            position: relative;
            overflow: hidden;
        }

        .shimmer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s ease-in-out infinite;
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

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
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

    <div class="min-h-screen bg-gradient-to-br from-orange-100 via-yellow-50 to-red-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header avec animation -->
            <div class="flex items-center justify-between mb-8 animate-fadeIn">
                <div class="relative">
                    <h1
                        class="text-5xl font-extrabold bg-gradient-to-r from-orange-600 via-yellow-600 to-red-600 bg-clip-text text-transparent mb-2">
                        Gestion des Matières
                    </h1>
                    <div class="absolute -bottom-2 left-0 w-40 h-1 bg-gradient-to-r from-orange-600 to-red-600 rounded-full">
                    </div>
                    <p class="mt-4 text-gray-600 font-medium">Organisez et gérez toutes les matières académiques</p>
                </div>

                <div class="animate-bounceIn">
                    <a href="{{ route('subject.create') }}"
                        class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-2xl shadow-xl hover:from-green-600 hover:to-emerald-700 transition-all duration-300 hover:scale-105 hover:shadow-2xl shimmer">
                        <svg class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Ajouter une Matière
                        <div
                            class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                    <button id="openSubjectBulkImport"
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

            <!-- Statistiques des matières -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-slideUp">
                <div
                    class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 shimmer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Matières</p>
                            <p class="text-3xl font-bold">{{ $subjects->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 715.5 16c1.526 0 2.924-.39 4.5-.804zm7-4v10a7.969 7.969 0 01-4.5.804c-1.255 0-2.443-.29-3.5-.804V4.804A7.968 7.968 0 0114.5 4c1.526 0 2.924.39 4.5.804z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 shimmer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Enseignants Assignés</p>
                            <p class="text-3xl font-bold">{{ $subjects->unique('teacher_id')->count() }}</p>
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
                    class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 shimmer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Matières Actives</p>
                            <p class="text-3xl font-bold">{{ $subjects->count() }}</p>
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
                    class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 shimmer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Nouvelles ce mois</p>
                            <p class="text-3xl font-bold">
                                {{ $subjects->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
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

            <!-- Table moderne des matières -->
            <div
                class="glass rounded-3xl shadow-2xl border border-white/20 overflow-hidden hover:shadow-3xl transition-all duration-500">
                <!-- Header de la table -->
                <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black px-8 py-6">
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-3">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-orange-400 rounded-full mr-3 animate-pulse"></div>
                                Nom de la Matière
                            </h3>
                        </div>
                        <div class="col-span-2">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                                Code
                            </h3>
                        </div>
                        <div class="col-span-2">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-green-400 rounded-full mr-3 animate-pulse"></div>
                                Enseignant
                            </h3>
                        </div>
                        <div class="col-span-3">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="w-3 h-3 bg-purple-400 rounded-full mr-3 animate-pulse"></div>
                                Description
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
                    @foreach ($subjects as $index => $subject)
                        <div class="group hover:bg-gradient-to-r hover:from-orange-50 hover:to-yellow-50 transition-all duration-300 hover-scale"
                            style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="grid grid-cols-12 gap-4 items-center px-8 py-6">
                                <!-- Nom avec icône colorée -->
                                <div class="col-span-3">
                                    <div class="flex items-center space-x-4">
                                        @php
                                            $colors = [
                                                'from-orange-500 to-red-600',
                                                'from-blue-500 to-indigo-600',
                                                'from-green-500 to-emerald-600',
                                                'from-purple-500 to-pink-600',
                                                'from-cyan-500 to-teal-600',
                                                'from-yellow-500 to-orange-600',
                                            ];
                                            $colorClass = $colors[$index % count($colors)];
                                        @endphp
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br {{ $colorClass }} rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                {{ strtoupper(substr($subject->name, 0, 2)) }}
                                            </div>
                                            <div
                                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full">
                                            </div>
                                        </div>
                                        <div>
                                            <p
                                                class="font-bold text-gray-800 group-hover:text-orange-700 transition-colors text-lg">
                                                {{ $subject->name }}
                                            </p>
                                            <p class="text-sm text-gray-500 font-medium">
                                                Matière académique
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Code -->
                                <div class="col-span-2">
                                    <div
                                        class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 border border-blue-200 rounded-xl">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-bold text-blue-800">{{ $subject->subject_code }}</span>
                                    </div>
                                </div>

                                <!-- Enseignant -->
                                <div class="col-span-2">
                                    <div class="flex items-center space-x-3">
                                        @if ($subject->teacher && $subject->teacher->user)
                                            <div
                                                class="w-8 h-8 bg-gradient-to-r from-green-400 to-emerald-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr($subject->teacher->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $subject->teacher->user->name }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    @if ($subject->teachers && $subject->teachers->count() > 0)
                                                        Responsable + {{ $subject->teachers->count() }} autre(s)
                                                    @else
                                                        Professeur responsable
                                                    @endif
                                                </p>
                                            </div>
                                        @else
                                            <div
                                                class="w-8 h-8 bg-gray-300 rounded-lg flex items-center justify-center text-gray-500 font-bold text-sm">
                                                ?
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-500">Aucun enseignant</p>
                                                <p class="text-xs text-gray-400">Non assigné</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-span-3">
                                    <div class="relative">
                                        <p class="text-gray-700 font-medium line-clamp-2 text-sm leading-relaxed">
                                            {{ Str::limit($subject->description, 80) ?: 'Aucune description disponible' }}
                                        </p>
                                        @if (strlen($subject->description) > 80)
                                            <div
                                                class="absolute bottom-0 right-0 bg-gradient-to-l from-white via-white to-transparent pl-4">
                                                <span
                                                    class="text-xs text-blue-600 font-medium cursor-pointer hover:text-blue-800">...voir
                                                    plus</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="col-span-2 flex justify-end space-x-2">
                                    <!-- Modifier -->
                                    <a href="{{ route('subject.edit', $subject->id) }}"
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
                                            Modifier la matière
                                            <div
                                                class="absolute top-full left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45">
                                            </div>
                                        </div>
                                    </a>

                                    <!-- Supprimer -->
                                    <form action="{{ route('subject.destroy', $subject->id) }}" method="POST"
                                        class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette matière?')"
                                            class="group relative p-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl shadow-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 hover:scale-110 hover:shadow-xl"
                                            title="Supprimer">
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
                                                Supprimer la matière
                                                <div
                                                    class="absolute top-full left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45">
                                                </div>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($subjects->count() === 0)
                    <div class="text-center py-16">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-600 mb-3">Aucune matière trouvée</h3>
                        <p class="text-gray-500 mb-6 text-lg">Commencez par ajouter votre première matière académique.</p>
                        <a href="{{ route('subject.create') }}"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-red-600 text-white font-bold text-lg rounded-2xl shadow-lg hover:from-orange-600 hover:to-red-700 transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Ajouter la première matière
                        </a>
                    </div>
                @endif
            </div>

            <!-- Pagination moderne -->
            @if ($subjects->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-lg px-6 py-4 border border-gray-200">
                        {{ $subjects->links() }}
                    </div>
                </div>
            @endif

            <!-- Conseils et astuces -->
            <div
                class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200 animate-slideUp">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    Conseils de Gestion
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-700">
                    <div class="bg-white p-4 rounded-xl border border-blue-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                            <p class="font-semibold">Organisation</p>
                        </div>
                        <p>Utilisez des codes numériques logiques pour organiser vos matières par niveau ou département.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-green-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <p class="font-semibold">Attribution</p>
                        </div>
                        <p>Assignez toujours un enseignant qualifié à chaque matière pour assurer la qualité pédagogique.
                        </p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-purple-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-2">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-2"></div>
                            <p class="font-semibold">Description</p>
                        </div>
                        <p>Rédigez des descriptions claires incluant les objectifs et le contenu de chaque matière.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-orange-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-2">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mr-2"></div>
                            <p class="font-semibold">Mise à jour</p>
                        </div>
                        <p>Révisez régulièrement le contenu et les objectifs pour rester aligné avec les programmes.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal d'import en lot pour matières -->
    <div id="subjectBulkImportModal"
        class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="glass rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl animate-slideDown">
            <!-- Header du modal -->
            <div class="bg-gradient-to-r from-orange-600 via-yellow-600 to-red-600 px-8 py-6 rounded-t-3xl">
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
                            <h3 class="text-2xl font-bold text-white">Import en Lot de Matières</h3>
                            <p class="text-orange-100 font-medium">Importez plusieurs matières depuis un fichier Excel ou
                                CSV</p>
                        </div>
                    </div>
                    <button id="closeSubjectBulkImport" class="p-2 hover:bg-white/20 rounded-xl transition-colors">
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
                        <div id="subjectStep1" class="flex items-center step active">
                            <div
                                class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-full flex items-center justify-center font-bold mr-3">
                                1</div>
                            <span class="font-semibold text-gray-700">Télécharger le modèle</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 mx-4 rounded-full">
                            <div class="h-full bg-gradient-to-r from-orange-500 to-red-600 rounded-full subjectStep1-progress"
                                style="width: 0%"></div>
                        </div>
                        <div id="subjectStep2" class="flex items-center step">
                            <div
                                class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-bold mr-3">
                                2</div>
                            <span class="font-semibold text-gray-500">Importer le fichier</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 mx-4 rounded-full">
                            <div class="h-full bg-gradient-to-r from-orange-500 to-red-600 rounded-full subjectStep2-progress"
                                style="width: 0%"></div>
                        </div>
                        <div id="subjectStep3" class="flex items-center step">
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
                    <div id="subjectDownloadSection"
                        class="bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl p-6 border border-orange-200">
                        <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                    clip-rule="evenodd" />
                            </svg>
                            Étape 1: Télécharger le modèle de fichier
                        </h4>
                        <p class="text-gray-600 mb-4">Téléchargez le modèle Excel avec les colonnes requises et
                            remplissez-le avec les données des matières.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white rounded-xl p-4 border border-orange-200">
                                <h5 class="font-bold text-gray-800 mb-2">Colonnes obligatoires :</h5>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>nom (obligatoire)</li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>code_matiere (numérique)
                                    </li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>description</li>
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>email_enseignant</li>
                                </ul>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-orange-200">
                                <h5 class="font-bold text-gray-800 mb-2">Colonnes optionnelles :</h5>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li class="flex items-center"><span
                                            class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>emails_enseignants_additionnels
                                    </li>
                                    <li class="text-xs text-gray-500 mt-2">💡 Les emails additionnels doivent être séparés
                                        par des virgules</li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <a href="{{ route('subjects.download-template', 'excel') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                        clip-rule="evenodd" />
                                </svg>
                                Télécharger Modèle Excel
                            </a>
                            <a href="{{ route('subjects.download-template', 'csv') }}"
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
                    <div id="subjectUploadSection"
                        class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-200">
                        <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Étape 2: Importer votre fichier
                        </h4>

                        <form id="subjectImportForm" action="{{ route('subjects.bulk-import') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="file-upload-area bg-white rounded-xl p-8 text-center border-2 border-dashed border-gray-300 hover:border-purple-400 transition-all duration-300 cursor-pointer"
                                id="subjectFileDropArea">
                                <div id="subjectUploadContent">
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
                                <input type="file" id="subjectFileInput" name="import_file" accept=".xlsx,.xls,.csv"
                                    class="hidden">
                            </div>

                            <!-- Informations du fichier sélectionné -->
                            <div id="subjectFileInfo" class="hidden mt-4 bg-white rounded-xl p-4 border border-gray-200">
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
                                            <p id="subjectFileName" class="font-semibold text-gray-800"></p>
                                            <p id="subjectFileSize" class="text-sm text-gray-500"></p>
                                        </div>
                                    </div>
                                    <button type="button" id="subjectRemoveFile"
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
                            <div id="subjectProgressSection" class="hidden mt-4">
                                <div class="bg-gray-200 rounded-full h-3 mb-2">
                                    <div id="subjectProgressBar"
                                        class="bg-gradient-to-r from-orange-500 to-red-600 h-3 rounded-full progress-bar">
                                    </div>
                                </div>
                                <p id="subjectProgressText" class="text-sm text-gray-600 text-center">Importation en
                                    cours...</p>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex justify-end space-x-4 mt-6">
                                <button type="button" id="subjectCancelImport"
                                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                                    Annuler
                                </button>
                                <button type="submit" id="subjectStartImport" disabled
                                    class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white font-bold rounded-xl shadow-lg hover:from-orange-600 hover:to-red-700 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
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
                    <div id="subjectResultsSection"
                        class="hidden bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-200">
                        <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Résultat de l'importation
                        </h4>
                        <div id="subjectImportResults" class="space-y-4">
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
                        Assurez-vous que vos enseignants existent avant d'importer les matières
                    </p>
                    <button id="subjectCloseModalFooter" class="text-gray-400 hover:text-gray-600 transition-colors">
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
        // Variables globales pour les matières
        let selectedSubjectFile = null;

        // Éléments DOM pour les matières
        const subjectModal = document.getElementById('subjectBulkImportModal');
        const openSubjectBtn = document.getElementById('openSubjectBulkImport');
        const closeSubjectBtns = [
            document.getElementById('closeSubjectBulkImport'),
            document.getElementById('subjectCloseModalFooter')
        ];
        const subjectFileDropArea = document.getElementById('subjectFileDropArea');
        const subjectFileInput = document.getElementById('subjectFileInput');
        const subjectFileInfo = document.getElementById('subjectFileInfo');
        const subjectFileName = document.getElementById('subjectFileName');
        const subjectFileSize = document.getElementById('subjectFileSize');
        const subjectRemoveFileBtn = document.getElementById('subjectRemoveFile');
        const subjectStartImportBtn = document.getElementById('subjectStartImport');
        const subjectCancelImportBtn = document.getElementById('subjectCancelImport');
        const subjectProgressSection = document.getElementById('subjectProgressSection');
        const subjectProgressBar = document.getElementById('subjectProgressBar');
        const subjectProgressText = document.getElementById('subjectProgressText');
        const subjectResultsSection = document.getElementById('subjectResultsSection');
        const subjectImportResults = document.getElementById('subjectImportResults');

        // Ouvrir le modal des matières
        if (openSubjectBtn) {
            openSubjectBtn.addEventListener('click', function() {
                subjectModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        }

        // Fermer le modal des matières
        closeSubjectBtns.forEach(btn => {
            if (btn) {
                btn.addEventListener('click', closeSubjectModal);
            }
        });

        if (subjectCancelImportBtn) {
            subjectCancelImportBtn.addEventListener('click', closeSubjectModal);
        }

        function closeSubjectModal() {
            subjectModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            resetSubjectForm();
        }

        // Fermer en cliquant en dehors
        subjectModal.addEventListener('click', function(e) {
            if (e.target === subjectModal) {
                closeSubjectModal();
            }
        });

        // Gestion du drag & drop pour les matières
        subjectFileDropArea.addEventListener('click', () => subjectFileInput.click());

        subjectFileDropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        subjectFileDropArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        subjectFileDropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleSubjectFileSelect(files[0]);
            }
        });

        subjectFileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleSubjectFileSelect(e.target.files[0]);
            }
        });

        // Gérer la sélection de fichier pour les matières
        function handleSubjectFileSelect(file) {
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

            selectedSubjectFile = file;
            subjectFileName.textContent = file.name;
            subjectFileSize.textContent = formatFileSize(file.size);

            subjectFileInfo.classList.remove('hidden');
            subjectStartImportBtn.disabled = false;

            // Mettre à jour les étapes
            updateSubjectStep(1, true);
        }

        // Supprimer le fichier sélectionné
        if (subjectRemoveFileBtn) {
            subjectRemoveFileBtn.addEventListener('click', function() {
                selectedSubjectFile = null;
                subjectFileInput.value = '';
                subjectFileInfo.classList.add('hidden');
                subjectStartImportBtn.disabled = true;
                updateSubjectStep(1, false);
            });
        }

        // Mettre à jour les étapes pour les matières
        function updateSubjectStep(stepNumber, completed) {
            const steps = document.querySelectorAll('#subjectBulkImportModal .step');
            const progressBars = document.querySelectorAll('[class*="subjectStep"][class*="-progress"]');

            steps.forEach((step, index) => {
                const stepNum = index + 1;
                const circle = step.querySelector('div');
                const text = step.querySelector('span');

                if (stepNum <= stepNumber && completed) {
                    circle.className =
                        'w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-full flex items-center justify-center font-bold mr-3';
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

        // Gérer la soumission du formulaire des matières
        if (document.getElementById('subjectImportForm')) {
            document.getElementById('subjectImportForm').addEventListener('submit', function(e) {
                e.preventDefault();
                if (!selectedSubjectFile) return;

                startSubjectImport();
            });
        }

        // Démarrer l'importation des matières
        function startSubjectImport() {
            updateSubjectStep(2, true);
            subjectProgressSection.classList.remove('hidden');
            subjectStartImportBtn.disabled = true;

            // Faire l'appel AJAX réel
            const formData = new FormData();
            formData.append('import_file', selectedSubjectFile);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            $.ajax({
                url: '{{ route('subjects.bulk-import') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total * 100;
                            subjectProgressBar.style.width = percentComplete + '%';
                            subjectProgressText.textContent =
                                `Importation en cours... ${Math.round(percentComplete)}%`;
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    completeSubjectImport(response);
                },
                error: function(xhr) {
                    let errorMessage = 'Erreur lors de l\'importation';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert(errorMessage);
                    resetSubjectForm();
                }
            });
        }

        // Finaliser l'importation des matières
        function completeSubjectImport(response) {
            updateSubjectStep(3, true);
            subjectProgressSection.classList.add('hidden');
            subjectResultsSection.classList.remove('hidden');

            // Utiliser les vraies données de la réponse serveur
            showSubjectImportResults(response);
        }

        // Afficher les résultats d'importation des matières
        function showSubjectImportResults(results) {
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
                        <p class="text-sm text-gray-600">Matières importées</p>
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
            <button onclick="closeSubjectModal()" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
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

            subjectImportResults.innerHTML = resultsHTML;
        }

        // Réinitialiser le formulaire des matières
        function resetSubjectForm() {
            selectedSubjectFile = null;
            subjectFileInput.value = '';
            subjectFileInfo.classList.add('hidden');
            subjectProgressSection.classList.add('hidden');
            subjectResultsSection.classList.add('hidden');
            subjectStartImportBtn.disabled = true;

            // Réinitialiser les étapes
            updateSubjectStep(1, false);

            // Réinitialiser les classes des étapes
            document.getElementById('subjectStep1').querySelector('div').textContent = '1';
            document.getElementById('subjectStep2').querySelector('div').textContent = '2';
            document.getElementById('subjectStep3').querySelector('div').textContent = '3';
        }

        // Fonction utilitaire pour formater la taille du fichier
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
@endpush
