<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Fleet
{
    private string $id;
    private string $userId;
    private array $vehicles = [];

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
}
