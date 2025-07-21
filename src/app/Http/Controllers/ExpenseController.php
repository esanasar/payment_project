<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessExpensesRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Expense;
use App\Services\Expense\ExpenseService;

class ExpenseController extends Controller
{
    protected ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index()
    {
        // Simple pagination for now. Can be improved with filters.
        $expenses = Expense::with(['user', 'category', 'attachments'])
            ->where('status', 'pending')
            ->latest()
            ->paginate();

        return response()->json($expenses);
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = $this->expenseService->createExpense(
            $request->validated(),
            $request->file('attachment')
        );


        return response()->json($expense->load('attachments'), 201);
    }

    public function approve(ProcessExpensesRequest $request)
    {
        $approvedExpenses = $this->expenseService->approveExpenses(
            $request->validated()['expense_ids']
        );

        return response()->json([
            'message' => 'Expenses approved successfully.',
            'data' => $approvedExpenses
        ]);
    }

    public function reject(ProcessExpensesRequest $request)
    {
        $validated = $request->validated();
        $rejectedExpenses = $this->expenseService->rejectExpenses(
            $validated['expense_ids'],
            $validated['rejection_reason'] ?? null
        );

        return response()->json([
            'message' => 'Expenses rejected successfully.',
            'data' => $rejectedExpenses
        ]);
    }
} 