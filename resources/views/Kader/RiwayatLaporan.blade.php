<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Riwayat Laporan</title>
</head>

<body class="bg-slate-200">

    <div class="bg-gradient-to-r relative from-cyan-800 to-cyan-600 h-28 drop-shadow-lg overflow-hidden">
        <img src="img/edge dec1.png" class="absolute z-0 size-56 right-0 rotate-90" alt="">
        <div class="text-white font-semibold flex justify-center items-center h-full">
            <div class="text-2xl">Riwayat Laporan</div>
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

    <div class="mx-auto px-5 lg:px-10 xl:px-28 mt-3 pb-10">
        <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-4 mb-4">
            <form method="GET" class="flex items-center gap-3">
                <label class="text-sm text-slate-700">Filter Bulan</label>
                <input type="month" name="periode" value="{{ $periode }}"
                    class="border rounded px-2 py-1 text-black" onchange="this.form.submit()">
            </form>
        </div>

        <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-cyan-800 text-white">
                    <tr>
                        <th class="px-3 py-3 text-center">No</th>
                        <th class="px-3 py-3 text-left">Tanggal laporan</th>
                        <th class="px-3 py-3 text-center">Jumlah Anak Dilaporkan</th>
                        <th class="px-3 py-3 text-center">Status</th>
                        <th class="px-3 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($rows as $i => $r)
                        <tr class="hover:bg-slate-50">
                            <td class="px-3 py-3 text-center">{{ ($rows->firstItem() ?? 0) + $i }}</td>
                            <td class="px-3 py-3">
                                {{ \Carbon\Carbon::parse($r->tanggal_laporan)->translatedFormat('F Y') }}
                            </td>
                            <td class="px-3 py-3 text-center">{{ $r->jml_anak }}</td>
                            <td class="px-3 py-3 text-center">
                                @if ($r->status === 'sudah')
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 text-xs px-2 py-0.5">
                                        Sudah dikirim
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-yellow-100 text-yellow-700 text-xs px-2 py-0.5">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-center">
                                <a href="{{ route('detail.riwayat', $r->id) }}"
                                    class="inline-flex items-center gap-1 rounded bg-cyan-600 hover:bg-cyan-700 text-white text-xs px-3 py-1 transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-6 text-center text-slate-500">
                                Belum ada riwayat laporan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-4 py-3">
                {{ $rows->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</body>

</html>
