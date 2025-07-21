<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'national_code', 'email'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
