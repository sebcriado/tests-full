<?php

declare(strict_types=1);

namespace Fulll\App;

use Fulll\Domain\FleetRepository;

class RegisterVehicleHandler
{
    private FleetRepository $fleetRepository;

    public function __construct(FleetRepository $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    public function execute(string $fleetId, string $plateNumber): void
    {
        $fleet = $this->fleetRepository->getById($fleetId);

        if (!$fleet) {
            throw new \InvalidArgumentException("Fleet not found");
        }

        $fleet->registerVehicle($plateNumber);
        $this->fleetRepository->save($fleet);
    }
}
