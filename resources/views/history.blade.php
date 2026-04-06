<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historique des tirages
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="mb-6 flex gap-4">
                    <input type="text" name="search" placeholder="Rechercher un tirage..." class="flex-1 border rounded px-4 py-2" value="{{ request('search') }}">
                    <select name="type" class="border rounded px-4 py-2">
                        <option value="">Tous les modes</option>
                        <option value="A" {{ request('type') === 'A' ? 'selected' : '' }}>Mode A</option>
                        <option value="B" {{ request('type') === 'B' ? 'selected' : '' }}>Mode B</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Filtrer</button>
                </div>

                @if($draws->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Titre</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Date</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Participants</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Mode</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Hash</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($draws as $draw)
                                    <tr class="{{ $draw->isAnonymized() ? 'bg-gray-50 italic' : '' }}">
                                        <td class="px-4 py-3">{{ $draw->title }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $draw->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $draw->participant_count }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">Mode {{ $draw->type }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-xs font-mono">{{ substr($draw->hash_code, 0, 12) }}...</td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-2">
                                                <a href="{{ route('draw.show', $draw) }}" class="text-blue-600 hover:text-blue-800 text-sm">Voir</a>
                                                <a href="{{ route('draw.pdf', $draw) }}" class="text-red-600 hover:text-red-800 text-sm">PDF</a>
                                                <a href="{{ route('draw.excel', $draw) }}" class="text-green-600 hover:text-green-800 text-sm">Excel</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $draws->links() }}
                    </div>
                @else
                    <p class="text-gray-600 text-center py-8">Aucun tirage trouvé.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
