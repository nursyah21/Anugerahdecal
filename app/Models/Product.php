<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Menambahkan semua kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'name',
        'description',
        'brand',
        'image',
        'category_id',
        'material',          // Kolom untuk bahan
        'material_price',    // Kolom untuk harga bahan
        'lamination',        // Kolom untuk laminasi
        'lamination_price',  // Kolom untuk harga laminasi
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
