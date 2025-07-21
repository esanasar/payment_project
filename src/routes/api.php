<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseAttachmentController;
use App\Http\Controllers\PaymentController;

Route::post('/expenses', [ExpenseController::class, 'store']);
Route::get('/expenses', [ExpenseController::class, 'index']);
Route::post('/expenses/approve', [ExpenseController::class, 'approve']);
Route::post('/expenses/reject', [ExpenseController::class, 'reject']);

Route::get('/attachments/{attachment}/download', [ExpenseAttachmentController::class, 'download']);

Route::post('/payments/process-selected', [PaymentController::class, 'processSelected']);
