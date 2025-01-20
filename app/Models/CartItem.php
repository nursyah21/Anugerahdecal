<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'material',
        'material_price',
        'lamination',
        'lamination_price',
        'total_price',
        'quantity'
    ];

    // Relasi: setiap cart item terkait dengan satu cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Relasi: setiap cart item terkait dengan satu produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
