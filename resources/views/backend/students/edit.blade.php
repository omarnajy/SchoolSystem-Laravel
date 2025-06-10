@extends('layouts.app')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slideIn {
            animation: slideIn 0.6s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
        }

        .glass {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.9);
        }

        .gradient-border {
            background: linear-gradient(45deg, #f093fb 0%, #f5576c 50%, #4facfe 100%);
            padding: 2px;
            border-radius: 1rem;
        }

        .form-container {
            background: white;
            border-radius: calc(1rem - 2px);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-pink-100 via-purple-50 to-blue-100 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header avec animation -->
            <div class="flex items-center justify-between mb-8 animate-fadeIn">
                <div class="relative">
                    <h1
                        class="text-5xl font-extrabold bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">
                        Modifier l'Étudiant
                    </h1>
                    <div class="absolute -bottom-2 left-0 w-36 h-1 bg-gradient-to-r from-pink-600 to-blue-600 rounded-full">
                    </div>
                    <p class="mt-4 text-gray-600 font-medium">Modifiez les informations de l'étudiant
                        {{ $student->user->name }}</p>
                </div>

                <div class="animate-pulse-slow">
                    <a href="{{ route('student.index') }}"
                        class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-700 to-gray-800 text-white font-bold rounded-2xl shadow-xl hover:from-gray-800 hover:to-gray-900 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <svg class="w-5 h-5 mr-3 transition-transform group-hover:-translate-x-1" fill="currentColor"
                            viewBox="0 0 448 512">
                            <path
                                d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                        </svg>
                        Retour aux Étudiants
                        <div
                            class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                </div>
            </div>

            <!-- Badge de l'étudiant -->
            <div class="mb-6 animate-slideIn">
                <div
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-100 to-purple-100 border border-pink-200 rounded-2xl shadow-lg">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-pink-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg mr-4">
                        {{ strtoupper(substr($student->user->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $student->user->name }}</p>
                        <p class="text-sm text-gray-600">Matricule: {{ $student->roll_number }}</p>
                    </div>
                </div>
            </div>

            <!-- Formulaire avec design moderne -->
            <div class="gradient-border animate-slideIn">
                <div class="form-container p-8">
                    <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Photo actuelle -->
                        <div class="text-center mb-8">
                            <div class="relative inline-block">
                                <img class="w-32 h-32 rounded-2xl shadow-xl border-4 border-white object-cover"
                                    src="{{ asset('images/profile/' . $student->user->profile_picture) }}"
                                    alt="Photo de profil">
                                <div
                                    class="absolute -bottom-2 -right-2 w-8 h-8 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-3 text-sm text-gray-600 font-medium">Photo actuelle de l'étudiant</p>
                        </div>

                        <!-- Section Informations Personnelles -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                Informations Personnelles
                            </h3>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Nom -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Nom Complet
                                    </label>
                                    <input name="name" type="text" value="{{ $student->user->name }}"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all duration-300 font-medium">
                                    @error('name')
                                        <p class="text-red-500 text-sm flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        Adresse Email
                                    </label>
                                    <input name="email" type="email" value="{{ $student->user->email }}"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-200 transition-all duration-300 font-medium">
                                    @error('email')
                                        <p class="text-red-500 text-sm flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Numéro de matricule -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM9 9a1 1 0 012 0v4a1 1 0 11-2 0V9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Numéro de Matricule
                                    </label>
                                    <input name="roll_number" type="number" value="{{ $student->roll_number }}"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-200 transition-all duration-300 font-medium">
                                    @error('roll_number')
                                        <p class="text-red-500 text-sm flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Téléphone -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                        Téléphone
                                    </label>
                                    <input name="phone" type="text" value="{{ $student->phone }}"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:ring-4 focus:ring-cyan-200 transition-all duration-300 font-medium">
                                    @error('phone')
                                        <p class="text-red-500 text-sm flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Genre -->
                                <div class="space-y-3 lg:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Genre
                                    </label>
                                    <div class="flex flex-wrap gap-4">
                                        <label
                                            class="flex items-center px-6 py-3 bg-white border-2 border-gray-200 rounded-xl hover:border-blue-300 transition-colors cursor-pointer {{ $student->gender == 'male' ? 'border-blue-500 bg-blue-50' : '' }}">
                                            <input name="gender" type="radio" value="male"
                                                {{ $student->gender == 'male' ? 'checked' : '' }} class="sr-only peer">
                                            <div
                                                class="w-4 h-4 border-2 border-gray-300 rounded-full peer-checked:bg-blue-500 peer-checked:border-blue-500 mr-3 {{ $student->gender == 'male' ? 'bg-blue-500 border-blue-500' : '' }}">
                                            </div>
                                            <span class="font-medium text-gray-700">Homme</span>
                                        </label>
                                        <label
                                            class="flex items-center px-6 py-3 bg-white border-2 border-gray-200 rounded-xl hover:border-pink-300 transition-colors cursor-pointer {{ $student->gender == 'female' ? 'border-pink-500 bg-pink-50' : '' }}">
                                            <input name="gender" type="radio" value="female"
                                                {{ $student->gender == 'female' ? 'checked' : '' }} class="sr-only peer">
                                            <div
                                                class="w-4 h-4 border-2 border-gray-300 rounded-full peer-checked:bg-pink-500 peer-checked:border-pink-500 mr-3 {{ $student->gender == 'female' ? 'bg-pink-500 border-pink-500' : '' }}">
                                            </div>
                                            <span class="font-medium text-gray-700">Femme</span>
                                        </label>
                                    </div>
                                    @error('gender')
                                        <p class="text-red-500 text-sm flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section Informations Complémentaires -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                Informations Complémentaires
                            </h3>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Date de naissance -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Date de Naissance
                                    </label>
                                    <input name="dateofbirth" id="datepicker-se" autocomplete="off"
                                        value="{{ $student->dateofbirth }}"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-200 transition-all duration-300 font-medium">
                                    @error('dateofbirth')
                                        <p class="text-red-500 text-sm flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Photo de profil -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Nouvelle Photo de Profil
                                    </label>
                                    <input name="profile_picture" type="file" accept="image/*"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-200 transition-all duration-300 font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>

                                <!-- Adresse actuelle -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Adresse Actuelle
                                    </label>
                                    <input name="current_address" type="text" value="{{ $student->current_address }}"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-200 transition-all duration-300 font-medium">
                                    @error('current_address')
                                        <p class="text-red-500 text-sm flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Adresse permanente -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                        </svg>
                                        Adresse Permanente
                                    </label>
                                    <input name="permanent_address" type="text"
                                        value="{{ $student->permanent_address }}"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-rose-500 focus:ring-4 focus:ring-rose-200 transition-all duration-300 font-medium">
                                    @error('permanent_address')
                                        <p class="text-red-500 text-sm flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Classe -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Classe Assignée
                                    </label>
                                    <select name="class_id"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-yellow-500 focus:ring-4 focus:ring-yellow-200 transition-all duration-300 font-medium">
                                        <option value="">-- Sélectionner une classe --</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ $class->id === $student->class_id ? 'selected' : '' }}>
                                                {{ $class->class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Parent -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-violet-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Parent de l'Étudiant
                                    </label>
                                    <select name="parent_id"
                                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-200 transition-all duration-300 font-medium">
                                        <option value="">-- Sélectionner un parent --</option>
                                        @foreach ($parents as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ $parent->id === $student->parent_id ? 'selected' : '' }}>
                                                {{ $parent->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="flex justify-center pt-8">
                            <button type="submit"
                                class="group relative inline-flex items-center px-16 py-5 bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 text-white font-bold text-xl rounded-2xl shadow-2xl hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-pink-200 transition-all duration-300 hover:scale-105 hover:shadow-3xl transform">
                                <svg class="w-6 h-6 mr-4 transition-transform group-hover:scale-110" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Mettre à Jour l'Étudiant
                                <div
                                    class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-pink-600 to-blue-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200">
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#datepicker-se").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        })
    </script>
@endpush
