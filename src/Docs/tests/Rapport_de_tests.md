

# SAE \- Semestre 4 \-                   Rapport de tests

## 

# AZIRGUI Younes

# BOMET Pierre-Alix

# CHAARAOUI Abdelaziz

# KOLOSIANA Kevin

# SUKKARIE Rayan

# INF2-FI- B – 2024-2025

## 

# **1- INTRODUCTION** 

Ce rapport présente les résultats des tests boîte noire effectués dans le cadre du projet **Sigmax**. L'objectif principal de ce projet est de développer un logiciel fiable et performant en effectuant des vérifications rigoureuses de toutes les fonctionnalités par le biais de tests de validation.

Les tests boîte noire sont utilisés ici pour évaluer le bon fonctionnement des différentes fonctions et modules du système, sans tenir compte de leur implémentation interne. L'idée est de se concentrer sur les entrées et sorties des fonctions, afin de s'assurer qu'elles répondent correctement aux spécifications attendues.

Dans ce rapport, chaque fonction ou fonctionnalité testée est présentée avec des cas de test basés sur la partition d'équivalence. Les tests sont organisés de manière à couvrir tous les scénarios possibles d'entrée et à analyser les résultats produits par le système. Cette approche permet de valider que le logiciel répond correctement aux besoins et exigences définis, en garantissant une utilisation fiable dans différents contextes.

L'objectif final est d'assurer que le projet **Sigmax** soit stable, performant et prêt à être déployé en production, tout en offrant une expérience utilisateur de qualité.

# **2- ELABORATION DES TESTS BOITES NOIRES**

Un **test boîte noire** est une méthode de test où le testeur évalue le comportement d'une application ou d'un système sans avoir connaissance de son code interne ou de sa structure. L'objectif de ce type de test est de valider que le système fonctionne comme prévu en fonction des spécifications et des exigences.

## **1- TESTS DES FONCTIONS DU MODULE DE CALCUL** 

## 

### **1\. Fonction `loi_inverse_gaussienne`**

### **Tableau 1 \- Conception Test `loi_inverse_gaussienne` (Boite Noire)**

| Cas de test | Entrée `x` | Entrée `espérance` | Entrée `forme` | Sortie attendue |
| ----- | ----- | ----- | ----- | ----- |
| P1 | x valide | Espérance valide | Forme valide | Valeur calculée |
| P2 | x égal à 0 | Espérance valide | Forme valide | 0 |
| P3 | x valide | Espérance valide | Forme égale à 0 | 0 |
| P4 | x valide | Espérance égale à 0 | Forme valide | Valeur calculée |

### 

### 

### **Tableau 2 \- Données de test `loi_inverse_gaussienne`**

| Cas de test | Entrée `x` | Entrée `espérance` | Entrée `forme` | Sortie attendue |
| ----- | ----- | ----- | ----- | ----- |
| P1 | 1 | 0 | 1 | 0.24197 |
| P2 | 0 | 0 | 1 | 0 |
| P3 | 1 | 0 | 0 | 0 |
| P4 | 1 | 1 | 1 | 0.24197 |

#### ---

## **2\. Fonction `methode_rectangles_medians`**

### **Tableau 1 \- Conception Test `methode_rectangles_medians` (Boite Noire)**

| Cas de test | Entrée `n` | Entrée `esperance` | Entrée `forme` | Entrée `t` | Sortie attendue |
| ----- | ----- | ----- | ----- | ----- | ----- |
| P1 | n \> 0 | Espérance valide | Forme valide | t \> 0 | Valeur calculée |
| P2 | n \<= 0 | Espérance valide | Forme valide | t \> 0 | ERREUR |
| P3 | n \> 0 | Esperance invalide | Forme valide | t \> 0 | ERREUR |
| P4 | n \> 0 | Esperance valide | Forme invalide | t \> 0 | ERREUR |

### 

### **Tableau 2 \- Données de test `methode_rectangles_medians`**

| Cas de test | Entrée `n` | Entrée `esperance` | Entrée `forme` | Entrée `t` | Sortie attendue |
| ----- | ----- | ----- | ----- | ----- | ----- |
| P1 | 4 | 0 | 1 | 1 | 0.24197 |
| P2 | \-4 | 0 | 1 | 1 | ERREUR |
| P3 | 4 | \-1 | 1 | 1 | ERREUR |
| P4 | 4 | 0 | 0 | 1 | ERREUR |

#### ---

## **3\. Fonction `methode_trapezes`**

### **Tableau 1 \- Conception Test `methode_trapezes` (Boite Noire)**

| Cas de test | Entrée `n` | Entrée `esperance` | Entrée `forme` | Entrée `t` | Sortie attendue |
| ----- | ----- | ----- | ----- | ----- | ----- |
| P1 | n \> 0 | Esperance valide | Forme valide | t \> 0 | Valeur calculée |
| P2 | n \<= 0 | Esperance valide | Forme valide | t \> 0 | ERREUR |
| P3 | n \> 0 | Esperance invalide | Forme valide | t \> 0 | ERREUR |
| P4 | n \> 0 | Esperance valide | Forme invalide | t \> 0 | ERREUR |

