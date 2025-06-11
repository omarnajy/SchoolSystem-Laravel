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

        @keyframes bounce {

            0%,
            20%,
            53%,
            80%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            40%,
            43% {
                transform: translate3d(0, -8px, 0);
            }

            70% {
                transform: translate3d(0, -4px, 0);
            }

            90% {
                transform: translate3d(0, -2px, 0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slideIn {
            animation: slideIn 0.6s ease-out;
        }

        .animate-bounce-slow {
            animation: bounce 2s ease-in-out infinite;
        }

        .glass {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.9);
        }

        .gradient-border {
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
            padding: 3px;
            border-radius: 1.5rem;
        }

        .form-container {
            background: white;
            border-radius: calc(1.5rem - 3px);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-cyan-100 via-blue-50 to-teal-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header avec animation -->
            <div class="flex items-center justify-between mb-8 animate-fadeIn">
                <div class="relative">
                    <h1
                        class="text-5xl font-extrabold bg-gradient-to-r from-cyan-600 via-blue-600 to-teal-600 bg-clip-text text-transparent mb-2">
                        Nouvelle Matière
                    </h1>
                    <div class="absolute -bottom-2 left-0 w-32 h-1 bg-gradient-to-r from-cyan-600 to-teal-600 rounded-full">
                    </div>
                    <p class="mt-4 text-gray-600 font-medium">Créez une nouvelle matière académique avec tous les détails
                        nécessaires</p>
                </div>

                <div class="animate-bounce-slow">
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

            <!-- Formulaire avec design moderne -->
            <div class="gradient-border animate-slideIn">
                <div class="form-container p-8">
                    <form action="{{ route('subject.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Icône de matière au centre -->
                        <div class="text-center mb-8">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-cyan-500 to-teal-600 rounded-2xl mx-auto flex items-center justify-center shadow-2xl">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.526 0 2.924-.39 4.5-.804zm7-4v10a7.969 7.969 0 01-4.5.804c-1.255 0-2.443-.29-3.5-.804V4.804A7.968 7.968 0 0114.5 4c1.526 0 2.924.39 4.5.804z" />
                                </svg>
                            </div>
                            <h2 class="mt-4 text-2xl font-bold text-gray-800">Détails de la Matière</h2>
                            <p class="text-gray-600">Remplissez les informations ci-dessous</p>
                        </div>

                        <!-- Section Informations de base -->
                        <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-2xl p-6 border border-cyan-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
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
                                        <svg class="w-4 h-4 mr-2 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.526 0 2.924-.39 4.5-.804zm7-4v10a7.969 7.969 0 01-4.5.804c-1.255 0-2.443-.29-3.5-.804V4.804A7.968 7.968 0 0114.5 4c1.526 0 2.924.39 4.5.804z" />
                                        </svg>
                                        Nom de la Matière
                                    </label>
                                    <input name="name" type="text" value="{{ old('name') }}"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-cyan-500 focus:ring-4 focus:ring-cyan-200 transition-all duration-300 font-medium text-lg"
                                        placeholder="Ex: Mathématiques, Physique, Histoire...">
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
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Code de la Matière
                                    </label>
                                    <input name="subject_code" type="number" value="{{ old('subject_code') }}"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all duration-300 font-medium text-lg"
                                        placeholder="Ex: 101, 205, 301...">
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
                        <div class="bg-gradient-to-r from-teal-50 to-green-50 rounded-2xl p-6 border border-teal-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-teal-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
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
                                        <svg class="w-4 h-4 mr-2 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Description de la Matière
                                    </label>
                                    <textarea name="description" rows="4"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-teal-500 focus:ring-4 focus:ring-teal-200 transition-all duration-300 font-medium resize-none"
                                        placeholder="Décrivez brièvement le contenu et les objectifs de cette matière...">{{ old('description') }}</textarea>
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
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Enseignant Assigné
                                    </label>
                                    <!-- Liste déroulante des enseignants -->
                                    <div
                                        class="space-y-3 max-h-64 overflow-y-auto border border-gray-200 rounded-2xl p-4 bg-gray-50">
                                        @foreach ($teachers as $teacher)
                                            <label
                                                class="flex items-center space-x-3 p-3 bg-white rounded-xl border border-gray-100 hover:border-green-300 hover:shadow-sm transition-all duration-200 cursor-pointer group">
                                                <input type="checkbox" name="teacher_ids[]" value="{{ $teacher->id }}"
                                                    class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300 rounded transition-colors">

                                                <!-- Avatar de l'enseignant -->
                                                <div
                                                    class="w-10 h-10 bg-gradient-to-r from-green-400 to-emerald-500 rounded-lg flex items-center justify-center text-white font-bold text-sm group-hover:scale-110 transition-transform">
                                                    {{ strtoupper(substr($teacher->user->name, 0, 2)) }}
                                                </div>

                                                <div class="flex-1">
                                                    <p
                                                        class="font-semibold text-gray-800 group-hover:text-green-700 transition-colors">
                                                        {{ $teacher->user->name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $teacher->user->email }}
                                                    </p>
                                                </div>

                                                <!-- Badge optionnel -->
                                                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-5 h-5 text-green-500" fill="currentColor"
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
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="flex justify-center pt-8">
                            <button type="submit"
                                class="group relative inline-flex items-center px-16 py-5 bg-gradient-to-r from-cyan-600 via-blue-600 to-teal-600 text-white font-bold text-xl rounded-2xl shadow-2xl hover:from-cyan-700 hover:via-blue-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-cyan-200 transition-all duration-300 hover:scale-105 hover:shadow-3xl transform">
                                <svg class="w-6 h-6 mr-4 transition-transform group-hover:scale-110" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Créer la Matière
                                <div
                                    class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-cyan-600 to-teal-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200">
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Conseils -->
            <div
                class="mt-8 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl p-6 border border-yellow-200 animate-slideIn">
                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    Conseils pour la création
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div class="flex items-start space-x-2">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 flex-shrink-0"></div>
                        <p>Choisissez un nom clair et descriptif pour la matière</p>
                    </div>
                    <div class="flex items-start space-x-2">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 flex-shrink-0"></div>
                        <p>Utilisez un code numérique unique pour identifier la matière</p>
                    </div>
                    <div class="flex items-start space-x-2">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 flex-shrink-0"></div>
                        <p>Rédigez une description détaillée des objectifs d'apprentissage</p>
                    </div>
                    <div class="flex items-start space-x-2">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 flex-shrink-0"></div>
                        <p>Assignez un enseignant qualifié pour cette matière</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const teacherSearch = document.getElementById('teacherSearch');
            const teacherDropdown = document.getElementById('teacherDropdown');
            const selectedTeachers = document.getElementById('selectedTeachers');
            const hiddenInputs = document.getElementById('hiddenInputs');
            const teacherOptions = document.querySelectorAll('.teacher-option');

            let selectedTeacherIds = [];

            // Afficher/masquer la liste déroulante
            teacherSearch.addEventListener('focus', () => {
                teacherDropdown.classList.remove('hidden');
                filterTeachers();
            });

            document.addEventListener('click', (e) => {
                if (!document.getElementById('teacherSelector').contains(e.target)) {
                    teacherDropdown.classList.add('hidden');
                }
            });

            // Filtrer les enseignants lors de la recherche
            teacherSearch.addEventListener('input', filterTeachers);

            function filterTeachers() {
                const searchTerm = teacherSearch.value.toLowerCase();
                teacherOptions.forEach(option => {
                    const name = option.dataset.name.toLowerCase();
                    const email = option.dataset.email.toLowerCase();
                    const isVisible = name.includes(searchTerm) || email.includes(searchTerm);
                    const isSelected = selectedTeacherIds.includes(option.dataset.id);

                    option.style.display = (isVisible && !isSelected) ? 'flex' : 'none';
                });
            }

            // Sélectionner un enseignant
            teacherOptions.forEach(option => {
                option.addEventListener('click', () => {
                    const id = option.dataset.id;
                    const name = option.dataset.name;

                    if (!selectedTeacherIds.includes(id)) {
                        selectedTeacherIds.push(id);
                        addTeacherTag(id, name);
                        addHiddenInput(id);
                        filterTeachers();
                        teacherSearch.value = '';
                    }
                });
            });

            function addTeacherTag(id, name) {
                const tag = document.createElement('div');
                tag.className =
                    'inline-flex items-center px-3 py-2 bg-gradient-to-r from-green-100 to-emerald-100 border border-green-300 rounded-xl text-sm font-semibold text-green-800';
                tag.innerHTML = `
                <span>${name}</span>
                <button type="button" class="ml-2 text-green-600 hover:text-green-800 focus:outline-none" onclick="removeTeacher('${id}')">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
                tag.setAttribute('data-teacher-id', id);

                // Insérer avant l'input de recherche
                selectedTeachers.insertBefore(tag, teacherSearch);
            }

            function addHiddenInput(id) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'teacher_ids[]';
                input.value = id;
                input.setAttribute('data-teacher-id', id);
                hiddenInputs.appendChild(input);
            }

            // Fonction globale pour supprimer un enseignant
            window.removeTeacher = function(id) {
                // Supprimer de la liste
                selectedTeacherIds = selectedTeacherIds.filter(teacherId => teacherId !== id);

                // Supprimer le tag
                const tag = selectedTeachers.querySelector(`[data-teacher-id="${id}"]`);
                if (tag) tag.remove();

                // Supprimer l'input caché
                const input = hiddenInputs.querySelector(`[data-teacher-id="${id}"]`);
                if (input) input.remove();

                // Rafraîchir la liste
                filterTeachers();
            };
        });
    </script>
@endpush
