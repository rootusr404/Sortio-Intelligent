<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sortio Intelligent - Tirage au sort certifié et auditable</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-gray-900">Sortio</span>
                        <span class="text-xs text-gray-500 block">Intelligent</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                        Se connecter
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl">
                        Essayer gratuitement
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-green-50 via-white to-blue-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                    Un tirage <span class="text-green-600">rapide, juste</span><br>et <span class="text-blue-600">auditable</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Sortio Intelligent résout la méfiance lors des répartitions en groupes grâce à la certification cryptographique SHA-256 et l'algorithme Fisher-Yates.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition shadow-xl hover:shadow-2xl text-lg">
                        Créer un compte gratuit
                    </a>
                    <a href="{{ route('verify') }}" class="px-8 py-4 bg-white hover:bg-gray-50 text-gray-900 font-bold rounded-lg transition shadow-lg border-2 border-gray-200 text-lg">
                        Vérifier un tirage
                    </a>
                </div>
                <p class="text-sm text-gray-500 mt-4">Gratuit jusqu'à 5 tirages/mois • Aucune carte bancaire requise</p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white py-12 border-y border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">1,200+</div>
                    <div class="text-gray-600">Organisateurs actifs</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">18,400</div>
                    <div class="text-gray-600">Tirages certifiés</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">340K</div>
                    <div class="text-gray-600">Participants traités</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">0</div>
                    <div class="text-gray-600">Contestation</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Pourquoi choisir Sortio ?</h2>
                <p class="text-xl text-gray-600">La seule plateforme qui garantit l'équité mathématique et la traçabilité cryptographique</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Auditabilité totale</h3>
                    <p class="text-gray-600">Chaque tirage est certifié par un hash SHA-256 impossible à falsifier. Vérification publique disponible.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Équité mathématique</h3>
                    <p class="text-gray-600">Algorithme Fisher-Yates garantissant qu'aucune permutation n'est favorisée statistiquement.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Historique complet</h3>
                    <p class="text-gray-600">Détection automatique des doublons inter-sessions pour éviter les répétitions de groupes.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Contraintes métier</h3>
                    <p class="text-gray-600">Gérez jusqu'à 20 contraintes d'inclusion ou d'exclusion entre participants.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Exports officiels</h3>
                    <p class="text-gray-600">Procès-verbal PDF avec certificat d'authenticité et export Excel structuré.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Conformité RGPD</h3>
                    <p class="text-gray-600">Anonymisation automatique après 12 mois et respect total du règlement européen.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-br from-green-600 to-green-700 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Prêt à créer votre premier tirage ?</h2>
            <p class="text-xl text-green-100 mb-8">Rejoignez plus de 1,200 organisateurs qui font confiance à Sortio</p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white hover:bg-gray-100 text-green-600 font-bold rounded-lg transition shadow-xl hover:shadow-2xl text-lg">
                Créer un compte gratuit
            </a>
            <p class="text-sm text-green-100 mt-4">Gratuit jusqu'à 5 tirages/mois • Aucune carte bancaire requise</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-white font-bold">Sortio</span>
                    </div>
                    <p class="text-sm">Tirage au sort certifié et auditable pour tous vos besoins.</p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Produit</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Fonctionnalités</a></li>
                        <li><a href="#" class="hover:text-white">Tarifs</a></li>
                        <li><a href="{{ route('verify') }}" class="hover:text-white">Vérifier un tirage</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Légal</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">CGU</a></li>
                        <li><a href="#" class="hover:text-white">Politique de confidentialité</a></li>
                        <li><a href="#" class="hover:text-white">Mentions légales</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Support</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Documentation</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2024 Sortio Intelligent. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>
