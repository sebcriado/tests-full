<?php

declare(strict_types=1);

namespace Fulll\Infra;

use Fulll\Domain\Fleet;
use Fulll\Domain\FleetRepository;

class FileSystemFleetRepository implements FleetRepository
{
    private string $dataDir;

    public function __construct(string $dataDir)
    {
        $this->dataDir = $dataDir;

        // Création du dossier de données s'il n'existe pas
        if (!is_dir($this->dataDir)) {
            if (!mkdir($this->dataDir, 0755, true) && !is_dir($this->dataDir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->dataDir));
            }
        }
    }

    public function save(Fleet $fleet): void
    {
        $fleetData = serialize($fleet);
        file_put_contents($this->getFleetFilePath($fleet->getId()), $fleetData);
    }

    public function getById(string $id): ?Fleet
    {
        $filePath = $this->getFleetFilePath($id);

        if (!file_exists($filePath)) {
            return null;
        }

        $fleetData = file_get_contents($filePath);
        return $fleetData !== false ? unserialize($fleetData) : null;
    }

    private function getFleetFilePath(string $id): string
    {
        return $this->dataDir . '/' . $id . '.data';
    }
}
