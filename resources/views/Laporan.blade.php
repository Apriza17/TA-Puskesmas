<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <title>Laporan</title>
</head>

@include('Layout.Navbar')

<body class="bg-slate-300">
    {{-- HERO --}}
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="{{ asset('img/edge dec1.png') }}" alt="" class="size-40">
            <img src="{{ asset('img/edge dec1.png') }}" alt="" class="size-40 rotate-90">
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24">
            <h1 class="text-3xl font-bold mb-2">Rekap Laporan Bulanan</h1>
            <p class="font-thin mb-14">Berikut merupakan laporan bulanan tiap posyandu</p>
        </div>
    </div>

    {{-- SECTION --}}
    <div class="mx-auto px-5 lg:px-10 xl:px-52 -mt-24 pb-10">

        {{-- FILTER + SUMMARY --}}

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex gap-2">
                <span
                    class="inline-flex items-center gap-2 rounded-lg bg-white/70 ring-1 ring-black/5 px-3 py-2 text-slate-700">
                    <span class="size-2 rounded-full bg-cyan-600"></span>
                    <span class="text-sm font-medium">Sudah: {{ $sudahAll }}</span>
                </span>
                <span
                    class="inline-flex items-center gap-2 rounded-lg bg-white/70 ring-1 ring-black/5 px-3 py-2 text-slate-700">
                    <span class="size-2 rounded-full bg-rose-600"></span>
                    <span class="text-sm font-medium">Belum: {{ $belumAll }}</span>
                </span>
                <span
                    class="inline-flex items-center gap-2 rounded-lg bg-white/70 ring-1 ring-black/5 px-3 py-2 text-slate-700">
                    <span class="size-2 rounded-full bg-slate-400"></span>
                    <span class="text-sm">Total Posyandu: {{ $totalPosAll }}</span>
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="bg-sky-900 font-semibold px-2 text-lg py-1 border-2 border-white text-white rounded-sm">
                    Filter Bulan
                </span>
                <form method="GET" id="filterBulan">
                    <input type="month" name="tanggal" value="{{ $tanggal->format('Y-m') }}"
                        onchange="document.getElementById('filterBulan').submit();"
                        class="border px-2 text-center py-1 rounded-md text-black focus:outline-none focus:ring-2 focus:ring-cyan-600">
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="mt-5 rounded-2xl bg-white shadow-xl ring-1 ring-black/5 overflow-hidden animate-fade-up">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="sticky top-0 bg-white/90 backdrop-blur border-b">
                        <tr class="text-left text-slate-700">
                            <th class="py-3 px-4 w-14">No.</th>
                            <th class="px-4">Nama Posyandu</th>
                            <th class="px-4">Tanggal Pemeriksaan</th>
                            <th class="px-4">Status</th>
                            <th class="px-4 w-32 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($posyanduList as $i => $pos)
                            @php $dataLaporan = $laporan[$pos->id] ?? null; @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 text-center text-slate-600">
                                    {{ ($posyanduList->firstItem() ?? 0) + $i }}</td>
                                <td class="px-4 font-medium text-slate-800">{{ $pos->nama }}</td>
                                <td class="px-4 text-slate-600">
                                    {{ $dataLaporan ? \Carbon\Carbon::parse($dataLaporan->tanggal_laporan)->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="px-4">
                                    @if ($dataLaporan)
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-cyan-100 text-cyan-800 px-3 py-1 text-xs font-semibold">
                                            <span class="size-1.5 rounded-full bg-cyan-600"></span> Sudah Melapor
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-rose-100 text-rose-700 px-3 py-1 text-xs font-semibold">
                                            <span class="size-1.5 rounded-full bg-rose-600"></span> Belum Melapor
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- tombol daftar ringkas (placeholder href kosong seperti semula) --}}


                                        @if ($dataLaporan)
                                            <a href="/Laporan/{{ $dataLaporan->id }}" title="Lihat detail"
                                                class="inline-flex items-center justify-center size-8 rounded-md bg-cyan-100 text-cyan-600 hover:bg-cyan-200 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="size-5">
                                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @else
                                            <button type="button" disabled
                                                class="inline-flex items-center justify-center size-8 rounded-md bg-slate-100 text-slate-400 cursor-not-allowed"
                                                title="Belum ada laporan">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="size-5">
                                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-slate-500">
                                    Tidak ada data posyandu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t bg-white">
                {{ $posyanduList->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</body>

</html>
