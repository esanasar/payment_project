<?php

namespace App\Jobs;

use App\Enums\ExpenseStatus;
use App\Models\Expense;
use App\Services\Payment\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $expenseId;

    public function __construct($expenseId)
    {
        $this->expenseId = $expenseId;
    }

    public function handle(PaymentService $paymentService): void
    {
        $expense = Expense::find($this->expenseId);

        if (!$expense) {
            Log::warning("Expense with ID {$this->expenseId} not found in job.");
            return;
        }

        if ($expense->status === ExpenseStatus::APPROVED) {
            Log::info("Condition MET. Processing payment for expense ID: {$expense->id}");
            $paymentService->processPayment($expense);
        } else {
            Log::warning("Condition NOT MET. Status was '{$expense->status->value}'. Skipping payment for expense ID: {$expense->id}");
        }
    }
}