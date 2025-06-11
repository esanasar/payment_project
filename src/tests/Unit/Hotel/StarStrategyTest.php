<?php

namespace Tests\Unit\HotelCombination;

use Tests\TestCase;
use App\Services\HotelCombination\StarStrategy;

class StarStrategyTest extends TestCase
{
    public function test_generates_valid_combinations()
    {
        $strategy = new StarStrategy();

        $requestedRooms = [
            ['guests' => 1],
            ['guests' => 1],
        ];

        $availabilities = [[
                               ['index' => 1, 'name' => 'Room A', 'bedCount' => 1, 'price' => 10, 'board' => 'room_only'],
                               ['index' => 2, 'name' => 'Room A', 'bedCount' => 1, 'price' => 12, 'board' => 'bed_and_breakfast'],
                               ['index' => 3, 'name' => 'Room B', 'bedCount' => 2, 'price' => 15, 'board' => 'room_only'],
                           ]];

        $inventory = [
            'Room A' => 2,
            'Room B' => 1,
        ];

        $combinations = $strategy->generate($requestedRooms, $availabilities, $inventory);

        $this->assertIsArray($combinations);
        $this->assertNotEmpty($combinations);

        foreach ($combinations as $combination) {
            $this->assertArrayHasKey('rooms', $combination);
            $this->assertArrayHasKey('price', $combination);

            $this->assertIsArray($combination['rooms']);
            $this->assertIsNumeric($combination['price']);
            $this->assertCount(2, $combination['rooms']); // چون دو اتاق خواستیم
        }
    }
}
