<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Sartika</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}">
</head>
@include('Layout.Navbar')

<body class="bg-slate-300">
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Data Sartika</h1>
                <p class="font-thin mb-14">Berikut merupakan tabel yang berisikan Data dari tiap Posyandu</p>
            </div>

        </div>
    </div>
    {{-- Section --}}
    <div class="mx-auto px-5 lg:px-10 xl:px-52 -mt-24 pb-10">
        {{-- tombol --}}
        <div class="flex justify-between">
            <button onclick="openModal()"
                class="bg-cyan-600 hover:bg-cyan-800 p-1 px-3 text-center font-semibold text-sm border-2 border-white text-white drop-shadow-md rounded-sm scale-100 hover:scale-105 transition ease-in-out duration-100">
                Tambah
            </button>
            {{-- import --}}
            <div class="flex gap-3">
                <div class="bg-gray-200 p-2 rounded-md">
                    <form action="{{ route('sartika.import') }}" method="POST" enctype="multipart/form-data"
                        class="flex items-center gap-3">
                        @csrf
                        <input type="file" name="file" accept=".xlsx,.xls,.csv"
                            class="block w-full text-sm text-black" required>
                        <button type="submit"
                            class="bg-orange-600 hover:bg-orange-800 p-1 px-3 text-center font-semibold text-sm border-2 border-white text-white drop-shadow-md rounded-sm scale-100 hover:scale-105 transition ease-in-out duration-100">
                            Import
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div
            class="w-full bg-white p-2 mt-5 rounded-lg shadow-lg  animate-fade-up animate-once animate-duration-1000 animate-ease-out">
            <table class="w-full">
                <tr class="border-b-2 border-slate-500">
                    <th class="py-2">No.</th>
                    <th>Nama Posyandu</th>
                    {{-- <th>Kader</th> --}}
                    <th>Jumlah Anak</th>
                    {{-- <th>Jumlah Ibu Hamil</th> --}}
                    <th class="max-w-15">Aksi</th>
                </tr>

                @foreach ($posyandu as $p)
                    <tr class="text-center font-normal text-slate-500">
                        <td>{{ $loop->iteration + ($posyandu->currentPage() - 1) * $posyandu->perPage(10) }}.</td>
                        <td>{{ $p->nama }}</td>
                        {{-- <td>{{ $p->kader->name ?? 'tidak ada Kader' }}</td> --}}
                        <td>{{ $p->anak->count() }}</td>
                        {{-- <td>{{ $p->bumil->count() }}</td> --}}
                        <td class="flex justify-center gap-2">
                            <button type="button"
                                class="bg-orange-300 hover:bg-orange-800 mt-2 p-1 rounded-sm text-orange-600 scale-100 peer hover:scale-105 transition"
                                data-id="{{ $p->id }}" data-nama="{{ e($p->nama) }}"
                                onclick="openEditModal(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                    <path
                                        d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                </svg>
                            </button>

                            <a href="{{ url('/Data-Sartika/' . $p->id) }}"
                                class="bg-cyan-300 hover:bg-cyan-800 mt-2 p-1 rounded-sm text-cyan-600 scale-100 peer hover:scale-105 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    <path fill-rule="evenodd"
                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <button onclick="confirmDelete({{ $p->id }})"
                                class="bg-red-300 hover:bg-red-800 mt-2 p-1 rounded-sm text-red-500 scale-100 peer hover:scale-105 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path fill-rule="evenodd"
                                        d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="py-2">
            {{ $posyandu->links() }}
        </div>
    </div>

    {{-- Modal tambah --}}
    <div class="hidden" id="addModal">
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 ">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md animate-jump-in animate-duration-500 p-5">
                <div class="flex justify-start gap-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-11 text-cyan-700" width="24" height="24"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2m5 11h-4v4h-2v-4H7v-2h4V7h2v4h4z" />
                    </svg>
                    <h2 class="text-lg font-semibold text-slate-800">Tambah Posyandu</h2>
                </div>

                <p class="text-sm text-slate-400 mt-3">Silahkan isi nama posyandu : </p>
                <form action="{{ route('simpanDS') }}" method="POST" class="">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="nama" required placeholder="Sartika 1 "
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-0">
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="button" onclick="closeModalt()"
                            class="px-4 py-2 bg-gray-300 rounded mr-2">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-cyan-600 text-white rounded hover:bg-cyan-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal edit sartika --}}
    <div class="hidden" id="editModal">
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900/50" data-close>
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md animate-jump-in p-5"
                onclick="event.stopPropagation()">
                <div class="flex items-center gap-3 mb-3">
                    <div class="rounded-full bg-orange-100 text-orange-600 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-5">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                            <path
                                d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800">Edit Data Sartika</h3>
                    <button class="ml-auto text-slate-400 hover:text-slate-600" data-close>&times;</button>
                </div>
                <p class="text-sm text-slate-400">silahkan memperbarui nama posyandu :</p>
                <form id="editForm" method="POST" action="#">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <input type="text" name="nama" id="input-nama"
                            class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600"
                            placeholder="Nama posyandu…">
                        @error('nama')
                            <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" class="px-3 py-2 rounded bg-slate-100 text-slate-700"
                            data-close>Batal</button>
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Modal Konfirmasi Hapus --}}
    <div class="hidden" id="deleteModal">
        <div class="fixed inset-0 flex  items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white rounded-lg animate-jump-in animate-duration-500 shadow-lg w-full max-w-md p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="rounded-full bg-rose-100 text-rose-600 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12.884 2.532c-.346-.654-1.422-.654-1.768 0l-9 17A1 1 0 0 0 3 21h18a.998.998 0 0 0 .883-1.467zM13 18h-2v-2h2zm-2-4V9h2l.001 5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800">Hapus Data Anak</h3>
                </div>
                <p class="text-slate-600 text-sm">
                    Kamu akan menghapus Sartkia beserta seluruh data anak yang terdaftar di dalamnya?
                    Tindakan ini <span class="font-semibold text-rose-600">tidak dapat dibatalkan</span>.
                </p>
                <div class="mt-3 flex justify-end">
                    <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded mr-2 scale-100 peer hover:scale-105 transition ease-in-out duration-150">Batal</button>
                    <form method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-rose-500 text-white px-4 py-2 rounded hover:bg-rose-700 scale-100 peer hover:scale-105 transition ease-in-out duration-150">Ya,Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
{{-- skrip tambah --}}
<script>
    function openModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }

    function closeModalt() {
        document.getElementById('addModal').classList.add('hidden');
    }
</script>

{{-- skrip edit --}}
<script>
    function openEditModal(btn) {
        const id = btn.dataset.id;
        const nama = btn.dataset.nama || '';

        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');

        // Set action form ke route update
        form.action = "{{ url('/Data-Sartika') }}/" + id;
        // Isi input nama sesuai item yang dipilih
        document.getElementById('input-nama').value = nama;

        modal.classList.remove('hidden');
    }

    // Close modal (klik backdrop / tombol close)
    document.querySelectorAll('#editModal [data-close]').forEach(el => {
        el.addEventListener('click', () => document.getElementById('editModal').classList.add('hidden'));
    });

    // Tutup modal kalau ESC
    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.getElementById('editModal').classList.add('hidden');
    });
</script>


{{-- skript hapus --}}
<script>
    function confirmDelete(posyanduId) {
        let deleteForm = document.getElementById('deleteForm');
        deleteForm.action = '/Data-Sartika/' + posyanduId;

        let modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
    }

    function closeModal() {
        let modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }
</script>

</html>
