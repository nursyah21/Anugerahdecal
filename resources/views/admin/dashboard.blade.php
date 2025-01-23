<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
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

                @if ($orders && $orders->count() > 0)
                <table class="w-full table-auto border-collapse overflow-x-scroll">
                    <thead>
                        <tr>
                            <th>OrderId</th>
                            <th>Data Pengguna</th>
                            <!-- <th>Alamat</th>
                            <th>No Hp</th> -->
                            <th>Item</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $idx => $data)
                        <tr>
                            <td class="p-2">{{substr($data->order_id,6)}}</td>
                            <td class="p-2">nama: {{$data->name}}
                                <br>alamat: {{$data->address}}
                                <br>no hp: {{$data->number_phone}}
                            </td>
                            <!-- <td class="p-2">{{$data->address}}</td>
                            <td class="p-2">{{$data->number_phone}}</td> -->
                            <td class="p-2 min-w-48" id="detail_transaksi">{!! get_item_transaksi($data->detail_transaksi) !!}</td>
                            <td class="p-2">Rp{{number_format($data->total_price)}}</td>
                            <td class="p-2">{{$data->status}}
                            </td>
                            <td class="p-2 min-w-32">
                                <form action="{{route('admin.ubahStatus')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    <select id="category_id" name="status"
                                        class="w-full border-gray-300 rounded-lg px-4 py-2" required>
                                        <!-- <option value="menunggu konfirmasi" selected>Menunggu Konfirmasi</option> -->
                                        <option value="diproses">diproses</option>
                                        <option value="selesai">selesai</option>
                                        <option value="ditolak">ditolak</option>
    
                                    </select>
                                    <br> <button class="my-2 bg-green-600 px-2 py-1 rounded-lg text-white hover:opacity-80">ubah</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>

    <!-- <div id="my-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full">
        <div class="relative w-full max-w-2xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex justify-between items-center p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Modal Title
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="my-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c0 .083.035.159.111.222 1.11.371 2.329.55 3.548.55 1.04 0 2.053-.139 3.024-.395M9 13h6m-3-3v3m0-7a2 2 0 012-2h6a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2z"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3>
                    <button data-modal-toggle="my-modal" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Yes, I'm sure</button>
                    <button data-modal-toggle="my-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">No, cancel</button>
                </div>
            </div>
        </div>
    </div> -->

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