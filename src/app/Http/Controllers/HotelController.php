<?php

namespace App\Http\Controllers;

use App\Services\Hotel\HotelCombinationContext;
use Illuminate\Support\Facades\Http;

class HotelController
{
    public function show(HotelCombinationContext $context)
    {
        $data = Http::get('https://administrator.luxota.network/api/fake-hotels?name=' . request('name'))->json();

        $combinations = $context->getCombinations(
            $data['requestedRooms'],
            $data['availabilities'],
            $data['inventory']
        );

        return response()->json(['combinations' => $combinations]);
    }
}