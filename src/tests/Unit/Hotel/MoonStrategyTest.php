<?php

namespace Tests\Unit\HotelCombination;

use Tests\TestCase;
use App\Services\HotelCombination\MoonStrategy;

class MoonStrategyTest extends TestCase
{
    public function test_generates_combinations_correctly()
    {
        $strategy = new MoonStrategy();

        $requestedRooms = [
            ['guests' => 1],
            ['guests' => 2],
        ];

        $availabilities = [[
                               ['index' => 1, 'name' => 'Room X', 'bedCount' => 1, 'price' => 25, 'board' => 'room_only'],
                               ['index' => 2, 'name' => 'Room X', 'bedCount' => 1, 'price' => 28, 'board' => 'bed_and_breakfast'],
                               ['index' => 3, 'name' => 'Room Y', 'bedCount' => 2, 'price' => 30, 'board' => 'room_only'],
                               ['index' => 4, 'name' => 'Room Y', 'bedCount' => 2, 'price' => 35, 'board' => 'full_board'],
                               ['index' => 5, 'name' => 'Room Z', 'bedCount' => 3, 'price' => 40, 'board' => 'all_inclusive'],
                           ]];

        $inventory = [
            'Room X' => 3,
            'Room Y' => 1,
            'Room Z' => 1,
        ];

        $combinations = $strategy->generate($requestedRooms, $availabilities, $inventory);

        $this->assertIsArray($combinations, 'Combinations should be an array');
        $this->assertNotEmpty($combinations, 'Combinations should not be empty');

        foreach ($combinations as $combo) {
            $this->assertArrayHasKey('rooms', $combo, 'Combination should have rooms key');
            $this->assertArrayHasKey('price', $combo, 'Combination should have price key');

            $this->assertIsArray($combo['rooms']);
            $this->assertCount(2, $combo['rooms'], 'Each combination must contain exactly 2 room indices');
            $this->assertIsNumeric($combo['price']);
        }
    }
}
