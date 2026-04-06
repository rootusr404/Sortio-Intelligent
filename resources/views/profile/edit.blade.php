<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Mon profil</h2>
            <p class="text-sm text-gray-600 mt-1">Gérez vos informations personnelles et paramètres de compte</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">

                    {{-- Avatar lettre + badge statut --}}
                    <div class="relative inline-block mb-4">
                        {{-- Anneau coloré selon le plan --}}
                        <div class="p-[3px] rounded-full {{ $user->plan === 'pro' ? 'bg-gradient-to-br from-yellow-400 to-orange-500' : 'bg-gradient-to-br from-green-400 to-green-600' }}">
                            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center shadow-inner">
                                <span class="text-white text-2xl font-bold tracking-wide select-none">
                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                </span>
                            </div>
                        </div>

                        {{-- Badge statut email (en ligne / non vérifié) --}}
                        @if($user->email_verified_at)
                            <span class="absolute bottom-0.5 right-0.5 w-4 h-4 bg-green-500 border-2 border-white rounded-full"
                                  title="Email vérifié"></span>
                        @else
                            <span class="absolute bottom-0.5 right-0.5 w-4 h-4 bg-amber-400 border-2 border-white rounded-full"
                                  title="Email non vérifié"></span>
                        @endif
                    </div>

                    <h3 class="text-lg font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h3>
                    <p class="text-sm text-gray-500 mt-0.5 truncate">{{ $user->email }}</p>

                    {{-- Badges plan + vérification --}}
                    <div class="flex items-center justify-center gap-2 mt-3 flex-wrap">
                        @if($user->plan === 'pro')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-yellow-100 to-orange-100 text-orange-800 border border-orange-200">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Pro
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                Gratuit
                            </span>
                        @endif

                        @if($user->email_verified_at)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Vérifié
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                Non vérifié
                            </span>
                        @endif
                    </div>

                    <div class="mt-5 pt-5 border-t border-gray-100 space-y-2.5 text-left">
                        @if($user->role)
                        <div class="flex items-center gap-2.5 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $user->role }}
                        </div>
                        @endif
                        @if($user->organization)
                        <div class="flex items-center gap-2.5 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $user->organization }}
                        </div>
                        @endif
                        @if($user->country)
                        <div class="flex items-center gap-2.5 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $user->city ? $user->city.', ' : '' }}{{ $user->country }}
                        </div>
                        @endif
                        <div class="flex items-center gap-2.5 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Membre depuis {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>

                {{-- Stats rapides --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Activité</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Tirages réalisés</span>
                            <span class="text-sm font-bold text-gray-900">{{ $user->draws()->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Participants traités</span>
                            <span class="text-sm font-bold text-gray-900">{{ $user->draws()->sum('participant_count') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contenu principal --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Informations personnelles --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Informations personnelles</h3>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Sécurité --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Sécurité</h3>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>

                {{-- Zone de danger --}}
                <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-red-800">Zone de danger</h3>
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
