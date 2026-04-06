<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        
        <!-- Sélection du mode -->
        <div class="mb-8">
            <label class="block text-sm font-semibold text-gray-700 mb-4">
                Mode de répartition <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Mode A -->
                <div wire:click="$set('mode', 'A')" 
                    class="relative border-2 rounded-xl p-5 cursor-pointer transition hover:shadow-md
                        {{ $mode === 'A' ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:border-green-300' }}">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0
                            {{ $mode === 'A' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-1">Mode A — Par groupes</h3>
                            <p class="text-sm text-gray-600">Répartir les participants en groupes de taille définie</p>
                        </div>
                        @if($mode === 'A')
                            <svg class="w-6 h-6 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                </div>

                <!-- Mode B -->
                <div wire:click="$set('mode', 'B')" 
                    class="relative border-2 rounded-xl p-5 cursor-pointer transition hover:shadow-md
                        {{ $mode === 'B' ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:border-green-300' }}">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0
                            {{ $mode === 'B' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-1">Mode B — Par thèmes</h3>
                            <p class="text-sm text-gray-600">Répartir les participants sur des thèmes de travail</p>
                        </div>
                        @if($mode === 'B')
                            <svg class="w-6 h-6 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuration Mode A -->
        @if($mode === 'A')
            <div class="mb-8 p-5 bg-gray-50 rounded-lg border border-gray-200">
                <label for="groupSize" class="block text-sm font-semibold text-gray-700 mb-2">
                    Taille des groupes <span class="text-red-500">*</span>
                </label>
                <input type="number" id="groupSize" wire:model.live="groupSize" min="2" 
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                        {{ $errors->has('groupSize') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    placeholder="Ex: 5">
                <x-input-error-icon :messages="$errors->get('groupSize')" />
                
                @if(count($suggestions) > 0)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">💡 Suggestions optimales :</p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            @foreach($suggestions as $suggestion)
                                <button wire:click="selectSuggestion({{ $suggestion['size'] }})" 
                                    class="px-4 py-2.5 bg-white border-2 border-blue-200 text-blue-800 rounded-lg text-sm font-medium hover:bg-blue-50 hover:border-blue-400 transition">
                                    <div class="font-bold text-base">{{ $suggestion['size'] }} personnes</div>
                                    <div class="text-xs text-blue-600">{{ $suggestion['groups'] }} groupes • reste: {{ $suggestion['remainder'] }}</div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Configuration Mode B -->
        @if($mode === 'B')
            <div class="mb-8 p-5 bg-gray-50 rounded-lg border border-gray-200">
                <label for="themeInput" class="block text-sm font-semibold text-gray-700 mb-2">
                    Thèmes de travail <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2 mb-3">
                    <input type="text" id="themeInput" wire:model="themeInput" wire:keydown.enter="addTheme" 
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="Ex: Intelligence Artificielle">
                    <button wire:click="addTheme" 
                        class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                        Ajouter
                    </button>
                </div>
                <x-input-error-icon :messages="$errors->get('themes')" />
                
                @if(count($themes) > 0)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Thèmes ajoutés ({{ count($themes) }}) :</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($themes as $index => $theme)
                                <span class="inline-flex items-center gap-2 bg-purple-100 border border-purple-300 text-purple-800 px-3 py-2 rounded-lg font-medium">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $theme }}
                                    <button wire:click="removeTheme({{ $index }})" 
                                        class="text-purple-600 hover:text-purple-800 hover:bg-purple-200 rounded-full p-0.5 transition">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Contraintes (optionnel) -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <label class="block text-sm font-semibold text-gray-700">
                    Contraintes (optionnel)
                </label>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">
                    {{ count($constraints) }}/20
                </span>
            </div>
            <p class="text-sm text-gray-600 mb-4">
                Définissez des règles pour forcer certains participants à être ensemble (inclusion) ou séparés (exclusion).
            </p>
            
            @if(count($constraints) > 0)
                <div class="space-y-2 mb-4">
                    @foreach($constraints as $index => $constraint)
                        <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center gap-2">
                                @if($constraint['type'] === 'inclusion')
                                    <span class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm"><span class="font-semibold text-green-700">Ensemble</span></span>
                                @else
                                    <span class="w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <span class="text-sm"><span class="font-semibold text-red-700">Séparés</span></span>
                                @endif
                            </div>
                            <button wire:click="removeConstraint({{ $index }})" 
                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                Supprimer
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg text-center">
                    <p class="text-sm text-blue-700">Aucune contrainte définie. Le tirage sera purement aléatoire.</p>
                </div>
            @endif
        </div>

        <!-- Boutons navigation -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
            @if($errors->has('general'))
                <div class="w-full mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-800 text-sm">
                    {{ $errors->first('general') }}
                </div>
            @endif
            
            <button wire:click="previousStep" 
                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Retour
            </button>
            <button wire:click="nextStep" 
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-semibold rounded-lg transition shadow-lg">
                <span wire:loading.remove wire:target="nextStep">Lancer le tirage</span>
                <span wire:loading wire:target="nextStep">Traitement...</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </button>
        </div>
    </div>
</div>
