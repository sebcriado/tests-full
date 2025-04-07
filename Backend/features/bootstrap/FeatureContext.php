<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\App\Calculator;
use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicle;
use Fulll\App\RegisterVehicleHandler;
use Fulll\Domain\Exception\VehicleAlreadyRegisteredInFleetException;
use Fulll\Infra\InMemoryFleetRepository;

class FeatureContext implements Context
{
    private ?Fleet $myFleet = null;
    private ?Fleet $otherFleet = null;
    private ?Vehicle $vehicle = null;
    private ?string $exceptionMessage = null;
    private InMemoryFleetRepository $fleetRepository;

    public function __construct()
    {
        $this->fleetRepository = new InMemoryFleetRepository();
    }

    /**
     * @Given my fleet
     */
    public function myFleet(): void
    {
        $this->myFleet = new Fleet('user-1');
        $this->fleetRepository->save($this->myFleet);
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle(): void
    {
        $this->vehicle = new Vehicle('ABC-123');
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $handler = new RegisterVehicleHandler($this->fleetRepository);
        $handler->execute($this->myFleet->getId(), $this->vehicle->getPlateNumber());
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $handler = new RegisterVehicleHandler($this->fleetRepository);
        $handler->execute($this->myFleet->getId(), $this->vehicle->getPlateNumber());
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        try {
            $handler = new RegisterVehicleHandler($this->fleetRepository);
            $handler->execute($this->myFleet->getId(), $this->vehicle->getPlateNumber());
        } catch (VehicleAlreadyRegisteredInFleetException $e) {
            $this->exceptionMessage = $e->getMessage();
        }
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyFleetVehicles(): void
    {
        $fleet = $this->fleetRepository->getById($this->myFleet->getId());
        if (!$fleet->hasVehicle($this->vehicle->getPlateNumber())) {
            throw new \RuntimeException('Vehicle was not found in the fleet');
        }
    }

    /**
     * @Then I should be informed this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisVehicleWasAlreadyRegisteredIntoMyFleet(): void
    {
        if (!$this->exceptionMessage) {
            throw new \RuntimeException('Expected exception was not thrown');
        }
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser(): void
    {
        $this->otherFleet = new Fleet('user-2');
        $this->fleetRepository->save($this->otherFleet);
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUserSFleet(): void
    {
        $handler = new RegisterVehicleHandler($this->fleetRepository);
        $handler->execute($this->otherFleet->getId(), $this->vehicle->getPlateNumber());
    }
}
