@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-purple-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Historique des présences</h1>
                            <p class="text-gray-600 mt-1">Détail complet des présences de l'étudiant</p>
                        </div>
                    </div>

                    <a href="{{ route('home') }}"
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

            <!-- Student Info Card -->
            @if (isset($attendances[0]))
                <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-6 py-6">
                        <div class="flex items-center">
                            <div
                                class="h-16 w-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4">
                                <span
                                    class="text-white font-bold text-xl">{{ substr($attendances[0]->student->user->name ?? 'N', 0, 1) }}</span>
                            </div>
                            <div class="text-white">
                                <h2 class="text-2xl font-bold">{{ $attendances[0]->student->user->name ?? 'Étudiant' }}</h2>
                                <p class="text-purple-100 mt-1">
                                    Numéro de matricule : {{ $attendances[0]->student->roll_number ?? 'N/A' }}
                                </p>
                                <p class="text-purple-100">
                                    Email : {{ $attendances[0]->student->user->email ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Row -->
                    <div class="grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                        <div class="p-6 text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ count($attendances) }}</div>
                            <div class="text-sm font-medium text-gray-600">Total séances</div>
                        </div>
                        <div class="p-6 text-center">
                            <div class="text-2xl font-bold text-green-600">
                                {{ collect($attendances)->where('attendence_status', true)->count() }}</div>
                            <div class="text-sm font-medium text-gray-600">Présences</div>
                        </div>
                        <div class="p-6 text-center">
                            <div class="text-2xl font-bold text-red-600">
                                {{ collect($attendances)->where('attendence_status', false)->count() }}</div>
                            <div class="text-sm font-medium text-gray-600">Absences</div>
                        </div>
                        <div class="p-6 text-center">
                            @php
                                $totalSessions = count($attendances);
                                $presentSessions = collect($attendances)->where('attendence_status', true)->count();
                                $percentage =
                                    $totalSessions > 0 ? round(($presentSessions / $totalSessions) * 100, 1) : 0;
                            @endphp
                            <div
                                class="text-2xl font-bold {{ $percentage >= 75 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $percentage }}%
                            </div>
                            <div class="text-sm font-medium text-gray-600">Taux de présence</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Attendance History Table -->
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-700 to-gray-800 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Historique détaillé
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>Date</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span>Professeur</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        <span>Classe</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center justify-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Présence</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($attendances as $attendance)
                                <tr
                                    class="hover:bg-gray-50 transition-colors duration-200 {{ $attendance->attendence_status ? 'border-l-4 border-green-400' : 'border-l-4 border-red-400' }}">
                                    <!-- Date -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ \Carbon\Carbon::parse($attendance->attendence_date)->format('d/m/Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($attendance->attendence_date)->format('l') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Teacher -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center mr-3">
                                                <span
                                                    class="text-white font-semibold text-xs">{{ substr($attendance->teacher->user->name ?? 'T', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $attendance->teacher->user->name ?? 'Non assigné' }}</div>
                                                <div class="text-xs text-gray-500">Professeur</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Class -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">
                                            {{ $attendance->class->class_name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $attendance->class->class_description ?? '' }}</div>
                                    </td>

                                    <!-- Attendance Status -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($attendance->attendence_status)
                                            <span
                                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Présent
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                Absent
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="h-12 w-12 text-gray-400 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun historique trouvé</h3>
                                            <p class="text-gray-500">Aucune donnée de présence n'est disponible pour cet
                                                étudiant.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Performance Analysis -->
            @if (count($attendances) > 0)
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Attendance Trend -->
                    <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Analyse de performance
                        </h4>

                        @php
                            $percentage =
                                count($attendances) > 0
                                    ? round(
                                        (collect($attendances)->where('attendence_status', true)->count() /
                                            count($attendances)) *
                                            100,
                                        1,
                                    )
                                    : 0;
                        @endphp

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600">Taux de présence global</span>
                                <span
                                    class="text-sm font-bold {{ $percentage >= 75 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $percentage }}%
                                </span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full {{ $percentage >= 75 ? 'bg-green-500' : ($percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                    style="width: {{ $percentage }}%"></div>
                            </div>

                            <div class="text-xs text-gray-500">
                                @if ($percentage >= 90)
                                    Excellent! Performance exemplaire.
                                @elseif($percentage >= 75)
                                    Très bien! Bonne assiduité.
                                @elseif($percentage >= 50)
                                    Correct, mais peut mieux faire.
                                @else
                                    Attention! Taux d'absentéisme élevé.
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Activité récente
                        </h4>

                        <div class="space-y-3">
                            @foreach ($attendances->take(5) as $recent)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div
                                            class="h-2 w-2 rounded-full mr-3 {{ $recent->attendence_status ? 'bg-green-500' : 'bg-red-500' }}">
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($recent->attendence_date)->format('d/m/Y') }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $recent->class->class_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="text-xs px-2 py-1 rounded-full {{ $recent->attendence_status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $recent->attendence_status ? 'P' : 'A' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
