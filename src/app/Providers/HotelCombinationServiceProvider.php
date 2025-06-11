<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Hotel\HotelCombinationContext;
use App\Services\Hotel\MoonStrategy;
use App\Services\Hotel\StarStrategy;

class HotelCombinationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(HotelCombinationContext::class, function ($app) {
            $type = request()->query('name', 'star');
            $strategy = match ($type) {
                'moon' => new MoonStrategy(),
                default => new StarStrategy(),
            };

            return new HotelCombinationContext($strategy);
        });
    }
}
