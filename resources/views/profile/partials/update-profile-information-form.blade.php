<form method="post" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('patch')

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                Prénom <span class="text-red-500">*</span>
            </label>
            <input id="first_name" name="first_name" type="text"
                value="{{ old('first_name', $user->first_name) }}"
                class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                    {{ $errors->has('first_name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                required autofocus>
            @error('first_name')
                <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                Nom <span class="text-red-500">*</span>
            </label>
            <input id="last_name" name="last_name" type="text"
                value="{{ old('last_name', $user->last_name) }}"
                class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                    {{ $errors->has('last_name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                required>
            @error('last_name')
                <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
            Adresse email <span class="text-red-500">*</span>
        </label>
        <input id="email" name="email" type="email"
            value="{{ old('email', $user->email) }}"
            class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
            required autocomplete="username">
        @error('email')
            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2 flex items-center gap-2 text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                Email non vérifié.
                <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="inline">@csrf</form>
                <button form="send-verification" class="underline font-medium hover:text-amber-900">Renvoyer le lien</button>
            </div>
            @if (session('status') === 'verification-link-sent')
                <p class="mt-1.5 text-xs text-green-600">Lien de vérification envoyé à votre adresse email.</p>
            @endif
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
            <input id="phone" name="phone" type="tel"
                value="{{ old('phone', $user->phone) }}"
                placeholder="+226 XX XX XX XX"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
        </div>

        <div>
            <label for="organization" class="block text-sm font-medium text-gray-700 mb-1">Organisation</label>
            <input id="organization" name="organization" type="text"
                value="{{ old('organization', $user->organization) }}"
                placeholder="Université, entreprise..."
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">
                Pays <span class="text-red-500">*</span>
            </label>
            <input id="country" name="country" type="text"
                value="{{ old('country', $user->country) }}"
                class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                    {{ $errors->has('country') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                required>
            @error('country')
                <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
            <input id="city" name="city" type="text"
                value="{{ old('city', $user->city) }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
        </div>
    </div>

    <div class="pt-2 flex items-center gap-4">
        <button type="submit"
            class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Enregistrer les modifications
        </button>
    </div>
</form>
