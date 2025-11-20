{{-- resources/views/LaporanAnak.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Laporan Anak</title>
    <link rel="icon" href="{{ asset('img/favlogo.png') }}">
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
        {{-- Alert sisa anak (opsional)
        @isset($sisaBelumLapor)
            @if ($sisaBelumLapor > 0)
                <div class="mb-5 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800">
                    <span class="font-semibold">Perhatian:</span> Masih ada {{ $sisaBelumLapor }} anak yang belum dilaporkan
                    bulan ini.
                </div>
            @endif
        @endisset --}}

        <div class="lg:flex justify-center sm:flex-none gap-6">
            <div class="w-full mb-4 lg:hidden">
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                    <h3 class="text-slate-800 font-semibold">Tips Pengisian BB & TB</h3>
                    <p class="text-sm text-slate-600 mt-2"> Untuk pengisian BB dan TB mohon
                        Gunakan titik (.) untuk desimal.</p>
                </div>
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5 mt-2">
                    <h3 class="text-slate-800 font-semibold">Pengisian NIK & KK</h3>
                    <p class="text-sm text-slate-600 mt-2">Gunakan Nomor KK jika anak belum memiliki NIK!</p>
                </div>

            </div>
            {{-- FORM --}}
            <div class="w-full">
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                    <form method="POST" action="{{ route('simpanRegis') }}" class="font text-sky-900">
                        @csrf
                        {{-- nama --}}
                        <div class="mb-3">
                            <label for="" class="font-semibold">Nama</label>
                            <br>
                            <input type="text" name="nama" id=""
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                        focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic @error('nama') ring-2 ring-rose-500 border-transparent @enderror"
                                placeholder="Masukan disini">
                            @error('nama')
                                <p class="text-red-500 font-normal text-sm mb-3">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- kelamin --}}
                        <div class="mb-3">
                            <label for="" class="font-semibold">Kelamin</label>
                            <br>
                            <select name="kelamin" id=""
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                        focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic @error('kelamin') ring-2 ring-rose-500 border-transparent @enderror">
                                <option value="" class="">Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            @error('kelamin')
                                <p class="text-red-500 font-normal text-sm mb-3">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- NIK --}}
                        <div class="mb-3">
                            <label class="font-semibold block mb-2">Pilih salah satu NIK atau Nomor KK :</label>

                            <div class="flex items-center gap-4 mb-2">
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="pilihan" value="nik" id="r-nik" checked>
                                    NIK
                                </label>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="pilihan" value="kk" id="r-kk">
                                    Nomor KK
                                </label>
                            </div>

                            <div id="group-nik" class="mt-2">
                                <input type="text" name="nik" placeholder="Masukan NIK yang valid"
                                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 animate-rotate-x ease-in duration-100 focus:ring-cyan-600 placeholder:italic" />
                            </div>

                            <div id="group-kk" class="mt-2 hidden">
                                <input type="text" name="nik" placeholder="Masukan Nomor KK yang valid"
                                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 animate-rotate-x ease-in duration-100 focus:ring-cyan-600 placeholder:italic" />
                            </div>
                        </div>

                        {{-- tanggal lahir --}}
                        <div class="mb-3">
                            <label for="" class="font-semibold">Tanggal Lahir</label>
                            <br>
                            <input type="date" name="tanggal_lahir" id=""
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                        focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic @error('tanggal_lahir') ring-2 ring-rose-500 border-transparent @enderror"
                                placeholder="Masukan disini">
                            @error('tanggal_lahir')
                                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- berat lahir --}}
                        <div class="mb-3">
                            <label for="" class="font-semibold">Berat Lahir</label>
                            <br>
                            <input type="number" step="any" name="berat_lahir" id=""
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                        focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic @error('berat_lahir') ring-2 ring-rose-500 border-transparent @enderror"
                                placeholder="Contoh 3.5 Kg">
                            @error('berat_lahir')
                                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- tinggi lahir --}}
                        <div class="mb-3">
                            <label for="" class="font-semibold">Tinggi Lahir</label>
                            <br>
                            <input type="number" step="any" name="tinggi_lahir" id=""
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                        focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic @error('tinggi_lahir') ring-2 ring-rose-500 border-transparent @enderror"
                                placeholder="Contoh 30.2 Cm">
                            @error('tinggi_lahir')
                                <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="w-full bg-sky-900 rounded-2xl text-white py-1 font-semibold mt-2 scale-100 hover:scale-105 transition ease-in-out duration-200">Daftarkan
                            Anak</button>
                    </form>
                </div>
            </div>

            {{-- PANEL INFO KECIL (opsional) --}}
            <div class="lg:max-w-xs lg:block hidden">
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                    <h3 class="text-slate-800 font-semibold">Tips Pengisian BB & TB</h3>
                    <p class="text-sm text-slate-600 mt-2"> Untuk pengisian BB dan TB mohon
                        Gunakan titik (.) untuk desimal.</p>
                </div>
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5 mt-2">
                    <h3 class="text-slate-800 font-semibold">Pengisian NIK & KK</h3>
                    <p class="text-sm text-slate-600 mt-2">Gunakan Nomor KK jika anak belum memiliki NIK!</p>
                </div>
            </div>

        </div>
    </div>
    {{-- tabel --}}
    <div class="pb-10">
        {{-- Data Anak Posyandu --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
            <div class="lg:flex items-center justify-between gap-4 mb-4">
                <h2 class="text-xl font-semibold text-sky-900">
                    Data Anak Posyandu {{ optional(auth()->user()->posyandu)->nama ?? '-' }}
                </h2>

                <form method="GET" action="{{ url('/dashboard1') }}" class="flex gap-2 w-full sm:w-auto">
                    {{-- Search --}}
                    <div class="relative w-full sm:w-72">
                        <label for="q" class="sr-only">Cari Anak</label>
                        <input type="text" id="q" name="q" value="{{ $search ?? '' }}"
                            placeholder="Cari nama / NIK…"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-cyan-600" />
                        <button type="submit" class="absolute inset-y-0 right-0 px-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-gray-500" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="m21 21-4.35-4.35m1.35-4.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>
                    </div>

                    {{-- Sort --}}
                    <div class="text-gray-500">
                        <label for="sort" class="sr-only">Urutkan</label>
                        <select id="sort" name="sort"
                            class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-600"
                            onchange="this.form.submit()">
                            <option value="nama" {{ ($sort ?? 'nama') === 'nama' ? 'selected' : '' }}>
                                Sort: Nama (A–Z)
                            </option>
                            <option value="laki" {{ ($sort ?? '') === 'laki' ? 'selected' : '' }}>
                                Sort: Laki-laki saja
                            </option>
                            <option value="perempuan" {{ ($sort ?? '') === 'perempuan' ? 'selected' : '' }}>
                                Sort: Perempuan saja
                            </option>
                            <option value="umur_terendah" {{ ($sort ?? '') === 'umur_terendah' ? 'selected' : '' }}>
                                Sort: Umur terendah
                            </option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow ring-1 ring-black/5 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <th class="px-4 py-3">NO</th>
                                <th class="px-4 py-3">NIK</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Jenis Kelamin</th>
                                <th class="px-4 py-3">Tanggal Lahir</th>
                                <th class="px-4 py-3">Umur (bulan)</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($anak as $a)
                                @php
                                    $umurBulan = \Carbon\Carbon::parse($a->tanggal_lahir)->diffInMonths(now());
                                @endphp
                                <tr class="text-sm text-gray-700">
                                    <td class="px-4 py-3">
                                        {{ $loop->iteration + ($anak->currentPage() - 1) * $anak->perPage(5) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap font-mono">{{ $a->nik }}</td>
                                    <td class="px-4 py-3">{{ $a->nama }}</td>
                                    <td class="px-4 py-3">
                                        {{ $a->kelamin === 'L' ? 'Laki-laki' : ($a->kelamin === 'P' ? 'Perempuan' : $a->kelamin) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($a->tanggal_lahir)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">{{ $umurBulan }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a href="{{ route('kader.anak.edit', $a) }}"
                                            class="text-cyan-600 hover:underline mr-2">Edit</a>
                                        <form action="{{ route('kader.anak.destroy', $a) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline"
                                                onclick="return confirm('Yakin ingin menghapus data anak ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada data anak terdaftar pada posyandu ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-4">
                    {{ $anak->links() }}
                </div>
            </div>
        </div>
    </div>


</body>

<script>
    const rNik = document.getElementById('r-nik');
    const rKk = document.getElementById('r-kk');
    const gNik = document.getElementById('group-nik');
    const gKk = document.getElementById('group-kk');

    function toggle() {
        if (rNik.checked) {
            gNik.classList.remove('hidden');
            gKk.classList.add('hidden');
        } else if (rKk.checked) {
            gKk.classList.remove('hidden');
            gNik.classList.add('hidden');
        }
    }

    rNik.addEventListener('change', toggle);
    rKk.addEventListener('change', toggle);

    // inisialisasi ketika page load
    toggle();
</script>

</html>
