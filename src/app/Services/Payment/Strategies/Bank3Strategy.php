<?php

namespace App\Services\Payment\Strategies;

use App\Models\Expense;
use Illuminate\Support\Facades\Log;

class Bank3Strategy implements PaymentStrategyInterface
{
    public function pay(Expense $expense): array
    {
        Log::info("Processing payment for expense ID {$expense->id} via Bank 3.");

        // Simulate API call to Bank 3
        $isSuccess = true;
        $response = [
            'status' => 'success',
            'transaction_id' => 'B3-' . uniqid(),
            'message' => 'Payment processed successfully by Bank 3.'
        ];

        return $response;
    }
} 