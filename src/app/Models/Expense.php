<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ExpenseStatus;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'description',
        'amount',
        'shaba_number',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'status' => ExpenseStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
    
    public function attachments()
    {
        return $this->hasMany(ExpenseAttachment::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
