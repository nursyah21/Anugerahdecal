<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Hitung total harga
        $totalPrice = $product->material_price + $product->lamination_price;

        return view('product.show', compact('product', 'totalPrice'));
    }
}
