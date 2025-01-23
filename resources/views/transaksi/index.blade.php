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
        <h1 class="text-2xl font-semibold">Daftar Transaksi</h1>

        @if ($order && $order->count() > 0)
        <div class="mt-6">
            <table class="w-full table-auto border-collapse overflow-auto">
                <thead>
                    <tr>
                        <th>OrderId</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Hp</th>
                        <th>Item</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
        
                @foreach ($order as $idx => $data)
                <tr>
                    <td class="p-2">{{$data->order_id}}</td>
                    <td class="p-2">{{$data->name}}</td>
                    <td class="p-2">{{$data->address}}</td>
                    <td class="p-2">{{$data->number_phone}}</td>
                    <td class="p-2 min-w-48" id="detail_transaksi">{!! get_item_transaksi($data->detail_transaksi) !!}</td>
                    <td class="p-2">Rp{{number_format($data->total_price)}}</td>
                    <td class="p-2">{{$data->status}}</td>
                </tr>
                @endforeach
                    
                </tbody>
            </table>
            
        </div>
        @else
        <p>Transaksi kamu kosong.</p>
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
        document.querySelector('#detail_transaksi')

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