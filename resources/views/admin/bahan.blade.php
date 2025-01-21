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

                {{-- Form Tambah Bahan --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">Tambah Bahan</h3>
                    <form action="{{ route('admin.storeBahan') }}" method="POST" enctype="multipart/form-data"
                        class="mt-4">
                        @csrf
                        <div class="flex gap-4 items-center">
                            <input type="text" name="name" placeholder="Bahan"
                                class="w-full border-gray-300 rounded-lg px-4 py-2" required>
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Simpan</button>
                        </div>
                    </form>
                </div>

                {{-- Daftar Kategori --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    @foreach ($bahans as $bahan)
                    <div class="flex flex-col text-center items-center bg-gray-100 p-4 rounded-lg shadow">    
                    {{$bahan->name}}
                       <form action="{{ route('admin.deleteBahan', $bahan->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus bahan ini?');" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600">Hapus</button>
                        </form>
                    </div>
                    @endforeach
                </div>


            </div>
        </div>
    </div>


    <script>
        // Tambahkan Material
        document.getElementById('add-material').addEventListener('click', () => {
            const container = document.getElementById('materials-container');
            const index = container.children.length;

            const materialRow = `
            <div class="flex gap-x-4 items-center">
                                    <input type="checkbox" name="" id="" >
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
                                    <input type="checkbox" name="" id="" >
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