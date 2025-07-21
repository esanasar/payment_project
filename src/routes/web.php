<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ExpenseController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ExpenseController::class, 'pending'])->name('expenses.pending');

Route::prefix('expenses')->name('expenses.')->group(function () {
    // Form to create a new expense
    Route::get('/create', [ExpenseController::class, 'create'])->name('create');

    // Lists of expenses
    Route::get('/pending', [ExpenseController::class, 'pending'])->name('pending');
    Route::get('/approved', [ExpenseController::class, 'approved'])->name('approved');
});

