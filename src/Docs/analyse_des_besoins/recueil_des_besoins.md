# Recueil des besoins

## CHAPITRE 1 : Objectif et portée

L’objectif principal de ce projet est de développer une application web en PHP et MySQL permettant aux utilisateurs d'effectuer divers calculs mathématiques à l’aide de modules spécifiques. La plateforme offrira un espace personnalisé avec un tableau de bord pour les utilisateurs inscrits, ainsi qu’un accès limité aux visiteurs. Elle vise également à faciliter la gestion des utilisateurs et à assurer un suivi sécurisé de leurs actions.

Les intervenants sont au nombre de 4 :

- **Visiteur** : Il accède seulement à la page d’accueil et à une vidéo explicative, sans utiliser les modules.
- **Utilisateur inscrit** : Il accède aux modules de calculs et peut gérer son historique personnel.
- **Administrateur web** : Responsable de la gestion des utilisateurs (inscriptions, suppressions avec logs).
- **Administrateur système** : Surveille les activités via les journaux pour assurer la sécurité et la fiabilité de la plateforme.

La portée du système définit les fonctionnalités clés incluses dans le projet ainsi que les éléments exclus, afin de cadrer les objectifs et les limites de l’application.

**Ce qui entre dans la portée** : Développement des modules de calculs, gestion des comptes utilisateurs (inscriptions, connexions, suppressions), stockage des historiques d’utilisation, suivi des activités via des journaux et sécurisation des accès.

**Ce qui est en dehors de la portée** : La récupération de mot de passe (uniquement simulée par un lien de page en construction), les notifications par e-mail ou SMS, et tout développement hors de PHP/MySQL spécifiquement sur ce projet.

## CHAPITRE 2 : Terminologie employée / Glossaire

Ce glossaire se concentre sur les termes et concepts spécifiques relatifs à l'intégrale, l'espérance, la variance et l'écart-type. Ces concepts sont essentiels dans les domaines des mathématiques appliquées, des statistiques et des probabilités. Le but de ce glossaire est d'assurer une compréhension commune des fonctionnalités à implémenter sur un site de calcul mathématique.

1. **Intégrale**
   - L’intégrale est un concept fondamental en analyse mathématique, qui représente l’aire sous une courbe ou la somme continue d'une fonction. Elle peut être définie de manière indéfinie ou définie.
   - **Objectifs de calcul** : Le site de calcul devrait permettre à l'utilisateur de calculer des intégrales définies et indéfinies, de manipuler des fonctions (exemples : polynômes, fonctions trigonométriques), et d'obtenir des résultats exacts ou numériques (approximation).

2. **Espérance (ou Moyenne)**
   - L'espérance, notée E(X), est la moyenne pondérée de toutes les valeurs possibles d'une variable aléatoire, pondérées par leur probabilité respective. Elle représente la valeur "attendue" ou "moyenne" que l’on peut obtenir dans un grand nombre d’essais d’une expérience aléatoire.
   - **Objectifs de calcul** : Le site devrait permettre de calculer l'espérance d'une variable discrète (en utilisant une somme pondérée) ou d'une variable continue (en utilisant une intégrale), à partir de la distribution de probabilité fournie.

3. **Variance**
   - La variance mesure la dispersion des valeurs d'une variable aléatoire autour de son espérance. Plus la variance est élevée, plus les valeurs sont dispersées. La variance est le carré de l'écart-type.
   - **Objectifs de calcul** : Le site de calcul devrait pouvoir calculer la variance pour des variables discrètes et continues, en utilisant les formules appropriées en fonction du type de distribution de probabilité.

4. **Écart-Type**
   - L'écart-type est la racine carrée de la variance. Il fournit une mesure de la dispersion des valeurs d’une variable aléatoire par rapport à sa moyenne (espérance), exprimée dans la même unité que la variable.
   - **Objectifs de calcul** : Le site devrait permettre de calculer l’écart-type d’une variable aléatoire en fonction de sa variance, soit de manière directe, soit en le dérivant de la variance obtenue. Il peut aussi permettre de visualiser l'écart-type sur des distributions graphiques.

## CHAPITRE 3 : Les cas d’utilisation

### (a) Les acteurs principaux et leurs objectifs généraux

