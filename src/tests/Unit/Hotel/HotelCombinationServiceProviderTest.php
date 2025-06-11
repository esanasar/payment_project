<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\App;
use App\Services\HotelCombination\HotelCombinationContext;

class HotelCombinationServiceProviderTest extends TestCase
{
    public function test_context_is_resolved_from_container()
    {
        // ساخت یک request fake با name=star
        $this->app['request']->query->set('name', 'star');

        $context = App::make(HotelCombinationContext::class);

        $this->assertInstanceOf(HotelCombinationContext::class, $context);
    }
}
