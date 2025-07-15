<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengaturan | Admin</title>
    @vite('resources/css/app.css')
</head>
@include('Layout.Navbar')

<body class="bg-slate-300">
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div
            class="lg:px-52 md:px-28 text-white -translate-y-24 flex justify-between animate-fade animate-once animate-ease-out">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Menu Pengaturan</h1>
                <p class="font-thin mb-4">Menu untuk mengatur akun, standar stunting dll</p>
            </div>
            <div>
                <img src="img/img2.png" alt="" class="w-36">
            </div>
        </div>
    </div>
    {{-- section --}}
    <div class="lg:px-52 md:px-28 pt-5">
        <div class="bg-white rounded-sm drop-shadow-lg p-2">
            <p class="text-lg font-bold text-sky-900">Masukan Standar Stunting </p>
            <p class=" font-light mb-2 ">Siapkan excel yang berisi tabel IMT Tinggi Badan (TB)</p>
            <div>
                <form action="{{ route('stunting.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".xlsx,.xls" required class="border rounded-sm">
                    <button type="submit"
                        class="bg-cyan-600 hover:bg-cyan-800 text-white px-4 py-1 rounded-sm">Import</button>
                </form>
            </div>
        </div>
    </div>
    {{-- notif --}}
    @if (session('success'))
        <div class="absolute right-0 z-10 top-5 animate-fade-left">
            <div
                class="bg-slate-100 h-16 flex items-center justify-start rounded-l-md shadow-lg outline outline-2 outline-green-800">
                <div class="bg-gradient-to-t from-green-700 to-emerald-500 w-2 h-full rounded-l-md"></div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="size-10 text-green-600 ml-5">
                    <path fill-rule="evenodd"
                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                        clip-rule="evenodd" />
                </svg>
                <div class="px-5">
                    <p class="text-green-800 font-semibold">Berhasil !</p>
                    <p class="font-thin text-sm">{{ session('success') }}</p>
                </div>
                <a href="/Pengaturan-admin">
                    <p class="text-xs pr-3">❌</p>
                </a>
            </div>
        </div>
    @endif

</body>

</html>
