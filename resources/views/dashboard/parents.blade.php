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

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    @keyframes heartbeat {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
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

    .animate-heartbeat {
        animation: heartbeat 1.5s ease-in-out infinite;
    }

    .glass {
        backdrop-filter: blur(16px);
        background: rgba(255, 255, 255, 0.9);
    }

    .child-card {
        transition: all 0.3s ease;
    }

    .child-card:hover {
        transform: translateY(-8px) scale(1.02);
    }
</style>

<div class="space-y-8">
    <!-- Statistique principale des enfants -->
    <div class="animate-fadeIn">
        <div
            class="glass rounded-3xl shadow-2xl border border-white/20 p-8 bg-gradient-to-br from-pink-500 to-rose-600 text-white text-center overflow-hidden relative">
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse">
            </div>
            <div class="relative z-10">
                <div
                    class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6 animate-heartbeat">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="text-5xl font-bold mb-4 animate-pulse-slow">
                    {{ sprintf('%02d', $parents->children_count) }}
                </div>
                <div class="text-2xl font-semibold text-pink-100 uppercase tracking-wider">
                    {{ $parents->children_count > 1 ? 'Mes Enfants' : 'Mon Enfant' }}
                </div>
                <div class="mt-4 text-lg text-pink-200">
                    Suivi parental personnalisé
                </div>
            </div>
        </div>
    </div>

    <!-- Cartes détaillées des enfants -->
    <div class="grid grid-cols-1 {{ $parents->children_count > 1 ? 'lg:grid-cols-2' : 'max-w-2xl mx-auto' }} gap-8">
        @foreach ($parents->children as $key => $child)
            <div class="child-card glass rounded-3xl shadow-2xl border border-white/20 p-8 bg-gradient-to-br {{ $loop->even ? 'from-blue-500 to-indigo-600' : 'from-purple-500 to-pink-600' }} text-white animate-slideIn"
                style="animation-delay: {{ $key * 0.2 }}s">

                <!-- Header avec photo et nom -->
                <div class="text-center mb-8">
                    <div class="relative inline-block">
                        <div
                            class="w-24 h-24 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 {{ $loop->even ? 'animate-pulse-slow' : 'animate-heartbeat' }}">
                            <span class="text-3xl font-bold text-white">
                                {{ strtoupper(substr($child->user->name, 0, 2)) }}
                            </span>
                        </div>
                        <div
                            class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-400 border-2 border-white rounded-full animate-pulse">
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">{{ $child->user->name }}</h3>
                    <p class="text-lg {{ $loop->even ? 'text-blue-200' : 'text-purple-200' }}">{{ $child->user->email }}
                    </p>
                </div>

                <!-- Informations détaillées -->
                <div class="space-y-4">
                    <div class="bg-white/10 rounded-2xl p-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex justify-between items-center py-2 border-b border-white/20">
                                <span
                                    class="font-medium {{ $loop->even ? 'text-blue-200' : 'text-purple-200' }}">Classe:</span>
                                <span class="font-bold text-white">{{ $child->class->class_name }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-white/20">
                                <span
                                    class="font-medium {{ $loop->even ? 'text-blue-200' : 'text-purple-200' }}">Matricule:</span>
                                <span class="font-bold text-white">{{ $child->roll_number }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-white/20">
                                <span
                                    class="font-medium {{ $loop->even ? 'text-blue-200' : 'text-purple-200' }}">Téléphone:</span>
                                <span class="font-bold text-white">{{ $child->phone ?: 'Non renseigné' }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-white/20">
                                <span
                                    class="font-medium {{ $loop->even ? 'text-blue-200' : 'text-purple-200' }}">Genre:</span>
                                <span class="font-bold text-white capitalize">{{ $child->gender }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-white/20">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-medium {{ $loop->even ? 'text-blue-200' : 'text-purple-200' }}">Date
                                    de naissance:</span>
                                <span class="font-bold text-white">{{ $child->dateofbirth }}</span>
                            </div>

                            <div class="flex justify-between items-start">
                                <span
                                    class="font-medium {{ $loop->even ? 'text-blue-200' : 'text-purple-200' }}">Adresse:</span>
                                <span
                                    class="font-bold text-white text-right ml-2">{{ $child->current_address ?: 'Non renseignée' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton d'action -->
                <div class="mt-8 text-center">
                    <a href="{{ route('attendance.show', $child->id) }}"
                        class="group relative inline-flex items-center px-8 py-4 bg-white/20 text-white font-bold rounded-2xl shadow-lg hover:bg-white/30 transition-all duration-300 hover:scale-105 hover:shadow-xl backdrop-blur-sm">
                        <svg class="w-5 h-5 mr-3 transition-transform group-hover:scale-110" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        Rapport de Présence
                        <div
                            class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Section informations générales -->
    <div class="glass rounded-3xl shadow-2xl border border-white/20 p-8 bg-gradient-to-r from-slate-800 via-gray-800 to-slate-900 text-white animate-fadeIn"
        style="animation-delay: 0.8s">
        <div class="text-center">
            <h2
                class="text-3xl font-bold mb-4 bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">
                Espace Parent
            </h2>
            <p class="text-lg text-gray-300 mb-6">
                Suivez le parcours scolaire de {{ $parents->children_count > 1 ? 'vos enfants' : 'votre enfant' }} en
                temps réel
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-2xl p-6 border border-green-400/30">
                    <div class="w-12 h-12 bg-green-400/30 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-green-400 mb-2">Suivi en Temps Réel</h3>
                    <p class="text-sm text-gray-400">Accès aux présences et bulletins instantanément</p>
                </div>

                <div
                    class="bg-gradient-to-br from-blue-500/20 to-indigo-500/20 rounded-2xl p-6 border border-blue-400/30">
                    <div class="w-12 h-12 bg-blue-400/30 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                            <path
                                d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-blue-400 mb-2">Communication</h3>
                    <p class="text-sm text-gray-400">Échanges directs avec l'équipe pédagogique</p>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-2xl p-6 border border-purple-400/30">
                    <div class="w-12 h-12 bg-purple-400/30 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-purple-400 mb-2">Sécurité</h3>
                    <p class="text-sm text-gray-400">Données protégées et accès sécurisé</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-700">
                <p class="text-gray-400 text-sm">
                    Dernière mise à jour: {{ now()->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>
