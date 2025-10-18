{{-- resources/views/LaporanAnak.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Laporan Anak</title>
</head>

<body class="bg-slate-200">

    {{-- HERO --}}
    <div class="bg-gradient-to-r relative from-cyan-800 to-cyan-600 h-28 drop-shadow-lg overflow-hidden">
        <div class="text-white font-semibold flex justify-center items-center h-full">
            <img src="img/edge dec1.png" class="absolute z-0 size-56 right-0 rotate-90" alt="">
            <div class="text-2xl">Registrasi Anak</div>
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

    {{-- notif --}}
    @if (session('success'))
        <div class="bg-gray-900/70 fixed inset-0 flex items-center justify-center z-50 ">
            <div class="bg-white rounded-lg p-6 max-w-lg shadow-lg animate-jump-in duration-100">
                <p class="text-2xl font-bold text-center">Berhasil</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-24 mx-auto text-green-700" width="1024"
                    height="1024" viewBox="0 0 1024 1024">
                    <path fill="currentColor"
                        d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z" />
                </svg>
                <p class="mt-3 text-center">Data berhasil ditambahkan</p>
                <a href="/Regis-anak"
                    class="bg-gradient-to-r text-center max-w-28 from-sky-900 to-cyan-600 text-white px-4 py-2 mt-4 rounded-md mx-auto block hover:scale-105 transition transform duration-200 ease-in-out">Kembali</a>

            </div>
        </div>
    @endif

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        {{-- Alert sisa anak (opsional) --}}
        @isset($sisaBelumLapor)
            @if ($sisaBelumLapor > 0)
                <div class="mb-5 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800">
                    <span class="font-semibold">Perhatian:</span> Masih ada {{ $sisaBelumLapor }} anak yang belum dilaporkan
                    bulan ini.
                </div>
            @endif
        @endisset

        <div class="lg:flex justify-center sm:flex-none gap-6">
            <div class="w-full mb-4 lg:hidden">
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                    <h3 class="text-slate-800 font-semibold">Tips Pengisian</h3>
                    <p class="text-sm text-slate-600 mt-2">Isi sesuai dengan data anak.
                        Gunakan titik (.) untuk desimal.</p>
                </div>

            </div>
            {{-- FORM --}}
            <div class="w-full">
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                    <form method="POST" action="{{ route('simpanRegis') }}" class="font text-sky-900">
                        @csrf
                        {{-- nama --}}
                        <label for="" class="font-semibold">Nama</label>
                        <br>
                        <input type="text" name="nama" id=""
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic mb-3"
                            placeholder="Masukan disini">
                        @error('nama')
                            <p class="text-red-500 font-normal text-sm mb-3">{{ $message }}</p>
                        @enderror
                        {{-- kelamin --}}
                        <label for="" class="font-semibold">Kelamin</label>
                        <br>
                        <select name="kelamin" id=""
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic mb-3">
                            <option value="" class="">Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('kelamin')
                            <p class="text-red-500 font-normal text-sm mb-3">{{ $message }}</p>
                        @enderror
                        {{-- NIK --}}
                        <label for="" class="font-semibold">NIK</label>
                        <br>
                        <input type="text" name="nik" id=""
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic mb-3"
                            placeholder="Masukan disini">
                        @error('nik')
                            <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
                        @enderror
                        {{-- tanggal lahir --}}
                        <label for="" class="font-semibold">Tanggal Lahir</label>
                        <br>
                        <input type="date" name="tanggal_lahir" id=""
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic mb-3"
                            placeholder="Masukan disini">
                        @error('tanggal_lahir')
                            <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
                        @enderror
                        {{-- berat lahir --}}
                        <label for="" class="font-semibold">Berat Lahir</label>
                        <br>
                        <input type="number" step="any" name="berat_lahir" id=""
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic mb-3"
                            placeholder="Masukan disini">
                        @error('berat_lahir')
                            <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
                        @enderror
                        {{-- tinggi lahir --}}
                        <label for="" class="font-semibold">Tinggi Lahir</label>
                        <br>
                        <input type="number" step="any" name="tinggi_lahir" id=""
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic mb-3"
                            placeholder="Masukan disini">
                        @error('tinggi_lahir')
                            <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
                        @enderror
                        <button type="submit"
                            class="w-full bg-sky-900 rounded-2xl text-white py-1 font-semibold mt-2 scale-100 hover:scale-105 transition ease-in-out duration-200">Daftarkan
                            Anak</button>
                    </form>
                </div>
            </div>

            {{-- PANEL INFO KECIL (opsional) --}}
            <div class="lg:max-w-xs lg:visible invisible">
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                    <h3 class="text-slate-800 font-semibold">Tips Pengisian</h3>
                    <p class="text-sm text-slate-600 mt-2">Isi sesuai dengan data anak.
                        Gunakan titik (.) untuk desimal.</p>
                </div>
            </div>

        </div>
    </div>


</body>

</html>
