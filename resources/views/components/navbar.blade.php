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
            <a href="/transaksi"
                class="block py-2 px-4 hover:bg-gray-200 hover:text-[#009E84] md:hover:bg-transparent md:hover:text-white">Transaksi</a>

            <!-- <a href="#"
                class="block py-2 px-4 hover:bg-gray-200 hover:text-[#009E84] md:hover:bg-transparent md:hover:text-white">Portofolio</a>
            <a href="#"
                class="block py-2 px-4 hover:bg-gray-200 hover:text-[#009E84] md:hover:bg-transparent md:hover:text-white">Kontak</a>
         -->
        </div>

        <!-- Search & Icons (Desktop) -->
        <div class="items-center gap-4 hidden md:flex">
            <!-- Search Bar -->
            <div class="relative">
                <input type="text" placeholder="Cari Produk"
                    class="p-2 rounded-md focus:outline-none focus:ring focus:ring-yellow-500">
            </div>

            @if (Auth::check())
            @if (Auth::user()->usertype == 'admin')
            <a href="{{ Auth::user()->usertype == 'admin' ? zroute('admin.dashboard') : route('dashboard') }}"
                :active="{{ Auth::check() ? (Auth::user()->usertype == 'admin' ? 'request()->routeIs(\'admin.dashboard\')' : 'request()->routeIs(\'dashboard\')') : 'request()->routeIs(\'login\')' }}"
                class="relative hover:text-gray-200">
                <i class="fas fa-user text-2xl"></i>
            </a>
            @else
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <a href="{{ route('logout') }}" :active="false"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                <i class="fa-solid fa-right-from-bracket text-2xl"></i>
            </a>
            @endif

            @else
            <a href="{{ route('login') }}" class="relative hover:text-gray-200"
                title="Login untuk mengakses akun Anda">
                <i class="fas fa-lock text-2xl"></i>
            </a>
            @endif

            <a href="{{ route('cart.index') }}" class="relative hover:text-gray-200">
                <i class="fas fa-shopping-cart text-2xl"></i>
                @if (Auth::check())
                @php
                $cart = Auth::user()->cart; // Mengambil keranjang dari pengguna yang sedang login
                $cartCount = 0;

                // Pastikan keranjang ada dan menghitung jumlah item
                if ($cart && $cart->items) {
                $cartCount = $cart->items->sum('quantity'); // Menghitung jumlah total item dalam keranjang
                }
                @endphp

                @if ($cartCount > 0)
                <span id="cartCount"
                    class="absolute -top-2 -right-2 inline-block px-2 py-1 text-xs font-bold text-white bg-red-500 rounded-full">
                    {{ $cartCount }}
                </span>
                @endif
                @else
                @php
                $cartCount = 0; // Tidak ada keranjang jika pengguna belum login
                @endphp
                @endif
            </a>


        </div>
    </div>
</nav>

<script>
    // Script to toggle the mobile menu
    document.getElementById('menu-toggle').addEventListener('click', function() {
        const menu = document.getElementById('menu');
        menu.classList.toggle('hidden');
    });
</script>