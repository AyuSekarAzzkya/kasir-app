<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItems extends Model
{
    protected $fillable = [
        'transactions_id',
        'products_id',
        'price',
        'quantity',
        'subtotal'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transactions_id');
    }
}
