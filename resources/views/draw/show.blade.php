<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $draw->title }}</h2>
                <p class="text-sm text-gray-600 mt-1">
                    Tirage réalisé le {{ $draw->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>
            <a href="{{ route('history') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                ← Retour à l'historique
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @php
            $groups = $draw->type === 'A' 
                ? $draw->participants->groupBy('group_id')
                : $draw->participants->groupBy('theme_name');
        @endphp

        <!-- Résultats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">
                    @if($draw->type === 'A')
                        Groupes formés ({{ $groups->count() }})
                    @else
                        Répartition par thèmes ({{ $groups->count() }})
                    @endif
                </h3>
                <span class="text-sm text-gray-500">{{ $draw->participant_count }} participants</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $colors = ['blue', 'purple', 'pink', 'indigo', 'cyan', 'teal', 'emerald', 'lime', 'amber', 'orange'];
                @endphp
                
                @foreach($groups as $key => $members)
                    @php
                        $color = $colors[($loop->index) % count($colors)];
                    @endphp
                    
                    <div class="border-2 border-{{ $color }}-200 bg-{{ $color }}-50 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-3 pb-3 border-b border-{{ $color }}-200">
                            <div class="w-8 h-8 bg-{{ $color }}-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                {{ $draw->type === 'A' ? $key : substr($key, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-{{ $color }}-900">
                                    @if($draw->type === 'A')
                                        Groupe {{ $key }}
                                    @else
                                        {{ $key }}
                                    @endif
                                </h4>
                                <p class="text-xs text-{{ $color }}-600">{{ $members->count() }} membres</p>
                            </div>
                        </div>
                        <ul class="space-y-2">
                            @foreach($members as $member)
                                <li class="flex items-center gap-2 text-sm text-gray-700">
                                    <svg class="w-4 h-4 text-{{ $color }}-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $member->full_name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Certificat -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-xl p-6 text-white mb-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold">Certificat d'authenticité</h3>
                    <p class="text-sm text-gray-300">Hash cryptographique SHA-256</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1">SEED</label>
                    <div class="bg-black/30 rounded-lg p-3 font-mono text-xs text-green-400 break-all">
                        {{ $draw->seed }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1">TIMESTAMP</label>
                    <div class="bg-black/30 rounded-lg p-3 font-mono text-xs text-blue-400">
                        {{ $draw->locked_at->toIso8601String() }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-1">HASH SHA-256</label>
                    <div class="bg-black/30 rounded-lg p-3 font-mono text-xs text-yellow-400 break-all">
                        {{ $draw->hash_code }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('draw.pdf', $draw) }}" target="_blank"
                    class="flex items-center justify-center gap-2 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                    </svg>
                    Télécharger PDF
                </a>

                <a href="{{ route('draw.excel', $draw) }}"
                    class="flex items-center justify-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Télécharger Excel
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
