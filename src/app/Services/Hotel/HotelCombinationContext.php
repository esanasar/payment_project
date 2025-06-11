<?php

namespace App\Services\Hotel;

use App\Services\Hotel\CombinationStrategyInterface;

class HotelCombinationContext
{
    protected CombinationStrategyInterface $strategy;

    public function __construct(CombinationStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function getCombinations(array $requestedRooms, array $availabilities, array $inventory): array
    {
        return $this->strategy->generate($requestedRooms, $availabilities, $inventory);
    }
}
