<?php

namespace App\Services\Hotel;

class StarStrategy implements CombinationStrategyInterface
{
    public function generate(array $requestedRooms, array $availabilities, array $inventory): array
    {
        $combinations = [];

        $backtrack = function ($i, $current, $usedInventory, $price) use (
            &$backtrack, $requestedRooms, $availabilities, $inventory, &$combinations
        ) {
            if ($i === count($requestedRooms)) {
                $combinations[] = [
                    'rooms' => $current,
                    'price' => $price,
                ];
                return;
            }

            foreach ($availabilities as $room) {
                $roomName = $room['name'];
                if (($usedInventory[$roomName] ?? 0) + 1 > $inventory[$roomName]) {
                    continue;
                }

                if ($room['bedCount'] < $requestedRooms[$i]['guests']) {
                    continue;
                }

                $usedInventory[$roomName] = ($usedInventory[$roomName] ?? 0) + 1;
                $current[] = $room['index'];

                $backtrack($i + 1, $current, $usedInventory, $price + $room['price']);

                array_pop($current);
                $usedInventory[$roomName]--;
            }
        };

        $backtrack(0, [], [], 0);
        return $combinations;
    }
}

