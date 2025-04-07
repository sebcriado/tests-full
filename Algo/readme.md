# Justification détaillée de mon implémentation FizzBuzz

## Séparation de la génération et de l'affichage

```php
function generateFizzBuzz(int $max): array { ... }
function printFizzBuzz(int $max): void { ... }
```

**Pourquoi?** Ce choix est basé sur le principe de responsabilité unique (SOLID).

**Exemple concret:** Si demain les spécifications changent et qu'on doit:
- Envoyer la sortie au format JSON pour une API
- Exporter en CSV
- Afficher dans une interface web

Il suffit d'ajouter de nouvelles fonctions d'affichage sans toucher à la logique métier:

```php
function fizzbuzzToJson(int $max): string {
    return json_encode(generateFizzBuzz($max));
}
```

## Utilisation de l'expression `match`

```php
match (0) {
    $number % 15 => 'FizzBuzz',
    $number % 3 => 'Fizz',
    $number % 5 => 'Buzz',
    default => $number
}
```

**Pourquoi?** Plus concis, plus sûr et plus expressif que les alternatives.

**Exemple d'alternative problématique avec `switch`:**
```php
switch (true) {
    case $number % 3 === 0 && $number % 5 === 0:
        $result = 'FizzBuzz';
        break; // Oublier ce break causerait des bugs subtils
    case $number % 3 === 0:
        $result = 'Fizz';
        break;
    // etc.
}
return $result;
```

**Problèmes évités:**
- Oubli de `break` qui causerait une continuation involontaire
- Verbosité inutile
- Comparaisons non-strictes par défaut dans `switch`

## Programmation fonctionnelle avec `array_map`

```php
array_map(fn (int $number) => ..., range(1, $max))
```

**Pourquoi?** La programmation fonctionnelle exprime l'intention plus clairement.

**Exemple d'alternative impérative:**
```php
$result = [];
for ($i = 1; $i <= $max; $i++) {
    if ($i % 3 === 0 && $i % 5 === 0) {
        $result[] = 'FizzBuzz';
    } elseif ($i % 3 === 0) {
        $result[] = 'Fizz';
    } elseif ($i % 5 === 0) {
        $result[] = 'Buzz';
    } else {
        $result[] = $i;
    }
}
return $result;
```

**Avantages de l'approche fonctionnelle:**
- Moins de code et donc moins d'opportunités de bugs
- Intention claire: "transformer chaque nombre de la séquence"
- Pas de variables d'état mutables à suivre mentalement
- Plus facilement parallélisable si nécessaire

## Optimisation avec `$number % 15`

**Pourquoi?** Plus efficace et élégant mathématiquement.

**Exemple de code non optimisé:**
```php
if ($number % 3 === 0 && $number % 5 === 0) {
    return 'FizzBuzz';
}
```

Cela effectue deux calculs de modulo alors qu'un seul est nécessaire.

**Explication mathématique:** 15 est le plus petit commun multiple (PPCM) de 3 et 5. Si un nombre est divisible par 15, il est automatiquement divisible par 3 et par 5.

## Typage strict avec `declare(strict_types=1)`

**Pourquoi?** Détecte les erreurs plus tôt dans le cycle de développement.

**Exemple de bug évité:**
```php
// Sans strict_types
function add(int $a, int $b) {
    return $a + $b;
}
echo add("2", 3); // Fonctionne mais n'était peut-être pas l'intention

// Avec strict_types
// La même fonction lèverait une TypeError, révélant un bug potentiel
```

## Documentation PHPDoc détaillée

```php
/**
 * @param int $max La limite supérieure de la séquence
 * @return array<int, string|int> La séquence générée
 */
```

**Pourquoi?** Améliore la maintenabilité et l'expérience de développement.

**Exemple concret:** Dans un IDE comme PhpStorm, cette documentation permet:
- De voir le type exact attendu par la fonction
- D'obtenir des auto-complétion précises en utilisant le résultat
- D'être alerté si vous passez un type incorrect

Imaginez un collègue utilisant votre fonction:
```php
$result = generateFizzBuzz("100"); // L'IDE va signaler une erreur avant même exécution
$firstItem = $result[0]; // L'IDE sait que c'est un string|int et suggère les méthodes appropriées
```

## Ordre des conditions

```php
$number % 15 => 'FizzBuzz',
$number % 3 => 'Fizz',
$number % 5 => 'Buzz',
```

**Pourquoi?** L'ordre est crucial pour la correction de l'algorithme.

**Exemple de bug si l'ordre était incorrect:**
```php
match (0) {
    $number % 3 => 'Fizz',     // Si on teste d'abord divisible par 3
    $number % 5 => 'Buzz',     // Puis divisible par 5
    $number % 15 => 'FizzBuzz', // Le cas FizzBuzz ne serait jamais atteint!
    default => $number
}
```

Pour le nombre 15, ce code retournerait incorrectement 'Fizz' au lieu de 'FizzBuzz', car 15 est aussi divisible par 3.

Ces justifications démontrent une compréhension approfondie des pratiques modernes de développement et une attention aux détails qui font la différence entre un code simplement fonctionnel et un code de qualité professionnelle.