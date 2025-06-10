{{-- resources/views/backend/payments/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails du Paiement')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-file-invoice text-blue-600 mr-3"></i>
                    Détails du Paiement
                </h1>
                <p class="text-gray-600 mt-1">Facture N° {{ $payment->invoice_number }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('payments.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
                @if ($payment->status !== 'paid')
                    <button type="button" onclick="openEditModal()"
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </button>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Informations du paiement -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Informations du Paiement</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Numéro de Facture</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $payment->invoice_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Type de Paiement</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($payment->payment_type) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Montant</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="text-3xl font-bold text-green-600">{{ $payment->formatted_amount }}</span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Statut</dt>
                                    <dd class="mt-1">
                                        @if ($payment->status === 'pending')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-2"></i>En attente
                                            </span>
                                        @elseif($payment->status === 'paid')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-2"></i>Payé
                                            </span>
                                        @elseif($payment->status === 'overdue')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>En retard
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Année Académique</dt>
                                    <dd class="mt-1 text-lg text-gray-900">{{ $payment->academic_year }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Période</dt>
                                    <dd class="mt-1 text-lg text-gray-900">{{ $payment->period ?: 'Non spécifiée' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date d'Échéance</dt>
                                    <dd class="mt-1">
                                        <div class="text-lg text-gray-900">
                                            {{ is_string($payment->due_date) ? \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') : $payment->due_date->format('d/m/Y') }}
                                        </div>
                                        @if ($payment->status === 'overdue')
                                            <div class="text-sm text-red-600 flex items-center mt-1">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                {{ abs($payment->days_overdue) }} jour(s) de retard
                                            </div>
                                        @endif
                                    </dd>
                                </div>
                                @if ($payment->paid_date)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Date de Paiement</dt>
                                        <dd class="mt-1 text-lg text-gray-900">
                                            {{ is_string($payment->paid_date) ? \Carbon\Carbon::parse($payment->paid_date)->format('d/m/Y') : $payment->paid_date->format('d/m/Y') }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($payment->paid_at)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Date de Paiement</dt>
                                        <dd class="mt-1 text-lg text-gray-900">
                                            {{ is_string($payment->paid_at) ? \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y à H:i') : $payment->paid_at->format('d/m/Y à H:i') }}
                                        </dd>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($payment->notes)
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <dt class="text-sm font-medium text-gray-500 mb-2">Notes</dt>
                                <dd class="bg-gray-50 rounded-lg p-4 text-gray-900 border-l-4 border-blue-500">
                                    {{ $payment->notes }}
                                </dd>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informations de paiement (si payé) -->
                @if ($payment->status === 'paid')
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
                            <h3 class="text-lg font-semibold text-green-800 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                Informations de Paiement
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if ($payment->payment_method)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Méthode de Paiement</dt>
                                        <dd class="mt-1">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                {{ ucfirst($payment->payment_method) }}
                                            </span>
                                        </dd>
                                    </div>
                                @endif
                                @if ($payment->transaction_reference)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Référence de Transaction</dt>
                                        <dd class="mt-1 text-lg font-mono text-gray-900 bg-gray-100 px-3 py-1 rounded">
                                            {{ $payment->transaction_reference }}
                                        </dd>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Colonne latérale -->
            <div class="space-y-6">
                <!-- Informations Parent -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Informations Parent</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-6">
                            @if ($payment->parent->user->profile_picture)
                                <img src="{{ asset('images/profile/' . $payment->parent->user->profile_picture) }}"
                                    alt="Avatar" class="w-20 h-20 rounded-full mx-auto border-4 border-gray-200">
                            @else
                                <div
                                    class="w-20 h-20 rounded-full mx-auto border-4 border-gray-200 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-2xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $payment->parent->user->name }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-gray-900">
                                    <a href="mailto:{{ $payment->parent->user->email }}"
                                        class="text-blue-600 hover:text-blue-800 underline">
                                        {{ $payment->parent->user->email }}
                                    </a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                                <dd class="mt-1 text-gray-900">
                                    @if ($payment->parent->phone)
                                        <a href="tel:{{ $payment->parent->phone }}"
                                            class="text-blue-600 hover:text-blue-800 underline">
                                            {{ $payment->parent->phone }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">Non renseigné</span>
                                    @endif
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations Étudiant -->
                @if ($payment->student)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-900">Informations Étudiant</h3>
                        </div>
                        <div class="p-6">
                            <div class="text-center mb-6">
                                @if ($payment->student->user->profile_picture)
                                    <img src="{{ asset('images/profile/' . $payment->student->user->profile_picture) }}"
                                        alt="Avatar" class="w-16 h-16 rounded-full mx-auto border-4 border-gray-200">
                                @else
                                    <div
                                        class="w-16 h-16 rounded-full mx-auto border-4 border-gray-200 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-user text-xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">
                                        {{ $payment->student->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-gray-900">
                                        <a href="mailto:{{ $payment->student->user->email }}"
                                            class="text-blue-600 hover:text-blue-800 underline">
                                            {{ $payment->student->user->email }}
                                        </a>
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                @if ($payment->status === 'pending' || $payment->status === 'overdue')
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-900">Actions</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <button type="button" onclick="openPayModal()"
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-check mr-2"></i>Marquer comme Payé
                            </button>
                            <button type="button" onclick="openEditModal()"
                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>Modifier
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal d'édition -->
        @if ($payment->status !== 'paid')
            <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
                    <form method="POST" action="{{ route('payments.update', $payment) }}">
                        @csrf
                        @method('PUT')
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-medium text-gray-900">Modifier le paiement</h3>
                                <button type="button" onclick="closeEditModal()"
                                    class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Parent -->
                                <div>
                                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Parent *
                                    </label>
                                    <select name="parent_id" id="parent_id"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                        @foreach ($parents ?? [] as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ $payment->parent_id == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Étudiant -->
                                <div>
                                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Étudiant
                                    </label>
                                    <select name="student_id" id="student_id"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Sélectionner un étudiant</option>
                                        @foreach ($students ?? [] as $student)
                                            <option value="{{ $student->id }}"
                                                {{ $payment->student_id == $student->id ? 'selected' : '' }}>
                                                {{ $student->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Type de paiement -->
                                <div>
                                    <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Type de paiement *
                                    </label>
                                    <select name="payment_type" id="payment_type"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                        <option value="inscription"
                                            {{ $payment->payment_type == 'inscription' ? 'selected' : '' }}>Inscription
                                        </option>
                                        <option value="scolarite"
                                            {{ $payment->payment_type == 'scolarite' ? 'selected' : '' }}>Scolarité
                                        </option>
                                        <option value="cantine"
                                            {{ $payment->payment_type == 'cantine' ? 'selected' : '' }}>Cantine</option>
                                        <option value="transport"
                                            {{ $payment->payment_type == 'transport' ? 'selected' : '' }}>Transport
                                        </option>
                                        <option value="autre" {{ $payment->payment_type == 'autre' ? 'selected' : '' }}>
                                            Autre</option>
                                    </select>
                                </div>

                                <!-- Période -->
                                <div>
                                    <label for="period" class="block text-sm font-medium text-gray-700 mb-2">
                                        Période
                                    </label>
                                    <input type="text" name="period" id="period"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Ex: Septembre 2024, Trimestre 1..." value="{{ $payment->period }}">
                                </div>

                                <!-- Montant -->
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                        Montant (DH) *
                                    </label>
                                    <input type="number" name="amount" id="amount"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        step="0.01" min="0" required value="{{ $payment->amount }}">
                                </div>

                                <!-- Année académique -->
                                <div>
                                    <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">
                                        Année académique *
                                    </label>
                                    <input type="text" name="academic_year" id="academic_year"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        required value="{{ $payment->academic_year }}">
                                </div>

                                <!-- Date d'échéance -->
                                <div>
                                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Date d'échéance *
                                    </label>
                                    <input type="date" name="due_date" id="due_date"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        required
                                        value="{{ is_string($payment->due_date) ? $payment->due_date : $payment->due_date->format('Y-m-d') }}">
                                </div>

                                <!-- Statut -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Statut *
                                    </label>
                                    <select name="status" id="status"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                        <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>En
                                            attente</option>
                                        <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Payé
                                        </option>
                                        <option value="overdue" {{ $payment->status == 'overdue' ? 'selected' : '' }}>En
                                            retard</option>
                                        <option value="cancelled" {{ $payment->status == 'cancelled' ? 'selected' : '' }}>
                                            Annulé</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="mt-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Notes
                                </label>
                                <textarea name="notes" id="notes"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3"
                                    placeholder="Notes du paiement...">{{ $payment->notes }}</textarea>
                            </div>

                            <div class="flex justify-end space-x-3 mt-8">
                                <button type="button" onclick="closeEditModal()"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                                    Annuler
                                </button>
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                                    <i class="fas fa-save mr-2"></i>Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Modal pour marquer comme payé -->
        @if ($payment->status === 'pending' || $payment->status === 'overdue')
            <div id="payModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
                    <form method="POST" action="{{ route('payments.mark-paid', $payment) }}">
                        @csrf
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-semibold text-gray-900">Marquer comme payé</h3>
                                <button type="button" onclick="closePayModal()"
                                    class="text-gray-400 hover:text-gray-600 p-1">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                        Méthode de paiement <span class="text-red-500">*</span>
                                    </label>
                                    <select name="payment_method" id="payment_method" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Sélectionner...</option>
                                        <option value="especes">Espèces</option>
                                        <option value="cheque">Chèque</option>
                                        <option value="virement">Virement bancaire</option>
                                        <option value="carte">Carte bancaire</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="transaction_reference"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Référence de transaction
                                    </label>
                                    <input type="text" name="transaction_reference" id="transaction_reference"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Numéro de chèque, référence virement...">
                                </div>

                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                        <div>
                                            <p class="text-sm font-medium text-blue-800">Montant à encaisser</p>
                                            <p class="text-2xl font-bold text-blue-900">{{ $payment->formatted_amount }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-8">
                                <button type="button" onclick="closePayModal()"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                    Annuler
                                </button>
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center">
                                    <i class="fas fa-check mr-2"></i>Confirmer le Paiement
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Fonctions pour le modal d'édition
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Fonctions pour le modal de paiement
        function openPayModal() {
            document.getElementById('payModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePayModal() {
            document.getElementById('payModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Fermer les modals en cliquant à l'extérieur
        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const payModal = document.getElementById('payModal');

            if (event.target === editModal) {
                closeEditModal();
            }
            if (event.target === payModal) {
                closePayModal();
            }
        }

        // Fermer avec Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
                closePayModal();
            }
        });

        // Validation du formulaire d'édition
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.querySelector('#editModal form');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    const amount = editForm.querySelector('[name="amount"]');
                    const dueDate = editForm.querySelector('[name="due_date"]');
                    const parentId = editForm.querySelector('[name="parent_id"]');

                    // Validation du parent
                    if (!parentId.value) {
                        e.preventDefault();
                        alert('Veuillez sélectionner un parent.');
                        parentId.focus();
                        return;
                    }

                    // Validation du montant
                    if (amount && (parseFloat(amount.value) <= 0 || isNaN(parseFloat(amount.value)))) {
                        e.preventDefault();
                        alert('Veuillez saisir un montant valide supérieur à 0.');
                        amount.focus();
                        return;
                    }

                    // Validation de la date
                    if (dueDate && !dueDate.value) {
                        e.preventDefault();
                        alert('Veuillez sélectionner une date d\'échéance.');
                        dueDate.focus();
                        return;
                    }
                });
            }

            // Validation du formulaire de paiement
            const payForm = document.querySelector('#payModal form');
            if (payForm) {
                payForm.addEventListener('submit', function(e) {
                    const paymentMethod = payForm.querySelector('[name="payment_method"]');

                    if (!paymentMethod.value) {
                        e.preventDefault();
                        alert('Veuillez sélectionner une méthode de paiement.');
                        paymentMethod.focus();
                        return;
                    }
                });
            }

            // Auto-formatage du montant
            const amountInput = document.querySelector('[name="amount"]');
            if (amountInput) {
                amountInput.addEventListener('input', function(e) {
                    let value = e.target.value;
                    // Remplacer la virgule par un point pour la validation numérique
                    e.target.value = value.replace(',', '.');
                });
            }
        });
    </script>

    <style>
        /* Animations pour les modals */
        .modal-content {
            transform: scale(0.9);
            opacity: 0;
            transition: all 0.3s ease-out;
        }

        .modal-content.show {
            transform: scale(1);
            opacity: 1;
        }

        /* Amélioration de l'accessibilité */
        button:focus,
        select:focus,
        input:focus,
        textarea:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Responsive pour les modals */
        @media (max-width: 768px) {
            #editModal .relative {
                width: 95% !important;
                max-width: none !important;
                margin: 20px auto;
                top: 20px !important;
            }
        }
    </style>
@endsection
