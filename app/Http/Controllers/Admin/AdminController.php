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
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $products = Product::all();

        return view('admin.dashboard', compact('categories', 'products'));
    }

    public function kategori()
    {
        $categories = Category::all();
        $products = Product::all();

        return view('admin.kategori', compact('categories', 'products'));
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
            'name' => 'required|string|max:255',
            'price' => 'required',
        ]);

        // $imagePath = $request->file('image') ? $request->file('image')->store('categories', 'public') : null;

        Bahan::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return back();
    }

    public function storeLaminating(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
        ]);

        // $imagePath = $request->file('image') ? $request->file('image')->store('categories', 'public') : null;

        Laminating::create([
            'name' => $request->name,
            'price' => $request->price,
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
        $request->laminating;
        if(!$request->bahan){
            foreach($request->bahan as $idx => $bahan){
                if($bahan == 'on') $bahans = $bahan+$idx .',';
            }
        }
        if(!$request->laminating){
            foreach($request->laminating as $idx => $laminating){
                if($laminating == 'on') $laminatings = $laminating+$idx .',';
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
