@extends('layouts.frontend')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-white to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header with Icon -->
            <div class="text-center">
                <div
                    class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-gradient-to-br from-green-400 to-blue-500 mb-6">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">
                    {{ __('Vérifiez votre email') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Nous avons envoyé un lien de vérification à votre adresse email
                </p>
            </div>

            <!-- Verification Card -->
            <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl p-8 border border-white/20">

                <!-- Success Message -->
                @if (session('resent'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Instructions -->
                <div class="text-center mb-8">
                    <div class="mb-6">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="space-y-4 text-gray-700">
                        <p class="text-base leading-relaxed">
                            {{ __('Avant de continuer, veuillez vérifier votre email pour un lien de vérification.') }}
                        </p>

                        <div class="bg-gray-50 rounded-lg p-4 text-sm">
                            <p class="text-gray-600">
                                Vérifiez également votre dossier spam ou courrier indésirable si vous ne voyez pas l'email
                                dans votre boîte de réception.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-4">
                    <!-- Resend Button -->
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                            </span>
                            Renvoyer l'email de vérification
                        </button>
                    </form>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Retour à la connexion
                        </a>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">
                                    Besoin d'aide ?
                                </h3>
                                <p class="mt-1 text-sm text-blue-700">
                                    Si vous continuez à avoir des problèmes, contactez notre support technique.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
