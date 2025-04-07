<?php

declare(strict_types=1);

namespace Fulll\Domain;

interface FleetRepository
{
    public function save(Fleet $fleet): void;
    public function getById(string $id): ?Fleet;
}
