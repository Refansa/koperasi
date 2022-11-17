<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $fillable = [
        'user_id',
        'deposit_amount',
        'loan_amount',
    ];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}