<?php

declare(strict_types=1);

namespace Fulll\App;

use Fulll\Domain\FleetRepository;
use Fulll\Domain\Location;

class ParkVehicleHandler
{
    private FleetRepository $fleetRepository;

    public function __construct(FleetRepository $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    public function execute(string $fleetId, string $plateNumber, Location $location): void
    {
        $fleet = $this->fleetRepository->getById($fleetId);

        if (!$fleet) {
            throw new \InvalidArgumentException("Fleet not found");
        }

        $fleet->parkVehicle($plateNumber, $location);
        $this->fleetRepository->save($fleet);
    }
}
