<?php

declare(strict_types=1);

namespace Fulll\Domain;

use Fulll\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use Fulll\Domain\Exception\VehicleNotInFleetException;

class Fleet
{
    private string $id;
    private string $userId;
    private array $vehicles = [];
    private array $vehicleLocations = [];

    public function __construct(string $userId)
    {
        $this->id = uniqid('fleet_');
        $this->userId = $userId;
    }

    public function getId(): string
    {
        return $this->id;
    }
    public function getUserId(): string
    {
        return $this->userId;
    }

    public function registerVehicle(string $plateNumber): void
    {
        if ($this->hasVehicle($plateNumber)) {
            throw new \Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException("Vehicle {$plateNumber} is already registered in this fleet");
        }

        $this->vehicles[] = $plateNumber;
    }

    public function hasVehicle(string $plateNumber): bool
    {
        return in_array($plateNumber, $this->vehicles, true);
    }

    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    public function parkVehicle(string $plateNumber, Location $location): void
    {
        if (!$this->hasVehicle($plateNumber)) {
            throw new VehicleNotInFleetException("Vehicle {$plateNumber} is not in the fleet");
        }

        if (isset($this->vehicleLocations[$plateNumber]) && $this->vehicleLocations[$plateNumber]->equals($location)) {
            throw new VehicleAlreadyParkedAtLocationException("Vehicle {$plateNumber} is already parked at this location");
        }

        $this->vehicleLocations[$plateNumber] = $location;
    }

    public function getVehicleLocation(string $plateNumber): ?Location
    {
        if (!$this->hasVehicle($plateNumber)) {
            throw new VehicleNotInFleetException("Vehicle {$plateNumber} is not in the fleet");
        }

        return $this->vehicleLocations[$plateNumber] ?? null;
    }
}
