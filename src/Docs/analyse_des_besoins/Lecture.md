# CAHIER DES CHARGES  
## Développement d’Application  
**INF2 FI -B – 2024-2025**

---

### 1) Objets, Acteurs, Actions

| Objet | Acteurs | Actions |
| --- | --- | --- |
| Page d’accueil | Un administrateur système | Accéder à la page d’accueil |
| Tableau de bord (modules de calculs) | Un utilisateur  | s'inscrire |
| Vidéo explicative (quand utilisateur non inscrit) | Un utilisateur  | stocker ses résultats |
| Formulaire d’inscription avec captcha | Un visiteur | accéder à son profil |
| lien mot de passe oublié | | utiliser les modules de calculs |
| page web en construction | | voir la liste des users |
| Modules de calculs |  | créer des comptes users |
| profil | | supprimer des comptes users |
| Mot de passe | | accéder aux journaux des activités de l'application web |
| résultats de calculs | |  |
| Journaux d’activités |  |  |
| Résultats de calculs |  |  |
| Historique des calculs |  |  |
| Base de données |  |  |
| Fichiers de logs | |  |
| Liste des utilisateurs inscrits |  | |
| Fichier CSV |  |  |
| Journaux d’activités |  |  |

---

### 2) Questions à poser au client :

- **Quelles sont les couleurs que vous voulez pour le site ?**  
  Réponse : Bleu, Blanc, et Noir pour le texte.

- **Quels types de calculs seront proposés ?**  
  Réponse : Le client souhaite des calculs de moyenne, d’écart type, etc. Il pourrait en demander d’autres par la suite.

- **Combien de temps peuvent rester les informations dans l’historique ?**  
  Réponse : 1 an.

- **Peut-on contacter l’administrateur système et/ou l’admin web en cas de problème ?**  
  Réponse : Oui.

- **Le mot de passe devra-t-il respecter certaines contraintes ?**  
  Réponse : 8 caractères max, une lettre majuscule minimum et un caractère spécial.

- **Quelles informations des utilisateurs seront stockées dans la base de données ?**  
  Réponse : Login, mot de passe (chiffré), les calculs, date et heure de création du compte.

---

### 3) Exigences fonctionnelles et techniques :

#### Exigences fonctionnelles :
- Effectuer des calculs.
- Consulter l’historique des calculs qui ont été faits.
- S’inscrire.
- Créer ou supprimer des comptes utilisateurs.
- Accéder à son profil.

#### Exigences techniques :
- Utilisation de **PHP** & **MySQL**.
- Gestion des fichiers de logs.
- Gestion de la base de données.
