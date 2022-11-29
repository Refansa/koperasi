<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'loan_id',
        'installment_tracker_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function installment_tracker()
    {
        return $this->belongsTo(InstallmentTracker::class);
    }
}