### 

### **Tableau 2 \- Données de test `methode_trapezes`**

| Cas de test | Entrée `n` | Entrée `esperance` | Entrée `forme` | Entrée `t` | Sortie attendue |
| ----- | ----- | ----- | ----- | ----- | ----- |
| P1 | 4 | 0 | 1 | 1 | 0.24197 |
| P2 | \-4 | 0 | 1 | 1 | ERREUR |
| P3 | 4 | \-1 | 1 | 1 | ERREUR |
| P4 | 4 | 0 | 0 | 1 | ERREUR |

#### ---

## **4\. Fonction `methode_simpson`**

### **Tableau 1 \- Conception Test `methode_simpson` (Boite Noire)**

| Cas de test | Entrée `n` | Entrée `esperance` | Entrée `forme` | Entrée `t` | Sortie attendue |
| ----- | ----- | ----- | ----- | ----- | ----- |
| P1 | n pair | Esperance valide | Forme valide | t \> 0 | Valeur calculée |
| P2 | n impair | Esperance valide | Forme valide | t \> 0 | ERREUR |
| P3 | n pair | Esperance invalide | Forme valide | t \> 0 | ERREUR |
| P4 | n pair | Esperance valide | Forme invalide | t \> 0 | ERREUR |

### 

### **Tableau 2 \- Données de test `methode_simpson`**

| Cas de test | Entrée `n` | Entrée `esperance` | Entrée `forme` | Entrée `t` | Sortie attendue |
| ----- | ----- | ----- | ----- | ----- | ----- |
| P1 | 4 | 0 | 1 | 1 | 0.24197 |
| P2 | 5 | 0 | 1 | 1 | ERREUR |
| P3 | 4 | \-1 | 1 | 1 | ERREUR |
| P4 | 4 | 0 | 0 | 1 | ERREUR |

#### ---

## 

## **5\. Fonction `ecart_type`**

### **Tableau 1 \- Conception Test `ecart_type` (Boîte Noire)**

| Cas de test | Entrée `esperance` | Entrée `forme` | Sortie attendue |
| ----- | ----- | ----- | ----- |
| P1 | Esperance valide | Forme valide | Valeur calculée |
| P2 | Esperance égale à 0 | Forme valide | 0 |
| P3 | Esperance valide | Forme égale à 0 | ERREUR |

### 

### 

### **Tableau 2 \- Données de test `ecart_type`**

| Cas de test | Entrée `esperance` | Entrée `forme` | Sortie attendue |
| ----- | ----- | ----- | ----- |
| P1 | 0 | 1 | 0 |
| P2 | 1 | 1 | 1 |
| P3 | 1 | 0 | ERREUR |
| P4 | 0 | 1 | 0 |

#### 

## **2- TESTS DES FONCTIONS DU MODULE DE POLYNÔME**

### **Test Boîte Noire pour `discriminant`**

#### **Tableau 1: Conception Test pour la fonction `discriminant`**

| Test | Entrée a | Entrée b | Entrée c | Sortie discriminant |
| ----- | ----- | ----- | ----- | ----- |
| P1 | a \> 0 | b \> 0 | c \> 0 | Valeur positive |
| P2 | a \= 0 | b \= 0 | c \> 0 | Erreur / Non défini |
| P3 | a \> 0 | b \= 0 | c \> 0 | Valeur positive |
| P4 | a \< 0 | b \< 0 | c \< 0 | Valeur positive |

#### **Tableau 2: Données de test pour la fonction `discriminant`**

| Entrée a | Entrée b | Entrée c | Sortie discriminant |
| ----- | ----- | ----- | ----- |
| 1 | 4 | 3 | 4 |
| 2 | 6 | 4 | 20 |
| 0 | 0 | 5 | Erreur / Non défini |
| \-1 | \-3 | 4 | 25 |

---

### **Test Boîte Noire pour `racineReelle1`**

#### **Tableau 1: Conception Test pour la fonction `racineReelle1`**

| Test | Entrée a | Entrée b | Entrée c | Sortie racine réelle 1 |
| ----- | ----- | ----- | ----- | ----- |
| P1 | discriminant \> 0 | a \> 0 | b \> 0 | Racine réelle valide |
| P2 | discriminant \= 0 | a \> 0 | b \= 0 | Solution unique |
| P3 | discriminant \< 0 | a \> 0 | b \> 0 | Erreur (racine complexe) |

#### **Tableau 2: Données de test pour la fonction `racineReelle1`**

| Entrée a | Entrée b | Entrée c | Sortie racine réelle 1 |
| ----- | ----- | ----- | ----- |
| 1 | 5 | 6 | \-2 |
| 2 | \-4 | 2 | \-3 |
| 1 | \-3 | 2 | \-1 |
| 1 | 2 | 1 | \-1 |

---

### **Test Boîte Noire pour `racineReelle2`**

#### **Tableau 1: Conception Test pour la fonction `racineReelle2`**

