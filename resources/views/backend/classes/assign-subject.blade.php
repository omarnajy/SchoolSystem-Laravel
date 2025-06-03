@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-teal-50 via-white to-cyan-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Assigner des matières</h1>
                            <p class="text-gray-600 mt-1">Gérer les matières et consulter les étudiants de la classe <span
                                    class="font-semibold text-teal-600">{{ $assigned->class_name ?? 'N/A' }}</span></p>
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

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Subject Assignment Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                        <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-6 py-4">
                            <h2 class="text-lg font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                Sélection des matières
                            </h2>
                            <p class="text-teal-100 mt-1">Choisissez les matières à enseigner dans cette classe</p>
                        </div>

                        <form action="{{ route('store.class.assign.subject', $classid) }}" method="POST" class="p-6">
                            @csrf

                            <!-- Current Assignments Display -->
                            @if ($assigned->subjects->count() > 0)
                                <div class="bg-teal-50 rounded-xl p-4 mb-6 border border-teal-200">
                                    <h3 class="text-sm font-semibold text-teal-800 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Matières actuellement assignées
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($assigned->subjects as $assignedSubject)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800 border border-teal-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $assignedSubject->name }} ({{ $assignedSubject->subject_code }})
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Subject Selection Grid -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                        </path>
                                    </svg>
                                    Sélectionner les matières
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($subjects as $subject)
                                        @php
                                            $isAssigned = $assigned->subjects->contains('id', $subject->id);
                                        @endphp
                                        <label
                                            class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 hover:shadow-md group {{ $isAssigned ? 'border-teal-500 bg-teal-50' : 'border-gray-200 hover:border-teal-300' }}">
                                            <input type="checkbox" name="selectedsubjects[]" value="{{ $subject->id }}"
                                                {{ $isAssigned ? 'checked' : '' }}
                                                class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded transition-colors">
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <p
                                                            class="text-sm font-semibold text-gray-900 group-hover:text-teal-700">
                                                            {{ $subject->name }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            Code: {{ $subject->subject_code ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="h-8 w-8 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-lg flex items-center justify-center">
                                                        <span
                                                            class="text-white font-semibold text-xs">{{ substr($subject->name, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Actions rapides</h4>
                                <div class="flex flex-wrap gap-3">
                                    <button type="button" onclick="selectAll()"
                                        class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-teal-100 text-teal-700 hover:bg-teal-200 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Tout sélectionner
                                    </button>
                                    <button type="button" onclick="unselectAll()"
                                        class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tout désélectionner
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex items-center justify-end space-x-4">
                                    <a href="{{ route('classes.index') }}"
                                        class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                                        Annuler
                                    </a>

                                    <button type="submit"
                                        class="group relative px-8 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-semibold rounded-xl hover:from-teal-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200 transform hover:scale-105 active:scale-95">
                                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-teal-300 group-hover:text-teal-200 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                        Enregistrer les matières
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Students Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-600 to-gray-700 px-6 py-4">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                    </path>
                                </svg>
                                Étudiants de la classe
                            </h3>
                            <p class="text-gray-300 text-sm mt-1">{{ $assigned->students->count() }} étudiants inscrits
                            </p>
                        </div>

                        <div class="p-6">
                            @forelse ($assigned->students as $student)
                                <div
                                    class="flex items-center p-3 mb-3 last:mb-0 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-all duration-200">
                                    <div
                                        class="h-10 w-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mr-3">
                                        <span
                                            class="text-white font-semibold text-sm">{{ substr($student->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-900 truncate">
                                            {{ $student->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 truncate">
                                            {{ $student->user->email }}
                                        </div>
                                        <div class="flex items-center mt-1 space-x-4 text-xs text-gray-500">
                                            @if ($student->phone)
                                                <span class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                        </path>
                                                    </svg>
                                                    {{ $student->phone }}
                                                </span>
                                            @endif
                                            @if ($student->parent)
                                                <span class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                        </path>
                                                    </svg>
                                                    {{ Str::limit($student->parent->user->name, 15) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                        </path>
                                    </svg>
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Aucun étudiant</h4>
                                    <p class="text-xs text-gray-500">Cette classe n'a pas encore d'étudiants inscrits.</p>
                                </div>
                            @endforelse

                            <!-- Student Stats -->
                            @if ($assigned->students->count() > 0)
                                <div class="mt-6 pt-4 border-t border-gray-200">
                                    <div class="grid grid-cols-2 gap-4 text-center">
                                        <div class="bg-blue-50 rounded-lg p-3">
                                            <div class="text-lg font-bold text-blue-600">
                                                {{ $assigned->students->count() }}</div>
                                            <div class="text-xs text-blue-700">Total</div>
                                        </div>
                                        <div class="bg-green-50 rounded-lg p-3">
                                            <div class="text-lg font-bold text-green-600">
                                                {{ $assigned->students->whereNotNull('phone')->count() }}</div>
                                            <div class="text-xs text-green-700">Avec téléphone</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Class Info Card -->
                    <div class="mt-6 bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informations de la classe
                        </h4>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Nom</span>
                                <span
                                    class="text-sm text-gray-900 font-semibold">{{ $assigned->class_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Niveau</span>
                                <span
                                    class="text-sm text-gray-900 font-semibold">{{ $assigned->class_numeric ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Professeur</span>
                                <span
                                    class="text-sm text-gray-900 font-semibold">{{ $assigned->teacher->user->name ?? 'Non assigné' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Matières</span>
                                <span class="text-sm text-gray-900 font-semibold">{{ $assigned->subjects->count() }}
                                    assignées</span>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <h3 class="text-sm font-semibold text-blue-800">Guide d'assignation des matières</h3>
                        <ul class="mt-2 text-sm text-blue-700 space-y-1">
                            <li>• Sélectionnez les matières en cochant les cases correspondantes</li>
                            <li>• Utilisez les actions rapides pour sélectionner/désélectionner toutes les matières</li>
                            <li>• Les matières déjà assignées sont mises en surbrillance</li>
                            <li>• Les modifications prendront effet immédiatement après sauvegarde</li>
                            <li>• Consultez la liste des étudiants dans le panneau de droite</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectAll() {
            document.querySelectorAll('input[name="selectedsubjects[]"]').forEach(checkbox => {
                checkbox.checked = true;
                checkbox.closest('label').classList.add('border-teal-500', 'bg-teal-50');
                checkbox.closest('label').classList.remove('border-gray-200');
            });
        }

        function unselectAll() {
            document.querySelectorAll('input[name="selectedsubjects[]"]').forEach(checkbox => {
                checkbox.checked = false;
                checkbox.closest('label').classList.remove('border-teal-500', 'bg-teal-50');
                checkbox.closest('label').classList.add('border-gray-200');
            });
        }

        // Dynamic styling on checkbox change
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="selectedsubjects[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const label = this.closest('label');
                    if (this.checked) {
                        label.classList.add('border-teal-500', 'bg-teal-50');
                        label.classList.remove('border-gray-200');
                    } else {
                        label.classList.remove('border-teal-500', 'bg-teal-50');
                        label.classList.add('border-gray-200');
                    }
                });
            });
        });
    </script>
@endsection
