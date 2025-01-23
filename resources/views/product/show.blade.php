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
        <!-- Tombol Kembali -->
        <div class="mb-4">
            <a href="javascript:history.back()" class="bg-[#CF0101] text-white px-4 py-2 rounded-md hover:bg-red-600">
                &larr; Kembali
            </a>
        </div>

        <!-- Pemberitahuan Modal -->
        @if (session('success'))
        <div id="successModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg p-6 w-96">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-green-600">Berhasil!</h3>
                    <button onclick="closeModal()" class="text-gray-600 hover:text-gray-800">&times;</button>
                </div>
                <p class="mt-4 text-gray-700">{{ session('success') }}</p>
                <div class="mt-6 flex justify-end">
                    <button onclick="closeModal()"
                        class="bg-[#CF0101] text-white px-4 py-2 rounded-md hover:bg-red-600">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div id="warningModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50 hidden">
            <div class="bg-white rounded-lg p-6 w-96">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-yellow-600">Peringatan!</h3>
                    <button onclick="closeWarningModal()" class="text-gray-600 hover:text-gray-800">&times;</button>
                </div>
                <p class="mt-4 text-gray-700">Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.</p>
                <div class="mt-6 flex justify-end">
                    <button onclick="closeWarningModal()"
                        class="bg-[#CF0101] text-white px-4 py-2 rounded-md hover:bg-red-600">
                        Tutup
                    </button>
                </div>
            </div>
        </div>


        <div class="flex items-center justify-center">
            <div class="w-full md:w-3/4 lg:w-2/3 bg-white p-8 rounded-lg shadow-md">
                <div class="flex flex-wrap md:flex-nowrap mb-8">
                    <div class="w-full md:w-1/3 pr-4">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-auto rounded-lg border">
                    </div>

                    <div class="w-full md:w-2/3">
                        <h1>{{ $product->name }}</h1>
                        <p>Estimasi Harga: {{ count_range($product->bahan, $product->laminating) }}</p>

                        <div class="mt-6">
                            <!-- Form untuk menambahkan produk ke keranjang -->
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <!-- Pilihan Material -->
                                <div class="mb-4">
                                    <label for="material" class="block font-semibold">Pilih Bahan:</label>

                                    <select name="material" id="material"
                                        class="border-gray-300 rounded-lg px-4 py-2 w-full" required>
                                        <option value="" data-price="0">Pilih Bahan</option>
                                        @foreach(explode(',', substr($product->bahan, 1)) as $data)
                                        <option value="{{ $data }}" data-price="{{ get_price($data) }}" >
                                            {{ format_product($data) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Pilihan Laminasi -->
                                <div class="mb-4">
                                    <label for="lamination" class="block font-semibold">Pilih Laminasi:</label>

                                    <select name="lamination" id="lamination"
                                        class="border-gray-300 rounded-lg px-4 py-2 w-full" >
                                        <option value="" data-price="0">Pilih Laminasi</option>
                                        @foreach(explode(',', substr($product->laminating, 1)) as $data)
                                        <option value="{{ $data }}" data-price="{{ get_price($data) }}" >
                                            {{ format_product($data) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Input Kuantitas dengan Tombol -->
                                <div class="flex items-center mb-4">
                                    <button type="button" id="decrementQuantity"
                                        class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-l hover:bg-gray-400">
                                        -
                                    </button>
                                    <input type="number" name="quantity" id="quantity" min="1" value="1"
                                        class="text-center border-t border-b border-gray-300 w-12 min-w-24">
                                    <button type="button" id="incrementQuantity"
                                        class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-r hover:bg-gray-400">
                                        +
                                    </button>
                                </div>

                                <!-- Total Harga -->
                                <div class="mb-4">
                                    <p>Total Harga: Rp <span id="totalPrice">0</span></p>
                                </div>

                                <!-- Tombol Add to Cart dan Buy Now -->
                                <div class="flex space-x-4">
                                    @if (Auth::user() && Auth::user()->usertype == 'user')
                                    <button type="submit" name="action" value="add_to_cart"
                                        class="bg-[#CF0101] text-white px-4 py-2 rounded-md hover:bg-red-600">
                                        + ADD TO CART
                                    </button>

                                    <!-- <button type="submit" name="action" value="buy_now"
                                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                        BUY NOW
                                    </button> -->
                                    @else
                                    <p class="text-red-600">
                                        Anda Harus Login sebelum melakukan pembelian
                                    </p>
                                    @endif
                                </div>

                            </form>

                        </div>

                    </div>
                </div>

                <!-- Detail Produk -->
                <div>
                    <p class="text-lg mb-4 leading-relaxed">{{ $product->description }}</p>
                    <h2 class="text-lg font-semibold mb-2">Detail Produk Stiker</h2>
                    <ul class="list-disc list-inside text-sm text-gray-700">
                        <li>Bahan Stiker Standar Otomotif</li>
                        <li>Stiker Lentur Mudah Dipasang</li>
                        <li>Perekat Stiker Kuat, Dilepas Tidak Membekas</li>
                        <li>Mesin Printing Jepang & Tinta Original</li>
                        <li>Warna Stiker Tajam & Tidak Mudah Pudar</li>
                        <li>Laminasi Stiker Membuat Warna Tahan Lama</li>
                    </ul>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const decrementBtn = document.getElementById('decrementQuantity');
            const incrementBtn = document.getElementById('incrementQuantity');
            const quantityInput = document.getElementById('quantity');
            const materialSelect = document.getElementById('material');
            const laminationSelect = document.getElementById('lamination');
            const totalPriceElement = document.getElementById('totalPrice');

            // Fungsi untuk menghitung total harga
            function calculateTotalPrice() {
                const materialPrice = parseFloat(materialSelect.options[materialSelect.selectedIndex].dataset
                    .price) || 0;
                const laminationPrice = parseFloat(laminationSelect.options[laminationSelect.selectedIndex].dataset
                    .price) || 0;
                const quantity = parseInt(quantityInput.value) || 1;

                const totalPrice = (materialPrice + laminationPrice) * quantity;
                totalPriceElement.textContent = totalPrice.toLocaleString('id-ID');
            }

            // Event Listener untuk tombol decrement
            decrementBtn.addEventListener('click', function() {
                let quantity = parseInt(quantityInput.value);
                if (quantity > 1) {
                    quantityInput.value = --quantity;
                    calculateTotalPrice();
                }
            });

            // Event Listener untuk tombol increment
            incrementBtn.addEventListener('click', function() {
                let quantity = parseInt(quantityInput.value);
                quantityInput.value = ++quantity;
                calculateTotalPrice();
            });

            // Event Listener untuk input langsung di kuantitas
            quantityInput.addEventListener('input', calculateTotalPrice);

            // Event Listener untuk pilihan material dan laminasi
            materialSelect.addEventListener('change', calculateTotalPrice);
            laminationSelect.addEventListener('change', calculateTotalPrice);

            // Mengupdate total harga saat halaman dimuat pertama kali
            calculateTotalPrice();

        });


        // Function to close modal
        function closeModal() {
            document.getElementById('successModal').style.display = 'none';
        }


        // Function to show warning modal
        function showWarningModal() {
            document.getElementById('warningModal').style.display = 'flex';
        }

        // Function to close warning modal
        function closeWarningModal() {
            document.getElementById('warningModal').style.display = 'none';
        }

        // Function to close success modal
        function closeModal() {
            document.getElementById('successModal').style.display = 'none';
        }
    </script>

</body>

</html>