<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Belum Lapor</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('img/favlogo.png') }}">


</head>

<body class="bg-slate-200">
    @include('Layout.Navbar')
    {{-- head --}}
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div
            class="lg:px-52 md:px-28 text-white -translate-y-20 flex justify-between animate-fade animate-once animate-ease-out">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Sartika Belum Melapor</h1>
                <p class="text-sm text-white font-thin mb-4">
                    Berikut adalah daftar posyandu yang belum mengirimkan laporan pada bulan
                    <strong>{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                        {{ $tahun }}</strong>
                </p>
            </div>
        </div>
    </div>
    {{-- section --}}
    <div class="lg:px-52 md:px-28 py-5 mx-auto -mt-24">

        @if ($belumMelapor->isEmpty())
            <div class="bg-blue-100 text-blue-700 p-4 rounded shadow">
                🎉 Semua posyandu telah melapor bulan ini.
            </div>
        @else
            <form method="POST" action="{{ route('laporan.kirimPesanBelum') }}">
                @csrf
                <input type="hidden" name="periode"
                    value="{{ $tahun }}-{{ str_pad($bulan, 2, '0', STR_PAD_LEFT) }}">

                <div class="flex justify-between items-start mb-2 gap-4">
                    <div class="flex-1">
                        <label for="pesan" class="block text-sm font-medium text-white mb-1">
                            Isi Pesan Pengingat
                        </label>
                        @php
                            $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
                        @endphp
                        {{-- <input type="text" name="pesan" id="pesan"> --}}
                        <textarea id="pesan" name="pesan" rows="1"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-600"
                            placeholder="Tulis pesan pengingat untuk kader posyandu…">{{ old('pesan', "Yth. Kader Posyandu, mohon segera mengirim laporan penimbangan bulan $namaBulan $tahun melalui sistem pelaporan.") }}</textarea>
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-md shadow cursor-pointer hover:bg-orange-600">
                            Kirim Pesan Pengingat
                        </button>
                    </div>
                </div>
            </form>

            <div
                class="w-full bg-white p-2 mt-2 rounded-lg shadow-lg  animate-fade-up animate-once animate-duration-1000 animate-ease-out">
                <table class="w-full">
                    {{-- header tabel --}}
                    <tr class="border-b-2 border-slate-500">
                        <th class="px-3 py-1">No</th>
                        <th class="px-3 py-1 text-left">Nama Posyandu</th>
                        <th class="px-3 py-1">Jumlah Anak</th>
                        <th class="px-3 py-1">Status Pesan</th> {{-- NEW --}}
                    </tr>

                    {{-- body --}}
                    @foreach ($belumMelapor as $i => $p)
                        <tr class="border-b text-slate-700">
                            <td class="text-center px-3 py-2">
                                {{ $loop->iteration + ($belumMelapor->currentPage() - 1) * $belumMelapor->perPage(10) }}
                            </td>
                            <td class="px-3 py-2">{{ $p->nama }}</td>
                            <td class="text-center px-3 py-2">{{ $p->anak->count() }}</td>
                            <td class="text-center px-3 py-2">
                                @php
                                    $sent = !is_null($p->last_sent); // ada pesan terkirim di bulan ini?
                                    $read = isset($p->any_read) ? (int) $p->any_read : 0; // 1 jika ada yang sudah terbaca
                                @endphp

                                @if (!$sent)
                                    <span
                                        class="inline-flex items-center rounded-full bg-orange-200 text-orange-700 text-xs px-2 py-0.5">
                                        Belum dikirim
                                    </span>
                                @elseif ($read === 1)
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 text-xs px-2 py-0.5">
                                        Terbaca
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-yellow-100 text-yellow-700 text-xs px-2 py-0.5">
                                        Dikirim (Belum dibaca)
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="py-3">
                {{ $belumMelapor->links() }}
            </div>
        @endif
    </div>
</body>

</html>
