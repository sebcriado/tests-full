<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Vehicle
{
    private string $plateNumber;

    public function __construct(string $plateNumber)
    {
        if (empty($plateNumber)) {
            throw new \InvalidArgumentException("Vehicle plate number cannot be empty");
        }
        $this->plateNumber = $plateNumber;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function equals(Vehicle $other): bool
    {
        return $this->plateNumber === $other->getPlateNumber();
    }
}
