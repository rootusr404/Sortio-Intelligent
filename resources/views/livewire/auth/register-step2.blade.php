<div class="space-y-6">
    <div>
        <label class="block text-sm font-medium mb-3">Secteur d'activité *</label>
        <div class="grid grid-cols-2 gap-3">
            @foreach($contexts as $key => $label)
                <div wire:click="$set('context', '{{ $key }}')" class="border-2 rounded-lg p-4 cursor-pointer text-center {{ $context === $key ? 'border-green-500 bg-green-50' : 'border-gray-300' }}">
                    {{ $label }}
                </div>
            @endforeach
        </div>
        @error('context') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    @if($context)
        <div>
            <label class="block text-sm font-medium mb-2">Rôle *</label>
            <select wire:model="role" class="w-full border rounded px-4 py-2">
                <option value="">Sélectionnez votre rôle</option>
                @foreach($roles[$context] ?? [] as $roleOption)
                    <option value="{{ $roleOption }}">{{ $roleOption }}</option>
                @endforeach
            </select>
            @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Établissement / Organisation</label>
            <input type="text" wire:model="organization" class="w-full border rounded px-4 py-2">
            @error('organization') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Taille habituelle des groupes</label>
            <select wire:model="typical_group_size" class="w-full border rounded px-4 py-2">
                <option value="">Sélectionnez</option>
                <option value="less_20">Moins de 20</option>
                <option value="20_50">20 à 50</option>
                <option value="50_100">50 à 100</option>
                <option value="more_100">Plus de 100</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Fréquence de tirage estimée</label>
            <select wire:model="draw_frequency" class="w-full border rounded px-4 py-2">
                <option value="">Sélectionnez</option>
                <option value="occasional">Occasionnel</option>
                <option value="monthly">Mensuel</option>
                <option value="weekly">Hebdomadaire</option>
                <option value="daily">Quotidien</option>
            </select>
        </div>
    @endif

    <div class="flex gap-3">
        <button wire:click="previousStep" class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded hover:bg-gray-400 font-medium">
            ← Retour
        </button>
        <button wire:click="nextStep" class="flex-1 bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 font-medium">
            Continuer →
        </button>
    </div>
</div>
