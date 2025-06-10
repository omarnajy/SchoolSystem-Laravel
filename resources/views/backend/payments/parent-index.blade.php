{{-- resources/views/backend/payments/parent-index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mes Paiements')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-credit-card text-blue-600 mr-3"></i>
                    Mes Paiements
                </h1>
                <p class="text-gray-600 mt-1">Consultez l'historique de vos paiements et factures</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-blue-100 text-blue-800 px-3 py-2 rounded-lg text-sm font-medium">
                    <i class="fas fa-user mr-2"></i>{{ $parent->user->name }}
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Paiements -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-blue-600 uppercase tracking-wide">Total Paiements</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['total_payments'] ?? 0 }}</div>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-calendar text-3xl text-gray-300"></i>
                    </div>
                </div>
            </div>

            <!-- En Attente -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-yellow-600 uppercase tracking-wide">En Attente</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['pending_payments'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">{{ number_format($stats['total_amount_pending'] ?? 0, 2) }} DH
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-3xl text-gray-300"></i>
                    </div>
                </div>
            </div>

            <!-- Payés -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-green-600 uppercase tracking-wide">Payés</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['paid_payments'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">{{ number_format($stats['total_amount_paid'] ?? 0, 2) }} DH</div>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-check text-3xl text-gray-300"></i>
                    </div>
                </div>
            </div>

            <!-- En Retard -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="flex-1">
                        <div class="text-sm font-medium text-red-600 uppercase tracking-wide">En Retard</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['overdue_payments'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">{{ number_format($stats['total_amount_overdue'] ?? 0, 2) }} DH
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-3xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages d'alerte pour les paiements en retard -->
        @if ($stats['overdue_payments'] > 0)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                    <div>
                        <h3 class="text-red-800 font-semibold">Attention - Paiements en retard</h3>
                        <p class="text-red-700 text-sm">
                            Vous avez {{ $stats['overdue_payments'] }} paiement(s) en retard pour un montant total de
                            {{ number_format($stats['total_amount_overdue'] ?? 0, 2) }} DH.
                            Veuillez contacter l'administration pour régulariser votre situation.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Filtres de recherche</h3>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('parent.payments.index') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                        <select name="status" id="status"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tous les statuts</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente
                            </option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payé</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>En retard
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">Année
                            Académique</label>
                        <select name="academic_year" id="academic_year"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Toutes les années</option>
                            @foreach ($academicYears ?? [] as $year)
                                <option value="{{ $year }}"
                                    {{ request('academic_year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-2">Type de
                            Paiement</label>
                        <select name="payment_type" id="payment_type"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tous les types</option>
                            @foreach ($paymentTypes ?? [] as $type)
                                <option value="{{ $type }}"
                                    {{ request('payment_type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                        <input type="text" name="search" id="search"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="N° facture, période..." value="{{ request('search') }}">
                    </div>
                    <div class="lg:col-span-4 flex flex-wrap gap-3 pt-4">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-filter mr-2"></i>Filtrer
                        </button>
                        <a href="{{ route('parent.payments.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i>Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des paiements -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Historique des paiements</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N°
                                Facture</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Étudiant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Année</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Échéance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($payments ?? [] as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $payment->invoice_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $payment->student ? $payment->student->user->name : 'Non spécifié' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst($payment->payment_type) }}
                                    </span>
                                    @if ($payment->period)
                                        <div class="text-xs text-gray-500 mt-1">{{ $payment->period }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div
                                        class="text-lg font-semibold 
                                        {{ $payment->status === 'paid' ? 'text-green-600' : ($payment->status === 'overdue' ? 'text-red-600' : 'text-yellow-600') }}">
                                        {{ $payment->formatted_amount }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->academic_year }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ is_string($payment->due_date) ? \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') : $payment->due_date->format('d/m/Y') }}
                                    </div>
                                    @if ($payment->status === 'overdue' || ($payment->status === 'pending' && $payment->due_date < now()))
                                        <div class="text-xs text-red-600 flex items-center mt-1">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ abs($payment->days_overdue) }} jour(s) de retard
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($payment->status === 'pending')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>En attente
                                        </span>
                                    @elseif($payment->status === 'paid')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>Payé
                                        </span>
                                        @if ($payment->paid_at)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $payment->paid_at->format('d/m/Y H:i') }}
                                            </div>
                                        @endif
                                    @elseif($payment->status === 'overdue')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>En retard
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button type="button" onclick="openDetailsModal({{ $payment->id }})"
                                            class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                            title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if ($payment->status === 'overdue' && $payment->payment_method)
                                            <span class="text-xs text-gray-500"
                                                title="Payé par {{ $payment->payment_method }}">
                                                <i class="fas fa-info-circle"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-lg">Aucun paiement trouvé</p>
                                        <p class="text-sm text-gray-400">Vous n'avez aucun paiement enregistré pour le
                                            moment.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (isset($payments) && $payments->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>

        <!-- Informations de contact -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mr-3 mt-1"></i>
                <div>
                    <h3 class="text-blue-800 font-semibold mb-2">Besoin d'aide ?</h3>
                    <p class="text-blue-700 text-sm mb-2">
                        Pour toute question concernant vos paiements ou si vous rencontrez des difficultés,
                        n'hésitez pas à contacter l'administration scolaire.
                    </p>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span class="text-blue-600">
                            <i class="fas fa-phone mr-1"></i>Tél: +212 5XX XX XX XX
                        </span>
                        <span class="text-blue-600">
                            <i class="fas fa-envelope mr-1"></i>Email: administration@ecole.ma
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal des détails pour chaque paiement -->
    @if (isset($payments))
        @foreach ($payments as $payment)
            <div id="detailsModal{{ $payment->id }}"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-md shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Détails du paiement</h3>
                            <button type="button" onclick="closeDetailsModal({{ $payment->id }})"
                                class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-500">N° Facture:</span>
                                <span class="text-sm text-gray-900">{{ $payment->invoice_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-500">Type:</span>
                                <span class="text-sm text-gray-900">{{ ucfirst($payment->payment_type) }}</span>
                            </div>
                            @if ($payment->period)
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Période:</span>
                                    <span class="text-sm text-gray-900">{{ $payment->period }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-500">Montant:</span>
                                <span class="text-sm font-bold text-gray-900">{{ $payment->formatted_amount }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-500">Échéance:</span>
                                <span class="text-sm text-gray-900">
                                    {{ is_string($payment->due_date) ? \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') : $payment->due_date->format('d/m/Y') }}
                                </span>
                            </div>
                            @if ($payment->payment_method && $payment->status === 'paid')
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Méthode de paiement:</span>
                                    <span class="text-sm text-gray-900">{{ ucfirst($payment->payment_method) }}</span>
                                </div>
                            @endif
                            @if ($payment->transaction_reference && $payment->status === 'paid')
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium text-gray-500">Référence:</span>
                                    <span class="text-sm text-gray-900">{{ $payment->transaction_reference }}</span>
                                </div>
                            @endif
                            @if ($payment->notes)
                                <div class="pt-3 border-t">
                                    <span class="text-sm font-medium text-gray-500">Notes:</span>
                                    <p class="text-sm text-gray-900 mt-1">{{ $payment->notes }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="button" onclick="closeDetailsModal({{ $payment->id }})"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <script>
        // Fonctions pour les modals de détails
        function openDetailsModal(paymentId) {
            document.getElementById('detailsModal' + paymentId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailsModal(paymentId) {
            document.getElementById('detailsModal' + paymentId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Fermer les modals en cliquant à l'extérieur
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-gray-600')) {
                event.target.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        // Fermer les modals avec la touche Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const openModals = document.querySelectorAll('[id^="detailsModal"]');
                openModals.forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                    }
                });
                document.body.style.overflow = 'auto';
            }
        });
    </script>

    <style>
        /* Animation pour les statuts */
        .status-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        /* Amélioration responsive */
        @media (max-width: 768px) {
            .modal-container {
                width: 95% !important;
                max-width: none !important;
            }
        }
    </style>
@endsection
