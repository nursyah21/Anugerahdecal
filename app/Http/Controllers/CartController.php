<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // Menambahkan produk ke dalam keranjang
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        // // Validasi input
        // $request->validate([
        //         'bahan' => 'required',
        //         'laminating' => 'required',
        //         'quantity' => 'required|integer|min:1', // Pastikan quantity ada dan valid
        // ]);

        $materials = explode(';', $request->input('material'));
        $laminations = explode(';', $request->input('lamination'));
        $quantity = $request->input('quantity'); // Ambil nilai quantity dari form
        $action = $request->input('action');
        $material = $materials[1];
        $materialPrice = $materials[0];

        $lamination = '';
        $laminationPrice = 0;
        if (!empty($laminations) && $laminations[0] != '') {
            $lamination = $laminations[1];
            $laminationPrice = $laminations[0];
        }


        // // Hitung total harga per item
        $totalPrice = (intval($materialPrice) + intval($laminationPrice)) * intval($quantity);

        // // Cari atau buat keranjang untuk user
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // // Periksa apakah item dengan kombinasi material & laminasi sudah ada di keranjang
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
        // if ($action === 'buy_now') {
        //     return redirect()->route('cart.index');
        // }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }


    // Melihat isi keranjang
    public function showCart()
    {
        // Mengambil cart berdasarkan user_id
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        $detail_transaksi = '';

        if($cart &&  $cart->items->count() > 0){

            foreach ($cart->items as $item) {
                $name = $item->product->name;
                $bahan = $item->material;
                $laminating = $item->lamination;
                $quantity = $item->quantity;
                $total_price = $item->total_price;
    
                $detail_transaksi = ',' . 
                    $name . ';' .
                    $bahan . ';' .
                    $laminating . ';' .
                    $quantity . ';' .
                    $total_price;
            }
        }


        // Mengirimkan data cart ke view
        return view('cart.index', compact('cart', 'detail_transaksi'));
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

    public function test1()
    {
        return redirect()->route('cart.index');
    }

    public function checkout(Request $request)
    {
        $orderId = "ORDER_" . date('YmdHis');

        $imagePath = $request->file('image')->store('buktis', 'public');

        Order::create([
            'order_id' => $orderId,
            'user_id' => Auth::user()->id,
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'number_phone' => $request->input('number_phone'),
            'bukti_transfer' => $imagePath,
            'detail_transaksi' => $request->input('detail_transaksi'),
            'total_price' => $request->input('total_price'),
            'status' => 'menunggu konfirmasi'
        ]);

        // $cart = Cart::findOrFail('');
        // $cartItem->delete();

        $cart = Cart::where('user_id', Auth::id());
        $cart->each(function ($data){
            $data->delete();
        });

        return back()->with('success', 'Data Berhasil Masuk ke transaksi');
        // redirect()->route('cart.index');
    }


    // Melihat isi keranjang
    public function showTransaksi()
    {
        // Mengambil cart berdasarkan user_id
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        $order = Order::all()->where('user_id', Auth::id());
        Log::debug($order);
        
        // Mengirimkan data cart ke view
        return view('transaksi.index', compact('cart', 'order'));
    }
}
