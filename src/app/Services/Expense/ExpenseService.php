<?php

namespace App\Services\Expense;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Events\ExpenseRejected;

class ExpenseService
{
   
    public function createExpense(array $data, ?UploadedFile $attachment = null): Expense
    {
        $user = User::where('national_code', $data['national_code'])->firstOrFail();

        return DB::transaction(function () use ($data, $user, $attachment) {
            $expense = Expense::create([
                'user_id' => $user->id,
                'category_id' => $data['expense_category_id'],
                'description' => $data['description'],
                'amount' => $data['amount'],
                'shaba_number' => $data['shaba_number'],
                'status' => 'pending',
            ]);

            if ($attachment) {
                $path = $attachment->store('attachments', 'public');
                $expense->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $attachment->getClientOriginalName(),
                ]);
            }

            return $expense;
        });
    }

    public function approveExpenses(array $expenseIds): Collection
    {
        $expenses = Expense::whereIn('id', $expenseIds)->where('status', 'pending')->get();

        DB::transaction(function () use ($expenses) {
            foreach ($expenses as $expense) {
                $expense->update(['status' => 'approved']);
                // TODO: Dispatch notification event/job
            }
        });

        return $expenses;
    }

    public function rejectExpenses(array $expenseIds, ?string $rejectionReason = null): Collection
    {
        $expenses = Expense::whereIn('id', $expenseIds)->where('status', 'pending')->get();

        DB::transaction(function () use ($expenses, $rejectionReason) {
            foreach ($expenses as $expense) {
                $expense->update([
                    'status' => 'rejected',
                    'rejection_reason' => $rejectionReason
                ]);
                
                ExpenseRejected::dispatch($expense);
            }
        });

        return $expenses;
    }
} 