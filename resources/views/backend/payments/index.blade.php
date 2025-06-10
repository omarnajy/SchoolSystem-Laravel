{{-- resources/views/backend/payments/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestion des Paiements')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-credit-card text-blue-600 mr-3"></i>
                    Gestion des Paiements
                </h1>
                <p class="text-gray-600 mt-1">Gérer les paiements des parents et étudiants</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('payments.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i>Nouveau Paiement
                </a>
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
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-3xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Filtres</h3>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('payments.index') }}"
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
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé
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
                            placeholder="Nom, numéro facture..." value="{{ request('search') }}">
                    </div>
                    <div class="lg:col-span-4 flex flex-wrap gap-3 pt-4">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-filter mr-2"></i>Filtrer
                        </button>
                        <a href="{{ route('payments.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i>Réinitialiser
                        </a>
                        <a href="{{ route('payments.update-overdue') }}"
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Marquer en retard
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des paiements -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Liste des Paiements</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N°
                                Facture</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Parent</th>
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
                                    <div class="text-sm text-gray-900">{{ $payment->parent->user->name }}</div>
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
                                    <div class="text-lg font-semibold text-green-600">{{ $payment->formatted_amount }}
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
                                            En attente
                                        </span>
                                    @elseif($payment->status === 'paid')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Payé
                                        </span>
                                    @elseif($payment->status === 'overdue')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            En retard
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
                                        <a href="{{ route('payments.show', $payment) }}"
                                            class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                            title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($payment->status !== 'paid')
                                            <button type="button" onclick="openEditModal({{ $payment->id }})"
                                                class="text-yellow-600 hover:text-yellow-900 p-2 rounded-lg hover:bg-yellow-50 transition-colors duration-200"
                                                title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                        @if ($payment->status === 'pending' || $payment->status === 'overdue')
                                            <button type="button"
                                                class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                                onclick="openPayModal({{ $payment->id }})" title="Marquer comme payé">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if ($payment->status !== 'paid')
                                            <form method="POST" action="{{ route('payments.destroy', $payment) }}"
                                                style="display: inline;"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                                    title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-lg">Aucun paiement trouvé</p>
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
    </div>

    <!-- Modals d'édition pour chaque paiement -->
    @if (isset($payments))
        @foreach ($payments as $payment)
            <!-- Modal d'édition -->
            @if ($payment->status !== 'paid')
                <div id="editModal{{ $payment->id }}"
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                    <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
                        <form method="POST" action="{{ route('payments.update', $payment) }}">
                            @csrf
                            @method('PUT')
                            <div class="mt-3">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-medium text-gray-900">Modifier le paiement</h3>
                                    <button type="button" onclick="closeEditModal({{ $payment->id }})"
                                        class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Parent -->
                                    <div>
                                        <label for="parent_id{{ $payment->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Parent *
                                        </label>
                                        <select name="parent_id" id="parent_id{{ $payment->id }}"
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
                                        <label for="student_id{{ $payment->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Étudiant
                                        </label>
                                        <select name="student_id" id="student_id{{ $payment->id }}"
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
                                        <label for="payment_type_edit{{ $payment->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Type de paiement *
                                        </label>
                                        <select name="payment_type" id="payment_type_edit{{ $payment->id }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                            <option value="inscription"
                                                {{ $payment->payment_type == 'inscription' ? 'selected' : '' }}>Inscription
                                            </option>
                                            <option value="scolarite"
                                                {{ $payment->payment_type == 'scolarite' ? 'selected' : '' }}>Scolarité
                                            </option>
                                            <option value="cantine"
                                                {{ $payment->payment_type == 'cantine' ? 'selected' : '' }}>Cantine
                                            </option>
                                            <option value="transport"
                                                {{ $payment->payment_type == 'transport' ? 'selected' : '' }}>Transport
                                            </option>
                                            <option value="autre"
                                                {{ $payment->payment_type == 'autre' ? 'selected' : '' }}>Autre</option>
                                        </select>
                                    </div>

                                    <!-- Période -->
                                    <div>
                                        <label for="period{{ $payment->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Période
                                        </label>
                                        <input type="text" name="period" id="period{{ $payment->id }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Ex: Septembre 2024, Trimestre 1..."
                                            value="{{ $payment->period }}">
                                    </div>

                                    <!-- Montant -->
                                    <div>
                                        <label for="amount{{ $payment->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Montant (DH) *
                                        </label>
                                        <input type="number" name="amount" id="amount{{ $payment->id }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            step="0.01" min="0" required value="{{ $payment->amount }}">
                                    </div>

                                    <!-- Année académique -->
                                    <div>
                                        <label for="academic_year_edit{{ $payment->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Année académique *
                                        </label>
                                        <select name="academic_year" id="academic_year_edit{{ $payment->id }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                            @foreach ($academicYears ?? [] as $year)
                                                <option value="{{ $year }}"
                                                    {{ $payment->academic_year == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Date d'échéance -->
                                    <div>
                                        <label for="due_date{{ $payment->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Date d'échéance *
                                        </label>
                                        <input type="date" name="due_date" id="due_date{{ $payment->id }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required
                                            value="{{ is_string($payment->due_date) ? $payment->due_date : $payment->due_date->format('Y-m-d') }}">
                                    </div>

                                    <!-- Statut -->
                                    <div>
                                        <label for="status_edit{{ $payment->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Statut *
                                        </label>
                                        <select name="status" id="status_edit{{ $payment->id }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>
                                                En attente</option>
                                            <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Payé
                                            </option>
                                            <option value="overdue" {{ $payment->status == 'overdue' ? 'selected' : '' }}>
                                                En retard</option>
                                            <option value="cancelled"
                                                {{ $payment->status == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="mt-6">
                                    <label for="notes{{ $payment->id }}"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        Notes
                                    </label>
                                    <textarea name="notes" id="notes{{ $payment->id }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3"
                                        placeholder="Notes du paiement...">{{ $payment->notes }}</textarea>
                                </div>

                                <div class="flex justify-end space-x-3 mt-8">
                                    <button type="button" onclick="closeEditModal({{ $payment->id }})"
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
                <div id="payModal{{ $payment->id }}"
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <form method="POST" action="{{ route('payments.mark-paid', $payment) }}">
                            @csrf
                            <div class="mt-3">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Marquer comme payé</h3>
                                    <button type="button" onclick="closePayModal({{ $payment->id }})"
                                        class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label for="payment_method{{ $payment->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Méthode de paiement *
                                        </label>
                                        <select name="payment_method" id="payment_method{{ $payment->id }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                            <option value="">Sélectionner...</option>
                                            <option value="especes">Espèces</option>
                                            <option value="cheque">Chèque</option>
                                            <option value="virement">Virement bancaire</option>
                                            <option value="carte">Carte bancaire</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="transaction_reference{{ $payment->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Référence de transaction
                                        </label>
                                        <input type="text" name="transaction_reference"
                                            id="transaction_reference{{ $payment->id }}"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Numéro de chèque, référence virement...">
                                    </div>
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                        <p class="text-sm text-blue-800">
                                            <strong>Montant à encaisser :</strong>
                                            {{ $payment->formatted_amount }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-3 mt-6">
                                    <button type="button" onclick="closePayModal({{ $payment->id }})"
                                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                        Annuler
                                    </button>
                                    <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                                        <i class="fas fa-check mr-2"></i>Marquer comme payé
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

    <script>
        // Fonctions pour le modal d'édition
        function openEditModal(paymentId) {
            document.getElementById('editModal' + paymentId).classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Empêcher le scroll du body
        }

        function closeEditModal(paymentId) {
            document.getElementById('editModal' + paymentId).classList.add('hidden');
            document.body.style.overflow = 'auto'; // Réactiver le scroll du body
        }

        // Fonctions pour le modal de paiement
        function openPayModal(paymentId) {
            document.getElementById('payModal' + paymentId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePayModal(paymentId) {
            document.getElementById('payModal' + paymentId).classList.add('hidden');
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
                // Fermer tous les modals ouverts
                const openModals = document.querySelectorAll('[id^="editModal"], [id^="payModal"]');
                openModals.forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                    }
                });
                document.body.style.overflow = 'auto';
            }
        });

        // Validation du formulaire d'édition
        document.addEventListener('DOMContentLoaded', function() {
            // Validation des formulaires d'édition
            const editForms = document.querySelectorAll('form[action*="payments"][method="POST"]');

            editForms.forEach(form => {
                if (form.querySelector('[name="_method"][value="PUT"]')) {
                    form.addEventListener('submit', function(e) {
                        const amount = form.querySelector('[name="amount"]');
                        const dueDate = form.querySelector('[name="due_date"]');
                        const parentId = form.querySelector('[name="parent_id"]');

                        // Validation du parent
                        if (!parentId.value) {
                            e.preventDefault();
                            alert('Veuillez sélectionner un parent.');
                            parentId.focus();
                            return;
                        }

                        // Validation du montant
                        if (amount && (parseFloat(amount.value) <= 0 || isNaN(parseFloat(amount
                                .value)))) {
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
            });

            // Auto-formatage du montant
            document.addEventListener('input', function(e) {
                if (e.target.name === 'amount') {
                    let value = e.target.value;
                    // Remplacer la virgule par un point pour la validation numérique
                    e.target.value = value.replace(',', '.');
                }
            });
        });

        // Fonction pour confirmer la suppression
        function confirmDelete(form) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce paiement ? Cette action est irréversible.')) {
                form.submit();
            }
            return false;
        }

        // Animation d'ouverture des modals
        function showModalWithAnimation(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');

            // Animation d'entrée
            setTimeout(() => {
                modal.querySelector('.relative').style.transform = 'scale(1)';
                modal.querySelector('.relative').style.opacity = '1';
            }, 10);
        }

        // Préchargement des données pour améliorer les performances
        document.addEventListener('DOMContentLoaded', function() {
            // Précharger les options des selects si nécessaire
            console.log('Page des paiements chargée avec succès');
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
        input:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Responsive pour les modals */
        @media (max-width: 768px) {
            .modal-container {
                width: 95% !important;
                max-width: none !important;
            }
        }
    </style>
@endsection
