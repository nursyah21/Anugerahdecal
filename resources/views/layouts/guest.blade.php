<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Anugerah Decal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <nav class="bg-[#009E84] text-white">
        <!-- Header -->
        <div class="bg-white text-center text-xl font-bold p-2 w-full">
            <span class="text-[#CF0101]" style="font-family: 'Goldman', 'sans-serif';">ANUGERAH DECAL</span>
            <span class="text-[#959595]" style="font-family: 'Goldman', 'sans-serif';">STICKER MOTOR</span>
        </div>

        <!-- Navbar Container -->
        <div class="container mx-auto flex items-center justify-between p-4 relative">
            <!-- Logo (Responsive) -->
            <div class="flex items-center">
                <img src="{{ asset('images/logoNav.png') }}" alt="Logo" class="h-10 md:h-16 mx-auto md:mx-0">
            </div>

            <!-- Search Bar (Mobile) -->
            <div class="relative md:hidden w-full flex justify-center">
                <input type="text" placeholder="Cari Produk"
                    class="p-2 rounded-md focus:outline-none focus:ring focus:ring-yellow-500 w-3/4">
            </div>

            <!-- Hamburger Button (Mobile) -->
            <button id="menu-toggle" class="block md:hidden text-white focus:outline-none ml-auto">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <!-- Navigation Links -->
            <div id="menu"
                class="hidden flex-col md:flex md:flex-row md:items-center gap-4 absolute md:static top-full left-0 w-screen md:w-auto bg-[#009E84] md:bg-transparent shadow-md md:shadow-none z-50">
                <!-- Link Navigasi -->
                <a href="/"
                    class="block py-2 px-4 hover:bg-gray-200 hover:text-[#009E84] md:hover:bg-transparent md:hover:text-white">Home</a>
                <a href="/cart"
                    class="block py-2 px-4 hover:bg-gray-200 hover:text-[#009E84] md:hover:bg-transparent md:hover:text-white">Keranjang</a>
                <a href="#"
                    class="block py-2 px-4 hover:bg-gray-200 hover:text-[#009E84] md:hover:bg-transparent md:hover:text-white">Portofolio</a>
                <a href="#"
                    class="block py-2 px-4 hover:bg-gray-200 hover:text-[#009E84] md:hover:bg-transparent md:hover:text-white">Kontak</a>
            </div>

            <!-- Search & Icons (Desktop) -->
            <div class="flex items-center gap-4 hidden md:flex">
                <!-- Search Bar -->
                <div class="relative">
                    <input type="text" placeholder="Cari Produk"
                        class="p-2 rounded-md focus:outline-none focus:ring focus:ring-yellow-500">
                </div>

                @if (Auth::check())
                    <a href="{{ Auth::user()->usertype == 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                        :active="{{ Auth::check() ? (Auth::user()->usertype == 'admin' ? 'request()->routeIs(\'admin.dashboard\')' : 'request()->routeIs(\'dashboard\')') : 'request()->routeIs(\'login\')' }}"
                        class="relative hover:text-gray-200">
                        <i class="fas fa-user text-2xl"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="relative hover:text-gray-200"
                        title="Login untuk mengakses akun Anda">
                        <i class="fas fa-lock text-2xl"></i>
                    </a>
                @endif

                <a href="{{ url('cart') }}" class="relative hover:text-gray-200">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                    @if (session('cart'))
                        @php
                            $cart = session('cart');
                            $cartCount = array_sum(array_column($cart, 'quantity'));
                        @endphp
                        <span
                            class="absolute -top-2 -right-2 inline-block px-2 py-1 text-xs font-bold text-white bg-red-500 rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </nav>
    <div class="m-6 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
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
