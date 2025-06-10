{{-- resources/views/backend/schedules/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Emploi du Temps - {{ $class->class_name }}</h1>
                <p class="text-gray-600">{{ $academicYear }} (Semestre {{ $semester }})</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 mt-4 md:mt-0">
                <a href="{{ route('schedules.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
                <button onclick="window.print()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-print mr-2"></i>
                    Imprimer
                </button>
            </div>
        </div>

        <!-- Emploi du temps -->
        @if ($schedulesByDay->isEmpty())
            <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-12 text-center">
                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Aucun cours programmé</h3>
                <p class="text-gray-500 mb-6">Cette classe n'a pas encore d'emploi du temps pour cette période.</p>
                <a href="{{ route('schedules.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Créer un Cours
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Planning - {{ $class->class_name }}</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b-2 border-gray-200">
                                <th class="text-left py-4 px-4 font-semibold text-gray-700 w-24">Horaire</th>
                                @foreach ($days as $dayKey => $dayName)
                                    <th class="text-center py-4 px-2 font-semibold text-gray-700">{{ $dayName }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $timeSlot)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-4 font-medium text-gray-600 bg-gray-50">{{ $timeSlot }}</td>
                                    @foreach ($days as $dayKey => $dayName)
                                        <td class="py-2 px-2 text-center align-top">
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
                                                    class="bg-gradient-to-br from-blue-100 to-blue-200 border border-blue-300 rounded-lg p-3 text-xs shadow-sm">
                                                    <div class="font-bold text-blue-900 mb-1">
                                                        {{ $currentSchedule->subject->subject_name }}</div>
                                                    <div class="text-blue-700 font-medium">
                                                        {{ $currentSchedule->teacher->user->name }}</div>
                                                    <div class="text-blue-600 mt-1">
                                                        {{ $currentSchedule->formatted_start_time }} -
                                                        {{ $currentSchedule->formatted_end_time }}</div>
                                                    @if ($currentSchedule->room)
                                                        <div class="text-blue-600 flex items-center justify-center mt-1">
                                                            <i
                                                                class="fas fa-map-marker-alt mr-1"></i>{{ $currentSchedule->room }}
                                                        </div>
                                                    @endif
                                                    @if ($currentSchedule->notes)
                                                        <div class="text-blue-500 text-xs mt-1 italic">
                                                            {{ $currentSchedule->notes }}</div>
                                                    @endif

                                                    <!-- Actions d'administration -->
                                                    @can('update', $currentSchedule)
                                                        <div class="mt-2 flex justify-center space-x-1 print:hidden">
                                                            <a href="{{ route('schedules.edit', $currentSchedule->id) }}"
                                                                class="text-blue-600 hover:text-blue-800 bg-white/50 rounded px-1">
                                                                <i class="fas fa-edit text-xs"></i>
                                                            </a>
                                                            <form method="POST"
                                                                action="{{ route('schedules.destroy', $currentSchedule->id) }}"
                                                                class="inline"
                                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-red-600 hover:text-red-800 bg-white/50 rounded px-1">
                                                                    <i class="fas fa-trash text-xs"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endcan
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

            <!-- Statistiques rapides -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6 print:hidden">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Heures/semaine</p>
                            <p class="text-2xl font-bold text-gray-900">
                                @php
                                    $totalHours = 0;
                                    foreach ($schedulesByDay as $daySchedules) {
                                        foreach ($daySchedules as $schedule) {
                                            $start = \Carbon\Carbon::parse($schedule->start_time);
                                            $end = \Carbon\Carbon::parse($schedule->end_time);
                                            $totalHours += $end->diffInHours($start);
                                        }
                                    }
                                @endphp
                                {{ $totalHours }}h
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Matières</p>
                            <p class="text-2xl font-bold text-gray-900">
                                @php
                                    $subjects = collect();
                                    foreach ($schedulesByDay as $daySchedules) {
                                        foreach ($daySchedules as $schedule) {
                                            $subjects->push($schedule->subject_id);
                                        }
                                    }
                                @endphp
                                {{ $subjects->unique()->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Enseignants</p>
                            <p class="text-2xl font-bold text-gray-900">
                                @php
                                    $teachers = collect();
                                    foreach ($schedulesByDay as $daySchedules) {
                                        foreach ($daySchedules as $schedule) {
                                            $teachers->push($schedule->teacher_id);
                                        }
                                    }
                                @endphp
                                {{ $teachers->unique()->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Cours/semaine</p>
                            <p class="text-2xl font-bold text-gray-900">
                                @php
                                    $totalCourses = 0;
                                    foreach ($schedulesByDay as $daySchedules) {
                                        $totalCourses += $daySchedules->count();
                                    }
                                @endphp
                                {{ $totalCourses }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        @media print {
            body {
                font-size: 12px;
            }

            .container {
                max-width: none;
                margin: 0;
                padding: 0;
            }

            table {
                page-break-inside: avoid;
            }

            .print\\:hidden {
                display: none !important;
            }
        }
    </style>

    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif
@endsection
