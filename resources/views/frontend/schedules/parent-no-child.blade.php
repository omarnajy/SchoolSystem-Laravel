{{-- resources/views/frontend/schedules/parent-no-child.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Emploi du Temps</h1>
                <p class="text-gray-600">Espace Parent</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 mt-4 md:mt-0">
                <a href="{{ route('home') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour au Dashboard
                </a>
            </div>
        </div>

        <!-- Message d'information -->
        <div class="bg-yellow-50 rounded-xl border-2 border-dashed border-yellow-300 p-12 text-center">
            <i class="fas fa-info-circle text-4xl text-yellow-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-yellow-800 mb-2">Aucun enfant trouvé</h3>
            <p class="text-yellow-700 mb-6">
                {{ $message ?? 'Aucun enfant n\'est actuellement associé à votre compte ou aucune classe n\'est assignée.' }}
            </p>
            <div class="space-y-4">
                <a href="{{ route('parents.show', auth()->user()->id) }}"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-heart mr-2"></i>
                    Voir mes Enfants
                </a>
                <p class="text-yellow-600 text-sm">
                    Pour associer vos enfants à votre compte, veuillez contacter l'administration.
                </p>
            </div>
        </div>
    </div>
@endsection
