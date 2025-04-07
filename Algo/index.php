<?php

declare(strict_types=1);

/**
 * Génère une séquence FizzBuzz de 1 à N.
 *
 * @param int $max La limite supérieure de la séquence.
 * @return array<int, string|int> La séquence FizzBuzz.
 */
function generateFizzBuzz(int $max): array
{
    return array_map(
        fn (int $number): string|int => match (0) {
            $number % 15 => 'FizzBuzz',
            $number % 3 => 'Fizz',
            $number % 5 => 'Buzz',
            default => $number,
        },
        range(1, $max)
    );
}

/**
 * Affiche la séquence FizzBuzz.
 *
 * @param int $max La limite supérieure de la séquence.
 * @return void
 */
function printFizzBuzz(int $max): void
{
    foreach (generateFizzBuzz($max) as $value) {
        echo $value . PHP_EOL;
    }
}

$n = 50;
printFizzBuzz($n);
