<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Sartika</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    @vite('resources/css/app.css')
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

                    @if (session('success'))
                        <div class="mt-4 rounded-md border border-emerald-200 bg-emerald-50 p-3 text-emerald-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-4 rounded-md border border-rose-200 bg-rose-50 p-3 text-rose-800">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                    <th>Jumlah Ibu Hamil</th>
                    <th class="max-w-15">Aksi</th>
                </tr>

                @foreach ($posyandu as $p)
                    <tr class="text-center font-normal text-slate-500">
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $p->nama }}</td>
                        {{-- <td>{{ $p->kader->name ?? 'tidak ada Kader' }}</td> --}}
                        <td>{{ $p->anak->count() }}</td>
                        <td>{{ $p->bumil->count() }}</td>
                        <td class="flex justify-center gap-2">
                            <a href="/Data-Sartika/{{ $p->id }}/edit"
                                class="bg-orange-300 hover:bg-orange-800 mt-2 p-1 rounded-sm text-orange-600 scale-100 peer hover:scale-105 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                    <path
                                        d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                </svg>
                            </a>
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
                                class="bg-red-300 hover:bg-red-800 mt-2 p-1 rounded-sm text-red-500 scale-100 peer hover:scale-105 transition ease-in-out duration-150"><svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
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
    </div>

    <!-- Modal Tambah Posyandu-->
    <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden ">
        <div class="bg-white rounded-lg shadow-lg w-96 animate-jump-in">
            <div class="bg-gradient-to-r from-cyan-600 to-cyan-400 h-2 rounded-t-lg w-full"></div>
            <div class="p-6">
                <h2 class="text-lg font-bold mb-4 text-sky-900">Tambah Posyandu</h2>

                <form action="{{ route('simpanDS') }}" method="POST" class="">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sky-900 font-semi mb-2">Nama Posyandu</label>
                        <input type="text" name="nama" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-0">
                        <div class="h-1 bg-cyan-600 rounded-lg "></div>

                    </div>

                    {{-- <div class="mb-4">
                        <label class="block text-sky-900 font-semi mb-2">Kader</label>
                        <select name="kader_id" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-0 ">
                            <option value="" class="placeholder:font-thin">Pilih Kader</option>
                            @foreach ($users as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                        <div class="h-1 bg-cyan-600 rounded-lg "></div>

                    </div> --}}

                    <div class="mt-4 flex justify-end">
                        <button type="button" onclick="closeModalt()"
                            class="px-4 py-2 bg-gray-300 rounded mr-2">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-cyan-500 text-white rounded hover:bg-cyan-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Edit --}}
    <div id="addModal1" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden ">
        <div class="bg-white rounded-lg shadow-lg w-96 animate-jump-in">
            <div class="bg-gradient-to-r from-cyan-600 to-cyan-400 h-2 rounded-t-lg w-full"></div>
            <div class="p-6">
                <h2 class="text-lg font-bold mb-4 text-sky-900">Tambah Posyandu</h2>

                <form action="{{ route('simpanDS') }}" method="POST" class="">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sky-900 font-semi mb-2">Nama Posyandu</label>
                        <input type="text" name="nama" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-0">
                        <div class="h-1 bg-cyan-600 rounded-lg "></div>

                    </div>

                    <div class="mb-4">
                        <label class="block text-sky-900 font-semi mb-2">Kader</label>
                        <select name="kader_id" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-0 ">
                            <option value="" class="placeholder:font-thin">Pilih Kader</option>
                            @foreach ($users as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                        <div class="h-1 bg-cyan-600 rounded-lg "></div>

                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="button" onclick="closeModale()"
                            class="px-4 py-2 bg-gray-300 rounded mr-2">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-cyan-500 text-white rounded hover:bg-cyan-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div id="deleteModal" class="fixed inset-0 flex  items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg animate-jump-in shadow-lg w-96">
            <div class="bg-gradient-to-r from-red-600 rounded-t-lg to-red-400 h-2 w-full"></div>
            <div class="p-6 justify-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="size-16 text-red-600">
                    <path fill-rule="evenodd"
                        d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                        clip-rule="evenodd" />
                </svg>
                <h2 class="text-lg font-semibold">Konfirmasi Hapus</h2>
                <p class="text-sm text-center text-slate-600 ">Apakah anda yakin ingin menghapus Posyandu ini?</p>
                <div class="mt-5 flex">
                    <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded mr-2 scale-100 peer hover:scale-105 transition ease-in-out duration-150">Batal</button>
                    <form method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 scale-100 peer hover:scale-105 transition ease-in-out duration-150">Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function openModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }

    function closeModalt() {
        document.getElementById('addModal').classList.add('hidden');
    }
</script>


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
