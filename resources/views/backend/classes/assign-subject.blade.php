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
                            <p class="text-gray-600 mt-1">Gérer les matières et leurs enseignants pour la classe <span
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

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-red-800 font-semibold">Erreurs de validation :</h3>
                    <ul class="mt-2 text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

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
                                Assignation des matières par enseignant
                            </h2>
                            <p class="text-teal-100 mt-1">Sélectionnez chaque matière et les enseignants qui l'enseignent
                            </p>
                        </div>

                        <form action="{{ route('store.class.assign.subject', $classid) }}" method="POST" class="p-6"
                            id="assignmentForm">
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
                                    <div class="space-y-2">
                                        @foreach ($assigned->subjects as $assignedSubject)
                                            @php
                                                // Récupérer seulement les enseignants assignés via la table subject_teacher
                                                // qui sont les vrais enseignants sélectionnés pour cette matière dans cette classe
                                                $subjectTeachers = $assignedSubject->teachers;

                                                // Si aucun enseignant spécifiquement assigné via subject_teacher,
                                                // alors afficher l'enseignant principal par défaut
                                                if ($subjectTeachers->count() === 0 && $assignedSubject->teacher) {
                                                    $subjectTeachers = collect([$assignedSubject->teacher]);
                                                }
                                            @endphp
                                            <div
                                                class="flex items-center justify-between bg-white p-3 rounded-lg border border-teal-200">
                                                <div>
                                                    <span
                                                        class="font-medium text-teal-800">{{ $assignedSubject->name }}</span>
                                                    <span
                                                        class="text-xs text-teal-600 ml-2">({{ $assignedSubject->subject_code }})</span>
                                                </div>
                                                <div class="text-xs text-teal-700">
                                                    @if ($subjectTeachers->count() > 0)
                                                        {{ $subjectTeachers->pluck('user.name')->join(', ') }}
                                                    @else
                                                        <span class="text-amber-600">Aucun enseignant assigné</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Simple Subject Assignment -->
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                            </path>
                                        </svg>
                                        Assigner des matières
                                    </h3>
                                </div>

                                <!-- Subjects Selection -->
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                    <h4 class="text-md font-semibold text-gray-800 mb-4">Sélectionnez les matières pour
                                        cette classe</h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($subjects as $subject)
                                            @php
                                                $isAssigned = $assigned->subjects->contains('id', $subject->id);
                                                $allTeachers = $subject->getAllTeachers();
                                            @endphp
                                            <div
                                                class="border border-gray-200 rounded-lg p-4 {{ $isAssigned ? 'bg-teal-50 border-teal-300' : 'bg-white' }}">
                                                <div class="flex items-start space-x-3">
                                                    <input type="checkbox" name="selectedsubjects[]"
                                                        value="{{ $subject->id }}" {{ $isAssigned ? 'checked' : '' }}
                                                        class="mt-1 h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded"
                                                        onchange="toggleSubjectTeachers(this, {{ $subject->id }})">

                                                    <div class="flex-1">
                                                        <div class="flex items-center justify-between">
                                                            <div>
                                                                <p class="font-semibold text-gray-900">{{ $subject->name }}
                                                                </p>
                                                                <p class="text-sm text-gray-500">Code:
                                                                    {{ $subject->subject_code }}</p>
                                                            </div>
                                                            <div
                                                                class="h-8 w-8 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-lg flex items-center justify-center">
                                                                <span
                                                                    class="text-white font-semibold text-xs">{{ substr($subject->name, 0, 1) }}</span>
                                                            </div>
                                                        </div>

                                                        <!-- Teachers for this subject -->
                                                        <div class="mt-3 subject-teachers"
                                                            id="teachers-{{ $subject->id }}"
                                                            style="{{ $isAssigned ? '' : 'display: none;' }}">
                                                            <p class="text-xs font-medium text-gray-700 mb-2">Enseignants
                                                                qui peuvent enseigner cette matière :</p>
                                                            <div class="space-y-1">
                                                                @forelse($allTeachers as $teacher)
                                                                    <label class="flex items-center space-x-2 text-xs">
                                                                        <input type="checkbox"
                                                                            name="subject_teachers[{{ $subject->id }}][]"
                                                                            value="{{ $teacher->id }}"
                                                                            class="h-3 w-3 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                                                                        <span
                                                                            class="text-gray-700">{{ $teacher->user->name }}</span>
                                                                    </label>
                                                                @empty
                                                                    <p class="text-xs text-gray-500">Aucun enseignant
                                                                        disponible</p>
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="mt-6 p-4 bg-white rounded-xl border border-gray-200">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Actions rapides</h4>
                                        <div class="flex flex-wrap gap-3">
                                            <button type="button" onclick="selectAllSubjects()"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-teal-100 text-teal-700 hover:bg-teal-200 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Tout sélectionner
                                            </button>
                                            <button type="button" onclick="unselectAllSubjects()"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Tout désélectionner
                                            </button>
                                        </div>
                                    </div>
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
                                        Enregistrer les assignations
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Class Info -->
                    <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 p-6">
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
                                <span class="text-sm font-medium text-gray-600">Étudiants</span>
                                <span
                                    class="text-sm text-gray-900 font-semibold">{{ $assigned->students->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-600">Enseignants</span>
                                <span
                                    class="text-sm text-gray-900 font-semibold">{{ $assigned->teachers->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Enseignants de la classe -->
                    <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Enseignants de la classe
                        </h4>

                        @forelse ($assigned->teachers as $teacher)
                            <div class="flex items-center p-3 mb-3 last:mb-0 bg-gray-50 rounded-lg border border-gray-200">
                                <div
                                    class="h-8 w-8 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full flex items-center justify-center mr-3">
                                    <span
                                        class="text-white font-semibold text-xs">{{ substr($teacher->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 truncate">
                                        {{ $teacher->user->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 truncate">
                                        {{ $teacher->user->email }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-sm text-gray-500">Aucun enseignant assigné à cette classe</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Students Preview -->
                    <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                            Étudiants ({{ $assigned->students->count() }})
                        </h4>

                        @forelse ($assigned->students->take(3) as $student)
                            <div class="flex items-center p-2 mb-2 last:mb-0 bg-gray-50 rounded-lg">
                                <div
                                    class="h-6 w-6 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mr-3">
                                    <span
                                        class="text-white font-semibold text-xs">{{ substr($student->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium text-gray-900 truncate">
                                        {{ $student->user->name }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-sm text-gray-500">Aucun étudiant inscrit</p>
                            </div>
                        @endforelse

                        @if ($assigned->students->count() > 3)
                            <div class="text-center mt-2">
                                <span class="text-xs text-gray-500">+{{ $assigned->students->count() - 3 }} autres
                                    étudiants</span>
                            </div>
                        @endif
                    </div>

                    <!-- Help Section -->
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-semibold text-blue-800">Guide d'assignation</h4>
                                <ul class="mt-2 text-xs text-blue-700 space-y-1">
                                    <li>• Cochez les matières à assigner à cette classe</li>
                                    <li>• Sélectionnez les enseignants pour chaque matière</li>
                                    <li>• Une matière peut avoir plusieurs enseignants</li>
                                    <li>• Seuls les enseignants qui peuvent enseigner la matière apparaissent</li>
                                    <li>• Utilisez les actions rapides pour gagner du temps</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleSubjectTeachers(checkbox, subjectId) {
            const teachersDiv = document.getElementById('teachers-' + subjectId);
            const teacherCheckboxes = teachersDiv.querySelectorAll('input[type="checkbox"]');

            if (checkbox.checked) {
                teachersDiv.style.display = 'block';
                // Auto-scroll to make sure the teachers section is visible
                setTimeout(() => {
                    teachersDiv.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }, 100);
            } else {
                teachersDiv.style.display = 'none';
                // Uncheck all teacher checkboxes for this subject
                teacherCheckboxes.forEach(cb => cb.checked = false);
            }
        }

        function selectAllSubjects() {
            document.querySelectorAll('input[name="selectedsubjects[]"]').forEach(checkbox => {
                if (!checkbox.checked) {
                    checkbox.checked = true;
                    toggleSubjectTeachers(checkbox, checkbox.value);
                }
            });
        }

        function unselectAllSubjects() {
            document.querySelectorAll('input[name="selectedsubjects[]"]').forEach(checkbox => {
                if (checkbox.checked) {
                    checkbox.checked = false;
                    toggleSubjectTeachers(checkbox, checkbox.value);
                }
            });
        }

        // Form validation
        document.getElementById('assignmentForm').addEventListener('submit', function(e) {
            const selectedSubjects = document.querySelectorAll('input[name="selectedsubjects[]"]:checked');

            if (selectedSubjects.length === 0) {
                e.preventDefault();
                alert('Veuillez sélectionner au moins une matière.');
                return false;
            }

            // Check if each selected subject has at least one teacher
            let hasError = false;
            let errorSubjects = [];

            selectedSubjects.forEach(subjectCheckbox => {
                const subjectId = subjectCheckbox.value;
                const subjectName = subjectCheckbox.closest('.border').querySelector('p.font-semibold')
                    .textContent;
                const teacherCheckboxes = document.querySelectorAll(
                    `input[name="subject_teachers[${subjectId}][]"]:checked`);

                if (teacherCheckboxes.length === 0) {
                    hasError = true;
                    errorSubjects.push(subjectName);
                }
            });

            if (hasError) {
                e.preventDefault();
                alert(
                    `Veuillez sélectionner au moins un enseignant pour les matières suivantes :\n• ${errorSubjects.join('\n• ')}`
                    );
                return false;
            }

            // Confirm submission
            const confirmMessage =
                `Vous êtes sur le point d'assigner ${selectedSubjects.length} matière(s) à cette classe. Confirmer ?`;
            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return false;
            }
        });

        // Add visual feedback for better UX
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects for subject cards
            document.querySelectorAll('input[name="selectedsubjects[]"]').forEach(checkbox => {
                const card = checkbox.closest('.border');

                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        card.classList.add('bg-teal-50', 'border-teal-300');
                        card.classList.remove('bg-white');
                    } else {
                        card.classList.remove('bg-teal-50', 'border-teal-300');
                        card.classList.add('bg-white');
                    }
                });
            });

            // Count selected subjects and teachers
            function updateSelectionCount() {
                const selectedSubjects = document.querySelectorAll('input[name="selectedsubjects[]"]:checked')
                    .length;
                const selectedTeachers = document.querySelectorAll('input[name^="subject_teachers"]:checked')
                    .length;

                // Update counts in real-time (you can add elements to display these if needed)
                console.log(
                    `Matières sélectionnées: ${selectedSubjects}, Enseignants sélectionnés: ${selectedTeachers}`
                );
            }

            // Listen for changes
            document.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox') {
                    updateSelectionCount();
                }
            });
        });
    </script>
@endsection
