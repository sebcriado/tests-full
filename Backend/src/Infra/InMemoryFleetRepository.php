<?php

declare(strict_types=1);

namespace Fulll\Infra;

use Fulll\Domain\Fleet;
use Fulll\Domain\FleetRepository;

class InMemoryFleetRepository implements FleetRepository
{
    private array $fleets = [];

    public function save(Fleet $fleet): void
    {
        $this->fleets[$fleet->getId()] = $fleet;
    }

    public function getById(string $id): ?Fleet
    {
        return $this->fleets[$id] ?? null;
    }
}
