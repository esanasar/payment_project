<?php

namespace Tests\Unit\HotelCombination;

use Tests\TestCase;
use App\Services\HotelCombination\HotelCombinationContext;
use App\Services\HotelCombination\StarStrategy;

class HotelCombinationContextTest extends TestCase
{
    public function test_context_uses_strategy_to_generate_combinations()
    {
        $strategy = new StarStrategy();
        $context = new HotelCombinationContext($strategy);

        $requestedRooms = [
            ['guests' => 2],
        ];

        $availabilities = [[
                               ['index' => 1, 'name' => 'Room A', 'bedCount' => 2, 'price' => 20, 'board' => 'room_only'],
                           ]];

        $inventory = ['Room A' => 1];

        $combinations = $context->getCombinations($requestedRooms, $availabilities, $inventory);

        $this->assertIsArray($combinations);
        $this->assertNotEmpty($combinations);
        $this->assertArrayHasKey('rooms', $combinations[0]);
        $this->assertArrayHasKey('price', $combinations[0]);
    }
}
