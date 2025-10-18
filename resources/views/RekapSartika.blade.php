{{-- resources/views/Admin/RekapSartika.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Rekap Sartika</title>
</head>

<body class="bg-slate-100">
    @include('Layout.Navbar')
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between z-0">
            <img src="img/edge dec1.png" alt="" class="size-40">
            {{-- <img src="img/edge dec1.png" alt="" class="size-40 rotate-90"> --}}
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24 z-10 animate-fade animate-once animate-ease-out">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Rekap Sartika</h1>
                <p class="font-thin mb-4">Ringkasan stunting tiap posyandu</p>
            </div>
        </div>

    </div>

    <div class="mx-auto px-5 lg:px-10 xl:px-24 -mt-28 pb-10">
        <div class="flex justify-between mb-2 z-20">
            <div></div>
            <div class="flex gap-2 items-center">
                <form method="GET" action="{{ route('rekap.sartika') }}" id="filterBulan"
                    class="flex items-center gap-2">
                    <span class="bg-sky-900 text-white px-2 py-1 rounded border-2 border-white">Filter Bulan</span>
                    <input type="month" name="tanggal" value="{{ $tanggal->format('Y-m') }}"
                        onchange="document.getElementById('filterBulan').submit();"
                        class="rounded border cursor-pointer px-2 py-1 text-black">
                </form>
                <div>
                    <a href="{{ route('rekapSartika.export', ['tanggal' => $tanggal->format('Y-m')]) }}"
                        class="bg-orange-500 px-2 py-1 text-white  rounded shadow hover:bg-orange-700 border-2 border-white">
                        Export Excel
                    </a>
                </div>

            </div>

        </div>


        <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-sky-600 text-white">
                    <tr>
                        <th class="px-3 py-3 text-center">No</th>
                        <th class="px-3 py-3 text-left">Nama Posyandu</th>
                        <th class="px-3 py-3 text-center">Jumlah Balita</th>
                        <th class="px-3 py-3 text-center" colspan="4">TB/U</th>
                        <th class="px-3 py-3 text-center">Balita Ditimbang</th>
                        <th class="px-3 py-3 text-center">Balita Tidak Ditimbang</th>
                        <th class="px-3 py-3 text-center">Angka Stunting (%)</th>
                    </tr>
                    <tr class="bg-sky-700 text-slate-200">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="px-2 py-2 text-center">Sangat Pendek</th>
                        <th class="px-2 py-2 text-center">Pendek</th>
                        <th class="px-2 py-2 text-center">Normal</th>
                        <th class="px-2 py-2 text-center">Tinggi</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($rows as $i => $r)
                        <tr class="bg-white hover:bg-slate-50">
                            <td class="px-3 py-2 text-center">
                                {{ $loop->iteration + ($rows->currentPage() - 1) * $rows->perPage(10) }}</td>
                            <td class="px-3 py-2">{{ $r->posyandu }}</td>
                            <td class="px-3 py-2 text-center">{{ $r->total_balita }}</td>
                            <td class="px-3 py-2 text-center">{{ $r->sangat_pendek }}</td>
                            <td class="px-3 py-2 text-center">{{ $r->pendek }}</td>
                            <td class="px-3 py-2 text-center">{{ $r->normal }}</td>
                            <td class="px-3 py-2 text-center">{{ $r->tinggi }}</td>
                            <td class="px-3 py-2 text-center">{{ $r->ditimbang }}</td>
                            <td class="px-3 py-2 text-center">{{ $r->tdk_ditimbang }}</td>
                            <td class="px-3 py-2 text-center">
                                @if (!is_null($r->persen_stunting))
                                    {{ number_format($r->persen_stunting, 2) }}
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-3 py-6 text-center text-slate-500">
                                Tidak ada data untuk bulan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-slate-50">
                    <tr>
                        <td colspan="9" class="px-3 py-3 text-right font-semibold">Rata-Rata Stunting</td>
                        <td class="px-3 py-3 text-center font-semibold">
                            @if (!is_null($rataRata))
                                {{ number_format($rataRata, 2) }}
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $rows->onEachSide(1)->links() }}
        </div>
    </div>
</body>

</html>
