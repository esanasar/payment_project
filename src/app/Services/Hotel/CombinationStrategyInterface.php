<?php

namespace App\Services\Hotel;

interface CombinationStrategyInterface
{
    public function generate(array $requestedRooms, array $availabilities, array $inventory): array;
}