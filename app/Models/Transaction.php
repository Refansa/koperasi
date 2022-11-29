<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deposit()
    {
        return $this->hasOne(Deposit::class);
    }

    public function withdraw()
    {
        return $this->hasOne(Withdraw::class);
    }

    public function loan()
    {
        return $this->hasOne(Loan::class);
    }

    public function installment()
    {
        return $this->hasOne(Installment::class);
    }
}
