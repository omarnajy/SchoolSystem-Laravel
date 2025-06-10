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

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes glow {

            0%,
            100% {
                box-shadow: 0 0 5px rgba(99, 102, 241, 0.3);
            }

            50% {
                box-shadow: 0 0 20px rgba(99, 102, 241, 0.6);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slideIn {
            animation: slideIn 0.6s ease-out;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite;
        }

        .glass {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.9);
        }

        .gradient-border {
            background: linear-gradient(45deg, #8b5cf6, #a855f7, #c084fc, #e879f9);
            padding: 3px;
            border-radius: 1.5rem;
        }

        .form-container {
            background: white;
            border-radius: calc(1.5rem - 3px);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-violet-100 via-purple-50 to-indigo-100 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header avec animation -->
            <div class="flex items-center justify-between mb-8 animate-fadeIn">
                <div class="relative">
                    <h1
                        class="text-5xl font-extrabold bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                        Nouvel Enseignant
                    </h1>
                    <div
                        class="absolute -bottom-2 left-0 w-36 h-1 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-full">
                    </div>
                    <p class="mt-4 text-gray-600 font-medium">Créez un nouveau profil enseignant avec toutes les informations
                        professionnelles</p>
                </div>

                <div class="animate-float">
                    <a href="{{ route('teacher.index') }}"
                        class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-700 to-gray-800 text-white font-bold rounded-2xl shadow-xl hover:from-gray-800 hover:to-gray-900 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <svg class="w-5 h-5 mr-3 transition-transform group-hover:-translate-x-1" fill="currentColor"
                            viewBox="0 0 448 512">
                            <path
                                d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                        </svg>
                        Retour aux Enseignants
                        <div
                            class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                </div>
            </div>

            <!-- Formulaire avec design moderne -->
            <div class="gradient-border animate-slideIn animate-glow">
                <div class="form-container p-8">
                    <form action="{{ route('teacher.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-8">
                        @csrf

                        <!-- Icône enseignant au centre -->
                        <div class="text-center mb-8">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-violet-500 to-indigo-600 rounded-2xl mx-auto flex items-center justify-center shadow-2xl">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h2 class="mt-4 text-2xl font-bold text-gray-800">Profil Enseignant</h2>
                            <p class="text-gray-600">Remplissez les informations personnelles et professionnelles</p>
                        </div>

                        <!-- Section Informations Personnelles -->
                        <div class="bg-gradient-to-r from-violet-50 to-purple-50 rounded-2xl p-6 border border-violet-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-violet-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                Informations Personnelles
                            </h3>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Nom complet -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-violet-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Nom Complet
                                    </label>
                                    <input name="name" type="text" value="{{ old('name') }}"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-violet-500 focus:ring-4 focus:ring-violet-200 transition-all duration-300 font-medium text-lg"
                                        placeholder="Nom et prénom de l'enseignant...">
                                    @error('name')
                                        <p class="text-red-500 text-sm flex items-center mt-2">
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
                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        Adresse Email Professionnelle
                                    </label>
                                    <input name="email" type="email" value="{{ old('email') }}"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-purple-500 focus:ring-4 focus:ring-purple-200 transition-all duration-300 font-medium text-lg"
                                        placeholder="enseignant@ecole.ma">
                                    @error('email')
                                        <p class="text-red-500 text-sm flex items-center mt-2">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Mot de passe -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Mot de Passe
                                    </label>
                                    <input name="password" type="password"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-200 transition-all duration-300 font-medium text-lg"
                                        placeholder="Mot de passe sécurisé...">
                                    @error('password')
                                        <p class="text-red-500 text-sm flex items-center mt-2">
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
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                        Numéro de Téléphone
                                    </label>
                                    <input name="phone" type="text" value="{{ old('phone') }}"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-200 transition-all duration-300 font-medium text-lg"
                                        placeholder="+212 6XX XX XX XX">
                                    @error('phone')
                                        <p class="text-red-500 text-sm flex items-center mt-2">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

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
                                    <input name="dateofbirth" id="datepicker-tc" autocomplete="off"
                                        value="{{ old('dateofbirth') }}"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-orange-500 focus:ring-4 focus:ring-orange-200 transition-all duration-300 font-medium text-lg"
                                        placeholder="AAAA-MM-JJ">
                                    @error('dateofbirth')
                                        <p class="text-red-500 text-sm flex items-center mt-2">
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
                                        <svg class="w-4 h-4 mr-2 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Photo de Profil Professionnelle
                                    </label>
                                    <input name="profile_picture" type="file" accept="image/*"
                                        class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-pink-500 focus:ring-4 focus:ring-pink-200 transition-all duration-300 font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                                </div>
                            </div>
                        </div>

                        <!-- Section Genre et Adresses -->
                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-2xl p-6 border border-indigo-200">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                Informations Complémentaires
                            </h3>

                            <div class="space-y-6">
                                <!-- Genre -->
                                <div class="space-y-3">
                                    <label class="block text-sm font-bold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Genre
                                    </label>
                                    <div class="flex flex-wrap gap-4">
                                        <label
                                            class="flex items-center px-8 py-3 bg-white border-2 border-gray-200 rounded-xl hover:border-blue-300 transition-colors cursor-pointer group">
                                            <input name="gender" type="radio" value="male" class="sr-only peer">
                                            <div
                                                class="w-4 h-4 border-2 border-gray-300 rounded-full peer-checked:bg-blue-500 peer-checked:border-blue-500 mr-3 group-hover:border-blue-400">
                                            </div>
                                            <span class="font-medium text-gray-700 group-hover:text-blue-700">Homme</span>
                                        </label>
                                        <label
                                            class="flex items-center px-8 py-3 bg-white border-2 border-gray-200 rounded-xl hover:border-pink-300 transition-colors cursor-pointer group">
                                            <input name="gender" type="radio" value="female" class="sr-only peer">
                                            <div
                                                class="w-4 h-4 border-2 border-gray-300 rounded-full peer-checked:bg-pink-500 peer-checked:border-pink-500 mr-3 group-hover:border-pink-400">
                                            </div>
                                            <span class="font-medium text-gray-700 group-hover:text-pink-700">Femme</span>
                                        </label>
                                    </div>
                                    @error('gender')
                                        <p class="text-red-500 text-sm flex items-center mt-2">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Adresses -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <!-- Adresse actuelle -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-gray-700 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Adresse Actuelle
                                        </label>
                                        <input name="current_address" type="text"
                                            value="{{ old('current_address') }}"
                                            class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-teal-500 focus:ring-4 focus:ring-teal-200 transition-all duration-300 font-medium"
                                            placeholder="Adresse de résidence actuelle...">
                                        @error('current_address')
                                            <p class="text-red-500 text-sm flex items-center mt-2">
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
                                            <svg class="w-4 h-4 mr-2 text-rose-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                            </svg>
                                            Adresse Permanente
                                        </label>
                                        <input name="permanent_address" type="text"
                                            value="{{ old('permanent_address') }}"
                                            class="w-full px-6 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-rose-500 focus:ring-4 focus:ring-rose-200 transition-all duration-300 font-medium"
                                            placeholder="Adresse permanente ou familiale...">
                                        @error('permanent_address')
                                            <p class="text-red-500 text-sm flex items-center mt-2">
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
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="flex justify-center pt-8">
                            <button type="submit"
                                class="group relative inline-flex items-center px-16 py-5 bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 text-white font-bold text-xl rounded-2xl shadow-2xl hover:from-violet-700 hover:via-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-violet-200 transition-all duration-300 hover:scale-105 hover:shadow-3xl transform">
                                <svg class="w-6 h-6 mr-4 transition-transform group-hover:scale-110" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Créer le Profil Enseignant
                                <div
                                    class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-violet-600 to-indigo-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200">
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Conseils pour enseignants -->
            <div
                class="mt-8 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-200 animate-slideIn">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    Conseils pour un Profil Enseignant Complet
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-700">
                    <div class="bg-white p-4 rounded-xl border border-emerald-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-2">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                            <p class="font-semibold">Email Professionnel</p>
                        </div>
                        <p>Utilisez une adresse email institutionnelle pour la communication officielle.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-teal-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-2">
                            <div class="w-2 h-2 bg-teal-500 rounded-full mr-2"></div>
                            <p class="font-semibold">Photo Professionnelle</p>
                        </div>
                        <p>Ajoutez une photo de profil claire et professionnelle pour l'identification.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-cyan-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-2">
                            <div class="w-2 h-2 bg-cyan-500 rounded-full mr-2"></div>
                            <p class="font-semibold">Coordonnées</p>
                        </div>
                        <p>Renseignez un numéro de téléphone accessible pour les urgences pédagogiques.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-blue-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                            <p class="font-semibold">Sécurité</p>
                        </div>
                        <p>Choisissez un mot de passe fort avec lettres, chiffres et caractères spéciaux.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#datepicker-tc").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        })
    </script>
@endpush
