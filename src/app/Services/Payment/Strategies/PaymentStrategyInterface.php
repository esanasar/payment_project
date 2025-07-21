<?php

namespace App\Services\Payment\Strategies;

use App\Models\Expense;

interface PaymentStrategyInterface
{
    /**
     * Process the payment for a given expense.
     *
     * @param Expense $expense
     * @return array
     */
    public function pay(Expense $expense): array;
}
