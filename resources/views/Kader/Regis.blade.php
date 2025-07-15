<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <title>Registrasi | Anak</title>
</head>

<body class="">
    {{-- head --}}
    <div class="bg-gradient-to-r relative from-cyan-800 to-cyan-600 h-28 drop-shadow-lg overflow-hidden">
        <img src="img/edge dec1.png" class="absolute z-0 size-56 right-0 rotate-90" alt="">
        <div class="text-white font-semibold flex justify-center items-center h-full">
            <div class="text-2xl">Registrasi</div>
            <a href="/dashboard1" class="absolute left-4">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-9">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </a>
        </div>
    </div>
    {{-- Notifikasi --}}
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
                <a href="/Regis-anak">
                    <p class="text-xs pr-3">❌</p>
                </a>
            </div>
        </div>
    @endif
    {{-- Section --}}
    <div class="p-4">
        <p class="font-semibold text-sky-900 mb-2">Pilih Opsi Registrasi : </p>
        <div class="flex justify-start mb-4">
            <a href="/Regis-anak" class="">
                <div class="bg-sky-700 py-1 px-6 shadow-lg text-slate-300 rounded-l-lg">

                    <p class="font-semibold">Anak</p>
                </div>
            </a>
            <a href="/Regis-bumil">
                <div class="bg-slate-400 py-1 px-6 text-slate-600 rounded-r-lg">

                    <p class="font-semibold">Bumil</p>
                </div>
            </a>
        </div>
        <form method="POST" action="{{ route('simpanRegis') }}" class="font text-sky-900">
            @csrf
            <label for="" class="font-semibold">Nama</label>
            <br>
            <input type="text" name="nama" id="" class="w-full placeholder:italic font-thin"
                placeholder="Masukan disini">
            <div class="h-1 bg-cyan-600 rounded-lg mb-4 "></div>
            @error('nama')
                <p class="text-red-500 font-normal text-sm mb-3">{{ $message }}</p>
            @enderror
            <label for="" class="font-semibold">Kelamin</label>
            <br>
            <select name="kelamin" id="" class="w-full italic font-thin">
                <option value="" class="">Jenis Kelamin</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
            <div class="h-1 bg-cyan-600 rounded-lg mb-4 "></div>
            @error('nama')
                <p class="text-red-500 font-normal text-sm mb-3">{{ $message }}</p>
            @enderror
            <label for="" class="font-semibold">NIK</label>
            <br>
            <input type="text" name="nik" id="" class="w-full placeholder:italic font-thin"
                placeholder="Masukan disini">
            <div class="h-1 bg-cyan-600 rounded-lg mb-4"></div>
            @error('password')
                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
            @enderror
            <label for="" class="font-semibold">Tanggal Lahir</label>
            <br>
            <input type="date" name="tanggal_lahir" id="" class="w-full placeholder:italic font-thin"
                placeholder="Masukan disini">
            <div class="h-1 bg-cyan-600 rounded-lg mb-4"></div>
            @error('password')
                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
            @enderror
            <label for="" class="font-semibold">Berat Lahir</label>
            <br>
            <input type="number" step="any" name="berat_lahir" id=""
                class="w-full placeholder:italic font-thin" placeholder="Masukan disini">
            <div class="h-1 bg-cyan-600 rounded-lg mb-4"></div>
            @error('berat_lahir')
                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
            @enderror
            <label for="" class="font-semibold">Tinggi Lahir</label>
            <br>
            <input type="number" step="any" name="tinggi_lahir" id=""
                class="w-full placeholder:italic font-thin" placeholder="Masukan disini">
            <div class="h-1 bg-cyan-600 rounded-lg mb-4"></div>
            @error('tinggi_lahir')
                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
            @enderror
            <button type="submit"
                class="w-full bg-sky-900 rounded-2xl text-white py-1 font-semibold mt-6 scale-100 hover:scale-105 transition ease-in-out duration-200">Tambah</button>
        </form>
    </div>

</body>

</html>
