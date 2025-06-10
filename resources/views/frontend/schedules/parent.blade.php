{{-- resources/views/frontend/schedules/parent.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Emploi du Temps de mes Enfants</h1>
                <p class="text-gray-600">{{ $academicYear }} (Semestre {{ $semester }})</p>
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

        <!-- Liste des enfants et leurs emplois du temps -->
        @if ($children->isEmpty())
            <div class="bg-yellow-50 rounded-xl border-2 border-dashed border-yellow-300 p-12 text-center">
                <i class="fas fa-info-circle text-4xl text-yellow-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-yellow-800 mb-2">Aucun enfant trouvé</h3>
                <p class="text-yellow-700 mb-6">Aucun enfant n'est actuellement associé à votre compte.</p>
                <div class="space-y-4">
                    <a href="{{ route('parents.show', auth()->user()->id) }}"
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                        <i class="fas fa-heart mr-2"></i>
                        Voir mes Enfants
                    </a>
                    <p class="text-yellow-600 text-sm">
                        Pour associer vos enfants à votre compte, veuillez contacter l'administration.
                    </p>
                </div>
            </div>
        @else
            @foreach ($children as $child)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                    <!-- En-tête de l'enfant -->
                    <div class="bg-gradient-to-r from-pink-500 to-purple-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-graduate text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">{{ $child->user->name }}</h2>
                                    <p class="text-pink-100">Classe {{ $child->class->class_name ?? 'Non assignée' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-pink-100 text-sm">Emploi du temps</p>
                                <p class="text-white font-medium">{{ $academicYear }} - S{{ $semester }}</p>
                            </div>
                        </div>
                    </div>

                    @php
                        $childSchedules = $child->getSchedules($academicYear, $semester);
                        $schedulesByDay = $childSchedules->groupBy('day_of_week');
                        $days = \App\Schedule::getDaysOfWeek();
                    @endphp

                    <!-- Emploi du temps de l'enfant -->
                    @if ($childSchedules->isEmpty())
                        <div class="p-8 text-center">
                            <i class="fas fa-calendar-times text-3xl text-gray-400 mb-3"></i>
                            <h4 class="text-lg font-medium text-gray-600 mb-2">Aucun cours programmé</h4>
                            <p class="text-gray-500">L'emploi du temps de {{ $child->user->name }} n'est pas encore
                                disponible.</p>
                        </div>
                    @else
                        <!-- Vue grille (desktop) -->
                        <div class="hidden lg:block overflow-hidden print:block">
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 border-b-2 border-gray-200">
                                            <th class="text-left py-3 px-3 font-semibold text-gray-700 w-20 text-sm">Horaire
                                            </th>
                                            @foreach ($days as $dayKey => $dayName)
                                                <th class="text-center py-3 px-2 font-semibold text-gray-700 text-sm">
                                                    {{ $dayName }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $timeSlot)
                                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                                <td class="py-3 px-3 font-medium text-gray-600 bg-gray-50 text-sm">
                                                    {{ $timeSlot }}</td>
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
                                                                class="bg-gradient-to-br from-blue-100 to-blue-200 border border-blue-300 rounded-lg p-2 text-xs shadow-sm">
                                                                <div class="font-bold text-blue-900 mb-1 text-xs">
                                                                    {{ $currentSchedule->subject->subject_name }}</div>
                                                                <div class="text-blue-700 font-medium text-xs">
                                                                    {{ $currentSchedule->teacher->user->name }}</div>
                                                                <div class="text-blue-600 mt-1 text-xs">
                                                                    {{ $currentSchedule->formatted_start_time }} -
                                                                    {{ $currentSchedule->formatted_end_time }}</div>
                                                                @if ($currentSchedule->room)
                                                                    <div
                                                                        class="text-blue-600 flex items-center justify-center mt-1 text-xs">
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
                        <div class="lg:hidden print:hidden p-4">
                            <div class="space-y-4">
                                @foreach ($days as $dayKey => $dayName)
                                    @php $daySchedules = $schedulesByDay->get($dayKey, collect()) @endphp
                                    <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 px-4 py-2">
                                            <h4 class="text-white font-bold text-sm">{{ $dayName }}</h4>
                                        </div>

                                        @if ($daySchedules->isEmpty())
                                            <div class="p-4 text-center text-gray-500">
                                                <i class="fas fa-calendar-day text-lg mb-1"></i>
                                                <p class="text-sm">Aucun cours</p>
                                            </div>
                                        @else
                                            <div class="p-3 space-y-2">
                                                @foreach ($daySchedules->sortBy('start_time') as $schedule)
                                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <span
                                                                class="font-bold text-blue-900 text-sm">{{ $schedule->subject->subject_name }}</span>
                                                            <span
                                                                class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                                                {{ $schedule->formatted_start_time }} -
                                                                {{ $schedule->formatted_end_time }}
                                                            </span>
                                                        </div>
                                                        <div class="text-gray-700 font-medium text-xs mb-1">
                                                            <i
                                                                class="fas fa-chalkboard-teacher mr-1"></i>{{ $schedule->teacher->user->name }}
                                                        </div>
                                                        @if ($schedule->room)
                                                            <div class="text-gray-600 text-xs">
                                                                <i
                                                                    class="fas fa-map-marker-alt mr-1"></i>{{ $schedule->room }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Statistiques pour cet enfant -->
                        <div class="p-6 bg-gray-50 border-t border-gray-200 print:hidden">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">
                                        @php
                                            $totalHours = 0;
                                            foreach ($childSchedules as $schedule) {
                                                $start = \Carbon\Carbon::parse($schedule->start_time);
                                                $end = \Carbon\Carbon::parse($schedule->end_time);
                                                $totalHours += $end->diffInHours($start);
                                            }
                                        @endphp
                                        {{ $totalHours }}h
                                    </div>
                                    <div class="text-xs text-gray-600">Heures/semaine</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ $childSchedules->pluck('subject_id')->unique()->count() }}
                                    </div>
                                    <div class="text-xs text-gray-600">Matières</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-600">
                                        {{ $childSchedules->pluck('teacher_id')->unique()->count() }}
                                    </div>
                                    <div class="text-xs text-gray-600">Enseignants</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-orange-600">
                                        {{ $childSchedules->count() }}
                                    </div>
                                    <div class="text-xs text-gray-600">Cours/semaine</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            <!-- Conseils pour les parents -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden print:hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">Conseils pour un Suivi Optimal</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Conseil 1 -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mb-3">
                                <i class="fas fa-calendar-check text-white"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 mb-2">Vérifiez Régulièrement</h4>
                            <p class="text-gray-600 text-sm">Consultez l'emploi du temps de vos enfants chaque semaine pour
                                anticiper leur emploi du temps.</p>
                        </div>

                        <!-- Conseil 2 -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-3">
                                <i class="fas fa-comments text-white"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 mb-2">Communiquez</h4>
                            <p class="text-gray-600 text-sm">Restez en contact avec les enseignants pour suivre les progrès
                                de vos enfants.</p>
                        </div>

                        <!-- Conseil 3 -->
                        <div
                            class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-3">
                                <i class="fas fa-home text-white"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 mb-2">Organisez à la Maison</h4>
                            <p class="text-gray-600 text-sm">Aidez vos enfants à organiser leurs affaires selon leur emploi
                                du temps.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        @media print {
            body {
                font-size: 11px;
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
