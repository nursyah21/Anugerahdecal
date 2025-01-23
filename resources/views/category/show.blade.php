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

    <div class="container mx-auto py-8">
        <h1 class="text-2xl text-start font-bold mb-4" style="font-family: 'Goldman', sans-serif;">
            STICKER <span class="text-[#009E84]"
                style="font-family: 'Goldman', sans-serif;">{{ strtoupper($category->name) }}</span>
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
            <!-- Sidebar untuk brand dalam kategori yang dipilih -->
            <div class="col-span-1 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-900">KATEGORI STICKER {{ $category->name }}</h2>
                
            </div>

            <!-- Produk dari kategori yang dipilih dan dipfilter berdasarkan brand -->
            <div class="col-span-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach ($products as $product)
                        <div
                            class="border p-4 rounded-lg text-center transform transition duration-300 hover:scale-105 bg-[#D9D9D9] hover:shadow-xl">
                            <a href="{{ url('product/' . $product->id) }}">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-40 object-contain mb-4 rounded-lg transition-transform duration-300 hover:scale-110">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-center text-sm">{{ count_range($product->bahan, $product->laminating) }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

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