1. **Visiteur**
   - **Objectif général** :
     - Accéder à la page d'accueil de la plateforme pour comprendre son utilité et ses fonctionnalités.
     - Visionner une vidéo explicative mettant en valeur l'intérêt de l'inscription.
     - Ne peut pas utiliser les modules de calcul ni accéder à un tableau de bord.
   - **Actions possibles** :
     - Visualiser la page d'accueil et la vidéo.
     - S'inscrire via un formulaire avec vérification CAPTCHA en tant qu'utilisateur pour pouvoir accéder aux fonctionnalités avancées de la plateforme.

2. **Utilisateur inscrit**
   - **Objectif général** :
     - Profiter des fonctionnalités complètes de la plateforme après inscription (accès aux modules de calcul, gestion de son profil, historique des calculs).
   - **Actions possibles** :
     - Utiliser les modules de calcul mis à disposition.
     - Consulter et gérer son profil utilisateur (changer le mot de passe).
     - Accéder à son historique.

3. **Administrateur web**
   - **Objectif général** :
     - Gérer les utilisateurs inscrits sur la plateforme (création, suppression de comptes), assurer la gestion du site web et sa bonne organisation.
   - **Actions possibles** :
     - Se connecter à la plateforme avec des identifiants spécifiques (adminweb).
     - Voir la liste des utilisateurs inscrits.
     - Créer de nouveaux comptes utilisateurs à partir d'un fichier CSV.
     - Supprimer des comptes utilisateurs ainsi que leurs historiques et générer des logs de suppression.

