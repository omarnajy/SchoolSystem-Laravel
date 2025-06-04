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

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
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

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }

        100% {
            background-position: 1000px 0;
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out;
    }

    .animate-slideUp {
        animation: slideUp 0.6s ease-out;
    }

    .animate-pulse-slow {
        animation: pulse 2s ease-in-out infinite;
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    .animate-shimmer {
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite;
    }

    .glass {
        backdrop-filter: blur(16px);
        background: rgba(255, 255, 255, 0.9);
    }

    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
    }
</style>
<!-- Dashboard Admin avec statistiques principales -->
<div class="space-y-8">
    <!-- Première rangée de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-fadeIn">

        <!-- Statistique Étudiants -->
        <div
            class="stat-card glass rounded-3xl shadow-2xl border border-white/20 p-8 bg-gradient-to-br from-blue-500 to-indigo-600 text-white overflow-hidden relative">
            <div class="animate-shimmer absolute inset-0 opacity-30"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center animate-float">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 448 512">
                            <path
                                d="M319.4 320.6L224 416l-95.4-95.4C57.1 323.7 0 382.2 0 454.4v9.6c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-9.6c0-72.2-57.1-130.7-128.6-133.8zM13.6 79.8l6.4 1.5v58.4c-7 4.2-12 11.5-12 20.3 0 8.4 4.6 15.4 11.1 19.7L3.5 242c-1.7 6.9 2.1 14 7.6 14h41.8c5.5 0 9.3-7.1 7.6-14l-15.6-62.3C51.4 175.4 56 168.4 56 160c0-8.8-5-16.1-12-20.3V87.1l66 15.9c-8.6 17.2-14 36.4-14 57 0 70.7 57.3 128 128 128s128-57.3 128-128c0-20.6-5.3-39.8-14-57l96.3-23.2c18.2-4.4 18.2-27.1 0-31.5l-190.4-46c-13-3.1-26.7-3.1-39.7 0L13.6 48.2c-18.1 4.4-18.1 27.2 0 31.6z" />
                        </svg>
                    </div>
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                </div>
                <div class="text-4xl font-bold mb-2 animate-pulse-slow">
                    {{ sprintf('%02d', count($students)) }}
                </div>
                <div class="text-lg font-semibold text-blue-100 uppercase tracking-wider">
                    Étudiants
                </div>
                <div class="mt-4 text-sm text-blue-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                            clip-rule="evenodd" />
                    </svg>
                    Actifs dans le système
                </div>
            </div>
        </div>

        <!-- Statistique Enseignants -->
        <div
            class="stat-card glass rounded-3xl shadow-2xl border border-white/20 p-8 bg-gradient-to-br from-emerald-500 to-teal-600 text-white overflow-hidden relative">
            <div class="animate-shimmer absolute inset-0 opacity-30"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center animate-float"
                        style="animation-delay: 0.5s">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 448 512">
                            <path
                                d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                        </svg>
                    </div>
                    <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                </div>
                <div class="text-4xl font-bold mb-2 animate-pulse-slow">
                    {{ sprintf('%02d', count($teachers)) }}
                </div>
                <div class="text-lg font-semibold text-emerald-100 uppercase tracking-wider">
                    Enseignants
                </div>
                <div class="mt-4 text-sm text-emerald-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd" />
                    </svg>
                    Corps professoral
                </div>
            </div>
        </div>

        <!-- Statistique Parents -->
        <div
            class="stat-card glass rounded-3xl shadow-2xl border border-white/20 p-8 bg-gradient-to-br from-purple-500 to-pink-600 text-white overflow-hidden relative">
            <div class="animate-shimmer absolute inset-0 opacity-30"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center animate-float"
                        style="animation-delay: 1s">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 448 512">
                            <path
                                d="M224 0c70.7 0 128 57.3 128 128s-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0zM209.1 359.2l-18.6-31c-6.4-10.7 1.3-24.2 13.7-24.2H224h19.7c12.4 0 20.1 13.6 13.7 24.2l-18.6 31 33.4 123.9 39.5-161.2c77.2 12 136.3 78.8 136.3 159.4c0 17-13.8 30.7-30.7 30.7H265.1 182.9 30.7C13.8 512 0 498.2 0 481.3c0-80.6 59.1-147.4 136.3-159.4l39.5 161.2 33.4-123.9z" />
                        </svg>
                    </div>
                    <div class="w-3 h-3 bg-orange-400 rounded-full animate-pulse"></div>
                </div>
                <div class="text-4xl font-bold mb-2 animate-pulse-slow">
                    {{ sprintf('%02d', count($parents)) }}
                </div>
                <div class="text-lg font-semibold text-purple-100 uppercase tracking-wider">
                    Parents
                </div>
                <div class="mt-4 text-sm text-purple-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Communauté familiale
                </div>
            </div>
        </div>
    </div>

    <!-- Deuxième rangée de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-slideUp" style="animation-delay: 0.3s">

        <!-- Statistique Matières -->
        <div
            class="stat-card glass rounded-3xl shadow-2xl border border-white/20 p-8 bg-gradient-to-br from-orange-500 to-red-600 text-white overflow-hidden relative">
            <div class="animate-shimmer absolute inset-0 opacity-30"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center animate-float"
                        style="animation-delay: 1.5s">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 448 512">
                            <path
                                d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z" />
                        </svg>
                    </div>
                    <div class="w-3 h-3 bg-cyan-400 rounded-full animate-pulse"></div>
                </div>
                <div class="text-4xl font-bold mb-2 animate-pulse-slow">
                    {{ sprintf('%02d', count($subjects)) }}
                </div>
                <div class="text-lg font-semibold text-orange-100 uppercase tracking-wider">
                    Matières
                </div>
                <div class="mt-4 text-sm text-orange-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 715.5 16c1.526 0 2.924-.39 4.5-.804zm7-4v10a7.969 7.969 0 01-4.5.804c-1.255 0-2.443-.29-3.5-.804V4.804A7.968 7.968 0 0114.5 4c1.526 0 2.924.39 4.5.804z" />
                    </svg>
                    Programme académique
                </div>
            </div>
        </div>

        <!-- Statistique Classes -->
        <div
            class="stat-card glass rounded-3xl shadow-2xl border border-white/20 p-8 bg-gradient-to-br from-cyan-500 to-blue-600 text-white overflow-hidden relative">
            <div class="animate-shimmer absolute inset-0 opacity-30"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center animate-float"
                        style="animation-delay: 2s">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 512 512">
                            <path
                                d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z" />
                        </svg>
                    </div>
                    <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse"></div>
                </div>
                <div class="text-4xl font-bold mb-2 animate-pulse-slow">
                    {{ sprintf('%02d', count($classes)) }}
                </div>
                <div class="text-lg font-semibold text-cyan-100 uppercase tracking-wider">
                    Classes
                </div>
                <div class="mt-4 text-sm text-cyan-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                    </svg>
                    Organisation scolaire
                </div>
            </div>
        </div>
    </div>

    <!-- Section de résumé global -->
    <div class="glass rounded-3xl shadow-2xl border border-white/20 p-8 bg-gradient-to-r from-slate-800 via-gray-800 to-slate-900 text-white animate-slideUp"
        style="animation-delay: 0.6s">
        <div class="text-center">
            <h2
                class="text-3xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                Tableau de Bord Administrateur
            </h2>
            <p class="text-lg text-gray-300 mb-6">
                Vue d'ensemble complète de votre établissement scolaire
            </p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-400">
                        {{ count($students) + count($teachers) + count($parents) }}</div>
                    <div class="text-sm text-gray-400">Total Utilisateurs</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-emerald-400">{{ count($subjects) }}</div>
                    <div class="text-sm text-gray-400">Matières Actives</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-400">{{ count($classes) }}</div>
                    <div class="text-sm text-gray-400">Classes Ouvertes</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-400">100%</div>
                    <div class="text-sm text-gray-400">Système Actif</div>
                </div>
            </div>
        </div>
    </div>
</div>
