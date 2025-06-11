@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Gestion des classes</h1>
                            <p class="text-gray-600 mt-1">Administrer les classes, enseignants et matières</p>
                        </div>
                    </div>

                    <a href="{{ route('classes.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nouvelle classe
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total classes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $classes->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total étudiants</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $classes->sum('students_count') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Enseignants assignés</p>
                            <p class="text-2xl font-bold text-gray-900">
                                @php
                                    $uniqueTeachers = collect();
                                    foreach ($classes as $class) {
                                        foreach ($class->teachers as $teacher) {
                                            $uniqueTeachers->push($teacher->id);
                                        }
                                    }
                                @endphp
                                {{ $uniqueTeachers->unique()->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Matières assignées</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $classes->sum(function ($class) {return $class->subjects->count();}) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classes Table -->
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Liste des classes
                    </h2>
                </div>

                <!-- Responsive Table Container -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        <span>Niveau</span>
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
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                            </path>
                                        </svg>
                                        <span>Étudiants</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center justify-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                        <span>Matières</span>
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
                                        <span>Enseignants</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($classes as $class)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <!-- Niveau -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span
                                                class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-800 text-sm font-semibold">
                                                {{ $class->class_numeric }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Classe Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center mr-3">
                                                <span
                                                    class="text-white font-semibold text-sm">{{ substr($class->class_name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $class->class_name }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ Str::limit($class->class_description, 30) ?: 'Aucune description' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Students Count -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                </path>
                                            </svg>
                                            {{ $class->students_count }} étudiants
                                        </span>
                                    </td>

                                    <!-- Subjects -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-wrap gap-1 justify-center">
                                            @forelse ($class->subjects as $subject)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200"
                                                    title="{{ $subject->name }}">
                                                    {{ $subject->subject_code }}
                                                </span>
                                            @empty
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                    Aucune matière
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <!-- Enseignants -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            // Obtenir tous les enseignants de cette classe
                                            $allTeachers = $class->getAllTeachers();
                                        @endphp

                                        @if ($allTeachers->count() > 0)
                                            <div class="space-y-1">
                                                @foreach ($allTeachers->take(3) as $teacher)
                                                    <div class="flex items-center">
                                                        <div
                                                            class="h-6 w-6 bg-gradient-to-br from-emerald-400 to-green-500 rounded-full flex items-center justify-center mr-2">
                                                            <span class="text-white font-semibold text-xs">
                                                                {{ substr($teacher->user->name, 0, 1) }}
                                                            </span>
                                                        </div>
                                                        <div class="text-sm text-gray-900">
                                                            {{ $teacher->user->name }}
                                                        </div>

                                                        @php
                                                            // Vérifier si cet enseignant est directement assigné ou via une matière
                                                            $isDirectlyAssigned = $class->teachers->contains(
                                                                'id',
                                                                $teacher->id,
                                                            );
                                                            $subjectsForTeacher = $class->getSubjectsForTeacher(
                                                                $teacher->id,
                                                            );
                                                        @endphp

                                                        <div class="ml-2">
                                                            @if ($isDirectlyAssigned && $subjectsForTeacher->count() > 0)
                                                                <span
                                                                    class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                                                    title="Enseignant de classe + matières">
                                                                    <svg class="w-3 h-3" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                        </path>
                                                                    </svg>
                                                                </span>
                                                            @elseif($isDirectlyAssigned)
                                                                <span
                                                                    class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                                                    title="Enseignant de classe">
                                                                    C
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800"
                                                                    title="Enseigne: {{ $subjectsForTeacher->pluck('name')->join(', ') }}">
                                                                    M
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @if ($allTeachers->count() > 3)
                                                    <div class="text-xs text-gray-500 ml-8">
                                                        +{{ $allTeachers->count() - 3 }} autre(s)
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                                    </path>
                                                </svg>
                                                Aucun enseignant
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Edit -->
                                            <a href="{{ route('classes.edit', $class->id) }}"
                                                class="inline-flex items-center p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-all duration-200 hover:scale-105 group"
                                                title="Modifier">
                                                <svg class="h-4 w-4 group-hover:scale-110 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <!-- Assign Subject -->
                                            <a href="{{ route('class.assign.subject', $class->id) }}"
                                                class="inline-flex items-center p-2 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-lg transition-all duration-200 hover:scale-105 group"
                                                title="Assigner matières">
                                                <svg class="h-4 w-4 group-hover:scale-110 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                    </path>
                                                </svg>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('classes.destroy', $class->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-all duration-200 hover:scale-105 group"
                                                    title="Supprimer">
                                                    <svg class="h-4 w-4 group-hover:scale-110 transition-transform"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="h-12 w-12 text-gray-400 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune classe trouvée</h3>
                                            <p class="text-gray-500 mb-4">Commencez par créer votre première classe.</p>
                                            <a href="{{ route('classes.create') }}"
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Créer une classe
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($classes->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Affichage de {{ $classes->firstItem() }} à {{ $classes->lastItem() }} sur
                                {{ $classes->total() }} résultats
                            </div>
                            <div class="pagination-wrapper">
                                {{ $classes->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-blue-800">Nouveau système simplifié</h3>
                        <ul class="mt-2 text-sm text-blue-700 space-y-1">
                            <li>• <strong>Gestion séparée :</strong> L'assignation d'enseignants et l'assignation de
                                matières sont maintenant distinctes</li>
                            <li>• <strong>Plus de notion de professeur principal :</strong> Tous les enseignants d'une
                                classe ont le même statut</li>
                            <li>• <strong>Flexibilité :</strong> Une matière peut avoir plusieurs enseignants selon vos
                                besoins</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .pagination-wrapper .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination-wrapper .pagination .page-link {
            padding: 0.5rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .pagination-wrapper .pagination .page-link:hover {
            background-color: #f3f4f6;
            color: #374151;
        }

        .pagination-wrapper .pagination .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }
    </style>
@endsection
