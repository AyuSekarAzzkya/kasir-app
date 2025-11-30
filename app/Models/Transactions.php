<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [
        'users_id',
        'invoice_number',
        'total',
        'payment',
        'change'
    ];

    public function items()
    {
        return $this->hasMany(TransactionItems::class, 'transactions_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
