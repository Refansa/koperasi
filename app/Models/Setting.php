<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attribute that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'minimum_basic_cost',
        'minimum_mandatory_cost',
        'maximum_loan_amount',
        'saving_limit_for_loan',
    ];
}
