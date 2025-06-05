@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-amber-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Modifier le parent</h1>
                            <p class="text-gray-600 mt-1">Mettre à jour les informations de <span
                                    class="font-semibold text-orange-600">{{ $parent->user->name }}</span></p>
                        </div>
                    </div>

                    <a href="{{ route('parents.index') }}"
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

            <!-- Current Parent Info Card -->
            <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 p-6 mb-8">
                <div class="flex items-center">
                    <div
                        class="h-20 w-20 bg-gradient-to-br from-orange-400 to-amber-500 rounded-xl flex items-center justify-center mr-6">
                        @if ($parent->user->profile_picture)
                            <img class="h-20 w-20 rounded-xl object-cover"
                                src="{{ asset('images/profile/' . $parent->user->profile_picture) }}"
                                alt="{{ $parent->user->name }}">
                        @else
                            <span class="text-white font-bold text-2xl">{{ substr($parent->user->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $parent->user->name }}</h3>
                        <p class="text-gray-600">{{ $parent->user->email }}</p>
                        <div class="flex items-center mt-2 space-x-4">
                            @if ($parent->phone)
                                <span class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    {{ $parent->phone }}
                                </span>
                            @endif
                            @if ($parent->gender)
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if ($parent->gender === 'male') bg-blue-100 text-blue-800
                                @elseif($parent->gender === 'female') bg-pink-100 text-pink-800
                                @else bg-purple-100 text-purple-800 @endif">
                                    {{ ucfirst($parent->gender) }}
                                </span>
                            @endif
                            <span class="text-xs text-gray-500">
                                Enfants: {{ $parent->children->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-600 to-amber-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Modifier les informations
                    </h2>
                    <p class="text-orange-100 mt-1">Mettez à jour les détails du parent</p>
                </div>

                <form action="{{ route('parents.update', $parent->id) }}" method="POST" enctype="multipart/form-data"
                    class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Profile Picture Section -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Photo de profil
                            </h3>

                            <div class="flex items-center space-x-6">
                                <div
                                    class="h-24 w-24 bg-gradient-to-br from-orange-100 to-amber-100 rounded-xl flex items-center justify-center border-2 border-dashed border-orange-300">
                                    @if ($parent->user->profile_picture)
                                        <img class="h-24 w-24 rounded-xl object-cover"
                                            src="{{ asset('images/profile/' . $parent->user->profile_picture) }}"
                                            alt="{{ $parent->user->name }}">
                                    @else
                                        <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <label class="block">
                                        <span class="sr-only">Changer la photo</span>
                                        <input type="file" name="profile_picture" accept="image/*"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition-all duration-200">
                                    </label>
                                    <p class="mt-2 text-xs text-gray-500">
                                        PNG, JPG, GIF jusqu'à 2MB. Laissez vide pour conserver l'image actuelle.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information Section -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informations personnelles
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name Field -->
                                <div class="group">
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Nom complet *
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="name" id="name"
                                            value="{{ $parent->user->name }}" placeholder="Nom et prénom du parent"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white @error('name') border-red-300 bg-red-50 @enderror">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('name')
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

                                <!-- Email Field -->
                                <div class="group">
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Adresse Email *
                                    </label>
                                    <div class="relative">
                                        <input type="email" name="email" id="email"
                                            value="{{ $parent->user->email }}" placeholder="parent@exemple.com"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white @error('email') border-red-300 bg-red-50 @enderror">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('email')
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

                                <!-- Phone Field -->
                                <div class="group">
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Numéro de téléphone
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="phone" id="phone"
                                            value="{{ $parent->phone }}" placeholder="+33 6 12 34 56 78"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white @error('phone') border-red-300 bg-red-50 @enderror">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('phone')
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

                                <!-- Password Field -->
                                <div class="group">
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Nouveau mot de passe (optionnel)
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password"
                                            placeholder="Nouveau mot de passe"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white @error('password') border-red-300 bg-red-50 @enderror">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">
                                        Laissez vide pour conserver le mot de passe actuel
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Gender Selection -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Genre
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label
                                    class="flex items-center p-4 border-2 rounded-xl cursor-pointer hover:border-orange-300 transition-all duration-200 group
                                {{ $parent->gender === 'male' ? 'border-orange-500 bg-orange-50' : 'border-gray-200' }}">
                                    <input type="radio" name="gender" value="male"
                                        {{ $parent->gender === 'male' ? 'checked' : '' }}
                                        class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                                    <div class="ml-3 flex items-center">
                                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-sm font-medium text-gray-700 group-hover:text-orange-700">Homme</span>
                                    </div>
                                </label>
                                <label
                                    class="flex items-center p-4 border-2 rounded-xl cursor-pointer hover:border-orange-300 transition-all duration-200 group
                                {{ $parent->gender === 'female' ? 'border-orange-500 bg-orange-50' : 'border-gray-200' }}">
                                    <input type="radio" name="gender" value="female"
                                        {{ $parent->gender === 'female' ? 'checked' : '' }}
                                        class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                                    <div class="ml-3 flex items-center">
                                        <svg class="w-5 h-5 text-pink-500 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-sm font-medium text-gray-700 group-hover:text-orange-700">Femme</span>
                                    </div>
                                </label>

                            </div>
                            @error('gender')
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

                        <!-- Address Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Informations d'adresse
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Current Address -->
                                <div class="group">
                                    <label for="current_address" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Adresse actuelle
                                    </label>
                                    <div class="relative">
                                        <textarea name="current_address" id="current_address" rows="3"
                                            placeholder="Numéro, rue, ville, code postal..."
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white resize-none @error('current_address') border-red-300 bg-red-50 @enderror">{{ $parent->current_address }}</textarea>
                                        <div class="absolute top-3 right-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('current_address')
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

                                <!-- Permanent Address -->
                                <div class="group">
                                    <label for="permanent_address" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Adresse permanente
                                    </label>
                                    <div class="relative">
                                        <textarea name="permanent_address" id="permanent_address" rows="3"
                                            placeholder="Adresse de résidence principale..."
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white resize-none @error('permanent_address') border-red-300 bg-red-50 @enderror">{{ $parent->permanent_address }}</textarea>
                                        <div class="absolute top-3 right-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('permanent_address')
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

                            <!-- Copy Address Button -->
                            <div class="mt-4">
                                <button type="button" onclick="copyAddress()"
                                    class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-orange-100 text-orange-700 hover:bg-orange-200 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Copier l'adresse actuelle vers permanente
                                </button>
                            </div>
                        </div>

                        <!-- Children Information -->
                        @if ($parent->children->count() > 0)
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                        </path>
                                    </svg>
                                    Enfants associés ({{ $parent->children->count() }})
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($parent->children as $child)
                                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-10 w-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mr-3">
                                                    <span
                                                        class="text-white font-semibold text-sm">{{ substr($child->user->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $child->user->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $child->user->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('parents.index') }}"
                                class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                                Annuler
                            </a>

                            <button type="submit"
                                class="group relative px-8 py-3 bg-gradient-to-r from-orange-600 to-amber-600 text-white font-semibold rounded-xl hover:from-orange-700 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105 active:scale-95">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-orange-300 group-hover:text-orange-200 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                </span>
                                Mettre à jour le parent
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
                        <h3 class="text-sm font-semibold text-amber-800">Points importants</h3>
                        <ul class="mt-2 text-sm text-amber-700 space-y-1">
                            <li>• La modification de l'email peut affecter la connexion du parent</li>
                            <li>• Les enfants associés ne seront pas affectés par ces modifications</li>
                            <li>• Laissez le champ photo vide pour conserver l'image actuelle</li>
                            <li>• Laissez le champ mot de passe vide pour ne pas le modifier</li>
                            <li>• Les modifications prendront effet immédiatement</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyAddress() {
            const currentAddress = document.getElementById('current_address').value;
            document.getElementById('permanent_address').value = currentAddress;

            // Animation visuelle pour confirmer l'action
            const button = event.target.closest('button');
            const originalHTML = button.innerHTML;

            // Changement visuel temporaire
            button.innerHTML = `
                <svg class="w-3 h-3 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Adresse copiée !
            `;
            button.classList.remove('bg-orange-100', 'text-orange-700', 'hover:bg-orange-200');
            button.classList.add('bg-green-100', 'text-green-700', 'cursor-default');
            button.disabled = true;

            // Retour à l'état initial après 2 secondes
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('bg-green-100', 'text-green-700', 'cursor-default');
                button.classList.add('bg-orange-100', 'text-orange-700', 'hover:bg-orange-200');
                button.disabled = false;
            }, 2000);
        }

        // Preview image upload
        document.querySelector('input[name="profile_picture"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Vérifier la taille du fichier (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('La taille du fichier ne doit pas dépasser 2MB');
                    this.value = '';
                    return;
                }

                // Vérifier le type de fichier
                if (!file.type.startsWith('image/')) {
                    alert('Veuillez sélectionner un fichier image valide');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Créer une prévisualisation de l'image
                    const preview = document.querySelector('.h-24.w-24');
                    if (preview) {
                        preview.innerHTML =
                            `<img class="h-24 w-24 rounded-xl object-cover" src="${e.target.result}" alt="Prévisualisation">`;
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Validation du formulaire côté client
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();

            if (!name) {
                e.preventDefault();
                alert('Le nom est requis');
                document.getElementById('name').focus();
                return;
            }

            if (!email) {
                e.preventDefault();
                alert('L\'email est requis');
                document.getElementById('email').focus();
                return;
            }

            // Validation basique de l'email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Veuillez saisir un email valide');
                document.getElementById('email').focus();
                return;
            }
        });

        // Animation d'entrée pour les éléments du formulaire
        document.addEventListener('DOMContentLoaded', function() {
            const formSections = document.querySelectorAll('.space-y-8 > div');
            formSections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    section.style.transition = 'all 0.5s ease';
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
@endsection
