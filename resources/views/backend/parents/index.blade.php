@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Gestion des parents</h1>
                            <p class="text-gray-600 mt-1">Administrer les comptes parents et leurs informations</p>
                        </div>
                    </div>

                    <a href="{{ route('parents.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                        Nouveau parent
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total parents</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $parents->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Avec enfants</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $parents->filter(function ($parent) {return $parent->children->count() > 0;})->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Avec téléphone</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $parents->whereNotNull('phone')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Comptes actifs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $parents->whereNotNull('email')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Parents Table -->
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Liste des parents
                    </h2>
                </div>

                <!-- Responsive Table Container -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span>Parent</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                            </path>
                                        </svg>
                                        <span>Contact</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center justify-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                            </path>
                                        </svg>
                                        <span>Enfants</span>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($parents as $parent)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <!-- Parent Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-12 w-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center mr-4">
                                                @if ($parent->user->profile_picture)
                                                    <img class="h-12 w-12 rounded-xl object-cover"
                                                        src="{{ asset('images/profile/' . $parent->user->profile_picture) }}"
                                                        alt="{{ $parent->user->name }}">
                                                @else
                                                    <span
                                                        class="text-white font-semibold text-sm">{{ substr($parent->user->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $parent->user->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 flex items-center mt-1">
                                                    @if ($parent->gender)
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                        @if ($parent->gender === 'male') bg-blue-100 text-blue-800
                                                        @elseif($parent->gender === 'female') bg-pink-100 text-pink-800
                                                        @else bg-purple-100 text-purple-800 @endif">
                                                            {{ ucfirst($parent->gender) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Contact Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm text-gray-900 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                                    </path>
                                                </svg>
                                                {{ $parent->user->email }}
                                            </div>
                                            @if ($parent->phone)
                                                <div class="text-sm text-gray-500 flex items-center mt-1">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                        </path>
                                                    </svg>
                                                    {{ $parent->phone }}
                                                </div>
                                            @else
                                                <div class="text-xs text-gray-400 mt-1">Aucun téléphone</div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Children -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-wrap gap-1 justify-center">
                                            @forelse ($parent->children as $child)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                        </path>
                                                    </svg>
                                                    {{ Str::limit($child->user->name, 15) }}
                                                </span>
                                            @empty
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.077 16.5c-.77.833.192 2.5 1.732 2.5z">
                                                        </path>
                                                    </svg>
                                                    Aucun enfant
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- View Details -->
                                            <div class="group relative">
                                                <button
                                                    class="inline-flex items-center p-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all duration-200 hover:scale-105"
                                                    onclick="showParentDetails({{ $parent->id }})"
                                                    title="Voir détails">
                                                    <svg class="h-4 w-4 group-hover:scale-110 transition-transform"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Edit -->
                                            <a href="{{ route('parents.edit', $parent->id) }}"
                                                class="inline-flex items-center p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-all duration-200 hover:scale-105 group"
                                                title="Modifier">
                                                <svg class="h-4 w-4 group-hover:scale-110 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <!-- Delete -->
                                            <button
                                                onclick="openDeleteModal('{{ route('parents.destroy', $parent->id) }}', '{{ $parent->user->name }}')"
                                                class="inline-flex items-center p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-all duration-200 hover:scale-105 group deletebtn"
                                                data-url="{{ route('parents.destroy', $parent->id) }}" title="Supprimer">
                                                <svg class="h-4 w-4 group-hover:scale-110 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="h-12 w-12 text-gray-400 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun parent trouvé</h3>
                                            <p class="text-gray-500 mb-4">Commencez par ajouter votre premier parent.</p>
                                            <a href="{{ route('parents.create') }}"
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Ajouter un parent
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($parents->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Affichage de {{ $parents->firstItem() }} à {{ $parents->lastItem() }} sur
                                {{ $parents->total() }} résultats
                            </div>
                            <div class="pagination-wrapper">
                                {{ $parents->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-blue-800">Guide de gestion des parents</h3>
                        <ul class="mt-2 text-sm text-blue-700 space-y-1">
                            <li>• <strong>Voir détails :</strong> Cliquez sur l'icône œil pour afficher plus d'informations
                            </li>
                            <li>• <strong>Modifier :</strong> Cliquez sur l'icône crayon pour éditer les informations du
                                parent</li>
                            <li>• <strong>Supprimer :</strong> Cliquez sur l'icône poubelle pour supprimer le compte
                                (attention, irréversible)</li>
                            <li>• Les enfants associés sont affichés sous forme de badges dans la colonne correspondante
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Delete Modal -->
    @include('backend.modals.delete', ['name' => 'parent'])

    <style>
        .pagination-wrapper .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination-wrapper .pagination .page-link {
            padding: 0.5rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .pagination-wrapper .pagination .page-link:hover {
            background-color: #f3f4f6;
            color: #374151;
        }

        .pagination-wrapper .pagination .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }
    </style>

    <script>
        // Modal delete functionality
        function openDeleteModal(url, name) {
            const modal = document.getElementById('deletemodal');
            const form = modal.querySelector('.remove-record');
            form.action = url;

            // Update modal content with parent name
            const nameElement = modal.querySelector('strong');
            if (nameElement) {
                nameElement.textContent = name;
            }

            modal.classList.remove('hidden');
        }

        // Parent details modal (placeholder function)
        function showParentDetails(parentId) {
            // This would typically open a modal or navigate to a details page
            console.log('Show details for parent ID:', parentId);
            // You can implement a detailed view modal here
        }

        // jQuery functionality for backward compatibility
        $(function() {
            $(".deletebtn").on("click", function(event) {
                event.preventDefault();
                $("#deletemodal").removeClass("hidden");
                var url = $(this).attr('data-url');
                $(".remove-record").attr("action", url);
            });

            $("#deletemodelclose, #cancelDelete").on("click", function(event) {
                event.preventDefault();
                $("#deletemodal").addClass("hidden");
            });
        });
    </script>
@endsection
