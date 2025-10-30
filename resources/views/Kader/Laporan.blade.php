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
            <div class="text-2xl">Laporan Gizi</div>
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
                <p class="mt-3 text-center">Excel berhasil diimport!</p>
                <a href="/Laporan-anak"
                    class="bg-gradient-to-r text-center max-w-28 from-sky-900 to-cyan-600 text-white px-4 py-2 mt-4 rounded-md mx-auto block hover:scale-105 transition transform duration-200 ease-in-out">Kembali</a>

            </div>
        </div>
    @endif
    {{-- notif error --}}
    @if (session('error'))
        <div class="bg-gray-900/70 fixed inset-0 flex items-center justify-center z-50 ">
            <div class="bg-white rounded-lg p-6 max-w-lg shadow-lg animate-jump-in duration-100">
                <p class="text-2xl font-bold text-center mb-2">Gagal</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-24 mx-auto text-red-700" width="48"
                    height="48" viewBox="0 0 48 48">
                    <defs>
                        <mask id="SVGkgqorNOO">
                            <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4">
                                <path fill="#fff" stroke="#fff"
                                    d="M10 44h28a2 2 0 0 0 2-2V14H30V4H10a2 2 0 0 0-2 2v36a2 2 0 0 0 2 2" />
                                <path stroke="#fff" d="m30 4l10 10" />
                                <path stroke="#000" d="m18 22l12 12m0-12L18 34" />
                            </g>
                        </mask>
                    </defs>
                    <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#SVGkgqorNOO)" />
                </svg>
                <p class="mt-2 text-center">{{ session('error') }}</p>
                <a href="/Laporan-anak"
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
                <div class="">
                    {{-- Alert --}}
                    @php
                        $belum = $totalAnak - $totalDilaporkan;
                    @endphp
                    @if ($totalAnak === 0)
                        <div class="mb-4 p-4 bg-gray-200 text-gray-600 rounded-xl border border-gray-300">
                            Tidak ada anak terdaftar di posyandu ini.
                        </div>
                    @elseif ($totalDilaporkan === 0)
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-xl border border-red-300">
                            <strong>Peringatan:</strong> Bulan ini belum melakukan pelaporan!
                        </div>
                    @elseif ($belum > 0)
                        <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-xl border border-yellow-300">
                            <strong>Perhatian:</strong> Masih ada {{ $belum }} anak yang belum dilaporkan bulan
                            ini.
                        </div>
                    @else
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-xl border border-green-300">
                            <strong>Selamat:</strong> Seluruh anak sudah dilaporkan bulan ini.
                        </div>
                    @endif
                </div>
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                    <h3 class="text-slate-800 font-semibold">Tips Pengisian</h3>
                    <p class="text-sm text-slate-600 mt-2">Isi sesuai hasil penimbangan/pengukuran bulan berjalan.
                        Gunakan titik (.) untuk desimal.</p>
                </div>
                 <div class="mt-4">
                    <form method="POST" action="{{ route('laporan-anak.import') }}" enctype="multipart/form-data"
                        class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5 mb-4">
                        @csrf
                        <p class="text-slate-800 font-semibold mb-3">Import Data</p>
                        <div class="flex items-center gap-2">
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                class="block w-full text-sm text-slate-700 border-2 border-gray-200 hover:border-gray-500 rounded-lg">
                            <button class="px-3 py-1 rounded-md bg-sky-700 text-white hover:bg-sky-900">
                                Import
                            </button>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">
                            Format file: .xlsx, .xls, .csv. Gunakan template yang disediakan <a
                                href="/templates/LaporanTemplate.xlsx" class="text-sky-500 underline"> di sini</a>.
                        </p>
                        @error('file')
                            <div class="text-rose-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </form>
                </div>

            </div>
            {{-- FORM --}}
            <div class="w-full">
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                    <form action="" method="GET" id="tglForm">
                        <label class="block text-sky-900 font-medium">Tanggal Laporan</label>
                        <input type="date" name="tanggal_laporan"
                            value="{{ request('tanggal_laporan') ?? now()->format('Y-m-d') }}"
                            class="w-1/2 border rounded" onchange="document.getElementById('tglForm').submit();">
                    </form>
                    <form method="POST" action="{{ route('simpan.Laporan') }}" class="font text-sky-900">
                        @csrf
                        <input type="hidden" name="tanggal_pemeriksaan" value="{{ $tanggalDipilih->format('Y-m-d') }}">

                        <div class="h-1 w-1/2 bg-cyan-600 rounded-lg mb-4"></div>

                        {{-- nama --}}
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-slate-700">Nama</label>
                            <select name="anak_id"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent @error('anak_id') ring-2 ring-rose-500 border-transparent @enderror">
                                <option value="" selected disabled>Pilih nama anak</option>
                                @foreach ($anakList as $anak)
                                    <option value="{{ $anak->id }}">{{ $anak->nama }}</option>
                                @endforeach
                            </select>
                            @error('anak_id')
                                <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- DETAIL ANAK TERPILIH --}}
                        <div id="detail-anak" class="hidden rounded-lg bg-cyan-50 ring-1 ring-cyan-100 p-4">
                            <div class="flex items-start gap-4">
                                <div class="shrink-0">
                                    <div id="detail-avatar"
                                        class="size-12 rounded-full bg-cyan-200 text-cyan-900 flex items-center justify-center font-bold">
                                        A
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full">
                                    <div>
                                        <div class="text-xs text-slate-500">Nama</div>
                                        <div id="detail-nama" class="text-slate-900 font-medium">-</div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-slate-500">Kelamin</div>
                                        <div id="detail-kelamin" class="text-slate-900">-</div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-slate-500">Umur (bulan)</div>
                                        <div id="detail-umur" class="text-slate-900">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Berat Badan (JANGAN ubah name!) --}}
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-slate-700">Berat Badan</label>
                            <input type="number" step="0.1" name="berat_badan" placeholder="Contoh : 7.5 kg"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic @error('berat_badan') ring-2 ring-rose-500 border-transparent @enderror"
                                value="{{ old('berat_badan') }}">
                            @error('berat_badan')
                                <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tinggi Badan (JANGAN ubah name!) --}}
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-slate-700">Tinggi Badan</label>
                            <input type="number" step="0.1" name="tinggi_badan" placeholder="Contoh : 65.5 cm"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic @error('tinggi_badan') ring-2 ring-rose-500 border-transparent @enderror"
                                value="{{ old('tinggi_badan') }}">
                            @error('tinggi_badan')
                                <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Lingkar Kepala (JANGAN ubah name!) --}}
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-slate-700">Lingkar Kepala</label>
                            <input type="number" step="0.1" name="lingkar_kepala" placeholder="Contoh : 45.0 cm"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic @error('lingkar_kepala') ring-2 ring-rose-500 border-transparent @enderror"
                                value="{{ old('lingkar_kepala') }}">
                            @error('lingkar_kepala')
                                <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Lingkar Lengan Atas (JANGAN ubah name!) --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Lingkar Lengan Atas</label>
                            <input type="number" step="0.1" name="lingkar_lengan_atas"
                                placeholder="Contoh : 13.5 cm"
                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2
                                    focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent placeholder:italic @error('lingkar_lengan_atas') ring-2 ring-rose-500 border-transparent @enderror"
                                value="{{ old('lingkar_lengan_atas') }}">
                            @error('lingkar_lengan_atas')
                                <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full rounded-full bg-sky-700 hover:bg-sky-900 text-white py-2 mt-3 font-semibold shadow hover:shadow-md
                                hover:-translate-y-0.5 transition">
                            Laporkan
                        </button>
                    </form>
                </div>
            </div>

            {{-- PANEL INFO KECIL (opsional) --}}
            <div class="lg:max-w-xs lg:visible invisible">
                <div class="">
                    {{-- Alert --}}
                    @php
                        $belum = $totalAnak - $totalDilaporkan;
                    @endphp
                    @if ($totalAnak === 0)
                        <div class="mb-4 p-4 bg-gray-200 text-gray-600 rounded-xl border border-gray-300">
                            Tidak ada anak terdaftar di posyandu ini.
                        </div>
                    @elseif ($totalDilaporkan === 0)
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-xl border border-red-300">
                            <strong>Peringatan:</strong> Bulan ini belum melakukan pelaporan!
                        </div>
                    @elseif ($belum > 0)
                        <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-xl border border-yellow-300">
                            <strong>Perhatian:</strong> Masih ada {{ $belum }} anak yang belum dilaporkan bulan
                            ini.
                        </div>
                    @else
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-xl border border-green-300">
                            <strong>Selamat:</strong> Seluruh anak sudah dilaporkan bulan ini.
                        </div>
                    @endif
                </div>
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                    <h3 class="text-slate-800 font-semibold">Tips Pengisian</h3>
                    <p class="text-sm text-slate-600 mt-2">Isi sesuai hasil penimbangan/pengukuran bulan berjalan.
                        Gunakan titik (.) untuk desimal.</p>
                </div>
                {{-- import --}}
                <div class="mt-4">
                    <form method="POST" action="{{ route('laporan-anak.import') }}" enctype="multipart/form-data"
                        class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5 mb-4">
                        @csrf
                        <p class="text-slate-800 font-semibold mb-3">Import Data</p>
                        <div class="flex items-center gap-2">
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                class="block w-full text-sm text-slate-700 border-2 border-gray-200 hover:border-gray-500 rounded-lg">
                            <button class="px-3 py-1 rounded-md bg-sky-700 text-white hover:bg-sky-900">
                                Import
                            </button>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">
                            Format file: .xlsx, .xls, .csv. Gunakan template yang disediakan <a
                                href="/templates/LaporanTemplate.xlsx" class="text-sky-500 underline"> di sini</a>.
                        </p>
                        @error('file')
                            <div class="text-rose-600 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- ==== DATA & SCRIPT ==== --}}
    <script>
        // --- elemen detail ---
        const detailSection = document.getElementById('detail-anak');
        const detailAvatar = document.getElementById('detail-avatar');
        const detailNama = document.getElementById('detail-nama');
        const detailKelamin = document.getElementById('detail-kelamin');
        const detailUmur = document.getElementById('detail-umur');

        // tanggal pemeriksaan (akurasi hari)
        const reportDate = new Date("{{ $tanggalDipilih->format('Y-m-d') }}");

        // hitung umur (bulan) tepat di hari H
        function diffInMonths(dob, ref) {
            let m = (ref.getFullYear() - dob.getFullYear()) * 12 + (ref.getMonth() - dob.getMonth());
            if (ref.getDate() < dob.getDate()) m--;
            return Math.max(m, 0);
        }

        // === SAFE: encode via ->toJson(), tanpa arrow fn di Blade ===
        const anakLite = {!! $anakList->map(function ($a) {
                return [
                    'id' => $a->id,
                    'nama' => $a->nama,
                    'kelamin' => $a->kelamin,
                    'tanggal_lahir' => $a->tanggal_lahir,
                ];
            })->values()->toJson() !!};

        const selectAnak = document.querySelector('select[name="anak_id"]');

        selectAnak?.addEventListener('change', function() {
            const anak = anakLite.find(a => String(a.id) === String(this.value));
            if (!anak) {
                detailSection.classList.add('hidden');
                return;
            }

            detailSection.classList.remove('hidden');

            const initials = (anak.nama || '')
                .split(' ').map(s => s[0]).slice(0, 2).join('').toUpperCase() || 'A';
            detailAvatar.textContent = initials;
            detailNama.textContent = anak.nama;
            detailKelamin.textContent = (anak.kelamin === 'L' ? 'Laki-laki' :
                anak.kelamin === 'P' ? 'Perempuan' :
                (anak.kelamin || '-'));

            const umur = diffInMonths(new Date(anak.tanggal_lahir), reportDate);
            detailUmur.textContent = umur + ' bulan';
        });

        // jika sudah ada value terpilih (old value), render langsung
        if (selectAnak?.value) selectAnak.dispatchEvent(new Event('change'));
    </script>


</body>

</html>
