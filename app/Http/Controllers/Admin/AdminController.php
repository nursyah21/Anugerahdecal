<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Laminating;
use App\Models\Material;
use App\Models\Lamination;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        
        $orders = Order::all();
        return view('admin.dashboard', compact('orders','categories', 'products'));
    }

    public function ubahStatus(Request $request)
    {
        $status = $request->input('status');
        $id = $request->input('id');
        $order = Order::findOrFail($id);
        Log::debug($order);
        $order->status = $status;
        $order->save();

        return back();
    }

    public function kategori()
    {
        $categories = Category::all();
        $products = Product::all();
        $id = '';
        return view('admin.kategori', compact('categories', 'products', 'id'));
    }

    public function idCategori($id)
    {
        $categories = Category::all();
        $products = Product::all();
        $id = Category::findOrFail($id);

        return view('admin.kategori', compact('categories', 'products', 'id'));
    }

    public function updateCategory($id, Request $request)
    {
        $category = Category::findOrFail($id);
        
        $category->name = $request->input('name');
        $imagePath = $request->file('image') ? $request->file('image')->store('categories', 'public') : null;
        if($imagePath){
            $category->image = $imagePath;
        }
        $category->save();

        // Category::create([
        //     'name' => $request->name,
        //     'image' => $imagePath,
        // ]);

        return redirect()->route('admin.kategori');
    }

    public function stiker()
    {
        $categories = Category::all();
        $products = Product::all();
        $bahans = Bahan::all();
        $laminatings = Laminating::all();

        return view('admin.stiker', compact('categories', 'products', 'bahans', 'laminatings'));
    }

    public function laminating()
    {
        $laminatings = Laminating::all();

        return view('admin.laminating', compact('laminatings'));
    }

    public function bahan()
    {
        $bahans = Bahan::all();

        return view('admin.bahan', compact('bahans'));
    }

    public function storeBahan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // $imagePath = $request->file('image') ? $request->file('image')->store('categories', 'public') : null;

        Bahan::create([
            'name' => $request->name
        ]);

        return back();
    }

    public function storeLaminating(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // $imagePath = $request->file('image') ? $request->file('image')->store('categories', 'public') : null;

        Laminating::create([
            'name' => $request->name
        ]);

        return back();
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:1024',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('categories', 'public') : null;

        Category::create([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return back();
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            // 'brand' => 'required|string|max:255',
            'image' => 'required|image|max:1024',
            'description' => 'nullable|string',
            // 'material' => 'required|string|max:255',        // Validasi untuk material
            // 'material_price' => 'required|numeric',         // Validasi untuk harga material
            // 'lamination' => 'required|string|max:255',      // Validasi untuk laminasi
            // 'lamination_price' => 'required|numeric',       // Validasi untuk harga laminasi
        ]);

        $bahans = '';
        $laminatings = '';

        if($request->bahan_price){
            foreach($request->bahan_price as $key => $data){
                foreach($data as $price => $name){
                    $bahans = $bahans.','.$name.';'.$price;                
                }
            }
        }
        if($request->laminating_price){
            foreach($request->laminating_price as $key => $data){
                foreach($data as $price => $name){
                    $laminatings = $laminatings.','.$name.';'.$price;                
                }
            }
        }

        // Simpan gambar produk
        $imagePath = $request->file('image')->store('products', 'public');

        // Simpan produk
        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        //     'brand' => $request->brand,
            'image' => $imagePath,
            'description' => $request->description,
            'laminating' => $laminatings,
            'bahan' => $bahans
        //     'material' => $request->material,
        //     'material_price' => $request->material_price,
        //     'lamination' => $request->lamination,
        //     'lamination_price' => $request->lamination_price,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }


    public function deleteBahan($id)
    {
        $bahan = Bahan::findOrFail($id);

        $bahan->delete();

        return back()->with('success', 'Bahan berhasil dihapus!');
    }

    public function deleteLaminating($id)
    {
        $laminating = Laminating::findOrFail($id);

        $laminating->delete();

        return back()->with('success', 'Laminating berhasil dihapus!');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        // Hapus gambar jika ada
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }
}
