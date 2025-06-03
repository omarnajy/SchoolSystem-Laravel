@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Feuille de présence</h1>
                            <p class="text-gray-600 mt-1">Classe : <span
                                    class="font-semibold text-blue-600">{{ $class->class_name }}</span></p>
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

            <!-- Date and Status Bar -->
            <div class="mb-8 bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-10 w-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-lg flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Date d'aujourd'hui</p>
                            <p class="text-lg font-bold text-gray-900">{{ date('d/m/Y') }}</p>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    <div class="text-right">
                        @error('attendences')
                            <div class="flex items-center text-red-600 bg-red-50 px-4 py-2 rounded-lg border border-red-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                        @if (session('status'))
                            <div
                                class="flex items-center text-red-600 bg-red-50 px-4 py-2 rounded-lg border border-red-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Attendance Form -->
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Liste des étudiants ({{ $class->students->count() }} étudiants)
                    </h2>
                </div>

                <form action="{{ route('teacher.attendance.store') }}" method="POST" class="p-6">
                    @csrf

                    <!-- Table Header -->
                    <div
                        class="grid grid-cols-12 gap-4 items-center bg-gray-50 rounded-lg p-4 mb-4 font-semibold text-gray-700">
                        <div class="col-span-5 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Étudiant
                        </div>
                        <div class="col-span-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            Numéro
                        </div>
                        <div class="col-span-5 text-center">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                            Présence
                        </div>
                    </div>

                    <!-- Students List -->
                    <div class="space-y-3">
                        @foreach ($class->students as $index => $student)
                            <div
                                class="grid grid-cols-12 gap-4 items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all duration-200 group">

                                <!-- Student Info -->
                                <div class="col-span-5 flex items-center">
                                    <div
                                        class="h-10 w-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mr-3">
                                        <span
                                            class="text-white font-semibold text-sm">{{ substr($student->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $student->user->name }}</p>
                                        <p class="text-xs text-gray-500">ID: {{ $student->id }}</p>
                                    </div>
                                </div>

                                <!-- Roll Number -->
                                <div class="col-span-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $student->roll_number }}
                                    </span>
                                </div>

                                <!-- Attendance Radio Buttons -->
                                <div class="col-span-5 flex items-center justify-center space-x-6">
                                    <!-- Present -->
                                    <label
                                        class="flex items-center cursor-pointer group-hover:scale-105 transition-transform">
                                        <input type="radio" name="attendences[{{ $student->id }}]" value="present"
                                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                        <span class="ml-2 flex items-center text-green-600 font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Présent
                                        </span>
                                    </label>

                                    <!-- Absent -->
                                    <label
                                        class="flex items-center cursor-pointer group-hover:scale-105 transition-transform">
                                        <input type="radio" name="attendences[{{ $student->id }}]" value="absent"
                                            class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                                        <span class="ml-2 flex items-center text-red-600 font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            Absent
                                        </span>
                                    </label>
                                </div>

                                <!-- Hidden Inputs -->
                                <input type="hidden" name="class_id" value="{{ $student->class_id }}">
                                <input type="hidden" name="teacher_id" value="{{ $class->teacher_id }}">
                            </div>
                        @endforeach
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">{{ $class->students->count() }}</span> étudiants au total
                            </div>

                            <div class="flex items-center space-x-4">
                                <a href="{{ route('home') }}"
                                    class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    Annuler
                                </a>

                                <button type="submit"
                                    class="group relative px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105 active:scale-95">
                                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </span>
                                    Enregistrer les présences
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center">
                        <div class="h-8 w-8 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">Action rapide</p>
                            <button onclick="markAllPresent()" class="text-xs text-green-600 hover:text-green-500">
                                Marquer tous présents
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                    <div class="flex items-center">
                        <div class="h-8 w-8 bg-red-500 rounded-lg flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">Action rapide</p>
                            <button onclick="markAllAbsent()" class="text-xs text-red-600 hover:text-red-500">
                                Marquer tous absents
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-center">
                        <div class="h-8 w-8 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">Action rapide</p>
                            <button onclick="clearAll()" class="text-xs text-blue-600 hover:text-blue-500">
                                Tout effacer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function markAllPresent() {
            document.querySelectorAll('input[value="present"]').forEach(radio => {
                radio.checked = true;
            });
        }

        function markAllAbsent() {
            document.querySelectorAll('input[value="absent"]').forEach(radio => {
                radio.checked = true;
            });
        }

        function clearAll() {
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.checked = false;
            });
        }
    </script>
@endsection
