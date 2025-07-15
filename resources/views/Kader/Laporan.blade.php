<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Laporan | anak</title>
</head>

<body>
    {{-- head --}}
    <div class="bg-gradient-to-r relative from-cyan-800 to-cyan-600 h-28 drop-shadow-lg overflow-hidden">
        <img src="img/edge dec1.png" class="absolute z-0 size-56 right-0 rotate-90" alt="">
        <div class="text-white font-semibold flex justify-center items-center h-full">
            <div class="text-2xl">Laporan Anak</div>
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
                <a href="/Laporan-anak">
                    <p class="text-xs pr-3">❌</p>
                </a>
            </div>
        </div>
    @endif
    {{-- isi --}}
    <div class="p-4">
        {{-- Alert --}}
        @php
            $belum = $totalAnak - $totalDilaporkan;
        @endphp
        @if ($totalAnak === 0)
            <div class="mb-4 p-4 bg-gray-200 text-gray-600 rounded border border-gray-300">
                Tidak ada anak terdaftar di posyandu ini.
            </div>
        @elseif ($totalDilaporkan === 0)
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded border border-red-300">
                <strong>Peringatan:</strong> Bulan ini belum melakukan pelaporan!
            </div>
        @elseif ($belum > 0)
            <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded border border-yellow-300">
                <strong>Perhatian:</strong> Masih ada {{ $belum }} anak yang belum dilaporkan bulan ini.
            </div>
        @else
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded border border-green-300">
                <strong>Selamat:</strong> Seluruh anak sudah dilaporkan bulan ini.
            </div>
        @endif
        <form action="" method="GET" id="bulanForm">
            <label class="block text-sky-900 font-medium">Tanggal Laporan</label>
            <input type="date" name="bulan_laporan" value="{{ request('bulan_laporan') ?? now()->format('Y-m') }}"
                class="w-1/2 border rounded" onchange="document.getElementById('bulanForm').submit();">
        </form>
        <form method="POST" action="{{ route('simpan.Laporan') }}" class="font text-sky-900">
            @csrf
            <input type="hidden" name="tanggal_pemeriksaan" value="{{ $bulanDipilih->format('Y-m-d') }}">

            <div class="h-1 w-1/2 bg-cyan-600 rounded-lg mb-4"></div>
            @error('password')
                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
            @enderror
            <label for="" class="font-semibold">Nama</label>
            <br>
            <select class="w-full" name="anak_id" id="">
                <option value="">Pilih nama anak</option>
                @foreach ($anakList as $a)
                    <option value="{{ $a->id }}">{{ $a->nama }}</option>
                @endforeach
            </select>
            <div class="h-1 bg-cyan-600 rounded-lg mb-4 "></div>
            @error('anak_id')
                <p class="text-red-500 font-normal text-sm mb-3">{{ $message }}</p>
            @enderror
            <label for="" class="font-semibold">Berat Badan</label>
            <br>
            <input type="number" step="0.1" name="berat_badan" id=""
                class="w-full placeholder:italic font-thin" placeholder="Masukan disini">
            <div class="h-1 bg-cyan-600 rounded-lg mb-4"></div>
            @error('berat_badan')
                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
            @enderror
            <label for="" class="font-semibold">Tinggi Badan</label>
            <br>
            <input type="number" step="0.1" name="tinggi_badan" id=""
                class="w-full placeholder:italic font-thin" placeholder="Masukan disini">
            <div class="h-1 bg-cyan-600 rounded-lg mb-4"></div>
            @error('tinggi_badan')
                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
            @enderror
            <label for="" class="font-semibold">Lingkar Kepala</label>
            <br>
            <input type="number" step="0.1" name="lingkar_kepala" id=""
                class="w-full placeholder:italic font-thin" placeholder="Masukan disini">
            <div class="h-1 bg-cyan-600 rounded-lg mb-4"></div>
            @error('lingkar_kepala')
                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
            @enderror
            <label for="" class="font-semibold">Lingkar Lengan Atas</label>
            <br>
            <input type="number" step="0.1" name="lingkar_lengan_atas" id=""
                class="w-full placeholder:italic font-thin" placeholder="Masukan disini">
            <div class="h-1 bg-cyan-600 rounded-lg mb-4"></div>
            @error('lingkar_lengan_atas')
                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
            @enderror
            <button type="submit"
                class="w-full bg-sky-900 rounded-2xl text-white py-1 font-semibold mt-6 scale-100 hover:scale-105 transition ease-in-out duration-200">Laporkan</button>
        </form>

    </div>

</body>

</html>
