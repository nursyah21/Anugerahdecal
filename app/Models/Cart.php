<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id']; // Menambahkan atribut yang dapat diisi

    // Relasi: satu cart bisa memiliki banyak cart items
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
