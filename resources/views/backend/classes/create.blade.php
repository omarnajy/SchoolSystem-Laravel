@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-violet-50 via-white to-purple-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Nouvelle classe</h1>
                            <p class="text-gray-600 mt-1">Créer une nouvelle classe et assigner des enseignants</p>
                        </div>
                    </div>

                    <a href="{{ route('classes.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200 shadow-sm hover:shadow-md group">
                        <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Retour</span>
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                <div class="bg-gradient-to-r from-violet-600 to-purple-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Informations de la classe
                    </h2>
                    <p class="text-violet-100 mt-1">Remplissez tous les champs requis pour créer la classe</p>
                </div>

                <form action="{{ route('classes.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="space-y-8">
                        <!-- Class Name Field -->
                        <div class="group">
                            <label for="class_name" class="block text-sm font-semibold text-gray-700 mb-3">
                                Nom de la classe *
                            </label>
                            <div class="relative">
                                <input type="text" name="class_name" id="class_name" value="{{ old('class_name') }}"
                                    placeholder="Ex: Terminale S, 6ème A, CP1..."
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white @error('class_name') border-red-300 bg-red-50 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('class_name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Class Numeric Field -->
                        <div class="group">
                            <label for="class_numeric" class="block text-sm font-semibold text-gray-700 mb-3">
                                Niveau numérique *
                            </label>
                            <div class="relative">
                                <input type="number" name="class_numeric" id="class_numeric"
                                    value="{{ old('class_numeric') }}" placeholder="Ex: 1, 2, 3... (pour le classement)"
                                    min="1" max="20"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white @error('class_numeric') border-red-300 bg-red-50 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('class_numeric')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Enseignants de la classe -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <svg class="w-5 h-5 inline-block mr-2 text-violet-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Enseignants de la classe
                            </label>
                            <p class="text-sm text-gray-500 mb-4">
                                Sélectionnez les enseignants qui sont assignés à cette classe.
                                <span class="font-medium text-amber-600">Note :</span> Cela ne détermine pas
                                automatiquement les matières qu'ils enseignent.
                            </p>

                            <div
                                class="space-y-3 max-h-64 overflow-y-auto border border-gray-200 rounded-2xl p-4 bg-gray-50">
                                @foreach ($teachers as $teacher)
                                    <label
                                        class="flex items-center space-x-3 p-3 bg-white rounded-xl border border-gray-100 hover:border-violet-300 hover:shadow-sm transition-all duration-200 cursor-pointer group">
                                        <input type="checkbox" name="teacher_ids[]" value="{{ $teacher->id }}"
                                            {{ in_array($teacher->id, old('teacher_ids', [])) ? 'checked' : '' }}
                                            class="h-5 w-5 text-violet-600 focus:ring-violet-500 border-gray-300 rounded transition-colors">

                                        <div
                                            class="w-10 h-10 bg-gradient-to-r from-violet-400 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-sm group-hover:scale-110 transition-transform">
                                            {{ strtoupper(substr($teacher->user->name, 0, 2)) }}
                                        </div>

                                        <div class="flex-1">
                                            <p
                                                class="font-semibold text-gray-800 group-hover:text-violet-700 transition-colors">
                                                {{ $teacher->user->name }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $teacher->user->email }}
                                            </p>
                                            @if ($teacher->subjects->count() > 0)
                                                <p class="text-xs text-gray-400 mt-1">
                                                    Matières : {{ $teacher->subjects->pluck('name')->join(', ') }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="text-xs text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            @error('teacher_ids')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Actions rapides pour les enseignants -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Actions rapides</h4>
                            <div class="flex flex-wrap gap-3">
                                <button type="button" onclick="selectAllTeachers()"
                                    class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-violet-100 text-violet-700 hover:bg-violet-200 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Sélectionner tous
                                </button>
                                <button type="button" onclick="unselectAllTeachers()"
                                    class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Désélectionner tous
                                </button>
                            </div>
                        </div>

                        <!-- Class Description -->
                        <div class="group">
                            <label for="class_description" class="block text-sm font-semibold text-gray-700 mb-3">
                                Description de la classe
                            </label>
                            <div class="relative">
                                <textarea name="class_description" id="class_description" rows="4"
                                    placeholder="Description optionnelle de la classe, spécialité, informations complémentaires..."
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white resize-none @error('class_description') border-red-300 bg-red-50 @enderror">{{ old('class_description') }}</textarea>
                                <div class="absolute top-3 right-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('class_description')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('classes.index') }}"
                                class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition-all duration-200">
                                Annuler
                            </a>

                            <button type="submit"
                                class="group relative px-8 py-3 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-semibold rounded-xl hover:from-violet-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition-all duration-200 transform hover:scale-105 active:scale-95">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-violet-300 group-hover:text-violet-200 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </span>
                                Créer la classe
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-blue-800">Conseils pour créer une classe</h3>
                        <ul class="mt-2 text-sm text-blue-700 space-y-1">
                            <li>• Le nom de la classe doit être unique et facilement identifiable</li>
                            <li>• Le niveau numérique permet de trier les classes par ordre croissant</li>
                            <li>• Vous pourrez assigner des matières après la création de la classe</li>
                            <li>• Les étudiants pourront être ajoutés ultérieurement dans la gestion des classes</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Informations importantes -->
            <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-blue-800">Important à retenir</h3>
                        <ul class="mt-2 text-sm text-blue-700 space-y-1">
                            <li>• <strong>Enseignants de classe :</strong> Les enseignants sélectionnés sont assignés à
                                cette classe
                                mais cela ne définit pas automatiquement quelles matières ils enseignent</li>
                            <li>• <strong>Attribution des matières :</strong> Après création, vous devrez assigner les
                                matières avec
                                leurs enseignants respectifs</li>
                            <li>• <strong>Flexibilité :</strong> Une matière peut être enseignée par plusieurs enseignants
                            </li>
                            <li>• <strong>Gestion séparée :</strong> L'assignation d'enseignants et l'assignation de
                                matières sont
                                deux étapes distinctes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectAllTeachers() {
            document.querySelectorAll('input[name="teacher_ids[]"]').forEach(checkbox => {
                checkbox.checked = true;
                checkbox.closest('label').classList.add('border-violet-500', 'bg-violet-50');
                checkbox.closest('label').classList.remove('border-gray-100');
            });
        }

        function unselectAllTeachers() {
            document.querySelectorAll('input[name="teacher_ids[]"]').forEach(checkbox => {
                checkbox.checked = false;
                checkbox.closest('label').classList.remove('border-violet-500', 'bg-violet-50');
                checkbox.closest('label').classList.add('border-gray-100');
            });
        }

        // Dynamic styling on checkbox change
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="teacher_ids[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const label = this.closest('label');
                    if (this.checked) {
                        label.classList.add('border-violet-500', 'bg-violet-50');
                        label.classList.remove('border-gray-100');
                    } else {
                        label.classList.remove('border-violet-500', 'bg-violet-50');
                        label.classList.add('border-gray-100');
                    }
                });
            });
        });
    </script>
@endsection
