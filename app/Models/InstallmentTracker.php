<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallmentTracker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loan_id',
        'installment_of',
        'installment_needed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
