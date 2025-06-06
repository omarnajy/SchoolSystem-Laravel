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
                    <a href="{{ route('payments.edit', $payment) }}"
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
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
                                        <dd class="mt-1 text-lg text-gray-900">{{ $payment->paid_date->format('d/m/Y') }}
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
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Méthode de Paiement</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            {{ ucfirst($payment->payment_method) }}
                                        </span>
                                    </dd>
                                </div>
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
                            <img src="{{ asset('images/profile/' . $payment->parent->user->profile_picture) }}"
                                alt="Avatar" class="w-20 h-20 rounded-full mx-auto border-4 border-gray-200">
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
                                <img src="{{ asset('images/profile/' . $payment->student->user->profile_picture) }}"
                                    alt="Avatar" class="w-16 h-16 rounded-full mx-auto border-4 border-gray-200">
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
                            <a href="{{ route('payments.edit', $payment) }}"
                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>Modifier
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

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
        function openPayModal() {
            document.getElementById('payModal').classList.remove('hidden');
        }

        function closePayModal() {
            document.getElementById('payModal').classList.add('hidden');
        }

        // Fermer le modal en cliquant à l'extérieur
        window.onclick = function(event) {
            const modal = document.getElementById('payModal');
            if (event.target === modal) {
                closePayModal();
            }
        }

        // Fermer avec Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePayModal();
            }
        });
    </script>
@endsection
