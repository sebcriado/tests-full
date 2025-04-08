<?php

declare(strict_types=1);

namespace Fulll\App;

use Fulll\Domain\Fleet;
use Fulll\Domain\FleetRepository;

class CreateFleetHandler
{
    private FleetRepository $fleetRepository;

    public function __construct(FleetRepository $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    public function execute(string $userId): string
    {
        $fleet = new Fleet($userId);
        $this->fleetRepository->save($fleet);

        return $fleet->getId();
    }
}
