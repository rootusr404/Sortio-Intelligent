# Sortio Intelligent - Architecture Technique

## Structure mise en place

### Base de données

#### Migrations créées
- `create_users_table_sortio` - Table des organisateurs avec profils complets
- `create_draws_table` - Table des tirages avec certification SHA-256
- `create_participants_table` - Table des participants avec groupes/thèmes
- `create_constraints_table` - Table des contraintes inclusion/exclusion
- `create_draw_history_pairs_table` - Table anti-doublon inter-sessions

### Modèles Eloquent

- **User** - Organisateur avec relations vers Draw
- **Draw** - Tirage certifié avec hash SHA-256
- **Participant** - Participant d'un tirage (Mode A ou B)
- **Constraint** - Contrainte d'inclusion/exclusion
- **DrawHistoryPair** - Paire de participants pour détection doublons

### Services métier

#### HashService
- `generateSeed()` - Génération seed cryptographique via random_bytes()
- `buildHashInput()` - Construction chaîne déterministe pour hash
- `generateHash()` - Calcul SHA-256
- `verifyHash()` - Vérification authenticité

#### ShuffleService
- `fisherYatesShuffle()` - Algorithme Fisher-Yates non biaisé
- `suggestOptimalGroupSizes()` - Top 3 tailles optimales avec pénalités

#### ConstraintService
- `validateConstraints()` - Détection contradictions
- `resolveConstraints()` - Résolution avec backtracking
- `checkConstraint()` - Vérification satisfaction contrainte
- `attemptSwap()` - Tentative swap pour résolution

#### DrawService (orchestrateur principal)
- `executeDraw()` - Workflow complet du tirage en transaction
- `distributeParticipants()` - Distribution Mode A (groupes) ou B (thèmes)
- `saveParticipants()` - Persistance avec position Fisher-Yates
- `saveHistoryPairs()` - Enregistrement paires pour anti-doublon
- `detectDuplicatePairs()` - Détection paires déjà vues

## Prochaines étapes

### 1. Composants Livewire
- ParticipantImport (Étape 1)
- DrawConfigurator (Étape 2)
- ResultViewer (Étape 3)

### 2. Contrôleurs et routes
- DrawController
- DashboardController
- HistoryController
- VerificationController (public)

### 3. Vues Blade + Tailwind
- Layout principal
- Pages workflow 3 étapes
- Dashboard
- Historique

### 4. Exports
- ExportService (PDF + Excel)
- Procès-verbal avec certificat
- Intégration Browsershot/DomPDF

### 5. RGPD
- AnonymizationService
- Job scheduler anonymisation 12 mois
- Export données utilisateur

### 6. Admin panel
- Authentification 2FA
- Dashboard admin
- Gestion users/draws
- Audit log

## Commandes utiles

```bash
# Migrations
php artisan migrate

# Créer composant Livewire
php artisan make:livewire NomComposant

# Créer contrôleur
php artisan make:controller NomController

# Créer job
php artisan make:job NomJob

# Lancer queue worker
php artisan queue:work

# Lancer scheduler
php artisan schedule:work
```

## Configuration

Variables .env ajoutées :
- `APP_NAME="Sortio Intelligent"`
- `APP_LOCALE=fr`
- `MAIL_FROM_ADDRESS="noreply@sortio.app"`

À ajouter :
- `SORTIO_PDF_DRIVER=browsershot` (ou dompdf)
- `SORTIO_MAX_CONSTRAINTS=20`
- `SORTIO_ANONYMIZATION_MONTHS=12`
