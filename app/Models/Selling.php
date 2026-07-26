<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    protected $fillable = [
        'amount',
        'selling_date',
        'notes',
        'user_id',
        'product_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'selling_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
