<form method="post" action="{{ route('password.update') }}" class="space-y-5" x-data="passwordForm()">
    @csrf
    @method('put')

    <div>
        <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1">
            Mot de passe actuel <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input id="update_password_current_password" name="current_password"
                :type="showCurrent ? 'text' : 'password'"
                class="w-full px-4 py-2.5 pr-10 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                    {{ $errors->updatePassword->has('current_password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                autocomplete="current-password">
            <button type="button" @click="showCurrent = !showCurrent"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg x-show="!showCurrent" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <svg x-show="showCurrent" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
            </button>
        </div>
        @error('current_password', 'updatePassword')
            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1">
            Nouveau mot de passe <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input id="update_password_password" name="password"
                :type="showNew ? 'text' : 'password'"
                x-model="newPassword"
                @input="checkStrength()"
                class="w-full px-4 py-2.5 pr-10 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                    {{ $errors->updatePassword->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                autocomplete="new-password">
            <button type="button" @click="showNew = !showNew"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg x-show="!showNew" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <svg x-show="showNew" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
            </button>
        </div>

        <!-- Indicateur de force -->
        <div x-show="newPassword.length > 0" class="mt-2">
            <div class="flex gap-1 mb-1">
                <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 1 ? strengthColor : 'bg-gray-200'"></div>
                <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 2 ? strengthColor : 'bg-gray-200'"></div>
                <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 3 ? strengthColor : 'bg-gray-200'"></div>
                <div class="h-1 flex-1 rounded-full transition-colors" :class="strength >= 4 ? strengthColor : 'bg-gray-200'"></div>
            </div>
            <p class="text-xs" :class="strengthTextColor" x-text="strengthLabel"></p>
        </div>

        @error('password', 'updatePassword')
            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
            Confirmer le nouveau mot de passe <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input id="update_password_password_confirmation" name="password_confirmation"
                :type="showConfirm ? 'text' : 'password'"
                x-model="confirmPassword"
                class="w-full px-4 py-2.5 pr-10 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                    {{ $errors->updatePassword->has('password_confirmation') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                autocomplete="new-password">
            <button type="button" @click="showConfirm = !showConfirm"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
            </button>
        </div>
        <div x-show="confirmPassword.length > 0" class="mt-1.5">
            <p x-show="newPassword === confirmPassword" class="text-xs text-green-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Les mots de passe correspondent
            </p>
            <p x-show="newPassword !== confirmPassword" class="text-xs text-red-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                Les mots de passe ne correspondent pas
            </p>
        </div>
        @error('password_confirmation', 'updatePassword')
            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="pt-2">
        <button type="submit"
            class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Mettre à jour le mot de passe
        </button>
    </div>
</form>

@push('scripts')
<script>
function passwordForm() {
    return {
        showCurrent: false,
        showNew: false,
        showConfirm: false,
        newPassword: '',
        confirmPassword: '',
        strength: 0,
        strengthLabel: '',
        strengthColor: 'bg-gray-200',
        strengthTextColor: 'text-gray-500',
        checkStrength() {
            const p = this.newPassword;
            let s = 0;
            if (p.length >= 8) s++;
            if (/[A-Z]/.test(p)) s++;
            if (/[0-9]/.test(p)) s++;
            if (/[^A-Za-z0-9]/.test(p)) s++;
            this.strength = s;
            const levels = [
                { label: 'Trop court', color: 'bg-red-400', text: 'text-red-600' },
                { label: 'Acceptable', color: 'bg-orange-400', text: 'text-orange-600' },
                { label: 'Bonne', color: 'bg-yellow-400', text: 'text-yellow-600' },
                { label: 'Excellente', color: 'bg-green-500', text: 'text-green-600' },
            ];
            const l = levels[Math.max(0, s - 1)] || levels[0];
            this.strengthLabel = l.label;
            this.strengthColor = l.color;
            this.strengthTextColor = l.text;
        }
    }
}
</script>
@endpush
