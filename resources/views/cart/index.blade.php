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

    {{-- Pesan Error dan Sukses --}}
    @if ($errors->any())
    <div class="bg-red-100 text-red-600 p-4 rounded-lg mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="bg-green-100 text-green-600 p-4 rounded-lg mb-4">
        {{ session('success') }}
    </div>
    @endif

    <main class="container mx-auto py-8 min-h-screen">
        <!-- Progress Steps -->
        <!-- <div class="mb-8">
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
        </div> -->
        <h1 class="text-2xl font-semibold">Keranjang Belanja</h1>

        @if ($cart &&  $cart->items->count() > 0)
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
                        <td id='total' value="{{$item->total_price}}">Rp {{ number_format($item->total_price / $item->quantity ) }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}"
                                    min="1" class="w-12 min-w-24">
                                <button type="submit" class="text-blue-500">Update</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($item->total_price) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 text-right">
                <h2 class="text-xl font-semibold">Total Harga: Rp {{ number_format($cart->items->sum('total_price')) }}</h2>
            </div>
            <div class="mb-6">
                <h3 class="text-lg font-semibold">Detail Pembayaran</h3>
                <form class="flex flex-col gap-y-4" action="{{ route('cart.checkout') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label for="name" class="block font-semibold">Nama Pembeli</label>
                        <input type="text" id="name" name="name" value="{{Auth::user()->name }}"
                            class="w-full border-gray-300 rounded-lg px-4 py-2" required>
                    </div>

                    <div>
                        <label for="address" class="block font-semibold">Alamat</label>
                        <input type="text" id="name" name="address"
                            class="w-full border-gray-300 rounded-lg px-4 py-2" required>
                    </div>

                    <div>
                        <label for="number_phone" class="block font-semibold">Nomor Hp</label>
                        <input type="text" id="number_phone" name="number_phone"
                            class="w-full border-gray-300 rounded-lg px-4 py-2" required>
                    </div>

                    <div>
                        <label for="image" class="block font-semibold">Bukti Pembayaran</label>
                        <span>Transfer ke BCA 084532546 <br>Atas Nama: Anugrah Decal</span>
                        <input type="file" id="image" name="image"
                            class="w-full border-gray-300 rounded-lg px-4 py-2" accept="image/*" required>
                    </div>
                    <input type="hidden" value="{{$detail_transaksi}}" name="detail_transaksi" >
                    <input type="hidden" value="{{$cart->items->sum('total_price')}}" name="total_price">

                    <button type="submit" class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                        Bayar
                    </button>
                </form>
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
    <script>
        // preview gambar
        document.querySelectorAll('input[type="file"]').forEach((input) => {
            input.addEventListener('change', (e) => {
                const previewContainer = input.parentElement.querySelector('.image-preview');
                if (previewContainer) {
                    previewContainer.remove();
                }
                const reader = new FileReader();
                reader.onload = (event) => {
                    const preview = document.createElement('img');
                    preview.src = event.target.result;
                    preview.classList.add('w-16', 'h-16', 'mt-2', 'rounded-lg', 'image-preview');
                    input.parentElement.appendChild(preview);
                };
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
</body>

</html>