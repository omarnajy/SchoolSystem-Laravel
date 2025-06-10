{{-- resources/views/frontend/schedules/student.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Mon Emploi du Temps</h1>
                <p class="text-gray-600">Classe {{ $class->class_name }} - {{ $academicYear }} (Semestre {{ $semester }})
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 mt-4 md:mt-0">
                <button onclick="window.print()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-print mr-2"></i>
                    Imprimer
                </button>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <form method="GET" action="{{ route('schedules.my.show') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>

        <!-- Emploi du temps -->
        @if ($schedulesByDay->isEmpty())
            <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-12 text-center">
                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Aucun cours programmé</h3>
                <p class="text-gray-500">Votre emploi du temps n'est pas encore disponible pour cette période.</p>
            </div>
        @else
            <!-- Vue grille (desktop) -->
            <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden print:block">
                <div class="bg-gradient-to-r from-green-600 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Emploi du Temps - {{ $class->class_name }}</h2>
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
                                <tr class="border-b border-gray-100 hover:bg-gray-50 print:hover:bg-white">
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

            <!-- Vue mobile (liste) -->
            <div class="lg:hidden print:hidden space-y-4">
                @foreach ($days as $dayKey => $dayName)
                    @php $daySchedules = $schedulesByDay->get($dayKey, collect()) @endphp
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 px-4 py-3">
                            <h3 class="text-lg font-bold text-white">{{ $dayName }}</h3>
                        </div>

                        @if ($daySchedules->isEmpty())
                            <div class="p-6 text-center text-gray-500">
                                <i class="fas fa-calendar-day text-2xl mb-2"></i>
                                <p>Aucun cours programmé</p>
                            </div>
                        @else
                            <div class="p-4 space-y-3">
                                @foreach ($daySchedules->sortBy('start_time') as $schedule)
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <span
                                                class="font-bold text-blue-900">{{ $schedule->subject->subject_name }}</span>
                                            <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                                {{ $schedule->formatted_start_time }} -
                                                {{ $schedule->formatted_end_time }}
                                            </span>
                                        </div>
                                        <div class="text-gray-700 font-medium mb-1">
                                            <i
                                                class="fas fa-chalkboard-teacher mr-2"></i>{{ $schedule->teacher->user->name }}
                                        </div>
                                        @if ($schedule->room)
                                            <div class="text-gray-600 text-sm">
                                                <i class="fas fa-map-marker-alt mr-2"></i>{{ $schedule->room }}
                                            </div>
                                        @endif
                                        @if ($schedule->notes)
                                            <div class="text-gray-600 text-sm mt-2 italic">
                                                <i class="fas fa-sticky-note mr-2"></i>{{ $schedule->notes }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Statistiques et informations -->
            <div class="mt-8 print:hidden">
                <!-- Statistiques rapides -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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

                <!-- Résumé par matière -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white">Mes Matières cette Semaine</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $subjectSummary = [];
                                foreach ($schedulesByDay as $daySchedules) {
                                    foreach ($daySchedules as $schedule) {
                                        $subjectName = $schedule->subject->subject_name;

                                        if (!isset($subjectSummary[$subjectName])) {
                                            $subjectSummary[$subjectName] = [
                                                'subject' => $schedule->subject,
                                                'teacher' => $schedule->teacher,
                                                'hours' => 0,
                                                'sessions' => 0,
                                                'rooms' => [],
                                            ];
                                        }

                                        if ($schedule->room) {
                                            $subjectSummary[$subjectName]['rooms'][] = $schedule->room;
                                        }

                                        $start = \Carbon\Carbon::parse($schedule->start_time);
                                        $end = \Carbon\Carbon::parse($schedule->end_time);
                                        $subjectSummary[$subjectName]['hours'] += $end->diffInHours($start);
                                        $subjectSummary[$subjectName]['sessions']++;
                                    }
                                }
                            @endphp

                            @forelse ($subjectSummary as $subjectName => $summary)
                                <div
                                    class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow">
                                    <div class="flex items-start space-x-3 mb-3">
                                        <div
                                            class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-book text-indigo-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-900 text-sm">{{ $subjectName }}</h4>
                                            <p class="text-xs text-gray-600">{{ $summary['teacher']->user->name }}</p>
                                        </div>
                                    </div>

                                    <div class="space-y-2 text-xs text-gray-600">
                                        <div class="flex justify-between">
                                            <span>Séances:</span>
                                            <span class="font-medium">{{ $summary['sessions'] }}/semaine</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Durée:</span>
                                            <span class="font-medium">{{ $summary['hours'] }}h/semaine</span>
                                        </div>
                                        @if (!empty($summary['rooms']))
                                            <div class="flex justify-between">
                                                <span>Salles:</span>
                                                <span
                                                    class="font-medium">{{ implode(', ', array_unique($summary['rooms'])) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center text-gray-500 py-8">
                                    <i class="fas fa-book text-3xl mb-2"></i>
                                    <p>Aucune matière programmée</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Conseils pour les étudiants -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-8">
                    <div class="bg-gradient-to-r from-green-500 to-blue-500 px-6 py-4">
                        <h3 class="text-xl font-bold text-white">Conseils pour Réussir</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Conseil 1 -->
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mb-3">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2">Soyez Ponctuel</h4>
                                <p class="text-gray-600 text-sm">Arrivez 5 minutes avant le début de chaque cours pour être
                                    prêt à apprendre.</p>
                            </div>

                            <!-- Conseil 2 -->
                            <div
                                class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-3">
                                    <i class="fas fa-notebook text-white"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2">Prenez des Notes</h4>
                                <p class="text-gray-600 text-sm">Notez les points importants et n'hésitez pas à poser des
                                    questions.</p>
                            </div>

                            <!-- Conseil 3 -->
                            <div
                                class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-3">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2">Participez</h4>
                                <p class="text-gray-600 text-sm">Participez activement aux discussions et travaux de
                                    groupe.</p>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                            <p class="text-gray-500 text-sm">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Consultez régulièrement votre emploi du temps pour ne manquer aucun cours
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

            .print\\:block {
                display: block !important;
            }

            .print\\:hover\\:bg-white:hover {
                background-color: white !important;
            }
        }

        /* Animations pour améliorer l'expérience utilisateur */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animation pour les cartes de matières */
        .subject-card {
            transition: all 0.3s ease;
        }

        .subject-card:hover {
            transform: translateY(-2px);
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
