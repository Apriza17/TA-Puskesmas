<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan | Detail</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-200">
    {{-- HERO --}}
    <div class="relative bg-gradient-to-t from-gray-700 to-cyan-600 h-56 w-full shadow">
        <div
            class="absolute top-0 left-0 text-white bg-red-600/80 hover:bg-red-800 rounded-br-2xl px-5 py-3 font-semibold no-print z-10">
            <a href="/Laporan">Kembali</a>
        </div>
        <div class="flex justify-between z-0">
            <img src="{{ asset('img/edge dec1.png') }}" alt="" class="size-40">
            <img src="{{ asset('img/edge dec1.png') }}" alt=""
                class="size-40 rotate-90 select-none pointer-events-none">
        </div>
        <div class=" mx-auto px-5 lg:px-10 xl:px-28 -translate-y-36">
            <div class="flex items-center justify-between gap-6 text-white">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Detail Laporan</h1>
                    <p class="text-white/80 mt-1">Berikut merupakan detail laporan bulanan tiap posyandu</p>
                </div>
                <div class="hidden sm:block">
                    <img src="{{ asset('img/img1.png') }}" alt="" class="w-32 sm:w-36 opacity-90">
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class=" mx-auto px-5 lg:px-10 xl:px-28 -mt-6 pb-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- SIDECARD: DETAIL --}}
            <div class="lg:col-span-4">
                <div
                    class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5 animate-fade-up animate-once animate-duration-1000 animate-ease-out">
                    <h2 class="text-lg font-semibold text-slate-800">Detail</h2>
                    <dl class="mt-3 text-sm">
                        <div class="flex gap-3 py-1">
                            <dt class="text-slate-500 min-w-24">Posyandu</dt>
                            <dd class="text-slate-800">: {{ optional($laporanBulanan->posyandu)->nama ?? '-' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-5">
                        <h3 class="text-lg font-semibold text-amber-500">Keterangan</h3>
                        <div class="mt-2 text-sm">
                            <div class="flex gap-3 py-1">
                                <span class="text-slate-500 min-w-24">Baris 1</span>
                                <span class="text-slate-800">: Berat Badan</span>
                            </div>
                            <div class="flex gap-3 py-1">
                                <span class="text-slate-500 min-w-24">Baris 2</span>
                                <span class="text-slate-800">: Tinggi Badan</span>
                            </div>
                            <div class="flex gap-3 py-1">
                                <span class="text-slate-500 min-w-24">Baris 3</span>
                                <span class="text-slate-800">: Lingkar Kepala</span>
                            </div>
                            <div class="flex gap-3 py-1">
                                <span class="text-slate-500 min-w-24">Baris 4</span>
                                <span class="text-slate-800">: Lingkar Lengan Atas</span>
                            </div>
                        </div>

                        <div class="mt-6 rounded-lg bg-cyan-50 ring-1 ring-cyan-100 text-cyan-900 px-3 py-2 text-xs">
                            Tips: warna <span class="font-semibold text-rose-600">merah</span> pada tinggi badan
                            menandakan status <span class="font-semibold">Stunting</span> pada bulan tersebut.
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="lg:col-span-8">
                <div
                    class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm animate-fade-up animate-once animate-duration-1000 animate-ease-out">
                    @php
                        $bulanNama = [
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'Mei',
                            'Jun',
                            'Jul',
                            'Agus',
                            'Sept',
                            'Okt',
                            'Nov',
                            'Des',
                        ];
                    @endphp

                   <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base sm:text-lg font-semibold text-slate-800">
                            Hasil Pengukuran Tahun {{ $tahun }}
                        </h3>

                        {{-- FILTER TAHUN --}}
                        <form method="GET" class="flex items-center gap-2">
                            {{-- ketika paginate, withQueryString() sudah menjaga ?tahun ikut; di sini cukup set tahun --}}
                            <label class="text-sm text-slate-600">Tahun</label>
                            <select name="tahun" onchange="this.form.submit()"
                                    class="rounded-md border-slate-300 text-sm px-2 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                            @for ($y = now()->year; $y >= now()->year - 6; $y--)
                                <option value="{{ $y }}" {{ (int)request('tahun', $tahun) === $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                            </select>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-[13px] sm:text-sm">
                            <thead class="bg-cyan-800 text-white">
                                <tr class="text-center">
                                    <th class="px-3 py-3 whitespace-nowrap align-middle" rowspan="2">No</th>
                                    <th class="px-3 py-3 whitespace-nowrap align-middle" rowspan="2">Nama</th>
                                    <th class="px-1 py-3 whitespace-nowrap align-middle" rowspan="2">Kelamin</th>
                                    <th class="px-3 py-3 whitespace-nowrap align-middle" rowspan="2">Tgl Lahir</th>
                                    <th class="px-3 py-3 whitespace-nowrap align-middle" colspan="12">Hasil Pengukuran
                                    </th>
                                </tr>
                                <tr class="text-slate-200">
                                    @foreach ($bulanNama as $bulan)
                                        <th class="px-2 py-2 text-center">{{ $bulan }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200">
                                @foreach ($anakList as $i => $anak)
                                    <tr class="bg-white hover:bg-slate-50">
                                        <td class="px-3 py-3 text-center align-top">
                                            {{ ($anakList->firstItem() ?? 0) + $i }}</td>
                                        <td class="px-3 py-3 align-top">
                                            <div class="font-medium text-slate-800">{{ $anak->nama }}</div>
                                        </td>
                                        <td class="px-3 py-3 text-center align-top">
                                            {{ $anak->kelamin }}
                                        </td>
                                        <td class="px-1 py-3 text-center align-top">
                                            {{ $anak->tanggal_lahir ? \Carbon\Carbon::parse($anak->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                        </td>


                                        @for ($m = 1; $m <= 12; $m++)
                                            @php
                                                $key = $anak->id . '-' . $m;
                                                $lap = $laporanAnak[$key][0] ?? null;
                                            @endphp
                                            <td
                                                class="px-2 py-2 text-center align-top text-[12px] sm:text-[13px] leading-4">
                                                @if ($lap)
                                                    {{-- Baris 1: BB --}}
                                                    <div class="text-slate-800">
                                                        {{ number_format($lap->berat_badan, 1) }}</div>

                                                    {{-- Baris 2: TB (highlight merah kalau Stunting) --}}
                                                    <div
                                                        class="{{ $lap->status_stunting === 'Stunting' ? 'text-rose-600 font-semibold' : 'text-slate-800' }}">
                                                        {{ rtrim(rtrim(number_format($lap->tinggi_badan, 1), '0'), '.') }}
                                                    </div>

                                                    {{-- Baris 3: LK --}}
                                                    <div class="text-slate-600">
                                                        {{ rtrim(rtrim(number_format($lap->lingkar_kepala, 1), '0'), '.') }}
                                                    </div>

                                                    {{-- Baris 4: LILA --}}
                                                    <div class="text-slate-600">
                                                        {{ rtrim(rtrim(number_format($lap->lingkar_lengan_atas, 1), '0'), '.') }}
                                                    </div>
                                                @else
                                                    <span class="text-slate-400">-</span>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach

                                @if (count($anakList) === 0)
                                    <tr>
                                        <td colspan="16" class="px-3 py-6 text-center text-slate-500">
                                            Belum ada data anak pada posyandu ini.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{-- footer kecil --}}
                    <div class="px-5 py-3 text-xs text-slate-500 border-t border-gray-100">
                        Keterangan: BB = Berat Badan (kg), TB = Tinggi Badan (cm), LK = Lingkar Kepala (cm), LILA =
                        Lingkar Lengan Atas (cm).
                    </div>
                    <div class="px-5 py-4 border-t border-gray-100">
                        {{ $anakList->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PRINT STYLE --}}
    {{--  --}}
</body>

</html>
