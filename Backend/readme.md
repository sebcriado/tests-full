# Fleet Management System

## Fonctionnalités

Ce système de gestion de flotte permet aux utilisateurs de :

### Créer et gérer des flottes de véhicules
- Une flotte est identifiée par un ID unique et appartient à un utilisateur spécifique.
- Plusieurs utilisateurs peuvent avoir leurs propres flottes.

### Enregistrer des véhicules dans une flotte
- Les véhicules sont identifiés par leur numéro d'immatriculation.
- Un même véhicule ne peut être enregistré qu'une seule fois dans une flotte donnée.
- Un véhicule peut appartenir à plusieurs flottes différentes (appartenant à différents utilisateurs).

### Localiser des véhicules
- Les utilisateurs peuvent indiquer l'emplacement (coordonnées géographiques) de leurs véhicules.
- Le système empêche d'enregistrer un véhicule au même emplacement deux fois consécutives.
- Chaque véhicule ne peut avoir qu'un seul emplacement connu à la fois.

---

## Architecture et choix techniques

### Domain-Driven Design (DDD)
L'application est structurée selon les principes du Domain-Driven Design avec trois couches principales :

- **Domaine** : Contient les règles métier principales.
- **Application** : Contient les cas d'utilisation.
- **Infrastructure** : Interagit avec les systèmes externes (bases de données, interfaces).

Cette séparation permet :
- Une meilleure isolation des règles métier (domaine).
- Une plus grande maintenabilité du code.
- Des tests plus ciblés et efficaces.

---

### Entités et Objets Valeur

#### Entités avec identité propre :
- **Fleet** : Collection de véhicules appartenant à un utilisateur.
- **Vehicle** : Identifié par son numéro d'immatriculation.

#### Objets Valeur (immuables, sans identité propre) :
- **Location** : Coordonnées géographiques (latitude, longitude).

---

### Pattern Repository

Le système utilise le pattern **Repository** pour abstraire le stockage et l'accès aux entités :

- **FleetRepository** : Interface définissant les opérations sur les flottes.
- **InMemoryFleetRepository** : Implémentation en mémoire pour les tests.

Ce pattern permet :
- De découpler le domaine de l'infrastructure de persistance.
- De faciliter les tests et permettre de changer facilement l'implémentation (base de données, API, etc.).

---

### Pattern Command Handler

Les cas d'utilisation sont implémentés via des handlers de commande :
- **RegisterVehicleHandler** : Gère l'enregistrement d'un véhicule.
- **ParkVehicleHandler** : Gère le stationnement d'un véhicule.

Avantages de cette approche :
- Séparation claire des responsabilités.
- Facilité de traçage des actions dans le système.
- Extensibilité (ajout de validation, logging, etc.).

---

### Gestion des exceptions

Des exceptions spécifiques au domaine ont été créées pour représenter des cas d'erreur métier :
- **VehicleAlreadyRegisteredInFleetException**
- **VehicleAlreadyParkedAtLocationException**
- **VehicleNotInFleetException**

Cette approche permet de :
- Séparer les erreurs techniques des erreurs métier.
- Faciliter la gestion des cas d'erreur dans les couches supérieures.
- Améliorer la lisibilité des règles métier.

---

### Tests BDD avec Behat

Les fonctionnalités sont décrites et testées avec **Behat**, un framework de **BDD** (Behavior-Driven Development) :
- `register_vehicle.feature` : Scénarios d'enregistrement de véhicules.
- `park_vehicle.feature` : Scénarios de stationnement de véhicules.
- `FeatureContext.php` : Implémentation des étapes de test.

Avantages du BDD :
- Documentation vivante des fonctionnalités.
- Collaboration facilitée entre développeurs et non-développeurs.
- Tests qui reflètent les exigences réelles du système.

---

## Principes de conception appliqués

- **Principe de responsabilité unique (SRP)** : Chaque classe a une seule responsabilité bien définie.
- **Principe d'ouverture/fermeture (OCP)** : L'architecture permet d'étendre les fonctionnalités sans modifier le code existant.
- **Principe de substitution de Liskov (LSP)** : Les implémentations de repositories peuvent être échangées sans affecter le comportement.
- **Principe de ségrégation d'interface (ISP)** : Les interfaces sont spécifiques à leurs clients (pas d'interfaces génériques).
- **Principe d'inversion de dépendance (DIP)** : Les modules haut niveau (App) ne dépendent pas des modules bas niveau (Infra).

---

## Installation et utilisation

### Prérequis
- **PHP** 8.0 ou supérieur.
- **Composer**.

---

### Installation et exécution des tests

1. Cloner le dépôt :
   ```bash
   git clone <url-du-repo>
   cd <nom-du-repo>
   ```

2. Installer les dépendances :
   ```bash
   composer install
   ```

3. Exécuter les tests :
   ```bash
   vendor/bin/behat
   ```

---

## Conclusion

Ce système de gestion de flotte démontre l'application de principes de conception modernes et robustes pour créer une application évolutive et maintenable. L'architecture en couches et l'approche **DDD** permettent une séparation claire des préoccupations, facilitant l'ajout de nouvelles fonctionnalités et l'évolution du système dans le temps.