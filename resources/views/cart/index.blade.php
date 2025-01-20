<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Anugerah Decal' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Goldman&display=swap" rel="stylesheet">

</head>

<body>
    <x-navbar />

    <main class="container mx-auto py-8 min-h-screen">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex justify-between text-xs mt-2 mb-2">
                <span class="text-center font-semibold">Keranjang</span>
                <span class="text-center font-semibold">Detail & Nota</span>
                <span class="text-center font-semibold">Pembayaran</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-[#CF0101] h-2.5 rounded-full" style="width: 33%"></div>
                </div>
            </div>
        </div>
        <h1 class="text-2xl font-semibold">Keranjang Belanja</h1>

        @if ($cart && $cart->items->count() > 0)
            <div class="mt-6">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Material</th>
                            <th>Laminasi</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->material }}</td>
                                <td>{{ $item->lamination }}</td>
                                <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                                            min="1" class="w-12">
                                        <button type="submit" class="text-blue-500">Update</button>
                                    </form>
                                </td>
                                <td>Rp {{ number_format($item->total_price * $item->quantity, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 text-right">
                    <h2 class="text-xl font-semibold">Total Harga: Rp
                        {{ number_format($cart->items->sum('total_price'), 0, ',', '.') }}</h2>
                </div>
            </div>
        @else
            <p>Keranjang kamu kosong.</p>
        @endif
    </main>
    <footer class="bg-gradient-to-r from-[#009E84] to-[#00382F] text-white py-6">
        <div class="container mx-auto grid grid-cols-3 gap-6">
            <div>
                <img src="{{ asset('images/LogoFooter.png') }}" alt="LogoFooter" class="h-12 mb-2">
                <p>Layanan Pemesanan Online Adecal Selayar, Siap melayani Pelanggan Setia Anugerah Decal.</p>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">Layanan Pelanggan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:underline">Status Order</a></li>
                    <li><a href="#" class="hover:underline">Konfirmasi Pembayaran</a></li>
                    <li><a href="#" class="hover:underline">Bantuan / FAQ</a></li>
                    <li><a href="#" class="hover:underline">Syarat dan Ketentuan</a></li>
                    <li><a href="#" class="hover:underline">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">Tentang Printku</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:underline">Kontak Kami</a></li>
                    <li><a href="#" class="hover:underline">Tentang Kami</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>
