<div class="space-y-6">
    @if($draw)
    <!-- Message de succès -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold mb-1">Tirage réalisé avec succès !</h2>
                <p class="text-green-100">{{ $draw->title }}</p>
            </div>
        </div>
    </div>

    <!-- Résultats des groupes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
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

    <!-- Certificat d'authenticité -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-xl p-6 text-white">
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
                <label class="block text-xs font-semibold text-gray-400 mb-1">SEED CRYPTOGRAPHIQUE</label>
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

        <div class="mt-6 p-4 bg-yellow-500/10 border border-yellow-500/30 rounded-lg">
            <p class="text-xs text-yellow-200">
                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Ce hash est verrouillé et ne peut être modifié. Toute modification des données invaliderait le certificat.
            </p>
        </div>
    </div>

    <!-- Rapport des contraintes -->
    @if($draw->constraints && $draw->constraints->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Rapport des contraintes</h3>
            <div class="space-y-3">
                @foreach($draw->constraints as $constraint)
                    <div class="flex items-center gap-3 p-3 rounded-lg
                        {{ $constraint->satisfied ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        @if($constraint->satisfied)
                            <svg class="w-5 h-5 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-medium text-green-800">
                                Contrainte {{ $constraint->type === 'inclusion' ? 'd\'inclusion' : 'd\'exclusion' }} satisfaite
                            </span>
                        @else
                            <svg class="w-5 h-5 text-red-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <span class="text-sm font-medium text-red-800 block">
                                    Contrainte {{ $constraint->type === 'inclusion' ? 'd\'inclusion' : 'd\'exclusion' }} non satisfaite
                                </span>
                                @if($constraint->failure_reason)
                                    <span class="text-xs text-red-600">{{ $constraint->failure_reason }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Exporter les résultats</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('draw.pdf', $draw) }}" target="_blank"
                class="flex items-center justify-center gap-2 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                </svg>
                Procès-verbal PDF
            </a>

            <a href="{{ route('draw.excel', $draw) }}"
                class="flex items-center justify-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                Fichier Excel
            </a>

            <button wire:click="newDraw"
                class="flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Nouveau tirage
            </button>
        </div>
    </div>
    @else
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
        <p class="text-yellow-800">Aucun tirage en cours. Veuillez d'abord importer des participants.</p>
    </div>
    @endif
</div>
