<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        
        <!-- Titre du tirage -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                Titre du tirage <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" wire:model="title" 
                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                    {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                placeholder="Ex: Groupes TD — L3 Informatique — Semestre 2">
            <x-input-error-icon :messages="$errors->get('title')" />
        </div>

        <!-- Import fichier -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Méthode 1 : Importer un fichier
            </label>
            
            @if(!count($participants))
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-green-500 transition cursor-pointer">
                <input type="file" wire:model="file" accept=".csv,.xlsx,.xls" class="hidden" id="fileInput">
                
                <label for="fileInput" class="cursor-pointer block">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-700 mb-1">Cliquez pour sélectionner un fichier</p>
                    <p class="text-xs text-gray-500">CSV, XLS ou XLSX (max 2 Mo)</p>
                </label>

                <div wire:loading wire:target="file" class="mt-3">
                    <div class="inline-flex items-center gap-2 text-sm text-blue-600">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Importation en cours...
                    </div>
                </div>
            </div>
            @else
            <div class="border-2 border-green-300 bg-green-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-green-800">Fichier importé avec succès</p>
                            <p class="text-xs text-green-600">{{ count($participants) }} participants détectés</p>
                        </div>
                    </div>
                    <button wire:click="$set('participants', [])" type="button"
                        class="text-sm text-green-700 hover:text-green-900 font-medium">
                        Changer de fichier
                    </button>
                </div>
            </div>
            @endif
            
            <x-input-error-icon :messages="$errors->get('file')" />
        </div>

        <!-- Séparateur -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-3 bg-white text-gray-500 font-medium">OU</span>
            </div>
        </div>

        <!-- Copier-coller -->
        <div class="mb-6">
            <label for="pastedText" class="block text-sm font-semibold text-gray-700 mb-2">
                Méthode 2 : Copier-coller une liste
            </label>
            <textarea id="pastedText" wire:model.live.debounce.500ms="pastedText" rows="8"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition font-mono text-sm"
                placeholder="Jean Dupont&#10;Marie Martin&#10;Pierre Durand&#10;Sophie Lefebvre&#10;..."></textarea>
            <p class="mt-1.5 text-xs text-gray-500">Un nom par ligne. Les doublons seront automatiquement supprimés.</p>
        </div>

        <!-- Liste des participants détectés -->
        @if(count($participants) > 0)
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-green-800">{{ count($participants) }} participants détectés</span>
                    </div>
                    <button wire:click="$set('participants', [])" class="text-xs text-green-700 hover:text-green-900 font-medium">
                        Tout effacer
                    </button>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($participants as $index => $participant)
                        <span class="inline-flex items-center gap-1.5 bg-white border border-green-300 text-green-800 px-3 py-1.5 rounded-lg text-sm font-medium">
                            {{ $participant }}
                            <button wire:click="removeParticipant({{ $index }})" 
                                class="text-green-600 hover:text-green-800 hover:bg-green-100 rounded-full p-0.5 transition">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Alerte anti-doublon -->
        @if(count($duplicatePairs) > 0)
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-amber-800 mb-2">
                            Paires déjà vues dans vos tirages précédents
                        </p>
                        <ul class="text-sm text-amber-700 space-y-1">
                            @foreach($duplicatePairs as $pair)
                                <li class="flex items-center gap-1.5">
                                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $pair[0] }} <span class="text-amber-600">et</span> {{ $pair[1] }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="text-xs text-amber-600 mt-2">
                            Des contraintes d'exclusion seront automatiquement proposées à l'étape suivante.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Bouton suivant -->
        <div class="flex justify-end pt-4 border-t border-gray-200">
            <button wire:click="nextStep" 
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-semibold rounded-lg transition shadow-sm">
                <span wire:loading.remove wire:target="nextStep">Continuer vers la configuration</span>
                <span wire:loading wire:target="nextStep">Validation...</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
        </div>
    </div>
</div>
