<x-guest-layout>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Vérifier un tirage</h2>
                <p class="text-gray-600">Vérifiez l'authenticité d'un procès-verbal de tirage</p>
            </div>

            <x-flash-messages />
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-2 border-red-300 text-red-900 px-5 py-4 rounded-lg shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 shrink-0 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <p class="font-bold text-base mb-2">⚠️ Veuillez corriger les erreurs suivantes :</p>
                            <ul class="space-y-1.5">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-2">
                                        <span class="text-red-600 mt-1">•</span>
                                        <span class="text-sm">{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Explication -->
            <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="text-sm font-semibold text-blue-900 mb-2">Comment ça marche ?</h3>
                <p class="text-sm text-blue-800">
                    Chaque tirage Sortio génère un hash SHA-256 unique basé sur les participants, le seed, le timestamp et les paramètres.
                    Si une seule donnée est modifiée, le hash change complètement. Saisissez les informations du procès-verbal pour vérifier son authenticité.
                </p>
            </div>

            <form method="POST" action="{{ route('verify.check') }}" class="space-y-6">
                @csrf

                <!-- Hash -->
                <div>
                    <label for="hash" class="block text-sm font-medium text-gray-700 mb-2">
                        Hash SHA-256 <span class="text-red-500">*</span>
                    </label>
                    <input id="hash" name="hash" type="text" value="{{ old('hash') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg font-mono text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855">
                    <x-input-error-icon :messages="$errors->get('hash')" />
                </div>

                <!-- Seed -->
                <div>
                    <label for="seed" class="block text-sm font-medium text-gray-700 mb-2">
                        Seed cryptographique <span class="text-red-500">*</span>
                    </label>
                    <input id="seed" name="seed" type="text" value="{{ old('seed') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg font-mono text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="a1b2c3d4e5f6...">
                    <x-input-error-icon :messages="$errors->get('seed')" />
                </div>

                <!-- Timestamp -->
                <div>
                    <label for="timestamp" class="block text-sm font-medium text-gray-700 mb-2">
                        Timestamp ISO 8601 <span class="text-red-500">*</span>
                    </label>
                    <input id="timestamp" name="timestamp" type="text" value="{{ old('timestamp') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg font-mono text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="2024-01-15T14:30:00+00:00">
                    <x-input-error-icon :messages="$errors->get('timestamp')" />
                </div>

                <!-- Participants -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Liste des participants <span class="text-red-500">*</span>
                        </label>
                    </div>
                    
                    <!-- Zone d'upload -->
                    <div class="mb-3 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition cursor-pointer" 
                         onclick="document.getElementById('participant_file').click()">
                        <input type="file" id="participant_file" accept=".csv,.xlsx,.xls,.txt" class="hidden" 
                            onchange="handleParticipantFileUpload(event)">
                        
                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-xs font-medium text-gray-700">Cliquez pour importer un fichier</p>
                        <p class="text-xs text-gray-500">ou saisissez manuellement ci-dessous</p>
                    </div>
                    
                    <!-- Saisie manuelle -->
                    <textarea id="participants" name="participants" rows="8" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Jean Dupont&#10;Marie Martin&#10;Pierre Durand&#10;...">{{ old('participants') }}</textarea>
                    
                    <x-input-error-icon :messages="$errors->get('participants')" />
                </div>

                <!-- Type de tirage -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Type de tirage <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4" x-data="{ type: 'A' }">
                        <label class="relative border-2 rounded-lg p-4 cursor-pointer transition hover:border-blue-400"
                            :class="type === 'A' ? 'border-blue-500 bg-blue-50' : 'border-gray-300'">
                            <input type="radio" name="draw_type" value="A" x-model="type" class="sr-only" checked>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                    :class="type === 'A' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Mode A</div>
                                    <div class="text-xs text-gray-600">Par groupes</div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative border-2 rounded-lg p-4 cursor-pointer transition hover:border-blue-400"
                            :class="type === 'B' ? 'border-blue-500 bg-blue-50' : 'border-gray-300'">
                            <input type="radio" name="draw_type" value="B" x-model="type" class="sr-only">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                    :class="type === 'B' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Mode B</div>
                                    <div class="text-xs text-gray-600">Par thèmes</div>
                                </div>
                            </div>
                        </label>
                        
                        <!-- Champ Mode A -->
                        <div x-show="type === 'A'" class="col-span-2">
                            <label for="group_size" class="block text-sm font-medium text-gray-700 mb-2 mt-4">
                                Taille des groupes <span class="text-red-500">*</span>
                            </label>
                            <input id="group_size" name="group_size" type="number" min="2" value="{{ old('group_size') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Ex: 5">
                        </div>
                        
                        <!-- Champ Mode B -->
                        <div x-show="type === 'B'" class="col-span-2">
                            <div class="flex items-center justify-between mb-2 mt-4">
                                <label class="block text-sm font-medium text-gray-700">
                                    Thèmes <span class="text-red-500">*</span>
                                </label>
                            </div>
                            
                            <!-- Import fichier thèmes -->
                            <div class="mb-3 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition cursor-pointer"
                                 onclick="document.getElementById('theme_file').click()">
                                <input type="file" id="theme_file" accept=".csv,.xlsx,.xls,.txt" class="hidden" 
                                    onchange="handleThemeFileUpload(event)">
                                <svg class="mx-auto h-6 w-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-xs font-medium text-gray-700">Cliquez pour importer les thèmes</p>
                                <p class="text-xs text-gray-500">ou saisissez ci-dessous</p>
                            </div>
                            
                            <!-- Saisie manuelle thèmes -->
                            <textarea id="themes" name="themes" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Développement Frontend&#10;Design UX/UI&#10;Gestion de projet&#10;...">{{ old('themes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition shadow-lg hover:shadow-xl">
                    Vérifier l'authenticité
                </button>
            </form>

            <!-- Info supplémentaire -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500 text-center">
                    Toutes les informations nécessaires se trouvent sur le procès-verbal PDF du tirage.
                </p>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        function handleParticipantFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const content = e.target.result;
                parseFileContent(content, file.name, 'participants');
            };
            reader.readAsText(file);
        }
        
        function handleThemeFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const content = e.target.result;
                parseFileContent(content, file.name, 'themes');
            };
            reader.readAsText(file);
        }
        
        function parseFileContent(content, filename, targetId) {
            let lines = [];
            
            if (filename.endsWith('.csv')) {
                // Parser CSV simple
                lines = content.split('\n').map(line => {
                    const parts = line.split(',');
                    return parts[0] ? parts[0].trim() : '';
                });
            } else {
                // TXT ou autre
                lines = content.split('\n').map(line => line.trim());
            }
            
            // Retirer les lignes vides et les headers potentiels
            lines = lines.filter(line => {
                if (!line) return false;
                const lower = line.toLowerCase();
                return !lower.includes('nom') && !lower.includes('name') && !lower.includes('theme') && !lower.includes('thème');
            });
            
            // Remplir le textarea
            const textarea = document.getElementById(targetId);
            if (textarea) {
                textarea.value = lines.join('\n');
                // Afficher un feedback visuel
                textarea.classList.add('border-green-500', 'bg-green-50');
                setTimeout(() => {
                    textarea.classList.remove('border-green-500', 'bg-green-50');
                }, 2000);
            }
        }
    </script>
    @endpush
</x-guest-layout>
