<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Bon retour !</h2>
            <p class="text-gray-600">Connectez-vous pour accéder à vos tirages</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="votre@email.com">
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition shadow-lg hover:shadow-xl">
                Se connecter
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Nouveau sur Sortio ?</span>
            </div>
        </div>

        <!-- Register Link -->
        <a href="{{ route('register') }}" class="block w-full text-center py-3 border-2 border-green-600 text-green-600 hover:bg-green-50 font-semibold rounded-lg transition">
            Créer un compte gratuit
        </a>

        <!-- Features -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-500 text-center mb-4">Pourquoi choisir Sortio ?</p>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <div class="text-green-600 font-bold text-lg">100%</div>
                    <div class="text-xs text-gray-600">Gratuit</div>
                </div>
                <div>
                    <div class="text-green-600 font-bold text-lg">🔒</div>
                    <div class="text-xs text-gray-600">Certifié</div>
                </div>
                <div>
                    <div class="text-green-600 font-bold text-lg">⚡</div>
                    <div class="text-xs text-gray-600">Rapide</div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
