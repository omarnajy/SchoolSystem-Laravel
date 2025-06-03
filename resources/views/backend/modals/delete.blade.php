<div id="deletemodal"
    class="modal-bg hidden fixed top-0 left-0 right-0 bottom-0 w-full h-full overflow-auto z-50 bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white relative max-w-md w-full mx-auto shadow-2xl rounded-2xl border border-gray-200 transform transition-all duration-300 scale-95 opacity-0"
            id="modal-content">

            <!-- Close Button -->
            <div id="deletemodelclose"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 cursor-pointer transition-colors duration-200 z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </div>

            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-t-2xl px-6 py-6">
                <div class="flex items-center">
                    <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.077 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Confirmation de suppression</h3>
                        <p class="text-red-100 text-sm mt-1">Cette action est irréversible</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form action="" method="POST" class="remove-record">
                    @csrf
                    @method('DELETE')

                    <div class="text-center mb-6">
                        <div class="mx-auto h-16 w-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </div>

                        <h4 class="text-lg font-semibold text-gray-900 mb-2">
                            Êtes-vous sûr de vouloir supprimer ?
                        </h4>

                        <p class="text-gray-600 text-sm leading-relaxed">
                            Cette action supprimera définitivement <strong>{{ $name ?? 'cet élément' }}</strong> et
                            toutes ses données associées.
                            Cette opération ne peut pas être annulée.
                        </p>
                    </div>

                    <!-- Warning Notice -->
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-amber-500 mt-0.5 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.077 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                            <div>
                                <h5 class="text-sm font-medium text-amber-800">Attention</h5>
                                <p class="text-xs text-amber-700 mt-1">
                                    Toutes les données liées seront également supprimées (relations, historiques, etc.)
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" id="cancelDelete"
                            class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            Annuler
                        </button>

                        <button type="submit"
                            class="group relative px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-lg hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-105 active:scale-95">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-4 w-4 text-red-300 group-hover:text-red-200 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </span>
                            Supprimer définitivement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animation d'ouverture du modal */
    #deletemodal:not(.hidden) #modal-content {
        animation: modalOpen 0.3s ease-out forwards;
    }

    @keyframes modalOpen {
        0% {
            opacity: 0;
            transform: scale(0.95) translateY(-10px);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Animation de fermeture */
    #deletemodal.closing #modal-content {
        animation: modalClose 0.2s ease-in forwards;
    }

    @keyframes modalClose {
        0% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        100% {
            opacity: 0;
            transform: scale(0.95) translateY(-10px);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('deletemodal');
        const modalContent = document.getElementById('modal-content');
        const closeBtn = document.getElementById('deletemodelclose');
        const cancelBtn = document.getElementById('cancelDelete');

        // Fonction pour fermer le modal avec animation
        function closeModal() {
            modal.classList.add('closing');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('closing');
            }, 200);
        }

        // Gérer la fermeture
        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }

        // Fermer en cliquant sur l'arrière-plan
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Fermer avec la touche Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
</script>
