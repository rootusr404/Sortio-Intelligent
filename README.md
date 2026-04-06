<div align="center">

# 🎲 Sortio Intelligent

### Plateforme de tirages au sort certifiés et vérifiables

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

[Démo](#) • [Documentation](#fonctionnalités) • [Installation](#installation) • [Contribuer](#contribution)

</div>

---

## 📋 À propos

**Sortio Intelligent** est une application web professionnelle permettant de réaliser des tirages au sort **certifiés, transparents et vérifiables**. Conçue pour les établissements d'enseignement, associations et organisations, elle garantit l'équité et l'authenticité de chaque tirage grâce à la cryptographie SHA-256.

### 🎯 Cas d'usage

- 🎓 **Éducation** : Formation de groupes de TD, attribution de projets, répartition d'étudiants
- 🏢 **Entreprises** : Attribution de tâches, formation d'équipes, sélection aléatoire
- 🎪 **Événements** : Tirages au sort de lots, sélection de gagnants
- 🏛️ **Associations** : Répartition équitable, sélection transparente

---

## ✨ Fonctionnalités

### 🔐 Sécurité & Certification

- **Algorithme Fisher-Yates** : Garantit un mélange aléatoire uniforme et équitable
- **Hash SHA-256** : Chaque tirage génère une empreinte cryptographique unique
- **Seed cryptographique** : Traçabilité et reproductibilité des résultats
- **Timestamp verrouillé** : Horodatage immuable du tirage
- **Vérification publique** : N'importe qui peut vérifier l'authenticité d'un tirage

### 🎲 Modes de tirage

#### Mode A - Répartition par groupes
- Création de groupes de taille définie
- Suggestions automatiques de tailles optimales
- Répartition équilibrée des participants

#### Mode B - Répartition par thèmes
- Attribution de participants à des thèmes/projets
- Distribution équitable sur plusieurs thèmes
- Idéal pour l'attribution de sujets

### 🛠️ Gestion avancée

- **Import de participants** : CSV, Excel (XLS/XLSX) ou saisie manuelle
- **Contraintes personnalisées** :
  - Inclusion : Forcer 2 personnes dans le même groupe
  - Exclusion : Séparer 2 personnes
  - Jusqu'à 20 contraintes par tirage
- **Détection anti-doublon** : Alerte si des paires ont déjà été tirées ensemble
- **Historique complet** : Consultation de tous les tirages passés

### 📊 Exports & Rapports

- **Procès-verbal PDF** : Document officiel avec hash, seed et résultats
- **Export Excel** : Fichier exploitable pour traitement ultérieur
- **Certificat d'authenticité** : Hash SHA-256 visible et vérifiable
- **Rapport de contraintes** : Statut de satisfaction de chaque contrainte

### 👤 Gestion utilisateur

- **Profils personnalisés** : Avatar avec initiales, badges de statut
- **Plans Free/Pro** : Gestion des abonnements
- **Statistiques** : Nombre de tirages, participants traités
- **Authentification sécurisée** : Laravel Breeze avec validation email

---

## 🚀 Installation

### Prérequis

- PHP >= 8.4
- Composer
- MySQL >= 8.0
- Node.js >= 18.x
- NPM ou Yarn

### Étapes d'installation

```bash
# 1. Cloner le repository
git clone https://github.com/rootusr404/sortio.git
cd sortio

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JavaScript
npm install

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Générer la clé d'application
php artisan key:generate

# 6. Configurer la base de données dans .env
# DB_DATABASE=sortio_db
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Créer la base de données
mysql -u root -e "CREATE DATABASE sortio_db;"

# 8. Exécuter les migrations
php artisan migrate

# 9. (Optionnel) Peupler avec des données de test
php artisan db:seed

# 10. Compiler les assets
npm run build

# 11. Lancer le serveur de développement
php artisan serve
```

L'application sera accessible sur `http://localhost:8000`

---

## 🏗️ Architecture technique

### Stack technologique

- **Backend** : Laravel 12.x (PHP 8.4)
- **Frontend** : Livewire 3.x + Alpine.js
- **Styling** : TailwindCSS 3.x
- **Base de données** : MySQL 8.0
- **Exports** : PhpSpreadsheet (Excel), DomPDF (PDF)

### Structure du projet

```
sortio/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Contrôleurs (Draw, Profile, Verify)
│   │   └── Requests/         # Form Requests avec validation
│   ├── Livewire/
│   │   └── Draw/             # Composants Livewire (Import, Config, Results)
│   ├── Models/               # Eloquent Models (User, Draw, Participant)
│   └── Services/             # Logique métier
│       ├── DrawService.php   # Exécution des tirages
│       ├── HashService.php   # Génération/vérification SHA-256
│       ├── ShuffleService.php # Algorithme Fisher-Yates
│       ├── ConstraintService.php # Gestion des contraintes
│       └── ExportService.php # Génération PDF/Excel
├── database/
│   └── migrations/           # Schéma de base de données
├── resources/
│   ├── views/                # Vues Blade
│   └── css/                  # Styles Tailwind
└── routes/
    └── web.php               # Routes de l'application
```

### Services clés

#### DrawService
Gère l'exécution complète d'un tirage :
- Mélange Fisher-Yates des participants
- Application des contraintes (inclusion/exclusion)
- Génération du hash SHA-256
- Sauvegarde en base de données

#### HashService
Gère la cryptographie :
- Génération de seed aléatoire sécurisé
- Calcul du hash SHA-256 à partir des données
- Vérification d'authenticité des tirages

#### ConstraintService
Résout les contraintes :
- Validation des règles d'inclusion/exclusion
- Algorithme de swap avec backtracking
- Rapport de satisfaction des contraintes

---

## 📖 Utilisation

### 1. Créer un tirage

1. Connectez-vous à votre compte
2. Cliquez sur "Nouveau tirage"
3. **Étape 1** : Importez vos participants (CSV/Excel) ou saisissez-les manuellement
4. **Étape 2** : Choisissez le mode (A ou B) et configurez les paramètres
5. **Étape 3** : Consultez les résultats et téléchargez le procès-verbal

### 2. Vérifier un tirage

1. Accédez à la page "Vérifier un tirage" (accessible sans compte)
2. Sélectionnez le type de tirage (Mode A ou B)
3. Renseignez les informations du procès-verbal :
   - Hash SHA-256
   - Seed cryptographique
   - Timestamp
   - Liste des participants
   - Paramètres (taille groupes ou thèmes)
4. Cliquez sur "Vérifier l'authenticité"
5. Consultez le verdict détaillé

---

## 🔒 Sécurité

- **Hachage SHA-256** : Garantit l'intégrité des données
- **Protection CSRF** : Tous les formulaires sont protégés
- **Validation stricte** : Toutes les entrées utilisateur sont validées
- **Authentification sécurisée** : Laravel Breeze avec vérification email
- **Sanitization** : Protection contre XSS et injections SQL

---

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Fork le projet
2. Créez une branche (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

### Guidelines

- Suivez les conventions PSR-12 pour PHP
- Écrivez des tests pour les nouvelles fonctionnalités
- Documentez votre code
- Utilisez des messages de commit clairs

---

## 📝 License

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

## 👨‍💻 Auteur

**rootusr404**

- GitHub: [@rootusr404](https://github.com/rootusr404)
- Email: [contact@sortio.app](mailto:rootuser404@gmail.com)

---

## 🙏 Remerciements

- [Laravel](https://laravel.com) - Framework PHP élégant
- [Livewire](https://livewire.laravel.com) - Composants réactifs
- [TailwindCSS](https://tailwindcss.com) - Framework CSS utility-first
- [Alpine.js](https://alpinejs.dev) - Framework JavaScript léger
- [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io) - Manipulation Excel

---

<div align="center">

**⭐ Si ce projet vous plaît, n'hésitez pas à lui donner une étoile !**

Fait avec ❤️ par [rootusr404](https://github.com/rootusr404)

</div>
