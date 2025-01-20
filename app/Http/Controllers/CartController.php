<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menambahkan produk ke dalam keranjang
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Validasi input
        $request->validate([
            'material' => 'required',
            'lamination' => 'required',
            'quantity' => 'required|integer|min:1', // Pastikan quantity ada dan valid
        ]);

        $material = $request->input('material');
        $lamination = $request->input('lamination');
        $quantity = $request->input('quantity'); // Ambil nilai quantity dari form
        $action = $request->input('action');
        $materialPrice = $product->material_price;
        $laminationPrice = $product->lamination_price;

        // Hitung total harga per item
        $totalPrice = ($materialPrice + $laminationPrice) * $quantity;

        // Cari atau buat keranjang untuk user
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // Periksa apakah item dengan kombinasi material & laminasi sudah ada di keranjang
        $existingCartItem = $cart->items()->where('product_id', $productId)
            ->where('material', $material)
            ->where('lamination', $lamination)
            ->first();

        if ($existingCartItem) {
            // Jika item sudah ada, perbarui kuantitas dan harga total
            $existingCartItem->quantity += $quantity;
            $existingCartItem->total_price += $totalPrice;
            $existingCartItem->save();
        } else {
            // Jika item belum ada, tambahkan item baru ke keranjang
            $cartItem = new CartItem([
                'product_id' => $product->id,
                'material' => $material,
                'material_price' => $materialPrice,
                'lamination' => $lamination,
                'lamination_price' => $laminationPrice,
                'quantity' => $quantity, // Gunakan nilai quantity dari request
                'total_price' => $totalPrice,
            ]);

            $cart->items()->save($cartItem);
        }
        if ($action === 'buy_now') {
            return redirect()->route('cart.index');
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }


    // Melihat isi keranjang
    public function showCart()
    {
        // Mengambil cart berdasarkan user_id
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        // Mengirimkan data cart ke view
        return view('cart.index', compact('cart'));
    }

    // Memperbarui jumlah produk dalam keranjang
    public function updateCart(Request $request, $cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->quantity = $request->input('quantity');
        $cartItem->total_price = ($cartItem->material_price + $cartItem->lamination_price) * $cartItem->quantity;
        $cartItem->save();

        return redirect()->route('cart.index');
    }

    // Menghapus item dari keranjang
    public function removeCartItem($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();

        return redirect()->route('cart.index');
    }

    public function getCount()
    {
        $count = Auth::check() ? Auth::user()->cart->items->sum('quantity') : 0;
        return response()->json(['count' => $count]);
    }
}
