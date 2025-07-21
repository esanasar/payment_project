<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPaymentJob;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

    public function processSelected(Request $request): JsonResponse
    {
        $expenseIds = $request->input('expense_ids', []);
        if (!is_array($expenseIds) || empty($expenseIds)) {
            return response()->json(['message' => 'هیچ موردی انتخاب نشده است.'], 422);
        }

        $approvedExpenses = Expense::whereIn('id', $expenseIds)
            ->where('status', 'approved')
            ->whereDoesntHave('payment')
            ->get();

        
        foreach ($approvedExpenses as $expense) {
            Log::info("Log 1"); // <-- DEBUG LOG
            ProcessPaymentJob::dispatch($expense->id);
        }

        return response()->json([
            'message' => "{$approvedExpenses->count()} درخواست به صف پرداخت ارسال شد.",
        ]);
    }
}
