<x-guest-layout>
    <div class="max-w-4xl mx-auto">
        @if($isValid)
        <!-- Résultat AUTHENTIQUE -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-2xl p-8 text-white mb-6">
            <div class="text-center">
                <div class="w-24 h-24 bg-white/20 backdrop-blur rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold mb-3">✓ Tirage Authentique</h1>
                <p class="text-xl text-green-100 mb-2">Le hash correspond parfaitement aux données fournies</p>
                <p class="text-green-200 text-sm">Ce tirage n'a pas été modifié et est certifié conforme</p>
            </div>
        </div>
        @else
        <!-- Résultat NON AUTHENTIQUE -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-2xl p-8 text-white mb-6">
            <div class="text-center">
                <div class="w-24 h-24 bg-white/20 backdrop-blur rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold mb-3">✗ Tirage NON Authentique</h1>
                <p class="text-xl text-red-100 mb-2">Le hash ne correspond pas aux données fournies</p>
                <p class="text-red-200 text-sm">Les données ont peut-être été modifiées ou sont incorrectes</p>
            </div>
        </div>
        @endif

        <!-- Détails de la vérification -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Détails de la vérification
            </h2>

            <div class="space-y-6">
                <!-- Type de tirage -->
                <div class="border-l-4 {{ $isValid ? 'border-green-500' : 'border-red-500' }} pl-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Type de tirage</label>
                    <p class="text-lg font-medium text-gray-900">
                        Mode {{ $drawType }} - {{ $drawType === 'A' ? 'Répartition par groupes' : 'Répartition par thèmes' }}
                    </p>
                </div>

                <!-- Participants -->
                <div class="border-l-4 {{ $isValid ? 'border-green-500' : 'border-red-500' }} pl-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Participants vérifiés</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm font-bold text-gray-900 mb-2">{{ count($participants) }} participants</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($participants as $participant)
                                <span class="inline-block bg-white border border-gray-300 text-gray-700 px-3 py-1 rounded-lg text-sm">
                                    {{ $participant }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Paramètres -->
                <div class="border-l-4 {{ $isValid ? 'border-green-500' : 'border-red-500' }} pl-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Paramètres du tirage</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        @if($drawType === 'A')
                            <p class="text-sm text-gray-900">
                                <span class="font-semibold">Taille des groupes :</span> {{ $parameters['group_size'] }} personnes
                            </p>
                        @else
                            <p class="text-sm font-bold text-gray-900 mb-2">{{ count($parameters['themes']) }} thèmes :</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($parameters['themes'] as $theme)
                                    <span class="inline-block bg-purple-100 border border-purple-300 text-purple-800 px-3 py-1 rounded-lg text-sm font-medium">
                                        {{ $theme }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Hash vérifié -->
                <div class="border-l-4 {{ $isValid ? 'border-green-500' : 'border-red-500' }} pl-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Hash SHA-256 vérifié</label>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <p class="font-mono text-xs text-green-400 break-all">{{ $hash }}</p>
                    </div>
                </div>

                <!-- Timestamp -->
                <div class="border-l-4 {{ $isValid ? 'border-green-500' : 'border-red-500' }} pl-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Date et heure du tirage</label>
                    <p class="text-lg font-medium text-gray-900">{{ $timestamp }}</p>
                </div>
            </div>
        </div>

        <!-- Explication technique -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
            <h3 class="text-lg font-bold text-blue-900 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Comment fonctionne la vérification ?
            </h3>
            <p class="text-sm text-blue-800 leading-relaxed">
                Le hash SHA-256 est calculé à partir des participants, du seed cryptographique, du timestamp et des paramètres du tirage. 
                Si une seule lettre est modifiée dans n'importe quelle donnée, le hash change complètement. 
                @if($isValid)
                    <strong>Le hash que vous avez fourni correspond exactement au hash recalculé</strong>, ce qui prouve que les données n'ont pas été altérées.
                @else
                    <strong>Le hash que vous avez fourni ne correspond pas au hash recalculé</strong>, ce qui indique que les données ont été modifiées ou sont incorrectes.
                @endif
            </p>
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
            <a href="{{ route('verify') }}" 
                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Nouvelle vérification
            </a>
            
            <a href="{{ route('home') }}" 
                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Retour à l'accueil
            </a>
        </div>
    </div>
</x-guest-layout>
