<div x-data="{ open: false, confirmation: '', canDelete: false }" class="space-y-4">
    <p class="text-sm text-gray-600">
        Une fois votre compte supprimé, toutes vos données seront définitivement effacées.
        Cette action est <strong class="text-red-700">irréversible</strong>.
    </p>

    <button type="button" @click="open = true"
        class="inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        Supprimer mon compte
    </button>

    <!-- Modal -->
    <div x-show="open" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background: rgba(0,0,0,0.5);">
        <div @click.away="open = false"
            class="bg-white rounded-xl shadow-xl w-full max-w-md p-6"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Supprimer le compte</h3>
                    <p class="text-xs text-gray-500">Cette action est définitive et irréversible</p>
                </div>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('delete')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Mot de passe actuel <span class="text-red-500">*</span>
                    </label>
                    <input name="password" type="password"
                        class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                            {{ $errors->userDeletion->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        placeholder="Votre mot de passe">
                    @error('password', 'userDeletion')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tapez <span class="font-mono font-bold text-red-700">SUPPRIMER</span> pour confirmer <span class="text-red-500">*</span>
                    </label>
                    <input name="confirmation" type="text"
                        x-model="confirmation"
                        @input="canDelete = confirmation === 'SUPPRIMER'"
                        class="w-full px-4 py-2.5 border rounded-lg text-sm font-mono focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                            {{ $errors->userDeletion->has('confirmation') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        placeholder="SUPPRIMER">
                    @error('confirmation', 'userDeletion')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="open = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Annuler
                    </button>
                    <button type="submit"
                        :disabled="!canDelete"
                        :class="canDelete ? 'bg-red-600 hover:bg-red-700 cursor-pointer' : 'bg-red-300 cursor-not-allowed'"
                        class="px-4 py-2 text-sm font-semibold text-white rounded-lg transition">
                        Supprimer définitivement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
