<?php

namespace App\Services\Payment\Strategies;

use App\Models\Expense;
use Illuminate\Support\Facades\Log;

class Bank2Strategy implements PaymentStrategyInterface
{
    public function pay(Expense $expense): array
    {
        Log::info("Processing payment for expense ID {$expense->id} via Bank 2.");

        // Simulate API call to Bank 2
        $isSuccess = true;
        $response = [
            'status' => 'success',
            'transaction_id' => 'B2-' . uniqid(),
            'message' => 'Payment processed successfully by Bank 2.'
        ];

        return $response;
    }
} 