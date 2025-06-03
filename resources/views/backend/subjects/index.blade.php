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
                                        <div
                                            class="w-8 h-8 bg-gradient-to-r from-green-400 to-emerald-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($subject->teacher->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $subject->teacher->user->name }}</p>
                                            <p class="text-xs text-gray-500">Professeur</p>
                                        </div>
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
@endsection
