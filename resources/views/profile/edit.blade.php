@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <!-- En-tête avec navigation -->
        <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-pink-700 rounded-2xl shadow-2xl p-8 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center space-x-4 mb-6 sm:mb-0">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-edit text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Modifier mon Profil</h1>
                        <p class="text-purple-200 font-medium">Mettez à jour vos informations personnelles</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('profile') }}"
                        class="group inline-flex items-center px-6 py-3 bg-white/20 text-white font-semibold rounded-xl hover:bg-white/30 transition-all duration-300 hover:scale-105 backdrop-blur-sm border border-white/30">
                        <div class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span>Retour au Profil</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulaire d'édition -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user-edit text-white text-sm"></i>
                    </div>
                    Informations Personnelles
                </h2>
                <p class="text-gray-600 mt-2">Modifiez vos informations et votre photo de profil</p>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Formulaire principal -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Nom -->
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                <i class="fas fa-user text-blue-500 mr-2"></i>
                                Nom Complet
                            </label>
                            <div class="relative">
                                <input name="name" type="text" value="{{ auth()->user()->name }}"
                                    class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-800 font-medium placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:bg-white transition-all duration-300 group-hover:border-blue-300"
                                    placeholder="Entrez votre nom complet">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                    <i
                                        class="fas fa-user text-gray-400 group-hover:text-blue-500 transition-colors duration-300"></i>
                                </div>
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                <i class="fas fa-envelope text-green-500 mr-2"></i>
                                Adresse Email
                            </label>
                            <div class="relative">
                                <input name="email" type="email" value="{{ auth()->user()->email }}"
                                    class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-800 font-medium placeholder-gray-400 focus:outline-none focus:border-green-500 focus:bg-white transition-all duration-300 group-hover:border-green-300"
                                    placeholder="Entrez votre adresse email">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                    <i
                                        class="fas fa-envelope text-gray-400 group-hover:text-green-500 transition-colors duration-300"></i>
                                </div>
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Photo de profil -->
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                <i class="fas fa-camera text-purple-500 mr-2"></i>
                                Photo de Profil
                            </label>
                            <div class="relative">
                                <input name="profile_picture" type="file" accept="image/*"
                                    class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-800 font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-white file:bg-gradient-to-r file:from-purple-500 file:to-purple-600 hover:file:from-purple-600 hover:file:to-purple-700 file:transition-all file:duration-300 focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-300 group-hover:border-purple-300">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                    <i
                                        class="fas fa-camera text-gray-400 group-hover:text-purple-500 transition-colors duration-300"></i>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Formats acceptés : JPG, PNG, GIF (max 2MB)
                            </p>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="submit"
                                    class="group flex-1 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <div class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span>Enregistrer les Modifications</span>
                                </button>

                                <a href="{{ route('profile') }}"
                                    class="group flex-1 sm:flex-initial inline-flex items-center justify-center px-8 py-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all duration-300 border border-gray-300">
                                    <div class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span>Annuler</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Prévisualisation de la photo -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-8">
                            <div
                                class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl p-6 text-center border border-gray-300 shadow-lg">
                                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center justify-center">
                                    <i class="fas fa-image text-purple-500 mr-3"></i>
                                    Photo Actuelle
                                </h3>

                                <div class="relative inline-block mb-6">
                                    <div
                                        class="w-40 h-40 mx-auto rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                                        <img id="profile-preview" class="w-full h-full object-cover"
                                            src="{{ asset('images/profile/' . auth()->user()->profile_picture) }}"
                                            alt="Photo de profil actuelle">
                                    </div>
                                    <!-- Badge de modification -->
                                    <div
                                        class="absolute -bottom-2 -right-2 w-10 h-10 bg-purple-500 border-4 border-white rounded-full flex items-center justify-center animate-pulse">
                                        <i class="fas fa-camera text-white text-sm"></i>
                                    </div>
                                </div>

                                <h4 class="text-lg font-bold text-gray-800 mb-2">{{ auth()->user()->name }}</h4>
                                <p class="text-gray-600 font-medium mb-4">
                                    {{ auth()->user()->roles[0]->name ?? 'Utilisateur' }}</p>

                                <!-- Conseils -->
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-left">
                                    <h5 class="font-bold text-blue-800 mb-2 flex items-center">
                                        <i class="fas fa-lightbulb mr-2"></i>
                                        Conseils
                                    </h5>
                                    <ul class="text-sm text-blue-700 space-y-1">
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 text-xs"></i>
                                            <span>Utilisez une photo récente et professionnelle</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 text-xs"></i>
                                            <span>Évitez les photos floues ou pixelisées</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-500 mr-2 mt-0.5 text-xs"></i>
                                            <span>Centrez votre visage dans l'image</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Animations personnalisées */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: slideInUp 0.6s ease forwards;
        }

        /* Style personnalisé pour les inputs */
        .form-input:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        /* Animation pour la prévisualisation d'image */
        #profile-preview {
            transition: all 0.3s ease;
        }

        #profile-preview:hover {
            transform: scale(1.05);
        }

        /* Style pour le file input */
        input[type="file"]::-webkit-file-upload-button {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="file"]::-webkit-file-upload-button:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
            transform: translateY(-1px);
        }

        /* Effet de focus pour les groupes */
        .group:hover .form-input {
            border-color: #cbd5e1;
        }

        /* Animation pour les icônes */
        .icon-bounce {
            animation: bounce 1s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            53%,
            80%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            40%,
            43% {
                transform: translate3d(0, -8px, 0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prévisualisation de l'image
            const fileInput = document.querySelector('input[name="profile_picture"]');
            const previewImg = document.getElementById('profile-preview');

            if (fileInput && previewImg) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            // Animation de changement
                            previewImg.style.opacity = '0';
                            setTimeout(() => {
                                previewImg.style.opacity = '1';
                                previewImg.style.transform = 'scale(1.05)';
                                setTimeout(() => {
                                    previewImg.style.transform = 'scale(1)';
                                }, 200);
                            }, 100);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Animation d'entrée pour les éléments du formulaire
            const formElements = document.querySelectorAll('.group');
            formElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    element.style.transition = 'all 0.6s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 150);
            });

            // Validation en temps réel
            const nameInput = document.querySelector('input[name="name"]');
            const emailInput = document.querySelector('input[name="email"]');

            function validateField(input, validationFn, errorMessage) {
                const value = input.value.trim();
                const isValid = validationFn(value);

                // Retirer les anciens messages d'erreur
                const existingError = input.parentNode.parentNode.querySelector('.validation-error');
                if (existingError) {
                    existingError.remove();
                }

                if (!isValid && value !== '') {
                    input.classList.add('border-red-500', 'bg-red-50');
                    input.classList.remove('border-green-500', 'bg-green-50');

                    // Ajouter message d'erreur
                    const errorDiv = document.createElement('p');
                    errorDiv.className = 'validation-error mt-2 text-sm text-red-600 flex items-center';
                    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${errorMessage}`;
                    input.parentNode.parentNode.appendChild(errorDiv);
                } else if (isValid && value !== '') {
                    input.classList.add('border-green-500', 'bg-green-50');
                    input.classList.remove('border-red-500', 'bg-red-50');
                } else {
                    input.classList.remove('border-red-500', 'bg-red-50', 'border-green-500', 'bg-green-50');
                }
            }

            if (nameInput) {
                nameInput.addEventListener('input', function() {
                    validateField(this,
                        (value) => value.length >= 2,
                        'Le nom doit contenir au moins 2 caractères'
                    );
                });
            }

            if (emailInput) {
                emailInput.addEventListener('input', function() {
                    validateField(this,
                        (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
                        'Veuillez entrer une adresse email valide'
                    );
                });
            }

            // Animation du bouton de soumission
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    // Animation de loading
                    const originalText = this.innerHTML;
                    this.innerHTML = `
                        <div class="flex items-center justify-center">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-3"></div>
                            <span>Enregistrement...</span>
                        </div>
                    `;
                    this.disabled = true;

                    // Restaurer après 3 secondes si pas de soumission
                    setTimeout(() => {
                        if (this.disabled) {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }
                    }, 3000);
                });
            }
        });
    </script>
@endsection
