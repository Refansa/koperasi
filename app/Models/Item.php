<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'supplier_id',
        'stock',
        'price',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
