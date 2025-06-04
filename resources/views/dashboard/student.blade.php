<script src="https://cdn.tailwindcss.com"></script>
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
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

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
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

    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out;
    }

    .animate-slideIn {
        animation: slideIn 0.6s ease-out;
    }

    .animate-slideInRight {
        animation: slideInRight 0.6s ease-out;
    }

    .animate-pulse-slow {
        animation: pulse 2s ease-in-out infinite;
    }

    .animate-bounce-slow {
        animation: bounce 2s ease-in-out infinite;
    }

    .glass {
        backdrop-filter: blur(16px);
        background: rgba(255, 255, 255, 0.9);
    }

    .info-card {
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-4px);
    }
</style>

<div class="glass rounded-3xl shadow-2xl border border-white/20 p-8 bg-white/90 min-h-screen">
    <!-- Layout principal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Colonne gauche - Informations personnelles -->
        <div class="space-y-6 animate-slideIn">

            <!-- Header de profil -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 text-white text-center">
                <div
                    class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 animate-bounce-slow">
                    <span class="text-2xl font-bold">{{ strtoupper(substr($student->user->name, 0, 2)) }}</span>
                </div>
                <h2 class="text-2xl font-bold mb-2">{{ $student->user->name }}</h2>
                <p class="text-blue-200">Étudiant • {{ $student->class->class_name }}</p>
            </div>

            <!-- Informations de base -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <div
                        class="w-6 h-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    Mes Informations
                </h3>

                <div class="space-y-3">
                    <div
                        class="info-card flex justify-between items-center py-3 px-4 bg-white rounded-xl border border-blue-200 hover:shadow-md">
                        <span class="font-medium text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            Email
                        </span>
                        <span class="font-bold text-gray-800">{{ $student->user->email }}</span>
                    </div>

                    <div
                        class="info-card flex justify-between items-center py-3 px-4 bg-white rounded-xl border border-blue-200 hover:shadow-md">
                        <span class="font-medium text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM9 9a1 1 0 012 0v4a1 1 0 11-2 0V9z"
                                    clip-rule="evenodd" />
                            </svg>
                            Matricule
                        </span>
                        <span class="font-bold text-gray-800">{{ $student->roll_number }}</span>
                    </div>

                    <div
                        class="info-card flex justify-between items-center py-3 px-4 bg-white rounded-xl border border-blue-200 hover:shadow-md">
                        <span class="font-medium text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            Téléphone
                        </span>
                        <span class="font-bold text-gray-800">{{ $student->phone ?: 'Non renseigné' }}</span>
                    </div>

                    <div
                        class="info-card flex justify-between items-center py-3 px-4 bg-white rounded-xl border border-blue-200 hover:shadow-md">
                        <span class="font-medium text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Genre
                        </span>
                        <span class="font-bold text-gray-800 capitalize">{{ $student->gender }}</span>
                    </div>

                    <div
                        class="info-card flex justify-between items-center py-3 px-4 bg-white rounded-xl border border-blue-200 hover:shadow-md">
                        <span class="font-medium text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Date de naissance
                        </span>
                        <span class="font-bold text-gray-800">{{ $student->dateofbirth }}</span>
                    </div>
                </div>
            </div>

            <!-- Adresses -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <div
                        class="w-6 h-6 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    Mes Adresses
                </h3>

                <div class="space-y-3">
                    <div class="info-card p-4 bg-white rounded-xl border border-green-200 hover:shadow-md">
                        <p class="font-medium text-gray-700 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Adresse Actuelle
                        </p>
                        <p class="text-gray-800 font-bold">{{ $student->current_address ?: 'Non renseignée' }}</p>
                    </div>

                    <div class="info-card p-4 bg-white rounded-xl border border-green-200 hover:shadow-md">
                        <p class="font-medium text-gray-700 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            Adresse Permanente
                        </p>
                        <p class="text-gray-800 font-bold">{{ $student->permanent_address ?: 'Non renseignée' }}</p>
                    </div>
                </div>
            </div>

            <!-- Informations du parent -->
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl p-6 border border-yellow-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <div
                        class="w-6 h-6 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    Mon Parent/Tuteur
                </h3>

                <div class="space-y-3">
                    <div
                        class="info-card flex justify-between items-center py-3 px-4 bg-white rounded-xl border border-yellow-200 hover:shadow-md">
                        <span class="font-medium text-gray-700">Nom</span>
                        <span class="font-bold text-gray-800">{{ $student->parent->user->name }}</span>
                    </div>

                    <div
                        class="info-card flex justify-between items-center py-3 px-4 bg-white rounded-xl border border-yellow-200 hover:shadow-md">
                        <span class="font-medium text-gray-700">Email</span>
                        <span class="font-bold text-gray-800">{{ $student->parent->user->email }}</span>
                    </div>

                    <div
                        class="info-card flex justify-between items-center py-3 px-4 bg-white rounded-xl border border-yellow-200 hover:shadow-md">
                        <span class="font-medium text-gray-700">Téléphone</span>
                        <span class="font-bold text-gray-800">{{ $student->parent->phone ?: 'Non renseigné' }}</span>
                    </div>

                    <div class="info-card p-4 bg-white rounded-xl border border-yellow-200 hover:shadow-md">
                        <p class="font-medium text-gray-700 mb-2">Adresse</p>
                        <p class="text-gray-800 font-bold">{{ $student->parent->current_address ?: 'Non renseignée' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne droite - Matières et présences -->
        <div class="space-y-6 animate-slideInRight">

            <!-- Mes matières -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 715.5 16c1.526 0 2.924-.39 4.5-.804zm7-4v10a7.969 7.969 0 01-4.5.804c-1.255 0-2.443-.29-3.5-.804V4.804A7.968 7.968 0 0114.5 4c1.526 0 2.924.39 4.5.804z" />
                        </svg>
                    </div>
                    Mes Matières
                </h3>

                <!-- Header du tableau -->
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-t-2xl p-4 mb-1">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-white font-bold text-sm flex items-center">
                            <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                            Code
                        </div>
                        <div class="text-white font-bold text-sm flex items-center">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                            Matière
                        </div>
                        <div class="text-white font-bold text-sm text-right flex items-center justify-end">
                            <div class="w-2 h-2 bg-purple-400 rounded-full mr-2"></div>
                            Professeur
                        </div>
                    </div>
                </div>

                <!-- Liste des matières -->
                <div class="space-y-1">
                    @foreach ($student->class->subjects as $index => $subject)
                        @php
                            $colors = [
                                'from-blue-500 to-blue-600',
                                'from-green-500 to-green-600',
                                'from-purple-500 to-purple-600',
                                'from-pink-500 to-pink-600',
                                'from-indigo-500 to-indigo-600',
                                'from-cyan-500 to-cyan-600',
                                'from-orange-500 to-orange-600',
                                'from-red-500 to-red-600',
                            ];
                            $colorClass = $colors[$index % count($colors)];
                        @endphp

                        <div
                            class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-300 hover:scale-[1.02] group info-card">
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r {{ $colorClass }} rounded-xl flex items-center justify-center text-white font-bold text-sm mr-3 shadow-lg">
                                        {{ strtoupper(substr($subject->subject_code, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">{{ $subject->subject_code }}</p>
                                        <p class="text-xs text-gray-500">Code</p>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <p
                                        class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">
                                        {{ $subject->name }}
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="font-semibold text-gray-800">{{ $subject->teacher->user->name }}</p>
                                    <p class="text-xs text-gray-500">Professeur</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Mes présences -->
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    Mon Registre de Présence
                </h3>

                <!-- Header du tableau présences -->
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-t-2xl p-4 mb-1">
                    <div class="grid grid-cols-4 gap-4">
                        <div class="text-white font-bold text-sm">Date</div>
                        <div class="text-white font-bold text-sm">Classe</div>
                        <div class="text-white font-bold text-sm">Enseignant</div>
                        <div class="text-white font-bold text-sm text-right">Statut</div>
                    </div>
                </div>

                <!-- Liste des présences -->
                <div class="space-y-1 max-h-96 overflow-y-auto">
                    @foreach ($student->attendances as $attendance)
                        <div
                            class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-300 info-card">
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <div class="text-sm font-medium text-gray-800">{{ $attendance->attendence_date }}
                                </div>
                                <div class="text-sm font-medium text-gray-800">{{ $attendance->class->class_name }}
                                </div>
                                <div class="text-sm font-medium text-gray-800">{{ $attendance->teacher->user->name }}
                                </div>
                                <div class="text-right">
                                    @if ($attendance->attendence_status)
                                        <span
                                            class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold rounded-full shadow-lg">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Présent
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full shadow-lg">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Absent
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
