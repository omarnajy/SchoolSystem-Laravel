{{-- resources/views/backend/schedules/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestion des Emplois du Temps</h1>
                <p class="text-gray-600">Gérez les emplois du temps pour toutes les classes</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 mt-4 md:mt-0">
                <a href="{{ route('schedules.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Nouveau Cours
                </a>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <form method="GET" action="{{ route('schedules.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Année Académique</label>
                    <select name="academic_year"
                        class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="{{ date('Y') }}" {{ $academicYear == date('Y') ? 'selected' : '' }}>
                            {{ date('Y') }}</option>
                        <option value="{{ date('Y') + 1 }}" {{ $academicYear == date('Y') + 1 ? 'selected' : '' }}>
                            {{ date('Y') + 1 }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Semestre</label>
                    <select name="semester"
                        class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="1" {{ $semester == '1' ? 'selected' : '' }}>Semestre 1</option>
                        <option value="2" {{ $semester == '2' ? 'selected' : '' }}>Semestre 2</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Classe</label>
                    <select name="class_id"
                        class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Toutes les classes</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Filtrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Emplois du temps par classe -->
        @if ($organizedSchedules->isEmpty())
            <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-12 text-center">
                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Aucun emploi du temps trouvé</h3>
                <p class="text-gray-500 mb-6">Commencez par créer un emploi du temps pour vos classes.</p>
                <a href="{{ route('schedules.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Créer un Emploi du Temps
                </a>
            </div>
        @else
            @foreach ($organizedSchedules as $classId => $schedulesByDay)
                @php $class = $classes->find($classId) @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
                    <!-- En-tête de classe -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $class->class_name }}</h3>
                                <p class="text-blue-100">Emploi du temps - {{ $academicYear }} (Semestre
                                    {{ $semester }})</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('schedules.show', $classId) }}"
                                    class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-eye mr-2"></i>Voir
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Grille emploi du temps -->
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-gray-200">
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Horaire</th>
                                        @foreach (['monday' => 'Lundi', 'tuesday' => 'Mardi', 'wednesday' => 'Mercredi', 'thursday' => 'Jeudi', 'friday' => 'Vendredi', 'saturday' => 'Samedi'] as $dayKey => $dayName)
                                            <th class="text-center py-3 px-4 font-semibold text-gray-700">
                                                {{ $dayName }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $timeSlot)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                            <td class="py-3 px-4 font-medium text-gray-600">{{ $timeSlot }}</td>
                                            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $dayKey)
                                                <td class="py-3 px-4 text-center">
                                                    @php
                                                        $daySchedules = $schedulesByDay->get($dayKey, collect());
                                                        $currentSchedule = $daySchedules
                                                            ->filter(function ($schedule) use ($timeSlot) {
                                                                return $schedule->formatted_start_time == $timeSlot;
                                                            })
                                                            ->first();
                                                    @endphp

                                                    @if ($currentSchedule)
                                                        <div
                                                            class="bg-blue-100 border border-blue-300 rounded-lg p-2 text-xs">
                                                            <div class="font-semibold text-blue-800">
                                                                {{ $currentSchedule->subject->subject_name }}</div>
                                                            <div class="text-blue-600">
                                                                {{ $currentSchedule->teacher->user->name }}</div>
                                                            <div class="text-blue-500">
                                                                {{ $currentSchedule->formatted_start_time }} -
                                                                {{ $currentSchedule->formatted_end_time }}</div>
                                                            @if ($currentSchedule->room)
                                                                <div class="text-blue-500">{{ $currentSchedule->room }}
                                                                </div>
                                                            @endif
                                                            <div class="mt-1 flex justify-center space-x-1">
                                                                <a href="{{ route('schedules.edit', $currentSchedule->id) }}"
                                                                    class="text-blue-600 hover:text-blue-800">
                                                                    <i class="fas fa-edit text-xs"></i>
                                                                </a>
                                                                <form method="POST"
                                                                    action="{{ route('schedules.destroy', $currentSchedule->id) }}"
                                                                    class="inline"
                                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="text-red-600 hover:text-red-800">
                                                                        <i class="fas fa-trash text-xs"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $errors->first() }}
            </div>
        </div>
    @endif
@endsection