4. **Administrateur système**
   - **Objectif général** :
     - Assurer la maintenance du système et la sécurité de la plateforme au niveau matériel et logiciel.
     - Surveiller les journaux d'activités et garantir la stabilité de l'environnement d'exécution.
   - **Actions possibles** :
     - Se connecter à la plateforme avec des identifiants spécifiques (sysadmin).
     - Accéder aux logs système (activité serveur, logs d'accès, erreurs techniques).


### b) Les cas d’utilisation métier (concepts opérationnels)

#### 1. Utiliser les modules de calculs

| **Nom**                        | Utiliser les modules de calculs                                |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Entreprise/Organisation ◼️                                    |
| **Niveau**                      | 🪁                                                            |
| **Acteur principal**            | Utilisateur                                                   |
| **Scénario nominal**            | 1. L’utilisateur sélectionne au max. 3 méthodes de calculs numériques <br> 2. L’utilisateur obtient son résultat sous forme d’un tableau indiquant la valeur de probabilité et les paramètres |
| **Scénario alternatif**         | 1. L’utilisateur décide de stocker ses résultats dans l’historique |
| **Scénario exceptionnel**       |                                                               |

#### 2. Accéder à son historique

| **Nom**                        | Accéder à son historique                                      |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Entreprise/Organisation ◼️                                    |
| **Niveau**                      | 🌊                                                            |
| **Acteur principal**            | Utilisateur                                                   |
| **Scénario nominal**            | Il clique sur le bouton où il y a écrit “historique”          |
| **Scénario alternatif**         |                                                               |
| **Scénario exceptionnel**       |                                                               |

### c) Les cas d’utilisation système

#### 1. Visualiser la vidéo de présentation du site

| **Nom**                        | Visualiser la vidéo de présentation du site                   |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Site web ◼️                                                   |
| **Niveau**                      | 🌊 (utilisateur)                                              |
| **Acteur principal**            | Visiteur                                                      |
| **Scénario nominal**            | L’utilisateur clique sur la vidéo                             |
| **Scénario alternatif**         |                                                               |
| **Scénario exceptionnel**       |                                                               |

#### 2. S’inscrire

| **Nom**                        | S’inscrire                                                     |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Site web ◼️                                                   |
| **Niveau**                      | 🐟                                                            |
| **Acteur principal**            | Visiteur                                                      |
| **Scénario nominal**            | 1. Il clique sur le bouton avec écrit “s’inscrire” <br> 2. Il entre son pseudo <br> 3. Il entre son mot de passe <br> 4. Il valide un CAPTCHA <br> 5. Il appuie sur le bouton de création de compte |
| **Scénario alternatif**         | a. Le visiteur oublie de remplir un champ <br> 1. Un message d’erreur s’affiche <br> 2. Le visiteur remplit le champ manquant <br> b. Le visiteur échoue le CAPTCHA <br> 1. Un message d’erreur s’affiche <br> 2. Le visiteur retente le CAPTCHA et réussit |
| **Scénario exceptionnel**       |                                                               |

#### 3. Se connecter

| **Nom**                        | Se connecter                                                  |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Site web ◼️                                                   |
| **Niveau**                      | Sous fonction 🐟                                              |
| **Acteur principal**            | Utilisateurs, Administrateur Web et Système                   |
| **Scénario nominal**            | L’utilisateur entre son login et son mot de passe            |
| **Scénario alternatif**         |                                                               |
| **Scénario exceptionnel**       |                                                               |

#### 4. Se déconnecter

| **Nom**                        | Se déconnecter                                                |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Site web ◼️                                                   |
| **Niveau**                      | Sous fonction 🐟                                              |
| **Acteur principal**            | Utilisateurs, Administrateur Web et Système                   |
| **Scénario nominal**            | L’utilisateur clique sur le bouton de déconnexion             |
| **Scénario alternatif**         |                                                               |
| **Scénario exceptionnel**       |                                                               |

#### 5. Changer son mot de passe

| **Nom**                        | Changer son mot de passe                                       |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Site web ◼️                                                   |
| **Niveau**                      | 🐟                                                            |
| **Acteur principal**            | Utilisateur                                                   |
| **Scénario nominal**            | 1. Il clique sur le bouton avec écrit “profil” <br> 2. Il clique sur le bouton “changer mot de passe” <br> 3. Il entre le nouveau mot de passe dans le champ <br> 4. Il appuie sur le bouton pour changer son mot de passe |
| **Scénario alternatif**         | a. L’utilisateur entre le même mot de passe qu’un utilisateur avec qui il partage le même pseudo <br> 1. Un message d’erreur s’affiche <br> 2. Le visiteur entre un mot de passe différent <br> 3. Il appuie sur le bouton pour changer son mot de passe. |
| **Scénario exceptionnel**       |                                                               |

#### 6. Voir la liste des utilisateurs inscrits

| **Nom**                        | Voir la liste des utilisateurs inscrits                       |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Site web ◻️                                                   |
| **Niveau**                      | 🐟                                                            |
| **Acteur principal**            | Administrateur web                                            |
| **Scénario nominal**            | Il appuie sur le bouton où il y a écrit “liste des utilisateurs” |
| **Scénario alternatif**         |                                                               |
| **Scénario exceptionnel**       |                                                               |

#### 7. Créer de nouveaux comptes utilisateurs à partir d'un fichier CSV

| **Nom**                        | Créer de nouveaux comptes utilisateurs à partir d'un fichier CSV |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Site web ◻️                                                   |
| **Niveau**                      | 🐟                                                            |
| **Acteur principal**            | Administrateur web                                            |
| **Scénario nominal**            | 1. Il ajoute la ligne sur le fichier CSV contenant les utilisateurs |
| **Scénario alternatif**         |                                                               |
| **Scénario exceptionnel**       |                                                               |

#### 8. Supprimer des comptes utilisateurs ainsi que leurs historiques et générer des logs de suppression

| **Nom**                        | Supprimer des comptes utilisateurs ainsi que leurs historiques et générer des logs de suppression |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Site web ◻️                                                   |
| **Niveau**                      | 🐟                                                            |
| **Acteur principal**            | Administrateur web                                            |
| **Scénario nominal**            | 1. Il se connecte avec ses identifiants <br> 2. Il clique sur le bouton pour aller sur la liste des utilisateurs <br> 3. Il clique sur le bouton supprimer à côté des informations de l’utilisateur qu’il souhaite supprimer |
| **Scénario alternatif**         |                                                               |
| **Scénario exceptionnel**       |                                                               |

#### 9. Accéder aux logs système (activité serveur, logs d'accès, erreurs techniques)

| **Nom**                        | Accéder aux logs système (activité serveur, logs d'accès, erreurs techniques) |
|---------------------------------|---------------------------------------------------------------|
| **Portée**                      | Site web ◻️                                                   |
| **Niveau**                      | 🐟                                                            |
| **Acteur principal**            | Administrateur système                                        |
| **Scénario nominal**            | 1. Il se connecte avec ses identifiants <br> 2. Il clique sur le bouton pour accéder aux logs |
| **Scénario alternatif**         |                                                               |
| **Scénario exceptionnel**       |                                                               |




## CHAPITRE 4 : La technologie employée

Voici les exigences technologiques spécifiques pour le système :

### Serveur Web :

- **Apache** : Le système doit être capable d'héberger l'application web en PHP. Apache est recommandé pour sa compatibilité avec PHP, mais d'autres serveurs comme Nginx peuvent également être envisagés.

### Serveur de base de données :

- **MySQL** : La base de données sera utilisée pour gérer les utilisateurs, les modules de calcul, les logs, et les autres informations pertinentes pour la plateforme. Vous pouvez aussi utiliser un autre serveur SQL compatible avec PHP, mais MySQL est spécifié.

### PHP :

- **PHP** : Le langage principal pour développer l'application web et gérer la logique côté serveur. PHP doit être installé sur le serveur web pour traiter les requêtes et interagir avec la base de données.

### SSH (Secure Shell) :

- **Accès SSH sécurisé** : Vous devrez être capables de vous connecter à votre Raspberry Pi 4 (RPi 4) via SSH pour gérer le serveur, accéder à la configuration, et administrer la plateforme à distance.

### Raspberry Pi 4 (RPi4) :

- **Installation de l'OS** : Le Raspberry Pi servira de serveur, avec un système d'exploitation installé sur une carte SD. L’OS de base pourrait être Raspberry Pi OS (ancienement Raspbian), mais vous pouvez utiliser d’autres distributions Linux si nécessaire.
- **Configuration du réseau** : Le Raspberry Pi sera configuré pour être accessible en réseau, à la fois depuis les machines locales et, potentiellement, depuis l’extérieur via un tunnel SSH.

### Sécurité :

- **Accès sécurisé au serveur** : La plateforme devra sécuriser l'accès via SSH et gérer les connexions HTTP de manière sécurisée (potentiellement avec HTTPS).
- **Gestion des sessions utilisateurs** : Un système de gestion de sessions sécurisé devra être mis en place, pour que chaque utilisateur puisse s'identifier et gérer son profil.

### Code Source et Versioning :

- **Git (GitHub)** : Le code source du projet doit être versionné et mis à disposition sur un dépôt Git (GitHub du groupe) pour assurer la collaboration, la traçabilité et la sauvegarde du travail réalisé.

### Interface utilisateur :

- **HTML, CSS** : Le front-end de la plateforme sera développé en HTML et CSS pour structurer et styliser les pages.

### Formulaires et Validation :

- **Validation avec CAPTCHA** : Un mécanisme de validation de formulaire (comme un CAPTCHA) doit être mis en place lors de l'inscription des utilisateurs, pour éviter les inscriptions automatiques ou les attaques par bots.

### Logs et Suivi :

- **Fichiers de logs** : Des fichiers de logs devront être générés lors des actions critiques sur la plateforme (inscription des utilisateurs, suppression de comptes, utilisation des modules de calcul, etc.). Ces logs devront être consultables par les administrateurs pour assurer une traçabilité et une gestion des événements du système.

---

### (b) Avec quels systèmes ce système s'interfacera-t-il et avec quelles exigences ?

---

## CHAPITRE 5 : Autres exigences

### (a) Processus de développement

#### i) Qui sont les participants du projet ?

Le projet est mené par un groupe de 5 étudiants, chacun contribuant à toutes les phases du développement. Nous travaillerons ensemble pour organiser le projet, réaliser l'implémentation des différentes fonctionnalités, effectuer les tests nécessaires, et rédiger la documentation. La charge de travail sera répartie de manière équitable pour garantir l'efficacité et la réussite du projet.

#### ii) Quelles valeurs devront être privilégiées ?

Nous voulons privilégier la simplicité et l’innovation. Nous voulons rendre facile le fait de faire des calculs demandant des formules mathématiques qui demandent à la main beaucoup d’efforts.

#### iii) Quels retours ou quelle visibilité sur le projet les utilisateurs et commanditaires souhaitent-ils ?

- **Encadrants** : Suivi de l'avancement et accès à la documentation et au code source sur GitHub.
- **Utilisateurs** : Documentation disponible pour expliquer l'utilisation de la plateforme.

#### iv) Que peut-on acheter ? Que doit-on construire ? Qui sont nos concurrents ? 

**RIEN**

#### v) Quelles sont les autres exigences du processus ? (exemple : tests, installation, etc...)

- Préparation de la carte SD et configuration des services pour une installation rapide sur le Raspberry Pi.

#### vi) Préparation de la carte SD et configuration des services pour une installation rapide sur le Raspberry Pi

- Utilisation de **PHP**, **MySQL**, **R**, **Apache** pour la configuration et l'installation des services nécessaires sur le Raspberry Pi.

---

Les autres rubriques ainsi que le **Chapitre 6** ne nous concernent pas directement, car nous travaillons en tant qu’étudiants et ne sommes donc pas confrontés à ces enjeux professionnels.
