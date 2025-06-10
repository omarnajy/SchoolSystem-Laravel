{{-- resources/views/frontend/attendance/parent.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Présences de mes Enfants</h1>
                <p class="text-gray-600">Du {{ $startDate->format('d/m/Y') }} au {{ $endDate->format('d/m/Y') }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 mt-4 md:mt-0">
                <button onclick="window.print()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-print mr-2"></i>
                    Imprimer
                </button>
            </div>
        </div>

        <!-- Statistiques globales -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @php
                $totalChildrenDays = collect($statistics)->sum('total_days');
                $totalPresentDays = collect($statistics)->sum('present_days');
                $globalAttendanceRate =
                    $totalChildrenDays > 0 ? round(($totalPresentDays / $totalChildrenDays) * 100) : 0;
            @endphp

            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Enfants suivis</p>
                        <p class="text-3xl font-bold mt-2">{{ count($children) }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Présences totales</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalPresentDays }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-calendar-check text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">Taux global</p>
                        <p class="text-3xl font-bold mt-2">{{ $globalAttendanceRate }}%</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Présences par enfant -->
        @foreach ($children as $child)
            @php $childStats = $statistics[$child->id] ?? null; @endphp

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
                        @if ($childStats)
                            <div class="text-right">
                                <p class="text-white font-bold text-lg">{{ $childStats['attendance_rate'] }}%</p>
                                <p class="text-pink-100 text-sm">Taux de présence</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($childStats && $childStats['total_days'] > 0)
                    <!-- Statistiques de l'enfant -->
                    <div class="p-6 bg-gray-50 border-b border-gray-200">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-bold text-green-600">{{ $childStats['present_days'] }}</div>
                                <div class="text-sm text-gray-600">Présent(e)</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-red-600">{{ $childStats['absent_days'] }}</div>
                                <div class="text-sm text-gray-600">Absent(e)</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-blue-600">{{ $childStats['total_days'] }}</div>
                                <div class="text-sm text-gray-600">Total jours</div>
                            </div>
                        </div>

                        <!-- Barre de progression -->
                        <div class="mt-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Taux de présence</span>
                                <span>{{ $childStats['attendance_rate'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full transition-all duration-300"
                                    style="width: {{ $childStats['attendance_rate'] }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Détail des présences -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Détail des présences (30 derniers jours)</h3>

                        @php $childAttendances = $attendancesByChild[$child->id] ?? collect(); @endphp

                        @if ($childAttendances->isNotEmpty())
                            <div class="space-y-2">
                                @foreach ($childAttendances->sortByDesc('attendence_date')->take(10) as $attendance)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-8 h-8 rounded-full flex items-center justify-center {{ $attendance->attendence_status ? 'bg-green-100' : 'bg-red-100' }}">
                                                <i
                                                    class="fas fa-{{ $attendance->attendence_status ? 'check' : 'times' }} text-sm {{ $attendance->attendence_status ? 'text-green-600' : 'text-red-600' }}"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($attendance->attendence_date)->format('l d/m/Y') }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($attendance->attendence_date)->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attendance->attendence_status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $attendance->attendence_status ? 'Présent(e)' : 'Absent(e)' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($childAttendances->count() > 10)
                                    <div class="text-center pt-4">
                                        <p class="text-gray-500 text-sm">
                                            ... et {{ $childAttendances->count() - 10 }} autres enregistrements
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-calendar-times text-3xl mb-2"></i>
                                <p>Aucune donnée de présence pour cette période</p>
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Aucune donnée -->
                    <div class="p-8 text-center">
                        <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-600 mb-2">Aucune donnée de présence</h4>
                        <p class="text-gray-500">Aucune donnée de présence disponible pour {{ $child->user->name }} sur
                            cette période.</p>
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
                        <h4 class="font-bold text-gray-800 mb-2">Surveillez Régulièrement</h4>
                        <p class="text-gray-600 text-sm">Consultez les présences de vos enfants chaque semaine pour détecter
                            les absences récurrentes.</p>
                    </div>

                    <!-- Conseil 2 -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-comments text-white"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Communiquez</h4>
                        <p class="text-gray-600 text-sm">En cas d'absences répétées, contactez l'établissement pour
                            comprendre les raisons.</p>
                    </div>

                    <!-- Conseil 3 -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-heart text-white"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Encouragez l'Assiduité</h4>
                        <p class="text-gray-600 text-sm">Félicitez vos enfants pour leur régularité et encouragez-les à
                            maintenir une bonne assiduité.</p>
                    </div>
                </div>
            </div>
        </div>
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

            .print\:hidden {
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
