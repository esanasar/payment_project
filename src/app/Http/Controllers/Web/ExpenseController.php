<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    public function create()
    {
        $users = User::all();
        $categories = ExpenseCategory::all();
        return view('expenses.create', compact('users', 'categories'));
    }

    public function pending()
    {
        $expenses = Expense::with('user', 'category', 'attachments')
            ->where('status', 'pending')
            ->latest()
            ->get();
        return view('expenses.pending', compact('expenses'));
    }

    public function approved()
    {
        $expenses = Expense::with('user', 'category', 'attachments', 'payment')
            ->where('status', 'approved')
            ->latest()
            ->get();
        return view('expenses.approved', compact('expenses'));
    }
} 