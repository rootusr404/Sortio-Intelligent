# Sortio Intelligent - Guide de démarrage rapide

## 🚀 Installation et configuration

### 1. Prérequis
- PHP 8.2+
- MySQL 8.0+
- Composer 2.x
- Node.js 18+

### 2. Installation des dépendances
```bash
composer install
npm install
```

### 3. Configuration de l'environnement
Le fichier `.env` est déjà configuré avec :
- `APP_NAME="Sortio Intelligent"`
- `APP_LOCALE=fr`
- `DB_DATABASE=sortio_db`

### 4. Génération de la clé d'application
```bash
php artisan key:generate
```

### 5. Création de la base de données
```sql
CREATE DATABASE sortio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Exécution des migrations
```bash
php artisan migrate
```

### 7. Compilation des assets
```bash
npm run dev
```

### 8. Lancement du serveur
```bash
php artisan serve
```

L'application sera accessible sur `http://localhost:8000`

## 📋 Fonctionnalités implémentées

### Authentification
- ✅ Inscription en 3 étapes (Profil → Contexte → Sécurité)
- ✅ Connexion/Déconnexion
- ✅ Récupération mot de passe
- ✅ Vérification email

### Workflow de tirage
- ✅ **Étape 1** : Import participants (CSV/Excel ou copier-coller)
- ✅ **Étape 2** : Configuration (Mode A/B, contraintes, suggestions)
- ✅ **Étape 3** : Résultats avec certificat SHA-256

### Exports
- ✅ PDF professionnel (procès-verbal complet)
- ✅ Excel structuré (avec métadonnées)

### Fonctionnalités avancées
- ✅ Algorithme Fisher-Yates (mélange non biaisé)
- ✅ Certification SHA-256 (auditabilité)
- ✅ Anti-doublon inter-sessions
- ✅ Suggestions tailles optimales
- ✅ Gestion contraintes (inclusion/exclusion)
- ✅ Historique paginé avec filtres

## 🧪 Tester l'application

### Créer un utilisateur test
```bash
php artisan tinker
```

```php
User::create([
    'first_name' => 'Admin',
    'last_name' => 'Sortio',
    'email' => 'admin@sortio.app',
    'password' => bcrypt('password'),
    'country' => 'BF',
    'context' => 'edu',
    'role' => 'Professeur/Enseignant',
    'plan' => 'pro',
]);
```

### Connexion
- Email : `admin@sortio.app`
- Mot de passe : `password`

### Créer un tirage test
1. Cliquez sur "Nouveau tirage"
2. Collez cette liste de participants :
```
Jean Dupont
Marie Martin
Pierre Durand
Sophie Bernard
Luc Petit
```
3. Configurez en Mode A avec 2 personnes par groupe
4. Lancez le tirage
5. Téléchargez le PDF et l'Excel

## 📁 Structure du projet

```
sortio/
├── app/
│   ├── Exports/
│   │   └── DrawExport.php          # Export Excel
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── DrawController.php
│   │   └── HistoryController.php
│   ├── Livewire/
│   │   ├── Auth/                   # Inscription 3 étapes
│   │   └── Draw/                   # Workflow tirage
│   ├── Models/
│   │   ├── User.php
│   │   ├── Draw.php
│   │   ├── Participant.php
│   │   ├── Constraint.php
│   │   └── DrawHistoryPair.php
│   ├── Policies/
│   │   └── DrawPolicy.php
│   └── Services/
│       ├── HashService.php         # SHA-256
│       ├── ShuffleService.php      # Fisher-Yates
│       ├── ConstraintService.php
│       ├── DrawService.php         # Orchestrateur
│       └── ExportService.php       # PDF/Excel
├── database/migrations/
│   ├── create_users_table.php
│   ├── create_draws_table.php
│   ├── create_participants_table.php
│   ├── create_constraints_table.php
│   └── create_draw_history_pairs_table.php
├── resources/views/
│   ├── auth/
│   │   └── register.blade.php      # Inscription 3 étapes
│   ├── draw/
│   │   ├── create.blade.php        # Workflow
│   │   └── show.blade.php          # Détail
│   ├── exports/
│   │   └── draw-pdf.blade.php      # Template PDF
│   ├── livewire/
│   │   ├── auth/                   # Vues inscription
│   │   └── draw/                   # Vues workflow
│   ├── dashboard.blade.php
│   ├── history.blade.php
│   └── verify.blade.php
└── routes/
    └── web.php
```

## 🔧 Commandes utiles

```bash
# Vider le cache
php artisan optimize:clear

# Lancer les tests (à implémenter)
php artisan test

# Lancer le queue worker
php artisan queue:work

# Lancer le scheduler (pour RGPD)
php artisan schedule:work

# Créer un nouveau composant Livewire
php artisan make:livewire NomComposant

# Créer une migration
php artisan make:migration nom_migration
```

## 🎨 Personnalisation

### Modifier les couleurs
Les couleurs principales sont dans `tailwind.config.js` :
- Vert principal : `#16a34a`
- Bleu certificat : `#3b82f6`

### Ajouter un pays
Modifier `RegisterStep1.php` :
```php
public $countries = [
    'XX' => ['name' => 'Pays', 'code' => '+XXX'],
];
```

### Modifier les limites
Dans `.env` (à ajouter) :
```
SORTIO_MAX_CONSTRAINTS=20
SORTIO_ANONYMIZATION_MONTHS=12
```

## 📊 Packages utilisés

- **laravel/framework** : 12.x
- **livewire/livewire** : 4.2
- **laravel/breeze** : 2.4
- **maatwebsite/excel** : 3.1
- **barryvdh/laravel-dompdf** : 3.1

## 🐛 Dépannage

### Erreur de migration
```bash
php artisan migrate:fresh
```

### Erreur Livewire
```bash
php artisan livewire:discover
php artisan optimize:clear
```

### Erreur PDF
Vérifier que DomPDF est bien installé :
```bash
composer show barryvdh/laravel-dompdf
```

## 📝 Notes importantes

1. Les exports PDF utilisent DomPDF (pas de dépendance Node.js)
2. L'inscription en 3 étapes utilise la session Laravel
3. Les tirages sont verrouillés après génération du hash
4. L'anonymisation RGPD est à implémenter (scheduler)
5. La vérification publique nécessite un contrôleur POST

## 🚀 Prochaines étapes

1. Implémenter l'anonymisation RGPD (12 mois)
2. Créer le panneau d'administration
3. Ajouter les tests unitaires
4. Implémenter la vérification publique
5. Ajouter les pages légales (CGU, RGPD)

## 📞 Support

Pour toute question, consultez :
- `ARCHITECTURE.md` : Architecture technique
- `PROGRESS.md` : État d'avancement
- `README.md` : Documentation Laravel