| Test | Entrée a | Entrée b | Entrée c | Sortie racine réelle 2 |
| ----- | ----- | ----- | ----- | ----- |
| P1 | discriminant \> 0 | a \> 0 | b \> 0 | Racine réelle valide |
| P2 | discriminant \= 0 | a \> 0 | b \= 0 | Solution unique |
| P3 | discriminant \< 0 | a \> 0 | b \> 0 | Erreur (racine complexe) |

#### **Tableau 2: Données de test pour la fonction `racineReelle2`**

| Entrée a | Entrée b | Entrée c | Sortie racine réelle 2 |
| ----- | ----- | ----- | ----- |
| 1 | 5 | 6 | \-1 |
| 2 | \-4 | 2 | 2 |
| 1 | \-3 | 2 | 1 |
| 1 | 2 | 1 | 3 |

---

### **Test Boîte Noire pour `racineUnique`**

#### **Tableau 1: Conception Test pour la fonction `racineUnique`**

| Test | Entrée a | Entrée b | Sortie racine unique |
| ----- | ----- | ----- | ----- |
| P1 | discriminant \= 0 | a \> 0 | Racine unique valide |
| P2 | discriminant ≠ 0 | a \> 0 | Erreur |

#### **Tableau 2: Données de test pour la fonction `racineUnique`**

| Entrée a | Entrée b | Sortie racine unique |
| ----- | ----- | ----- |
| 1 | 6 | \-3 |
| 2 | \-4 | 2 |
| 1 | \-5 | 2.5 |
| 3 | 9 | \-1.5 |

---

### **Test Boîte Noire pour `racineComplexe1`**

#### **Tableau 1: Conception Test pour la fonction `racineComplexe1`**

| Test | Entrée a | Entrée b | Entrée c | Sortie racine complexe 1 |
| ----- | ----- | ----- | ----- | ----- |
| P1 | discriminant \< 0 | a \> 0 | b \> 0 | Racine complexe valide |
| P2 | discriminant ≥ 0 | a \> 0 | b \> 0 | Erreur (pas de racine complexe) |

#### **Tableau 2: Données de test pour la fonction `racineComplexe1`**

| Entrée a | Entrée b | Entrée c | Sortie racine complexe 1 |
| ----- | ----- | ----- | ----- |
| 1 | 2 | 3 | \[-0.5, \-1.118\] |
| 1 | \-4 | 7 | \[2, \-1.118\] |
| 3 | \-1 | 5 | \[0.166, \-1.632\] |
| 2 | 3 | 6 | \[-1.5, \-1.118\] |

---

### **Test Boîte Noire pour `racineComplexe2`**

#### **Tableau 1: Conception Test pour la fonction `racineComplexe2`**

| Test | Entrée a | Entrée b | Entrée c | Sortie racine complexe 2 |
| ----- | ----- | ----- | ----- | ----- |
| P1 | discriminant \< 0 | a \> 0 | b \> 0 | Racine complexe valide |
| P2 | discriminant ≥ 0 | a \> 0 | b \> 0 | Erreur (pas de racine complexe) |

#### **Tableau 2: Données de test pour la fonction `racineComplexe2`**

| Entrée a | Entrée b | Entrée c | Sortie racine complexe 2 |
| ----- | ----- | ----- | ----- |
| 1 | 2 | 3 | \[-0.5, 1.118\] |
| 1 | \-4 | 7 | \[2, 1.118\] |
| 3 | \-1 | 5 | \[0.166, 1.632\] |
| 2 | 3 | 6 | \[-1.5, 1.118\] |

## **3- TESTS DES FONCTIONS DU MODULE DE CRYPTOGRAPHIE**

## **Tests Boîte Noire des Fonctions**

### **1\. Fonction `Captcha`**

#### **Tableau 1 \- Conception des Tests pour `Captcha`**

| Test | Entrées | Sortie Attendue |
| ----- | ----- | ----- |
| P1 | Deux nombres aléatoires (0-9) | Somme correcte stockée en session |
| P2 | Valeurs limites (0 et 9\) | Somme correcte stockée en session |
| P3 | Valeurs non numériques | ERREUR |

#### **Tableau 2 \- Données de Test pour `Captcha`**

| Test | Num1 | Num2 | Sortie Attendue |
| :---- | :---- | :---- | :---- |
| P1 | 3 | 7 | 10 |
| P2 | 0 | 9 | 9 |
| P3 | "a" | 5 | ERREUR  |

### **2\. Fonction `rc4`**

#### **Tableau 1 \- Conception des Tests pour `rc4`**

| Test | Clé | Texte en clair | Texte chiffré attendu |
| :---- | :---- | :---- | :---- |
| P1 | Clé valide | Texte valide | Texte chiffré correct |
| P2 | Clé trop courte | Texte valide | ERREUR |
| P3 | Clé valide | Texte vide | Texte vide |

#### **Tableau 2 \- Données de Test pour `rc4`**

| Test | Clé | Texte en clair | Texte chiffré attendu |
| :---- | :---- | :---- | :---- |
| P1 | "Key" | "Plaintext" | "BBF316E8D940AF0AD3" |
| P2 | "Wiki" | "pedia" | "6044DB6D41B7" |
| P3 | "Secret" | "Attack at dawn" | "45A01F645FC35B383552544" |
| P4 | "A" | "Message" | ERREUR |

