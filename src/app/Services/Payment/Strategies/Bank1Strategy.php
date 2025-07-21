<?php

namespace App\Services\Payment\Strategies;

use App\Models\Expense;
use Illuminate\Support\Facades\Log;

class Bank1Strategy implements PaymentStrategyInterface
{
    public function pay(Expense $expense): array
    {
        Log::info("Processing payment for expense ID {$expense->id} via Bank 1.");

        // Simulate API call to Bank 1
        // In a real scenario, this would involve an HTTP client call.
        // For this test, we'll simulate a successful payment.

        $isSuccess = true; // Simulate success
        $response = [
            'status' => 'success',
            'transaction_id' => 'B1-' . uniqid(),
            'message' => 'Payment processed successfully by Bank 1.'
        ];

        if (!$isSuccess) {
            // $response = [
            //     'status' => 'failed',
            //     'error_code' => 'B1-500',
            //     'message' => 'Bank 1 service is unavailable.'
            // ];
        }

        return $response;
    }
} 