@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-green-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Modifier la permission</h1>
                            <p class="text-gray-600 mt-1">Mettre à jour <span
                                    class="font-semibold text-emerald-600">{{ $permission->name }}</span> et ses
                                assignations</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('permission.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200 shadow-sm hover:shadow-md group">
                            <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span class="font-medium">Retour</span>
                        </a>

                        <a href="{{ route('role.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-200 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="font-medium">Nouveau rôle</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Current Permission Info Card -->
            <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl border border-white/20 p-6 mb-8">
                <div class="flex items-center">
                    <div
                        class="h-16 w-16 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center mr-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $permission->name }}</h3>
                        <p class="text-gray-600">Permission système</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                {{ $permission->roles->count() }} rôles assignés
                            </span>
                            <span class="text-xs text-gray-500">
                                Créé {{ $permission->created_at ? $permission->created_at->diffForHumans() : 'récemment' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-green-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Modifier la permission
                    </h2>
                    <p class="text-emerald-100 mt-1">Mettez à jour le nom et les assignations de rôles</p>
                </div>

                <form action="{{ route('permission.update', $permission->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Current Roles Display -->
                        @if ($permission->roles->count() > 0)
                            <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-200">
                                <h3 class="text-sm font-semibold text-emerald-800 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Rôles actuellement assignés
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($permission->roles as $assignedRole)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $assignedRole->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Permission Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                                Nom de la permission *
                            </label>
                            <div class="relative">
                                <input type="text" name="name" id="name" value="{{ $permission->name }}"
                                    placeholder="Ex: view-users, edit-posts, manage-settings..."
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white @error('name') border-red-300 bg-red-50 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Role Assignment -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Assigner aux rôles
                            </label>
                            <div class="space-y-3 max-h-64 overflow-y-auto bg-gray-50 rounded-xl p-4">
                                @forelse ($roles as $role)
                                    @php
                                        $isAssigned = $permission->roles->contains('id', $role->id);
                                    @endphp
                                    <label
                                        class="flex items-center p-3 bg-white rounded-lg border-2 cursor-pointer hover:border-emerald-300 transition-all duration-200 group {{ $isAssigned ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200' }}">
                                        <input type="checkbox" name="selectedroles[]" value="{{ $role->name }}"
                                            {{ $isAssigned ? 'checked' : '' }}
                                            class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded transition-colors">
                                        <div class="ml-3 flex items-center justify-between w-full">
                                            <div>
                                                <span
                                                    class="text-sm font-medium text-gray-900 group-hover:text-emerald-700">
                                                    {{ $role->name }}
                                                </span>
                                                <p class="text-xs text-gray-500">
                                                    {{ $role->permissions->count() }} permissions au total
                                                </p>
                                            </div>
                                            <div
                                                class="h-8 w-8 bg-gradient-to-br from-emerald-400 to-green-500 rounded-lg flex items-center justify-center">
                                                <span
                                                    class="text-white font-semibold text-xs">{{ substr($role->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                    </label>
                                @empty
                                    <div class="text-center py-4">
                                        <svg class="h-8 w-8 text-gray-400 mx-auto mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.077 16.5c-.77.833.192 2.5 1.732 2.5z">
                                            </path>
                                        </svg>
                                        <p class="text-sm text-gray-500">Aucun rôle disponible</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Actions rapides</h4>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" onclick="selectAllRoles()"
                                    class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-emerald-100 text-emerald-700 hover:bg-emerald-200 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Tout sélectionner
                                </button>
                                <button type="button" onclick="unselectAllRoles()"
                                    class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Tout désélectionner
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('permission.create') }}"
                                class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                                Annuler
                            </a>

                            <button type="submit"
                                class="group relative px-8 py-3 bg-gradient-to-r from-emerald-600 to-green-600 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 transform hover:scale-105 active:scale-95">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-emerald-300 group-hover:text-emerald-200 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                </span>
                                Mettre à jour la permission
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Warning Section -->
            <div class="mt-8 bg-amber-50 rounded-xl p-6 border border-amber-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.077 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-amber-800">Attention</h3>
                        <ul class="mt-2 text-sm text-amber-700 space-y-1">
                            <li>• La modification du nom peut affecter les vérifications de permissions dans le code</li>
                            <li>• Les changements d'assignation prennent effet immédiatement</li>
                            <li>• Les utilisateurs avec les rôles modifiés verront leurs permissions changer</li>
                            <li>• Assurez-vous que les modifications sont appropriées avant de sauvegarder</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Permission Usage Info -->
            @if ($permission->roles->count() > 0)
                <div class="mt-6 bg-blue-50 rounded-xl p-6 border border-blue-200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-blue-800">Utilisation actuelle</h3>
                            <p class="mt-2 text-sm text-blue-700">
                                Cette permission est actuellement utilisée par {{ $permission->roles->count() }} rôle(s) :
                                @foreach ($permission->roles as $role)
                                    <span class="font-medium">{{ $role->name }}</span>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function selectAllRoles() {
            document.querySelectorAll('input[name="selectedroles[]"]').forEach(checkbox => {
                checkbox.checked = true;
                checkbox.closest('label').classList.add('border-emerald-500', 'bg-emerald-50');
                checkbox.closest('label').classList.remove('border-gray-200');
            });
        }

        function unselectAllRoles() {
            document.querySelectorAll('input[name="selectedroles[]"]').forEach(checkbox => {
                checkbox.checked = false;
                checkbox.closest('label').classList.remove('border-emerald-500', 'bg-emerald-50');
                checkbox.closest('label').classList.add('border-gray-200');
            });
        }

        // Dynamic styling on checkbox change
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="selectedroles[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const label = this.closest('label');
                    if (this.checked) {
                        label.classList.add('border-emerald-500', 'bg-emerald-50');
                        label.classList.remove('border-gray-200');
                    } else {
                        label.classList.remove('border-emerald-500', 'bg-emerald-50');
                        label.classList.add('border-gray-200');
                    }
                });
            });
        });
    </script>
@endsection
