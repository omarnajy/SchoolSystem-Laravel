@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header avec animation -->
            <div class="flex items-center justify-between mb-8 animate-fade-in">
                <div class="relative">
                    <h1
                        class="text-4xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Créer un Rôle
                    </h1>
                    <div
                        class="absolute -bottom-2 left-0 w-20 h-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full">
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('roles-permissions') }}"
                        class="group relative inline-flex items-center px-6 py-3 bg-gray-800 text-white font-semibold rounded-xl shadow-lg hover:bg-gray-700 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="currentColor"
                            viewBox="0 0 448 512">
                            <path
                                d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                        </svg>
                        Retour
                    </a>

                    <a href="{{ route('permission.create') }}"
                        class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2 transition-transform group-hover:rotate-90" fill="currentColor"
                            viewBox="0 0 448 512">
                            <path
                                d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0-32-14.33-32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
                        </svg>
                        Permission
                    </a>
                </div>
            </div>

            <!-- Formulaire avec design moderne -->
            <div
                class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 p-8 hover:shadow-3xl transition-all duration-500">
                <form action="{{ route('role.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Champ Nom du Rôle -->
                    <div class="group">
                        <label
                            class="block text-sm font-bold text-gray-700 mb-3 group-focus-within:text-indigo-600 transition-colors">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                        clip-rule="evenodd" />
                                </svg>
                                Nom du Rôle
                            </span>
                        </label>
                        <div class="relative">
                            <input name="name" type="text"
                                class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl text-gray-800 font-medium placeholder-gray-400 focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-200 transition-all duration-300"
                                placeholder="Entrez le nom du rôle...">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <div class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Section Permissions -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Permissions
                            </span>
                        </label>

                        <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-6 border border-gray-200">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($permissions as $permission)
                                    <label
                                        class="group relative flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-300 cursor-pointer">
                                        <input name="selectedpermissions[]" type="checkbox" value="{{ $permission->name }}"
                                            class="sr-only peer">

                                        <!-- Checkbox customisé -->
                                        <div class="relative w-5 h-5 mr-3">
                                            <div
                                                class="w-5 h-5 bg-gray-200 border-2 border-gray-300 rounded-md peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all duration-200">
                                            </div>
                                            <svg class="absolute inset-0 w-5 h-5 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>

                                        <span
                                            class="text-sm font-medium text-gray-700 group-hover:text-indigo-700 transition-colors">
                                            {{ $permission->name }}
                                        </span>

                                        <!-- Indicateur de sélection -->
                                        <div
                                            class="absolute top-2 right-2 w-2 h-2 bg-indigo-500 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200">
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="flex justify-center pt-6">
                        <button type="submit"
                            class="group relative inline-flex items-center px-12 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold text-lg rounded-2xl shadow-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <svg class="w-6 h-6 mr-3 transition-transform group-hover:scale-110" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Créer le Rôle
                            <div
                                class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }

        .hover\:shadow-3xl:hover {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
@endsection
