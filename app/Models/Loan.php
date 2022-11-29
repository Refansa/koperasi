<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'loan_period',
        'interest',
        'note',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function installment_tracker()
    {
        return $this->hasOne(InstallmentTracker::class);
    }
}
