<!-- resources/views/layouts/app.blade.php -->
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
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($categories as $category)
                <div
                    class="relative bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transform transition-transform duration-300 hover:scale-105">
                    <a href="{{ url('/category/' . $category->id) }}" class="block">
                        <div class="w-full h-48 bg-gray-100">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                class="w-full h-full object-contain transition-all duration-500 hover:opacity-90">
                        </div>
                        <div class="p-4">
                            <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $category->name }}</h2>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
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
