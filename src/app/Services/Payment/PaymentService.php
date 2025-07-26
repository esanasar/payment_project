<?php

namespace App\Services\Payment;

use App\Models\Expense;
use App\Models\Payment;
use App\Services\Payment\Factory\PaymentStrategyFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\ExpenseStatus;
use Throwable;

class PaymentService
{
    
    public function processPayment(Expense $expense): Payment
    {
        Log::info("Attempting to process payment for expense ID: {$expense->id}");

        $payment = Payment::create([
            'expense_id' => $expense->id,
            'status' => 'pending',
            'bank_name' => 'unknown', // Will be updated after strategy selection
        ]);

        Log::info("shaba {$expense->shaba_number}" );

        try {
            DB::beginTransaction();

            $strategy = PaymentStrategyFactory::make($expense->shaba_number);
            
            $response = $strategy->pay($expense);

            if ($response['status'] === 'success') {
                $payment->update([
                    'bank_name' => class_basename($strategy),
                    'status' => 'success',
                    'transaction_number' => $response['transaction_id'],
                    'response_log' => $response,
                ]);

                $expense->update([
                    'status' => ExpenseStatus::PAID
                ]);

                Log::info("Payment successful for expense ID: {$expense->id}", $response);

                DB::commit();

            } else {
                throw new \Exception($response['message'] ?? 'Unknown payment failure.');
            }
        } catch (Throwable $e) {
            $payment->update([
                'status' => 'failed',
                'error_log' => $e->getMessage(),
            ]);

            DB::rollback();

            Log::error("Payment failed for expense ID: {$expense->id}. Error: {$e->getMessage()}");
        }
        
        return $payment;
    }
} 