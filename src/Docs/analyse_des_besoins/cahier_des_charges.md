# CAHIER DES CHARGES

## Introduction
Nous sommes une équipe de 5 développeurs travaillant sur un projet informatique commandé par un client. L’objectif de ce projet est de mettre en place une application web en PHP et MySQL, destinée à proposer des modèles mathématiques afin de permettre des calculs. Le site comportera :
- Une page d’accueil avec un texte explicatif,
- Un tableau de bord avec les différents modules de calculs,
- Une vidéo explicative.

## Enoncé
Le logiciel permet d’effectuer des calculs. Les acteurs sont au nombre de quatre :

1. **Visiteur** : Accès limité à une vidéo explicative, sans possibilité d’utiliser les modules de calculs.
2. **Client (Utilisateur)** : Accès aux différents modules proposés sur le site.
3. **Utilisateur inscrit** : Accès à un tableau de bord contenant les différents modules de calculs. L’utilisateur non inscrit n’aura pas accès à cette partie.
4. **Administrateur web** : Identifiants fixes « adminweb » pour :
   - Voir la liste des utilisateurs,
   - Créer des comptes via un fichier CSV,
   - Supprimer des comptes, tout en générant un fichier de log pour chaque suppression.
5. **Administrateur système** : Identifiants « sysadmin » pour accéder aux journaux d’activités de l’application, afin de surveiller l’activité et d’assurer la sécurité de la plateforme.

## Pré-requis
L'application sera installée sur un Raspberry Pi 4 avec une carte SD configurée pour :
- Le système d'exploitation,
- Un serveur web (comme Apache),
- Un serveur SGBD (par exemple, MySQL),
- Des applications de sécurisation pour les accès SSH.

## Priorités
Les priorités de développement, établies avec le client, sont :

1. **Fonctionnalités essentielles** : Créer la page d’accueil, les modules de calculs, et la gestion des utilisateurs avec différents niveaux d’accès.
2. **Sécurité** : Renforcer l’authentification et les logs d’activités consultables par les administrateurs.
3. **Ergonomie** : Optimiser l’interface pour être ergonomique et responsive, assurant une utilisation intuitive sur ordinateurs et mobiles.
4. **Maintenance** : Assurer l’accès aux journaux d’activités pour l’administrateur système et fournir une documentation complète sur GitHub/GitLab pour garantir la maintenance de la plateforme.
