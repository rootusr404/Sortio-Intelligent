<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Nouveau tirage</h2>
            <p class="text-sm text-gray-600 mt-1">Créez un tirage certifié en 3 étapes simples</p>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center flex-1">
                    <div id="step-circle-1" class="w-12 h-12 rounded-full bg-green-600 text-white flex items-center justify-center font-bold shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-semibold text-gray-900">Import</div>
                        <div class="text-xs text-gray-500">Participants</div>
                    </div>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-4 rounded-full">
                    <div id="progress-bar-1" class="h-full bg-gray-200 rounded-full transition-all duration-500"></div>
                </div>
                <div class="flex items-center flex-1">
                    <div id="step-circle-2" class="w-12 h-12 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-semibold text-gray-400">Configuration</div>
                        <div class="text-xs text-gray-400">Mode & contraintes</div>
                    </div>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-4 rounded-full">
                    <div id="progress-bar-2" class="h-full bg-gray-200 rounded-full transition-all duration-500"></div>
                </div>
                <div class="flex items-center flex-1">
                    <div id="step-circle-3" class="w-12 h-12 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-semibold text-gray-400">Résultats</div>
                        <div class="text-xs text-gray-400">Certificat</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step Content -->
        <div id="step-1">
            <livewire:draw.participant-import />
        </div>

        <div id="step-2" class="hidden">
            <livewire:draw.draw-configurator />
        </div>

        <div id="step-3" class="hidden">
            <livewire:draw.result-viewer />
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            console.log('Livewire initialized');
            
            Livewire.on('step-completed', (event) => {
                console.log('Step completed event received:', event);
                const currentStep = event.step;
                const nextStep = currentStep + 1;
                
                console.log('Moving from step', currentStep, 'to step', nextStep);
                
                document.getElementById('step-' + currentStep).classList.add('hidden');
                document.getElementById('step-' + nextStep).classList.remove('hidden');
                
                // Update circles
                document.getElementById('step-circle-' + nextStep).classList.remove('bg-gray-200', 'text-gray-400');
                document.getElementById('step-circle-' + nextStep).classList.add('bg-green-600', 'text-white', 'shadow-lg');
                document.getElementById('step-circle-' + nextStep).nextElementSibling.querySelectorAll('div').forEach(el => {
                    el.classList.remove('text-gray-400');
                    el.classList.add('text-gray-900');
                });
                
                // Update progress bars
                document.getElementById('progress-bar-' + currentStep).classList.remove('bg-gray-200');
                document.getElementById('progress-bar-' + currentStep).classList.add('bg-green-600');
                
                // Force Livewire to reload step 3 component
                if (nextStep === 3) {
                    console.log('Reloading step 3 component');
                    setTimeout(() => {
                        window.location.reload();
                    }, 100);
                }
            });

            Livewire.on('step-back', (event) => {
                const targetStep = event.step;
                const currentStep = targetStep + 1;
                
                document.getElementById('step-' + currentStep).classList.add('hidden');
                document.getElementById('step-' + targetStep).classList.remove('hidden');
            });
        });
    </script>
    @endpush
</x-app-layout>
