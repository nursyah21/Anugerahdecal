<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">

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

                {{-- Form Tambah Stiker --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Tambah Stiker</h3>
                    <form action="{{ route('admin.storeProduct') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf

                        {{-- Nama Produk --}}
                        <div>
                            <label for="name" class="block font-semibold">Nama Produk</label>
                            <input type="text" id="name" name="name"
                                class="w-full border-gray-300 rounded-lg px-4 py-2" required>
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label for="category_id" class="block font-semibold">Kategori</label>
                            <select id="category_id" name="category_id"
                                class="w-full border-gray-300 rounded-lg px-4 py-2" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Brand --}}
                        {{-- <div>
                            <label for="brand" class="block font-semibold">Merek Produk</label>
                            <input type="text" id="brand" name="brand"
                                class="w-full border-gray-300 rounded-lg px-4 py-2" required>
                        </div> --}}

                        {{-- Gambar Produk --}}
                        <div>
                            <label for="image" class="block font-semibold">Gambar Produk</label>
                            <input type="file" id="image" name="image"
                                class="w-full border-gray-300 rounded-lg px-4 py-2" accept="image/*" required>
                        </div>

                        {{-- Bahan Stiker --}}
                        <div>
                            <h3 class="font-semibold">Bahan Stiker</h3>
                            <div class="flex gap-x-4">
                                @foreach ($bahans as $bahan)
                                <div class="bg-gray-100 p-4 rounded-lg text-center max-w-[100px]">
                                    <input type="checkbox" name="bahan[{{$bahan->id}}]" onclick="addNewBahan(this, '{{$bahan->id}}','{{$bahan->name}}')" /> <br />
                                    {{$bahan->name}}
                                </div>
                                @endforeach
                            </div>

                            <div id="list-stiker" class="my-4">

                            </div>
                        </div>

                        {{-- Laminasi --}}
                        <div>
                            <h3 class="font-semibold">Laminasi</h3>
                            <div class="flex gap-4">
                                @foreach ($laminatings as $laminating)
                                <div class="bg-gray-100 p-4 rounded-lg text-center max-w-[100px]">
                                    <input type="checkbox" name="laminating[{{$laminating->id}}]" onclick="addNewLaminating(this, '{{$laminating->id}}','{{$laminating->name}}')" /> <br />
                                    {{$laminating->name}}
                                </div>
                                @endforeach
                            </div>
                            <div id="list-laminating" class="my-4">

                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label for="description" class="block font-semibold">Deskripsi</label>
                            <textarea id="description" name="description" class="w-full border-gray-300 rounded-lg px-4 py-2"></textarea>
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Simpan</button>
                    </form>
                </div>
            </div>

            {{-- Daftar Stiker --}}
            <div class="grid grid-cols-1 mt-4 md:grid-cols-3 gap-6">
                @foreach ($products as $product)
                <div class="flex flex-col items-center bg-gray-100 p-4 rounded-lg shadow">
                    <img src="{{ Storage::url($product->image) }}" id="zoom" alt="{{ $product->name }}"
                        class="w-full h-40 object-contain rounded-lg">
                    <div class="text-center mt-4">
                        <h3 class="font-semibold">{{ $product->name }}</h3>
                        <h3 class="font-semibold">{{ count_range($product->bahan, $product->laminating) }}</h3>
                        <p class="text-gray-600">{{ $product->description }}</p>
                    </div>
                    <div class="flex gap-2 mt-4">
                        {{-- <a href="{{ route('admin.editProduct', $product->id) }}"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">UPDATE</a> --}}
                        <form action="{{ route('admin.deleteProduct', $product->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">HAPUS</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>


    <script>
        function countPrice(data){
            console.log(data)
            return '1000'
        }

        function addNewBahan(checkbox, id, name) {
            // console.log(checkbox.checked)
            if (!checkbox.checked) {
                document.getElementById(`stiker-${id}`).remove()
                return
            }
            const container = document.getElementById('list-stiker')
            const index = container.children.length;

            const data = `
                <div class="flex gap-4 mb-4" id="stiker-${id}">
                    <input type="text" value="${name}" name="bahan_name[${index}]" class="flex-1 border-gray-300 rounded-lg px-4 py-2" disabled />
                    <input type="number" placeholder="harga" name="bahan_price[${index}][${name}]"
                        class="flex-1 border-gray-300 rounded-lg px-4 py-2" required>
                </div>
            `
            container.insertAdjacentHTML('beforeend', data)
        }

        function addNewLaminating(checkbox, id, name) {
            // console.log(checkbox.checked)
            if (!checkbox.checked) {
                document.getElementById(`laminating-${id}`).remove()
                return
            }
            const container = document.getElementById('list-laminating')
            const index = container.children.length;

            const data = `
                <div class="flex gap-4 mb-4" id="laminating-${id}">
                    <input type="text" value="${name}" name="laminating_name[${index}]" class="flex-1 border-gray-300 rounded-lg px-4 py-2" disabled />
                    <input type="number" placeholder="harga" name="laminating_price[${index}][${name}]"
                        class="flex-1 border-gray-300 rounded-lg px-4 py-2" required>
                </div>
            `
            container.insertAdjacentHTML('beforeend', data)
        }

        // Tambahkan Material
        document.getElementById('add-material').addEventListener('click', () => {
            const container = document.getElementById('materials-container');
            const index = container.children.length;

            const materialRow = `
            <div class="flex gap-x-4 items-center">
                <div class='flex-1'>
                    <label for="materials[${index}][name]" class="block">Nama Bahan</label>
                    <input type="text" name="materials[${index}][name]" class="w-full border-gray-300 rounded-lg px-4 py-2" required>
                </div>
                <div class='flex-1'>
                    <label for="materials[${index}][price]" class="block">Harga Bahan</label>
                    <input type="number" name="materials[${index}][price]" class="w-full border-gray-300 rounded-lg px-4 py-2" required>
                </div>
            </div>`;
            container.insertAdjacentHTML('beforeend', materialRow);
        });



        // Tambahkan Laminasi
        document.getElementById('add-lamination').addEventListener('click', () => {
            const container = document.getElementById('laminations-container');
            const index = container.children.length;

            const laminationRow = `
            <div class="flex gap-x-4 items-center">
    <div class='flex-1'>
        <label for="laminations[${index}][name]" class="block">Nama Laminasi</label>
        <input type="text" name="laminations[${index}][name]" class="w-full border-gray-300 rounded-lg px-4 py-2" required>
    </div>
    <div class='flex-1'>
        <label for="laminations[${index}][price]" class="block">Harga Laminasi</label>
        <input type="number" name="laminations[${index}][price]" class="w-full border-gray-300 rounded-lg px-4 py-2" required>
    </div>
</div>`;
            container.insertAdjacentHTML('beforeend', laminationRow);
        });
    </script>

    {{-- Script untuk Preview Gambar --}}
    <script>
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

</x-app-layout>