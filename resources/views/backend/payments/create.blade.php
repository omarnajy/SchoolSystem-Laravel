{{-- resources/views/backend/payments/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Créer un Paiement')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-plus-circle text-blue-600 mr-3"></i>
                    Créer un Nouveau Paiement
                </h1>
                <p class="text-gray-600 mt-1">Ajouter un nouveau paiement au système</p>
            </div>
            <a href="{{ route('payments.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Informations du Paiement</h3>
            </div>

            <form method="POST" action="{{ route('payments.store') }}" class="p-6 space-y-6">
                @csrf

                <!-- Première ligne: Parent et Étudiant -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Parent <span class="text-red-500">*</span>
                        </label>
                        <select name="parent_id" id="parent_id" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('parent_id') border-red-300 @enderror">
                            <option value="">Sélectionner un parent...</option>
                            @foreach ($parents ?? [] as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->user->name }} - {{ $parent->user->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Étudiant (optionnel)
                        </label>
                        <select name="student_id" id="student_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('student_id') border-red-300 @enderror">
                            <option value="">Sélectionner un étudiant...</option>
                            @foreach ($students ?? [] as $student)
                                <option value="{{ $student->id }}"
                                    {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->user->name }} - {{ $student->user->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deuxième ligne: Type et Montant -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Type de Paiement <span class="text-red-500">*</span>
                        </label>
                        <select name="payment_type" id="payment_type" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('payment_type') border-red-300 @enderror">
                            <option value="">Sélectionner...</option>
                            <option value="scolarite" {{ old('payment_type') == 'scolarite' ? 'selected' : '' }}>
                                Frais de Scolarité
                            </option>
                            <option value="inscription" {{ old('payment_type') == 'inscription' ? 'selected' : '' }}>
                                Frais d'Inscription
                            </option>
                            <option value="cantine" {{ old('payment_type') == 'cantine' ? 'selected' : '' }}>
                                Cantine
                            </option>
                            <option value="transport" {{ old('payment_type') == 'transport' ? 'selected' : '' }}>
                                Transport
                            </option>
                            <option value="activites" {{ old('payment_type') == 'activites' ? 'selected' : '' }}>
                                Activités Extra-scolaires
                            </option>
                            <option value="fournitures" {{ old('payment_type') == 'fournitures' ? 'selected' : '' }}>
                                Fournitures
                            </option>
                            <option value="autre" {{ old('payment_type') == 'autre' ? 'selected' : '' }}>
                                Autre
                            </option>
                        </select>
                        @error('payment_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            Montant (DH) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="amount" id="amount" step="0.01" min="0" required
                                value="{{ old('amount') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('amount') border-red-300 @enderror pl-12"
                                placeholder="0.00">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">DH</span>
                            </div>
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Troisième ligne: Année, Période, Date -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">
                            Année Académique <span class="text-red-500">*</span>
                        </label>
                        <select name="academic_year" id="academic_year" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('academic_year') border-red-300 @enderror">
                            <option value="">Sélectionner...</option>
                            <option value="2023-2024" {{ old('academic_year') == '2023-2024' ? 'selected' : '' }}>
                                2023-2024
                            </option>
                            <option value="2024-2025" {{ old('academic_year') == '2024-2025' ? 'selected' : '' }}>
                                2024-2025
                            </option>
                            <option value="2025-2026" {{ old('academic_year') == '2025-2026' ? 'selected' : '' }}>
                                2025-2026
                            </option>
                        </select>
                        @error('academic_year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="period" class="block text-sm font-medium text-gray-700 mb-2">
                            Période
                        </label>
                        <select name="period" id="period"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('period') border-red-300 @enderror">
                            <option value="">Sélectionner...</option>
                            <option value="trimestre1" {{ old('period') == 'trimestre1' ? 'selected' : '' }}>
                                1er Trimestre
                            </option>
                            <option value="trimestre2" {{ old('period') == 'trimestre2' ? 'selected' : '' }}>
                                2ème Trimestre
                            </option>
                            <option value="trimestre3" {{ old('period') == 'trimestre3' ? 'selected' : '' }}>
                                3ème Trimestre
                            </option>
                            <option value="semestre1" {{ old('period') == 'semestre1' ? 'selected' : '' }}>
                                1er Semestre
                            </option>
                            <option value="semestre2" {{ old('period') == 'semestre2' ? 'selected' : '' }}>
                                2ème Semestre
                            </option>
                            <option value="annuel" {{ old('period') == 'annuel' ? 'selected' : '' }}>
                                Annuel
                            </option>
                        </select>
                        @error('period')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Date d'Échéance <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="due_date" id="due_date" required value="{{ old('due_date') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('due_date') border-red-300 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Notes
                    </label>
                    <textarea name="notes" id="notes" rows="4"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('notes') border-red-300 @enderror"
                        placeholder="Remarques ou informations supplémentaires...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons d'action -->
                <div
                    class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('payments.index') }}"
                        class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>Créer le Paiement
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Script pour filtrer les étudiants selon le parent sélectionné
        document.getElementById('parent_id').addEventListener('change', function() {
            const parentId = this.value;
            const studentSelect = document.getElementById('student_id');

            // Ici vous pourriez ajouter une requête AJAX pour récupérer 
            // les enfants du parent sélectionné si nécessaire

            // Pour l'instant, on garde tous les étudiants visibles
        });

        // Validation en temps réel
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required], select[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('border-red-300')) {
                        validateField(this);
                    }
                });
            });

            function validateField(field) {
                const errorElement = field.parentNode.querySelector('.text-red-600');

                if (field.value.trim() === '') {
                    field.classList.add('border-red-300');
                    field.classList.remove('border-green-300');
                    if (!errorElement) {
                        const error = document.createElement('p');
                        error.className = 'mt-1 text-sm text-red-600';
                        error.textContent = 'Ce champ est obligatoire';
                        field.parentNode.appendChild(error);
                    }
                } else {
                    field.classList.remove('border-red-300');
                    field.classList.add('border-green-300');
                    if (errorElement) {
                        errorElement.remove();
                    }
                }
            }
        });
    </script>
@endsection
