<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLogs extends Model
{
    protected $fillable = ['products_id', 'type', 'quantity', 'note'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id');
    }
}
