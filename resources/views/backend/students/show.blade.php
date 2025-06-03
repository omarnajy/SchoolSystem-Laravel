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

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.6s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.6s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
        }

        .glass {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.9);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header avec animation -->
            <div class="flex items-center justify-between mb-8 animate-fadeIn">
                <div class="relative">
                    <h1
                        class="text-5xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        Profil de l'Étudiant
                    </h1>
                    <div
                        class="absolute -bottom-2 left-0 w-36 h-1 bg-gradient-to-r from-indigo-600 to-pink-600 rounded-full">
                    </div>
                    <p class="mt-4 text-gray-600 font-medium">Détails complets du profil étudiant</p>
                </div>

                <div class="animate-pulse-slow">
                    <a href="{{ route('student.index') }}"
                        class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-700 to-gray-800 text-white font-bold rounded-2xl shadow-xl hover:from-gray-800 hover:to-gray-900 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <svg class="w-5 h-5 mr-3 transition-transform group-hover:-translate-x-1" fill="currentColor"
                            viewBox="0 0 448 512">
                            <path
                                d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                        </svg>
                        Retour à la Liste
                        <div
                            class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                </div>
            </div>

            <!-- Layout principal avec deux colonnes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Colonne gauche - Informations de l'étudiant -->
                <div class="space-y-6 animate-slideInLeft">

                    <!-- Carte principale avec photo -->
                    <div class="glass rounded-3xl shadow-2xl border border-white/20 p-8 card-hover">
                        <!-- Photo de profil -->
                        <div class="text-center mb-8">
                            <div class="relative inline-block">
                                <img class="w-40 h-40 rounded-3xl shadow-2xl border-4 border-white object-cover mx-auto"
                                    src="{{ asset('images/profile/' . $student->user->profile_picture) }}"
                                    alt="Photo de {{ $student->user->name }}">
                                <div
                                    class="absolute -bottom-2 -right-2 w-8 h-8 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <h2 class="mt-4 text-3xl font-bold text-gray-800">{{ $student->user->name }}</h2>
                            <p class="text-lg text-gray-600 font-medium">Étudiant actif</p>

                            <!-- Badge de classe -->
                            @if ($student->class)
                                <div
                                    class="mt-4 inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold rounded-full shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $student->class->class_name }}
                                </div>
                            @endif
                        </div>

                        <!-- Informations détaillées -->
                        <div class="space-y-6">

                            <!-- Informations de base -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <div
                                        class="w-6 h-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    Informations Personnelles
                                </h3>

                                <div class="grid grid-cols-1 gap-4">
                                    <div
                                        class="flex items-center justify-between py-3 border-b border-blue-200 last:border-b-0">
                                        <span class="font-semibold text-gray-700 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                            Email
                                        </span>
                                        <span class="text-gray-800 font-medium">{{ $student->user->email }}</span>
                                    </div>

                                    <div
                                        class="flex items-center justify-between py-3 border-b border-blue-200 last:border-b-0">
                                        <span class="font-semibold text-gray-700 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM9 9a1 1 0 012 0v4a1 1 0 11-2 0V9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Matricule
                                        </span>
                                        <span class="text-gray-800 font-medium">{{ $student->roll_number }}</span>
                                    </div>

                                    <div
                                        class="flex items-center justify-between py-3 border-b border-blue-200 last:border-b-0">
                                        <span class="font-semibold text-gray-700 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                            </svg>
                                            Téléphone
                                        </span>
                                        <span
                                            class="text-gray-800 font-medium">{{ $student->phone ?: 'Non renseigné' }}</span>
                                    </div>

                                    <div
                                        class="flex items-center justify-between py-3 border-b border-blue-200 last:border-b-0">
                                        <span class="font-semibold text-gray-700 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Genre
                                        </span>
                                        <span class="text-gray-800 font-medium capitalize">{{ $student->gender }}</span>
                                    </div>

                                    <div
                                        class="flex items-center justify-between py-3 border-b border-blue-200 last:border-b-0">
                                        <span class="font-semibold text-gray-700 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Date de naissance
                                        </span>
                                        <span class="text-gray-800 font-medium">{{ $student->dateofbirth }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Adresses -->
                            <div
                                class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-200">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <div
                                        class="w-6 h-6 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    Adresses
                                </h3>

                                <div class="space-y-4">
                                    <div class="p-4 bg-white rounded-xl border border-green-200">
                                        <p class="font-semibold text-gray-700 mb-2 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Adresse Actuelle
                                        </p>
                                        <p class="text-gray-800">{{ $student->current_address ?: 'Non renseignée' }}</p>
                                    </div>

                                    <div class="p-4 bg-white rounded-xl border border-green-200">
                                        <p class="font-semibold text-gray-700 mb-2 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-rose-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                            </svg>
                                            Adresse Permanente
                                        </p>
                                        <p class="text-gray-800">{{ $student->permanent_address ?: 'Non renseignée' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations du parent -->
                            @if ($student->parent)
                                <div
                                    class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl p-6 border border-yellow-200">
                                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                        <div
                                            class="w-6 h-6 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        Informations du Parent
                                    </h3>

                                    <div class="grid grid-cols-1 gap-4">
                                        <div
                                            class="flex items-center justify-between py-3 border-b border-yellow-200 last:border-b-0">
                                            <span class="font-semibold text-gray-700">Nom</span>
                                            <span
                                                class="text-gray-800 font-medium">{{ $student->parent->user->name }}</span>
                                        </div>

                                        <div
                                            class="flex items-center justify-between py-3 border-b border-yellow-200 last:border-b-0">
                                            <span class="font-semibold text-gray-700">Email</span>
                                            <span
                                                class="text-gray-800 font-medium">{{ $student->parent->user->email }}</span>
                                        </div>

                                        <div
                                            class="flex items-center justify-between py-3 border-b border-yellow-200 last:border-b-0">
                                            <span class="font-semibold text-gray-700">Téléphone</span>
                                            <span
                                                class="text-gray-800 font-medium">{{ $student->parent->phone ?: 'Non renseigné' }}</span>
                                        </div>

                                        <div
                                            class="flex items-center justify-between py-3 border-b border-yellow-200 last:border-b-0">
                                            <span class="font-semibold text-gray-700">Adresse</span>
                                            <span
                                                class="text-gray-800 font-medium">{{ $student->parent->current_address ?: 'Non renseignée' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Colonne droite - Matières de la classe -->
                <div class="animate-slideInRight">
                    <div class="glass rounded-3xl shadow-2xl border border-white/20 p-8 card-hover h-fit">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <div
                                class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 005.5 16c1.526 0 2.924-.39 4.5-.804zm7-4v10a7.969 7.969 0 01-4.5.804c-1.255 0-2.443-.29-3.5-.804V4.804A7.968 7.968 0 0114.5 4c1.526 0 2.924.39 4.5.804z" />
                                </svg>
                            </div>
                            Matières de la Classe {{ $class->class_name ?? 'Non assignée' }}
                        </h3>

                        @if (isset($class) && $class->subjects && $class->subjects->count() > 0)
                            <!-- Header du tableau -->
                            <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-t-2xl p-4 mb-1">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-white font-bold text-sm flex items-center">
                                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                        Code
                                    </div>
                                    <div class="text-white font-bold text-sm flex items-center">
                                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                        Matière
                                    </div>
                                    <div class="text-white font-bold text-sm text-right flex items-center justify-end">
                                        <div class="w-2 h-2 bg-purple-400 rounded-full mr-2"></div>
                                        Enseignant
                                    </div>
                                </div>
                            </div>

                            <!-- Corps du tableau -->
                            <div class="space-y-1">
                                @foreach ($class->subjects as $index => $subject)
                                    @php
                                        $colors = [
                                            'from-blue-500 to-blue-600',
                                            'from-green-500 to-green-600',
                                            'from-purple-500 to-purple-600',
                                            'from-pink-500 to-pink-600',
                                            'from-indigo-500 to-indigo-600',
                                            'from-cyan-500 to-cyan-600',
                                            'from-orange-500 to-orange-600',
                                            'from-red-500 to-red-600',
                                            'from-teal-500 to-teal-600',
                                            'from-yellow-500 to-yellow-600',
                                        ];
                                        $colorClass = $colors[$index % count($colors)];
                                    @endphp

                                    <div
                                        class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-300 hover:scale-[1.02] group">
                                        <div class="grid grid-cols-3 gap-4 items-center">
                                            <!-- Code de la matière -->
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 bg-gradient-to-r {{ $colorClass }} rounded-xl flex items-center justify-center text-white font-bold text-sm mr-3 shadow-lg">
                                                    {{ strtoupper(substr($subject->subject_code, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-800 text-sm">
                                                        {{ $subject->subject_code }}</p>
                                                    <p class="text-xs text-gray-500">Code</p>
                                                </div>
                                            </div>

                                            <!-- Nom de la matière -->
                                            <div class="text-center">
                                                <p
                                                    class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">
                                                    {{ $subject->name }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.526 0 2.924-.39 4.5-.804zm7-4v10a7.969 7.969 0 01-4.5.804c-1.255 0-2.443-.29-3.5-.804V4.804A7.968 7.968 0 0114.5 4c1.526 0 2.924.39 4.5.804z" />
                                                    </svg>
                                                    Matière principale
                                                </p>
                                            </div>

                                            <!-- Enseignant -->
                                            <div class="text-right">
                                                <div class="flex items-center justify-end">
                                                    <div class="text-right mr-3">
                                                        <p class="font-semibold text-gray-800">
                                                            {{ $subject->teacher->user->name }}</p>
                                                        <p class="text-xs text-gray-500">Professeur</p>
                                                    </div>
                                                    <div
                                                        class="w-8 h-8 bg-gradient-to-r from-gray-400 to-gray-500 rounded-lg flex items-center justify-center text-white font-bold text-xs">
                                                        {{ strtoupper(substr($subject->teacher->user->name, 0, 2)) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Statistiques de la classe -->
                            <div
                                class="mt-8 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-200">
                                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd"
                                            d="M4 5a2 2 0 012-2v1a2 2 0 00-2 2v6a2 2 0 002 2h2v1a2 2 0 002 2h8a2 2 0 002-2v-6a2 2 0 00-2-2h-2V4a2 2 0 00-2-2H6zm0 1v4h4V6H4zm0 6h4v4H4v-4zm6 0h4v4h-4v-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Statistiques de la Classe
                                </h4>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-4 bg-white rounded-xl border border-indigo-200">
                                        <div class="text-2xl font-bold text-indigo-600">{{ $class->subjects->count() }}
                                        </div>
                                        <div class="text-sm text-gray-600 font-medium">Matières</div>
                                    </div>
                                    <div class="text-center p-4 bg-white rounded-xl border border-indigo-200">
                                        <div class="text-2xl font-bold text-purple-600">
                                            {{ $class->subjects->unique('teacher_id')->count() }}</div>
                                        <div class="text-sm text-gray-600 font-medium">Enseignants</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- État vide -->
                            <div class="text-center py-12">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl mx-auto mb-4 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-600 mb-2">Aucune matière</h4>
                                <p class="text-gray-500">
                                    @if (!isset($class))
                                        Cet étudiant n'est assigné à aucune classe.
                                    @else
                                        Aucune matière n'est définie pour cette classe.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Actions rapides -->
                    <div class="mt-6 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 border border-blue-200">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Actions Rapides
                        </h4>

                        <div class="space-y-3">
                            <a href="{{ route('student.edit', $student->id) }}"
                                class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Modifier les Informations
                            </a>

                            <button
                                class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Voir les Notes
                            </button>

                            <button
                                class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-xl shadow-lg hover:from-purple-600 hover:to-pink-700 transition-all duration-300 hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Voir les Présences
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
