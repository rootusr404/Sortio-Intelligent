<x-app-layout>
    <x-slot name="header">
        <h2>Test Simple</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold">Page de test sans Livewire</h3>
            <p class="mt-4">Si vous voyez cette page, le problème vient de Livewire.</p>
            <p class="mt-2">User: {{ auth()->user()->email }}</p>
        </div>
    </div>
</x-app-layout>
