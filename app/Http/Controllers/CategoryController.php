<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('welcome', compact('categories'));
    }

    public function show($id, Request $request)
    {
        $category = Category::with('products')->findOrFail($id);

        // Ambil semua brand yang ada dalam kategori ini beserta count produk per brand
        // $brands = Product::where('category_id', $category->id)
        //     ->select('brand')
        //     ->groupBy('brand')
        //     ->selectRaw('count(*) as count')
        //     ->get();

        // // Jika ada parameter brand, filter produk berdasarkan brand
        // if ($request->has('brand')) {
        //     $products = Product::where('category_id', $category->id)
        //         ->where('brand', $request->brand)
        //         ->get();
        // } else {
        //     // Jika tidak ada parameter brand, ambil semua produk dalam kategori
        // }
        $products = $category->products;
        
        return view('category.show', compact('category', 'products'));
        // , compact('category', 'brands', 'products'));
    }
}
