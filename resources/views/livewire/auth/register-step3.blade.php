<div class="space-y-6">
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe *</label>
        <input type="password" wire:model.live="password" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('password') border-red-500 @enderror">
        @error('password') 
            <div class="mt-2 flex items-center text-sm text-red-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </div>
        @enderror
        
        @if(strlen($password) > 0)
            <div class="mt-3">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs text-gray-600">Force du mot de passe</span>
                    <span class="text-xs font-medium
                        @if($passwordStrength <= 2) text-red-600
                        @elseif($passwordStrength == 3) text-orange-600
                        @elseif($passwordStrength == 4) text-yellow-600
                        @else text-green-600
                        @endif">
                        @if($passwordStrength <= 2) Faible
                        @elseif($passwordStrength == 3) Moyen
                        @elseif($passwordStrength == 4) Bon
                        @else Excellent
                        @endif
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-300
                        @if($passwordStrength <= 2) bg-red-500 w-1/5
                        @elseif($passwordStrength == 3) bg-orange-500 w-2/5
                        @elseif($passwordStrength == 4) bg-yellow-500 w-3/5
                        @else bg-green-500 w-full
                        @endif"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Utilisez au moins 8 caractères avec majuscules, minuscules et chiffres</p>
            </div>
        @endif
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe *</label>
        <input type="password" wire:model="password_confirmation" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-3">Plan tarifaire</label>
        <div class="grid grid-cols-2 gap-4">
            <div wire:click="$set('plan', 'free')" class="border-2 rounded-lg p-4 cursor-pointer transition {{ $plan === 'free' ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:border-gray-400' }}">
                <div class="font-bold text-lg mb-2">Gratuit</div>
                <div class="text-sm text-gray-600 space-y-1">
                    <div>• 5 tirages/mois</div>
                    <div>• Historique 30 jours</div>
                    <div>• Exports PDF/Excel</div>
                </div>
            </div>
            <div wire:click="$set('plan', 'pro')" class="border-2 rounded-lg p-4 cursor-pointer transition {{ $plan === 'pro' ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:border-gray-400' }}">
                <div class="font-bold text-lg mb-2">Pro</div>
                <div class="text-sm text-gray-600 space-y-1">
                    <div>• Tirages illimités</div>
                    <div>• Historique complet</div>
                    <div>• Support prioritaire</div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-3 bg-gray-50 p-4 rounded-lg">
        <label class="flex items-start cursor-pointer">
            <input type="checkbox" wire:model="accept_terms" class="mt-1 mr-3 rounded border-gray-300 text-green-600 focus:ring-green-500">
            <span class="text-sm">J'accepte les <a href="#" class="text-green-600 hover:text-green-700 font-medium underline">Conditions Générales d'Utilisation</a> *</span>
        </label>
        @error('accept_terms') 
            <div class="flex items-center text-sm text-red-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </div>
        @enderror

        <label class="flex items-start cursor-pointer">
            <input type="checkbox" wire:model="accept_gdpr" class="mt-1 mr-3 rounded border-gray-300 text-green-600 focus:ring-green-500">
            <span class="text-sm">J'accepte le traitement de mes données conformément au <span class="font-medium">RGPD</span> *</span>
        </label>
        @error('accept_gdpr') 
            <div class="flex items-center text-sm text-red-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </div>
        @enderror

        <label class="flex items-start cursor-pointer">
            <input type="checkbox" wire:model="newsletter" class="mt-1 mr-3 rounded border-gray-300 text-green-600 focus:ring-green-500">
            <span class="text-sm">Je souhaite recevoir les newsletters Sortio (optionnel)</span>
        </label>
    </div>

    <div class="flex gap-3">
        <button wire:click="previousStep" class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 font-semibold transition">
            ← Retour
        </button>
        <button wire:click="register" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold transition shadow-lg hover:shadow-xl">
            Créer mon compte
        </button>
    </div>
</div>
