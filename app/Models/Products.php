<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'categories_id',
        'name',
        'price',
        'purchase_price',
        'stock',
        'barcode',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }

    public function stockLogs()
    {
        return $this->hasMany(StockLogs::class, 'products_id');
    }

    public function addStock($qty, $note = null)
    {
        $this->increment('stock', $qty);
        $this->stockLogs()->create([
            'type' => 'in',
            'quantity' => $qty,
            'note' => $note
        ]);
    }

    public function reduceStock($qty, $note = null)
    {
        $this->decrement('stock', $qty);
        $this->stockLogs()->create([
            'type' => 'out',
            'quantity' => $qty,
            'note' => $note
        ]);
    }
}
