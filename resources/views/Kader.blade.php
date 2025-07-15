<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Pengguna</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('img/logo.png') }}">
</head>
@include('Layout.Navbar')

<body class="bg-slate-300">
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24 flex justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Menu Pengguna</h1>
                <p class="font-thin mb-4">Merupakan menu yang berfungsi untuk mendaftarkan Kader (Kepala Daerah) serta
                    mengelola akun pengguna.</p>
            </div>
            <div>
                <img src="img/img1.png" alt="" class="w-36">
            </div>
        </div>
    </div>
    {{-- section --}}
    <div class="lg:px-52 md:px-28 py-5">
        <p
            class="text-sky-900 font-semibold px-2 text-xl bg-white animate-fade-up animate-once animate-duration-1000 animate-ease-out">
            Tambah Akun Kader </p>
        <form action="{{ route('penggunaBaru') }}" method="POST"
            class="flex justify-around bg-white p-3 rounded-sm drop-shadow-md animate-fade-up animate-once animate-duration-1000 animate-ease-out">
            @csrf
            <div class="w-52">
                <label for="" class="font-semibold">Username</label>
                <br>
                <input type="text" name="name" id="" class="w-full placeholder:italic font-thin"
                    placeholder="Masukan disini">
                <div class="h-1 bg-cyan-600 rounded-lg "></div>
            </div>
            <div class="w-52">
                <label for="" class="font-semibold">Posyandu</label>
                <br>
                <select name="posyandu_id" class="w-full italic font-thin" id="">
                    <option value="" class=" font-normal">Pilih posyandu</option>
                    @foreach ($posyandu as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                    @endforeach

                </select>
                <div class="h-1 bg-cyan-600 rounded-lg"></div>
            </div>
            <div class="w-52">
                <label for="" class="font-semibold">Email</label>
                <br>
                <input type="email" name="email" id="" class="w-full placeholder:italic font-thin"
                    placeholder="Masukan disini">
                <div class="h-1 bg-cyan-600 rounded-lg "></div>
            </div>
            <div class="w-52">
                <label for="" class="font-semibold">Password</label>
                <br>
                <input type="password" name="password" id="" class="w-full placeholder:italic font-thin"
                    placeholder="Masukan disini">
                <div class="h-1 bg-cyan-600 rounded-lg"></div>
            </div>


            <button type="submit"
                class="bg-cyan-600 p-1 font-bold text-lg text-white rounded-sm hover:bg-cyan-700">Tambah</button>
        </form>
        {{-- tabel pengguna --}}
        <div
            class="bg-white p-2 mt-5 animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-150">
            <p class="text-sky-900 font-semibold mb-2 text-xl">Daftar Pengguna </p>
            <table class="w-full">
                <tr class="border-b-2 border-slate-500 font-semibold">
                    <th class="max-w-5 py-2">No.</th>
                    <th class="text-left">Username</th>
                    <th class="text-left">Posyandu</th>
                    <th class="text-left">Email</th>
                    <th>Aksi</th>
                </tr>
                @foreach ($users as $u)
                    <tr class=" text-sm font-normal text-slate-500">
                        <td class="max-w-5 text-center">{{ $loop->iteration }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->posyandu->nama }}</td>
                        <td>{{ $u->email }}</td>
                        <td class="text-center">
                            <button onclick="confirmDelete({{ $u->id }})"
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
        {{-- Modal konfirmasi hapus --}}
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
                    <p class="text-sm text-center text-slate-600 ">Apakah anda yakin ingin menghapus pengguna ini?</p>
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
    </div>
</body>
<script>
    function confirmDelete(userId) {
        let deleteForm = document.getElementById('deleteForm');
        deleteForm.action = '/Pengguna/' + userId;

        let modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
    }

    function closeModal() {
        let modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }
</script>

</html>
