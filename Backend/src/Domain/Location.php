<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Location
{
    private float $latitude;
    private float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function equals(Location $other): bool
    {
        return $this->latitude === $other->latitude &&
            $this->longitude === $other->longitude;
    }

    // Ces méthodes permettent la sérialisation et désérialisation propre de l'objet
    public function __serialize(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
    }
}
