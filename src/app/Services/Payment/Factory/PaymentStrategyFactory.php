<?php

namespace App\Services\Payment\Factory;

use App\Services\Payment\Strategies\Bank1Strategy;
use App\Services\Payment\Strategies\Bank2Strategy;
use App\Services\Payment\Strategies\Bank3Strategy;
use App\Services\Payment\Strategies\PaymentStrategyInterface;
use InvalidArgumentException;

class PaymentStrategyFactory
{
    /**
     * @var array<string, class-string<PaymentStrategyInterface>>
     */
    protected static array $strategyMap = [
        '11' => Bank1Strategy::class,
        '12' => Bank2Strategy::class,
        '13' => Bank3Strategy::class,
    ];

    /**
     * Create a payment strategy instance based on the sheba number.
     *
     * @param string $shebaNumber
     * @return PaymentStrategyInterface
     */
    public static function make(string $shebaNumber): PaymentStrategyInterface
    {
        $bankCode = substr($shebaNumber, 0, 2);

        if (!isset(self::$strategyMap[$bankCode])) {
            throw new InvalidArgumentException("No payment strategy found for the given sheba number.");
        }

        $strategyClass = self::$strategyMap[$bankCode];
        return new $strategyClass();
    }
} 