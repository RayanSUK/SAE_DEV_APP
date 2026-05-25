# SAE_DEV_APP — Application Web de Calcul Mathématique

Application web PHP/MySQL développée dans le cadre d'un **projet académique** (SAE — Situation d'Apprentissage et d'Évaluation), avec une approche orientée qualité : tests unitaires, documentation technique et cahier des charges complet.

---

## Aperçu

L'application permet à des utilisateurs authentifiés d'effectuer des calculs mathématiques avancés et des opérations cryptographiques, avec un système complet de gestion des utilisateurs, de traçabilité des actions, et deux interfaces d'administration distinctes.

---

## Fonctionnalités

### Modules mathématiques
- **Loi Inverse Gaussienne** : calcul de la densité de probabilité et intégration numérique via trois méthodes (rectangles médians, trapèzes, Simpson)
- **Résolveur de polynômes** : résolution des équations du second degré (racines réelles, racine unique, racines complexes)
- **Cryptographie RC4** : chiffrement et déchiffrement de texte via l'algorithme RC4 *(implémenté à titre pédagogique — une application en production utiliserait bcrypt ou Argon2)*

### Gestion des utilisateurs
- Inscription avec CAPTCHA arithmétique anti-bot
- Connexion sécurisée avec gestion de session
- Import en masse d'utilisateurs depuis un fichier JSON (admin)

### Historique & traçabilité
- Historique des calculs par utilisateur
- Journal système : toutes les tentatives de connexion/inscription enregistrées avec IP, date et résultat
- Export du journal en JSON, filtrage et suppression

### Administration
- **Admin Web** : gestion des comptes utilisateurs (création, import JSON, suppression)
- **Admin Système** : consultation et gestion du journal d'activité

---

## Stack technique

| Côté | Technologie |
|------|-------------|
| Serveur | Apache 2 |
| Backend | PHP 8.0+ |
| Base de données | MySQL 5.7+ |
| Frontend | HTML5, CSS3, PHP templates |
| Visualisation | Chart.js, MathJax 3 |
| Tests unitaires | PHPUnit 11.5 |
| Documentation | Doxygen |
| Dépendances | Composer |

---

## Architecture & choix techniques

### Rôles utilisateurs (4 niveaux)
```
Visiteur → Utilisateur inscrit → Admin Web → Admin Système
```
Contrôle d'accès géré via les variables de session PHP (`$_SESSION['role']`).

### Sécurité
- Requêtes préparées (prepared statements) contre les injections SQL
- CAPTCHA arithmétique à l'inscription
- Journalisation de toutes les tentatives de connexion (IP, date, résultat)

### Architecture MVC simplifiée
- **Vue** : fichiers `.php` (HTML + PHP)
- **Contrôleur** : logique de traitement en haut de chaque fichier
- **Modèle** : fonctions dans `fonctions.php`, `fonctionsLIG.php`, `fonctionsPolynome.php`
- **Partials** : fragments de template réutilisables (navbar, footer)

### Intégration numérique — Loi Inverse Gaussienne
Trois méthodes implémentées et comparables par l'utilisateur :
- **Rectangles médians** : approximation par rectangles centrés
- **Trapèzes** : approximation linéaire
- **Simpson** : approximation parabolique (plus précise)

### Tests unitaires
Les tests couvrent :
- Les cas nominaux et les cas limites (discriminant nul, racines complexes)
- La symétrie RC4 (chiffrer puis déchiffrer = texte original)

---

## Lancer le projet

### Prérequis
- PHP 8.0+, MySQL 5.7+, Apache (ou XAMPP/WAMP), Composer

### Installation

```bash
# 1. Cloner le dépôt
git clone <url-du-repo>
cd SAE_DEV_APP

# 2. Installer les dépendances PHP
cd src
composer install

# 3. Importer la base de données
mysql -u root -p sigmax < src/site/sigmax.sql

# 4. Configurer la connexion MySQL
# Modifier les paramètres dans les fichiers .php (chercher mysqli_connect)

# 5. Copier src/site/ dans le répertoire web Apache
# Exemple XAMPP : htdocs/saesigmax/

# 6. Accéder à l'application
# http://localhost/saesigmax/
```

### Comptes de test

| Rôle | Login | Mot de passe |
|------|-------|--------------|
| Admin Web | `adminweb` | `admin` |
| Admin Système | `adminsys` | `admin` |

### Tests unitaires

```bash
cd src
./vendor/bin/phpunit tests/
```

---

## Structure du projet

```
SAE_DEV_APP/
├── phpunit.phar
└── src/
    ├── composer.json
    ├── Doxyfile
    ├── Docs/
    │   ├── analyse_des_besoins/   # Cahier des charges
    │   ├── conception/            # Diagrammes UML
    │   ├── doc_technique/         # Documentation Doxygen (HTML)
    │   ├── docs_user/             # Documentation utilisateur
    │   └── tests/                 # Rapport de tests
    ├── maquette/                  # Wireframes HTML/CSS
    ├── site/                      # Code source
    │   ├── fonctions.php          # Utilitaires (RC4, CAPTCHA, IP)
    │   ├── fonctionsLIG.php       # Calculs Loi Inverse Gaussienne
    │   ├── fonctionsPolynome.php  # Résolution polynômes
    │   ├── actions.php            # AJAX — actions admin
    │   ├── sigmax.sql             # Schéma BDD
    │   └── partiels/              # Fragments HTML réutilisables
    └── tests/
        ├── FonctionsTest.php
        ├── FonctionsLIGTest.php
        └── FonctionsPolynomeTest.php
```

---

## Contexte

Projet réalisé en **formation BUT Informatique** dans le cadre d'une SAE, en autonomie complète, avec livraison d'un cahier des charges, de diagrammes UML, d'une documentation Doxygen et d'un rapport de tests.
