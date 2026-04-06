<div class="space-y-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
        <input type="text" wire:model.blur="first_name" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('first_name') border-red-500 @enderror">
        @error('first_name') 
            <div class="mt-2 flex items-center text-sm text-red-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
        <input type="text" wire:model.blur="last_name" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('last_name') border-red-500 @enderror">
        @error('last_name') 
            <div class="mt-2 flex items-center text-sm text-red-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Email professionnel *</label>
        <div class="relative">
            <input type="email" wire:model.blur="email" class="w-full border rounded-lg px-4 py-3 pr-10 focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('email') border-red-500 @elseif($emailAvailable === true) border-green-500 @enderror">
            @if($emailAvailable === true)
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            @elseif($emailAvailable === false)
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
            @endif
        </div>
        @error('email') 
            <div class="mt-2 flex items-center text-sm text-red-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </div>
        @elseif($emailAvailable === true)
            <div class="mt-2 flex items-center text-sm text-green-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Cette adresse email est disponible
            </div>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Pays *</label>
        <select wire:model="country" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            @foreach($countries as $code => $data)
                <option value="{{ $code }}">{{ $data['name'] }} ({{ $data['code'] }})</option>
            @endforeach
        </select>
        @error('country') 
            <div class="mt-2 flex items-center text-sm text-red-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
        <input type="tel" wire:model="phone" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition" placeholder="{{ $countries[$country]['code'] ?? '' }}">
        @error('phone') 
            <div class="mt-2 flex items-center text-sm text-red-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
        <input type="text" wire:model="city" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
        @error('city') 
            <div class="mt-2 flex items-center text-sm text-red-600">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <button wire:click="nextStep" class="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold transition shadow-lg hover:shadow-xl">
        Continuer →
    </button>
</div>
