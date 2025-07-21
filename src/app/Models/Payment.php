<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'bank_name',
        'status',
        'response_log',
        'error_log',
        'retry_count',
        'transaction_number'
    ];

    protected $casts = [
        'response_log' => 'array',
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
