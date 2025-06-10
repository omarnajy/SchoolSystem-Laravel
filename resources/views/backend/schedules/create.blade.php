{{-- resources/views/backend/schedules/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Créer un Emploi du Temps</h1>
                <p class="text-gray-600">Ajoutez un nouveau cours à l'emploi du temps</p>
            </div>
            <a href="{{ route('schedules.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour
            </a>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Informations du Cours</h2>
            </div>

            <form method="POST" action="{{ route('schedules.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Classe -->
                    <div>
                        <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Classe <span class="text-red-500">*</span>
                        </label>
                        <select name="class_id" id="class_id" required
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('class_id') border-red-500 @enderror">
                            <option value="">Sélectionnez une classe</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Matière -->
                    <div>
                        <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Matière <span class="text-red-500">*</span>
                        </label>
                        <select name="subject_id" id="subject_id" required
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('subject_id') border-red-500 @enderror">
                            <option value="">Sélectionnez une matière</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->subject_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Enseignant -->
                    <div>
                        <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Enseignant <span class="text-red-500">*</span>
                        </label>
                        <select name="teacher_id" id="teacher_id" required
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('teacher_id') border-red-500 @enderror">
                            <option value="">Sélectionnez un enseignant</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jour de la semaine -->
                    <div>
                        <label for="day_of_week" class="block text-sm font-medium text-gray-700 mb-2">
                            Jour <span class="text-red-500">*</span>
                        </label>
                        <select name="day_of_week" id="day_of_week" required
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('day_of_week') border-red-500 @enderror">
                            <option value="">Sélectionnez un jour</option>
                            @foreach ($days as $key => $day)
                                <option value="{{ $key }}" {{ old('day_of_week') == $key ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                        @error('day_of_week')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Heure de début -->
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Heure de début <span class="text-red-500">*</span>
                        </label>
                        <select name="start_time" id="start_time" required
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('start_time') border-red-500 @enderror">
                            <option value="">Sélectionnez l'heure</option>
                            @foreach ($timeSlots as $time)
                                <option value="{{ $time }}" {{ old('start_time') == $time ? 'selected' : '' }}>
                                    {{ $time }}
                                </option>
                            @endforeach
                        </select>
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Heure de fin -->
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Heure de fin <span class="text-red-500">*</span>
                        </label>
                        <select name="end_time" id="end_time" required
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('end_time') border-red-500 @enderror">
                            <option value="">Sélectionnez l'heure</option>
                            @foreach ($timeSlots as $time)
                                <option value="{{ $time }}" {{ old('end_time') == $time ? 'selected' : '' }}>
                                    {{ $time }}
                                </option>
                            @endforeach
                        </select>
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salle -->
                    <div>
                        <label for="room" class="block text-sm font-medium text-gray-700 mb-2">Salle</label>
                        <input type="text" name="room" id="room" value="{{ old('room') }}"
                            placeholder="Ex: Salle A101"
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('room') border-red-500 @enderror">
                        @error('room')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Année académique -->
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">
                            Année Académique <span class="text-red-500">*</span>
                        </label>
                        <select name="academic_year" id="academic_year" required
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('academic_year') border-red-500 @enderror">
                            <option value="{{ date('Y') }}" {{ old('academic_year') == date('Y') ? 'selected' : '' }}>
                                {{ date('Y') }}</option>
                            <option value="{{ date('Y') + 1 }}"
                                {{ old('academic_year') == date('Y') + 1 ? 'selected' : '' }}>{{ date('Y') + 1 }}</option>
                        </select>
                        @error('academic_year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Semestre -->
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">
                            Semestre <span class="text-red-500">*</span>
                        </label>
                        <select name="semester" id="semester" required
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('semester') border-red-500 @enderror">
                            <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Semestre 1</option>
                            <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semestre 2</option>
                        </select>
                        @error('semester')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Notes additionnelles sur ce cours..."
                        class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alertes de conflit -->
                <div id="conflict-alert" class="hidden mt-6 p-4 bg-red-100 border border-red-300 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                        <span class="text-red-700 font-medium">Conflit détecté !</span>
                    </div>
                    <div id="conflict-message" class="text-red-600 text-sm mt-1"></div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('schedules.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $errors->first() }}
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classSelect = document.getElementById('class_id');
            const teacherSelect = document.getElementById('teacher_id');
            const daySelect = document.getElementById('day_of_week');
            const startTimeSelect = document.getElementById('start_time');
            const endTimeSelect = document.getElementById('end_time');
            const academicYearSelect = document.getElementById('academic_year');
            const semesterSelect = document.getElementById('semester');
            const conflictAlert = document.getElementById('conflict-alert');
            const conflictMessage = document.getElementById('conflict-message');

            function checkConflicts() {
                if (!classSelect.value || !teacherSelect.value || !daySelect.value ||
                    !startTimeSelect.value || !endTimeSelect.value ||
                    !academicYearSelect.value || !semesterSelect.value) {
                    conflictAlert.classList.add('hidden');
                    return;
                }

                fetch(`{{ route('schedules.get-available-slots') }}?` + new URLSearchParams({
                        class_id: classSelect.value,
                        teacher_id: teacherSelect.value,
                        day_of_week: daySelect.value,
                        academic_year: academicYearSelect.value,
                        semester: semesterSelect.value
                    }))
                    .then(response => response.json())
                    .then(data => {
                        const startTime = startTimeSelect.value;
                        const endTime = endTimeSelect.value;

                        const hasConflict = data.booked_slots.some(slot => {
                            return (startTime >= slot.start_time && startTime < slot.end_time) ||
                                (endTime > slot.start_time && endTime <= slot.end_time) ||
                                (startTime <= slot.start_time && endTime >= slot.end_time);
                        });

                        if (hasConflict) {
                            conflictAlert.classList.remove('hidden');
                            conflictMessage.textContent =
                                'Il y a un conflit d\'horaire pour cette classe ou cet enseignant.';
                        } else {
                            conflictAlert.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la vérification des conflits:', error);
                    });
            }

            // Écouter les changements sur les champs critiques
            [classSelect, teacherSelect, daySelect, startTimeSelect, endTimeSelect, academicYearSelect,
                semesterSelect
            ]
            .forEach(element => {
                element.addEventListener('change', checkConflicts);
            });

            // Validation de l'heure de fin
            startTimeSelect.addEventListener('change', function() {
                const startTime = this.value;
                const endTimeOptions = endTimeSelect.querySelectorAll('option');

                endTimeOptions.forEach(option => {
                    if (option.value && option.value <= startTime) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        });
    </script>
@endsection
