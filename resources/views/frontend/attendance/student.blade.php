{{-- resources/views/frontend/attendance/student.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Mes Présences</h1>
                <p class="text-gray-600">{{ $student->user->name }} - Classe
                    {{ $student->class->class_name ?? 'Non assignée' }}</p>
                <p class="text-gray-500 text-sm">Du {{ $startDate->format('d/m/Y') }} au {{ $endDate->format('d/m/Y') }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 mt-4 md:mt-0">
                <button onclick="window.print()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-print mr-2"></i>
                    Imprimer
                </button>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Total Jours</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalDays }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-calendar text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Présent</p>
                        <p class="text-3xl font-bold mt-2">{{ $presentDays }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-check text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium uppercase tracking-wide">Absent</p>
                        <p class="text-3xl font-bold mt-2">{{ $absentDays }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-times text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">Taux de Présence</p>
                        <p class="text-3xl font-bold mt-2">{{ $attendanceRate }}%</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de progression -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Progression de l'assiduité</h3>
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Taux de présence</span>
                <span>{{ $attendanceRate }}% ({{ $presentDays }}/{{ $totalDays }})</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-gradient-to-r from-green-400 to-green-600 h-4 rounded-full transition-all duration-500"
                    style="width: {{ $attendanceRate }}%"></div>
            </div>
            <div class="mt-2 text-xs text-gray-500">
                @if ($attendanceRate >= 90)
                    <span class="text-green-600 font-medium">Excellente assiduité ! Continuez ainsi.</span>
                @elseif($attendanceRate >= 75)
                    <span class="text-yellow-600 font-medium">Bonne assiduité, mais peut être améliorée.</span>
                @else
                    <span class="text-red-600 font-medium">Assiduité à améliorer. Contactez votre enseignant si
                        nécessaire.</span>
                @endif
            </div>
        </div>

        <!-- Historique des présences -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <h3 class="text-xl font-bold text-white">Historique des Présences</h3>
            </div>

            @if ($attendances->isNotEmpty())
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach ($attendances->sortByDesc('attendence_date') as $attendance)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center {{ $attendance->attendence_status ? 'bg-green-100' : 'bg-red-100' }}">
                                        <i
                                            class="fas fa-{{ $attendance->attendence_status ? 'check' : 'times' }} {{ $attendance->attendence_status ? 'text-green-600' : 'text-red-600' }}"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($attendance->attendence_date)->format('l d F Y') }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($attendance->attendence_date)->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $attendance->attendence_status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $attendance->attendence_status ? 'Présent(e)' : 'Absent(e)' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                    <h4 class="text-lg font-medium text-gray-600 mb-2">Aucune donnée de présence</h4>
                    <p class="text-gray-500">Aucune donnée de présence disponible pour cette période.</p>
                </div>
            @endif
        </div>

        <!-- Conseils pour l'étudiant -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-8 print:hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h3 class="text-xl font-bold text-white">Conseils pour une Meilleure Assiduité</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Conseil 1 -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Soyez Ponctuel</h4>
                        <p class="text-gray-600 text-sm">Organisez votre emploi du temps pour arriver à l'heure en cours.
                        </p>
                    </div>

                    <!-- Conseil 2 -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-heartbeat text-white"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Prenez Soin de Vous</h4>
                        <p class="text-gray-600 text-sm">Maintenez une bonne hygiène de vie pour éviter les absences pour
                            maladie.</p>
                    </div>

                    <!-- Conseil 3 -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mb-3">
                            <i class="fas fa-comments text-white"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Communiquez</h4>
                        <p class="text-gray-600 text-sm">En cas de problème, n'hésitez pas à contacter vos enseignants.</p>
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
