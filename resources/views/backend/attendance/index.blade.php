@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Rapport de présences</h1>
                            <p class="text-gray-600 mt-1">Consultez les statistiques de présence par classe et période</p>
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

            <!-- Filters Section -->
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z">
                            </path>
                        </svg>
                        Filtres de recherche
                    </h2>
                </div>

                <form action="{{ route('attendance.index') }}" method="GET" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">

                        <!-- Report Type -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Type de rapport
                            </label>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="type" value="class" checked
                                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                    <span class="ml-3 flex items-center text-gray-700 font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        Par classe
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Month Selection -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Mois de consultation
                            </label>
                            <div class="relative">
                                <select name="month"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none">
                                    <option value="">-- Sélectionner un mois --</option>
                                    @foreach ($months as $month => $values)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Generate Button -->
                        <div>
                            <button type="submit"
                                class="w-full group relative px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 transform hover:scale-105 active:scale-95">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-emerald-300 group-hover:text-emerald-200 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </span>
                                Générer le rapport
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Attendance Reports -->
            @if (!empty($attendances))
                <div class="space-y-8">
                    @foreach ($attendances as $classid => $datevalues)
                        <div
                            class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">

                            <!-- Class Header -->
                            <div class="bg-gradient-to-r from-slate-700 to-gray-800 px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xl font-bold text-white flex items-center">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        Classe {{ $classid }}
                                    </h3>
                                    <div class="text-gray-300 text-sm">
                                        {{ count($datevalues) }} jours de présence
                                    </div>
                                </div>
                            </div>

                            <!-- Attendance Data -->
                            <div class="p-6">
                                @foreach ($datevalues as $key => $attendancevals)
                                    <div class="mb-6 last:mb-0">
                                        <!-- Date Header -->
                                        <div
                                            class="flex items-center justify-between mb-4 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-200">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-8 w-8 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $key }}</h4>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                {{ count($attendancevals) }} étudiants
                                            </div>
                                        </div>

                                        <!-- Students Grid -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach ($attendancevals as $vals => $attendance)
                                                <div
                                                    class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-all duration-200">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="h-8 w-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mr-3">
                                                            <span
                                                                class="text-white font-semibold text-xs">{{ substr($attendance->student->user->name, 0, 1) }}</span>
                                                        </div>
                                                        <div>
                                                            <p class="font-medium text-gray-900 text-sm">
                                                                {{ $attendance->student->user->name }}</p>
                                                            <p class="text-xs text-gray-500">Roll:
                                                                {{ $attendance->student->roll_number ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="flex-shrink-0">
                                                        @if ($attendance->attendence_status)
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                                <svg class="w-3 h-3 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                    </path>
                                                                </svg>
                                                                Présent
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                                <svg class="w-3 h-3 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                    </path>
                                                                </svg>
                                                                Absent
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Daily Statistics -->
                                        <div class="mt-4 grid grid-cols-2 gap-4">
                                            <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm font-medium text-green-800">Présents</p>
                                                        <p class="text-lg font-bold text-green-900">
                                                            {{ collect($attendancevals)->where('attendence_status', true)->count() }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-red-50 rounded-lg p-3 border border-red-200">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm font-medium text-red-800">Absents</p>
                                                        <p class="text-lg font-bold text-red-900">
                                                            {{ collect($attendancevals)->where('attendence_status', false)->count() }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 p-12 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">Aucun rapport disponible</h3>
                        <p class="text-gray-500 mb-6">Sélectionnez un mois et générez un rapport pour voir les données de
                            présence.</p>
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-blue-500 mt-0.5 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="text-left">
                                    <h4 class="text-sm font-medium text-blue-800">Comment générer un rapport</h4>
                                    <ul class="mt-2 text-sm text-blue-700 space-y-1">
                                        <li>• Sélectionnez un mois dans le filtre ci-dessus</li>
                                        <li>• Cliquez sur "Générer le rapport"</li>
                                        <li>• Consultez les statistiques détaillées par classe et date</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
