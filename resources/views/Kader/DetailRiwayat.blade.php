<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Detail Riwayat Laporan</title>
</head>

<body class="bg-slate-200">

    <div class="bg-gradient-to-r relative from-cyan-800 to-cyan-600 h-28 drop-shadow-lg overflow-hidden">
        <div class="text-white font-semibold flex justify-center items-center h-full">
            <div class="text-2xl">Detail Riwayat Laporan</div>
            <a href="/Riwayat-laporan" class="absolute left-4">
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
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-4">
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                    <h2 class="text-lg font-semibold text-slate-800">Ringkasan</h2>
                    <dl class="mt-3 text-sm">
                        <div class="flex gap-3 py-1">
                            <dt class="text-slate-500 min-w-28">Posyandu</dt>
                            <dd class="text-slate-800">: {{ optional($bulanan->posyandu)->nama ?? '-' }}</dd>
                        </div>
                        <div class="flex gap-3 py-1">
                            <dt class="text-slate-500 min-w-28">Periode</dt>
                            <dd class="text-slate-800">: {{ $awal->translatedFormat('F Y') }}</dd>
                        </div>
                        <div class="flex gap-3 py-1">
                            <dt class="text-slate-500 min-w-28">Status</dt>
                            <dd class="text-slate-800">:
                                @if ($bulanan->status === 'sudah')
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 text-[12px] px-2 py-0.5">
                                        Sudah dikirim
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-yellow-100 text-yellow-700 text-[12px] px-2 py-0.5">
                                        Draft
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm overflow-x-auto">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-base sm:text-lg font-semibold text-slate-800">
                            Data Pemeriksaan Anak ({{ $laporan->count() }})
                        </h3>
                    </div>

                    <table class="min-w-full text-[13px] sm:text-sm">
                        <thead class="bg-cyan-800 text-white">
                            <tr class="text-center">
                                <th class="px-3 py-3">No</th>
                                <th class="px-3 py-3">NIK</th>
                                <th class="px-3 py-3 text-left">Nama</th>
                                <th class="px-3 py-3">Kelamin</th>
                                <th class="px-3 py-3">Tgl Periksa</th>
                                <th class="px-3 py-3">BB</th>
                                <th class="px-3 py-3">TB</th>
                                <th class="px-3 py-3">LK</th>
                                <th class="px-3 py-3">LILA</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($laporan as $i => $r)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-3 py-3 text-center">{{ $i + 1 }}</td>
                                    <td class="px-3 py-3 text-center">{{ $r->nik }}</td>
                                    <td class="px-3 py-3">{{ $r->nama_anak }}</td>
                                    <td class="px-3 py-3 text-center">{{ $r->kelamin }}</td>
                                    <td class="px-3 py-3 text-center">
                                        {{ \Carbon\Carbon::parse($r->tanggal_pemeriksaan)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-3 py-3 text-center">{{ number_format($r->berat_badan, 1) }}</td>
                                    <td class="px-3 py-3 text-center">{{ number_format($r->tinggi_badan, 1) }}</td>
                                    <td class="px-3 py-3 text-center">{{ number_format($r->lingkar_kepala, 1) }}</td>
                                    <td class="px-3 py-3 text-center">{{ number_format($r->lingkar_lengan_atas, 1) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-3 py-6 text-center text-slate-500">
                                        Belum ada data pemeriksaan pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
