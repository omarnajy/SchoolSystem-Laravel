@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-orange-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Modifier la classe</h1>
                            <p class="text-gray-600 mt-1">Mettre à jour les informations de la classe <span
                                    class="font-semibold text-amber-600">{{ $class->class_name }}</span></p>
                        </div>
                    </div>

                    <a href="{{ route('classes.index') }}"
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

            <!-- Current Class Info Card -->
            <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 p-6 mb-8">
                <div class="flex items-center">
                    <div
                        class="h-16 w-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-xl">{{ substr($class->class_name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $class->class_name }}</h3>
                        <p class="text-gray-600">Niveau {{ $class->class_numeric }} •
                            {{ $class->class_description ?: 'Aucune description' }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Professeur : {{ $class->teacher->user->name ?? 'Non assigné' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Modifier les informations
                    </h2>
                    <p class="text-amber-100 mt-1">Mettez à jour les détails de la classe</p>
                </div>

                <form action="{{ route('classes.update', $class->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Class Name Field -->
                        <div class="group">
                            <label for="class_name" class="block text-sm font-semibold text-gray-700 mb-3">
                                Nom de la classe *
                            </label>
                            <div class="relative">
                                <input type="text" name="class_name" id="class_name" value="{{ $class->class_name }}"
                                    placeholder="Ex: Terminale S, 6ème A, CP1..."
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white @error('class_name') border-red-300 bg-red-50 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('class_name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Class Numeric Field -->
                        <div class="group">
                            <label for="class_numeric" class="block text-sm font-semibold text-gray-700 mb-3">
                                Niveau numérique *
                            </label>
                            <div class="relative">
                                <input type="number" name="class_numeric" id="class_numeric"
                                    value="{{ $class->class_numeric }}" placeholder="Ex: 1, 2, 3... (pour le classement)"
                                    min="1" max="20"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white @error('class_numeric') border-red-300 bg-red-50 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('class_numeric')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Current Teacher Display -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Professeur principal actuel</h3>
                            @if ($class->teacher)
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 bg-gradient-to-br from-emerald-400 to-green-500 rounded-full flex items-center justify-center mr-3">
                                        <span
                                            class="text-white font-semibold text-sm">{{ substr($class->teacher->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $class->teacher->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $class->teacher->user->email }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center text-amber-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.077 16.5c-.77.833.192 2.5 1.732 2.5z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">Aucun professeur assigné</span>
                                </div>
                            @endif
                        </div>

                        <!-- Teacher Assignment -->
                        <div class="group">
                            <label for="teacher_id" class="block text-sm font-semibold text-gray-700 mb-3">
                                Nouveau professeur principal
                            </label>
                            <div class="relative">
                                <select name="teacher_id" id="teacher_id"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none @error('teacher_id') border-red-300 bg-red-50 @enderror">
                                    <option value="">-- Sélectionner un professeur --</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ $teacher->id === $class->teacher_id ? 'selected' : '' }}>
                                            {{ $teacher->user->name }}
                                        </option>
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
                            @error('teacher_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Class Description -->
                        <div class="group">
                            <label for="class_description" class="block text-sm font-semibold text-gray-700 mb-3">
                                Description de la classe
                            </label>
                            <div class="relative">
                                <textarea name="class_description" id="class_description" rows="4"
                                    placeholder="Description optionnelle de la classe, spécialité, informations complémentaires..."
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white resize-none @error('class_description') border-red-300 bg-red-50 @enderror">{{ $class->class_description }}</textarea>
                                <div class="absolute top-3 right-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('class_description')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('classes.index') }}"
                                class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                                Annuler
                            </a>

                            <button type="submit"
                                class="group relative px-8 py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white font-semibold rounded-xl hover:from-amber-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 transform hover:scale-105 active:scale-95">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-amber-300 group-hover:text-amber-200 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                </span>
                                Mettre à jour la classe
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Warning Section -->
            <div class="mt-8 bg-amber-50 rounded-xl p-6 border border-amber-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.077 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-amber-800">Attention</h3>
                        <ul class="mt-2 text-sm text-amber-700 space-y-1">
                            <li>• La modification du nom peut affecter les références existantes</li>
                            <li>• Le changement de professeur principal prendra effet immédiatement</li>
                            <li>• Les étudiants et matières assignés ne seront pas affectés</li>
                            <li>• Assurez-vous que les modifications sont appropriées avant de sauvegarder</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
