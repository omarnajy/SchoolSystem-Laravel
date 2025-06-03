@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Créer une permission</h1>
                            <p class="text-gray-600 mt-1">Définir de nouvelles permissions et les assigner aux rôles</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('roles-permissions') }}"
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

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Permission Creation Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                            <h2 class="text-lg font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Nouvelle permission
                            </h2>
                            <p class="text-purple-100 mt-1">Créer et assigner une permission aux rôles</p>
                        </div>

                        <form action="{{ route('permission.store') }}" method="POST" class="p-6">
                            @csrf

                            <div class="space-y-6">
                                <!-- Permission Name -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                                        Nom de la permission *
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="name" id="name"
                                            placeholder="Ex: view-users, edit-posts, manage-settings..."
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white @error('name') border-red-300 bg-red-50 @enderror">
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
                                    <p class="mt-2 text-xs text-gray-500">
                                        Utilisez des noms explicites comme "view-users", "edit-articles", "delete-comments"
                                    </p>
                                </div>

                                <!-- Role Assignment -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Assigner aux rôles
                                    </label>
                                    <div class="space-y-3 max-h-64 overflow-y-auto bg-gray-50 rounded-xl p-4">
                                        @forelse ($roles as $role)
                                            <label
                                                class="flex items-center p-3 bg-white rounded-lg border border-gray-200 cursor-pointer hover:border-purple-300 transition-all duration-200 group">
                                                <input type="checkbox" name="selectedroles[]" value="{{ $role->name }}"
                                                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded transition-colors">
                                                <div class="ml-3 flex items-center justify-between w-full">
                                                    <div>
                                                        <span
                                                            class="text-sm font-medium text-gray-900 group-hover:text-purple-700">
                                                            {{ $role->name }}
                                                        </span>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $role->permissions->count() }} permissions actuelles
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="h-8 w-8 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-lg flex items-center justify-center">
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
                                            class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-purple-100 text-purple-700 hover:bg-purple-200 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Tout sélectionner
                                        </button>
                                        <button type="button" onclick="unselectAllRoles()"
                                            class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Tout désélectionner
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex items-center justify-end space-x-4">
                                    <a href="{{ route('roles-permissions') }}"
                                        class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                                        Annuler
                                    </a>

                                    <button type="submit"
                                        class="group relative px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-105 active:scale-95">
                                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-purple-300 group-hover:text-purple-200 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </span>
                                        Créer la permission
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Existing Permissions Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-600 to-gray-700 px-6 py-4">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Permissions existantes
                            </h3>
                            <p class="text-gray-300 text-sm mt-1">{{ $permissions->count() }} permissions créées</p>
                        </div>

                        <div class="p-6">
                            <div class="max-h-96 overflow-y-auto space-y-3">
                                @forelse ($permissions as $permission)
                                    <div
                                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-all duration-200">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-gray-900 truncate">{{ $permission->name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $permission->roles->count() }} rôles assignés
                                            </p>
                                        </div>

                                        <a href="{{ route('permission.edit', $permission->id) }}"
                                            class="inline-flex items-center p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-all duration-200 hover:scale-105 group ml-3">
                                            <svg class="h-4 w-4 group-hover:scale-110 transition-transform" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Aucune permission</h4>
                                        <p class="text-xs text-gray-500">Créez votre première permission.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Quick Stats -->
                            @if ($permissions->count() > 0)
                                <div class="mt-6 pt-4 border-t border-gray-200">
                                    <div class="grid grid-cols-2 gap-4 text-center">
                                        <div class="bg-purple-50 rounded-lg p-3">
                                            <div class="text-lg font-bold text-purple-600">{{ $permissions->count() }}
                                            </div>
                                            <div class="text-xs text-purple-700">Permissions</div>
                                        </div>
                                        <div class="bg-blue-50 rounded-lg p-3">
                                            <div class="text-lg font-bold text-blue-600">{{ $roles->count() }}</div>
                                            <div class="text-xs text-blue-700">Rôles</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
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
                        <h3 class="text-sm font-semibold text-blue-800">Guide des permissions</h3>
                        <ul class="mt-2 text-sm text-blue-700 space-y-1">
                            <li>• <strong>Nommage :</strong> Utilisez des noms clairs comme "view-users", "edit-posts"</li>
                            <li>• <strong>Convention :</strong> Format recommandé : action-ressource (ex: create-article)
                            </li>
                            <li>• <strong>Assignment :</strong> Sélectionnez les rôles qui auront cette permission</li>
                            <li>• <strong>Modification :</strong> Cliquez sur l'icône d'édition pour modifier une permission
                                existante</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectAllRoles() {
            document.querySelectorAll('input[name="selectedroles[]"]').forEach(checkbox => {
                checkbox.checked = true;
                checkbox.closest('label').classList.add('border-purple-500', 'bg-purple-50');
                checkbox.closest('label').classList.remove('border-gray-200');
            });
        }

        function unselectAllRoles() {
            document.querySelectorAll('input[name="selectedroles[]"]').forEach(checkbox => {
                checkbox.checked = false;
                checkbox.closest('label').classList.remove('border-purple-500', 'bg-purple-50');
                checkbox.closest('label').classList.add('border-gray-200');
            });
        }

        // Dynamic styling on checkbox change
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="selectedroles[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const label = this.closest('label');
                    if (this.checked) {
                        label.classList.add('border-purple-500', 'bg-purple-50');
                        label.classList.remove('border-gray-200');
                    } else {
                        label.classList.remove('border-purple-500', 'bg-purple-50');
                        label.classList.add('border-gray-200');
                    }
                });
            });
        });
    </script>
@endsection
