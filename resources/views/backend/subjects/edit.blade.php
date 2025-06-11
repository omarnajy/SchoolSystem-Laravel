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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
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

        .animate-slideIn {
            animation: slideIn 0.6s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
        }

        .glass {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.9);
        }

        .gradient-border {
            background: linear-gradient(45deg, #f093fb, #f5576c, #4facfe, #00f2fe);
            padding: 3px;
            border-radius: 1.5rem;
        }

        .form-container {
            background: white;
            border-radius: calc(1.5rem - 3px);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-rose-100 via-pink-50 to-purple-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header avec animation -->
            <div class="flex items-center justify-between mb-8 animate-fadeIn">
                <div class="relative">
                    <h1
                        class="text-5xl font-extrabold bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent mb-2">
                        Modifier la Matière
                    </h1>
                    <div
                        class="absolute -bottom-2 left-0 w-36 h-1 bg-gradient-to-r from-rose-600 to-purple-600 rounded-full">
                    </div>
                    <p class="mt-4 text-gray-600 font-medium">Modifiez les informations de la matière {{ $subject->name }}
                    </p>
                </div>

                <div class="animate-pulse-slow">
                    <a href="{{ route('subject.index') }}"
                        class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-700 to-gray-800 text-white font-bold rounded-2xl shadow-xl hover:from-gray-800 hover:to-gray-900 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <svg class="w-5 h-5 mr-3 transition-transform group-hover:-translate-x-1" fill="currentColor"
                            viewBox="0 0 448 512">
                            <path
                                d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                        </svg>
                        Retour aux Matières
                        <div
                            class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                </div>
            </div>

            <!-- Badge de la matière -->
            <div class="mb-6 animate-slideIn">
                <div
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-100 to-purple-100 border border-rose-200 rounded-2xl shadow-lg">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-rose-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg mr-4">
                        {{ strtoupper(substr($subject->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $subject->name }}</p>
                        <p class="text-sm text-gray-600">Code: {{ $subject->subject_code }}</p>
                    </div>
                </div>
            </div>

            <!-- Formulaire avec design moderne -->
            <div class="gradient-border animate-slideIn">
                <div class="form-container p-8">
                    <form action="{{ route('subject.update', $subject->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Icône de matière au centre -->
                        <div class="text-center mb-8">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-rose-500 to-purple-600 rounded-2xl mx-auto flex items-center justify-center shadow-2xl">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </div>
                            <h2 class="mt-4 text-2xl font-bold text-gray-800">Modification en cours</h2>
                            <p class="text-gray-600">Mettez à jour les informations de la matière</p>
                        </div>

                        <!-- Section Informations de base -->
                        <div class="bg-gradient-to-r from-rose-50 to-pink-50 rounded-2xl p-6 border border-rose-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-rose-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                Informations de Base
                            </h3>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Nom de la matière -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 715.5 16c1.526 0 2.924-.39 4.5-.804zm7-4v10a7.969 7.969 0 01-4.5.804c-1.255 0-2.443-.29-3.5-.804V4.804A7.968 7.968 0 0114.5 4c1.526 0 2.924.39 4.5.804z" />
                                        </svg>
                                        Nom de la Matière
                                    </label>
                                    <input name="name" type="text" value="{{ $subject->name }}"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-rose-500 focus:ring-4 focus:ring-rose-200 transition-all duration-300 font-medium text-lg">
                                    @error('name')
                                        <p class="text-red-500 text-sm flex items-center mt-2">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Code de la matière -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Code de la Matière
                                    </label>
                                    <input name="subject_code" type="number" value="{{ $subject->subject_code }}"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-pink-500 focus:ring-4 focus:ring-pink-200 transition-all duration-300 font-medium text-lg">
                                    @error('subject_code')
                                        <p class="text-red-500 text-sm flex items-center mt-2">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section Description et Enseignant -->
                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-6 border border-purple-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                Description et Attribution
                            </h3>

                            <div class="space-y-6">
                                <!-- Description -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Description de la Matière
                                    </label>
                                    <textarea name="description" rows="4"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-purple-500 focus:ring-4 focus:ring-purple-200 transition-all duration-300 font-medium resize-none">{{ $subject->description }}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-sm flex items-center mt-2">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Enseignant assigné -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Enseignant Assigné
                                    </label>
                                    <div
                                        class="space-y-3 max-h-64 overflow-y-auto border border-gray-200 rounded-2xl p-4 bg-gray-50">
                                        @foreach ($teachers as $teacher)
                                            <label
                                                class="flex items-center space-x-3 p-3 bg-white rounded-xl border border-gray-100 hover:border-indigo-300 hover:shadow-sm transition-all duration-200 cursor-pointer group">
                                                <input type="checkbox" name="teacher_ids[]" value="{{ $teacher->id }}"
                                                    {{ in_array($teacher->id, $subject->teachers->pluck('id')->toArray()) ? 'checked' : '' }}
                                                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-colors">

                                                <!-- Avatar de l'enseignant -->
                                                <div
                                                    class="w-10 h-10 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-sm group-hover:scale-110 transition-transform">
                                                    {{ strtoupper(substr($teacher->user->name, 0, 2)) }}
                                                </div>

                                                <div class="flex-1">
                                                    <p
                                                        class="font-semibold text-gray-800 group-hover:text-indigo-700 transition-colors">
                                                        {{ $teacher->user->name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $teacher->user->email }}
                                                    </p>
                                                </div>

                                                <!-- Badge pour enseignant principal -->
                                                @if ($teacher->id === $subject->teacher_id)
                                                    <div
                                                        class="px-2 py-1 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold rounded-lg">
                                                        Principal
                                                    </div>
                                                @endif

                                                <!-- Icône de sélection -->
                                                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-5 h-5 text-indigo-500" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>

                                    @error('teacher_ids')
                                        <p class="text-red-500 text-sm flex items-center mt-2">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <!-- Affichage des enseignants actuellement assignés -->
                                <div
                                    class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                                    <h5 class="font-bold text-gray-800 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Enseignants Actuellement Assignés
                                    </h5>

                                    @if ($subject->teachers && $subject->teachers->count() > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($subject->teachers as $assignedTeacher)
                                                <div
                                                    class="inline-flex items-center px-3 py-2 bg-white border border-blue-200 rounded-xl shadow-sm">
                                                    <div
                                                        class="w-6 h-6 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-xs mr-2">
                                                        {{ strtoupper(substr($assignedTeacher->user->name, 0, 2)) }}
                                                    </div>
                                                    <span
                                                        class="font-semibold text-gray-800">{{ $assignedTeacher->user->name }}</span>
                                                    @if ($assignedTeacher->id === $subject->teacher_id)
                                                        <span
                                                            class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded">Principal</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500 italic">Aucun enseignant assigné actuellement</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Informations actuelles -->
                        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-200">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <div
                                    class="w-6 h-6 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                Informations Actuelles
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                                <div
                                    class="flex items-center justify-between p-3 bg-white rounded-xl border border-blue-200">
                                    <span class="font-medium">Enseignant actuel:</span>
                                    <span
                                        class="font-bold text-blue-600">{{ $subject->teacher->user->name ?? 'Non assigné' }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between p-3 bg-white rounded-xl border border-blue-200">
                                    <span class="font-medium">Dernière modification:</span>
                                    <span
                                        class="font-bold text-blue-600">{{ $subject->updated_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="flex justify-center pt-8">
                            <button type="submit"
                                class="group relative inline-flex items-center px-16 py-5 bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 text-white font-bold text-xl rounded-2xl shadow-2xl hover:from-rose-700 hover:via-pink-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-rose-200 transition-all duration-300 hover:scale-105 hover:shadow-3xl transform">
                                <svg class="w-6 h-6 mr-4 transition-transform group-hover:scale-110" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Mettre à Jour la Matière
                                <div
                                    class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-rose-600 to-purple-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200">
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Historique des modifications -->
            <div
                class="mt-8 bg-gradient-to-r from-gray-50 to-slate-50 rounded-2xl p-6 border border-gray-200 animate-slideIn">
                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                            clip-rule="evenodd" />
                    </svg>
                    Informations de Modification
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-700">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <p><span class="font-medium">Créée le:</span> {{ $subject->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <p><span class="font-medium">Modifiée le:</span> {{ $subject->updated_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                        <p><span class="font-medium">Statut:</span> Active</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
