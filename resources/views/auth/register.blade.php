<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Créer un compte</h2>
            <p class="text-gray-600">Inscription rapide en 3 étapes</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center flex-1">
                    <div id="step-indicator-1" class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-sm shadow-lg">
                        1
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-900">Profil</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2 rounded-full">
                    <div id="progress-1-2" class="h-full bg-gray-200 rounded-full transition-all duration-500"></div>
                </div>
                <div class="flex items-center flex-1">
                    <div id="step-indicator-2" class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-bold text-sm">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-400">Contexte</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2 rounded-full">
                    <div id="progress-2-3" class="h-full bg-gray-200 rounded-full transition-all duration-500"></div>
                </div>
                <div class="flex items-center flex-1">
                    <div id="step-indicator-3" class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-bold text-sm">
                        3
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-400">Sécurité</span>
                </div>
            </div>
        </div>

        <!-- Steps Content -->
        <div id="register-step-1">
            <livewire:auth.register-step1 />
        </div>

        <div id="register-step-2" class="hidden">
            <livewire:auth.register-step2 />
        </div>

        <div id="register-step-3" class="hidden">
            <livewire:auth.register-step3 />
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Déjà inscrit ?
                <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-medium">
                    Se connecter
                </a>
            </p>
        </div>

        <!-- Trust Indicators -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex items-center justify-center space-x-6 text-xs text-gray-500">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-green-600 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Données sécurisées
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-green-600 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Conforme RGPD
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-green-600 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                    </svg>
                    Gratuit à vie
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('step-completed', (event) => {
                const currentStep = event.step;
                const nextStep = currentStep + 1;
                
                // Hide current, show next
                document.getElementById('register-step-' + currentStep).classList.add('hidden');
                document.getElementById('register-step-' + nextStep).classList.remove('hidden');
                
                // Update indicators
                document.getElementById('step-indicator-' + nextStep).classList.remove('bg-gray-200', 'text-gray-400');
                document.getElementById('step-indicator-' + nextStep).classList.add('bg-green-600', 'text-white', 'shadow-lg');
                document.getElementById('step-indicator-' + nextStep).nextElementSibling.classList.remove('text-gray-400');
                document.getElementById('step-indicator-' + nextStep).nextElementSibling.classList.add('text-gray-900');
                
                // Update progress bar
                if (currentStep === 1) {
                    document.getElementById('progress-1-2').classList.remove('bg-gray-200');
                    document.getElementById('progress-1-2').classList.add('bg-green-600');
                } else if (currentStep === 2) {
                    document.getElementById('progress-2-3').classList.remove('bg-gray-200');
                    document.getElementById('progress-2-3').classList.add('bg-green-600');
                }
            });

            Livewire.on('step-back', (event) => {
                const targetStep = event.step;
                const currentStep = targetStep + 1;
                
                document.getElementById('register-step-' + currentStep).classList.add('hidden');
                document.getElementById('register-step-' + targetStep).classList.remove('hidden');
                
                // Reset indicators
                document.getElementById('step-indicator-' + currentStep).classList.add('bg-gray-200', 'text-gray-400');
                document.getElementById('step-indicator-' + currentStep).classList.remove('bg-green-600', 'text-white', 'shadow-lg');
                document.getElementById('step-indicator-' + currentStep).nextElementSibling.classList.add('text-gray-400');
                document.getElementById('step-indicator-' + currentStep).nextElementSibling.classList.remove('text-gray-900');
                
                // Reset progress bar
                if (currentStep === 2) {
                    document.getElementById('progress-1-2').classList.add('bg-gray-200');
                    document.getElementById('progress-1-2').classList.remove('bg-green-600');
                } else if (currentStep === 3) {
                    document.getElementById('progress-2-3').classList.add('bg-gray-200');
                    document.getElementById('progress-2-3').classList.remove('bg-green-600');
                }
            });
        });
    </script>
    @endpush
</x-guest-layout>
