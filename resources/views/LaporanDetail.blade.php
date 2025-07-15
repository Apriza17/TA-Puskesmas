<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan|Detail</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-300">
    @include('Layout.Navbar')
    {{-- head --}}
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24 flex justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Detail Laporan</h1>
                <p class="font-thin mb-4">Berikut merupakan detail laporan bulanan tiap posyandu</p>
            </div>
            <div>
                <img src="img/img1.png" alt="" class="w-36">
            </div>
        </div>
    </div>
    {{-- tabel --}}
    <div class="px-5 flex">
        {{-- detail --}}
        <div
            class="w-1/3 mr-5 rounded-sm drop-shadow-lg bg-white p-3 mt-5 animate-fade-up animate-once animate-duration-1000 animate-ease-out">
            <p class="font-semibold text-xl mb-1">Detail</p>
            <table class="font-light">
                <tr>
                    <td>Posyandu</td>
                    <td class="pl-3">: {{ $laporanBulanan->posyandu->nama }}</td>
                </tr>
            </table>

            <div>
                <p class="font-semibold text-xl mt-3 mb-1 text-amber-500">Keterangan</p>
                <table class="font-light">
                    <tr>
                        <td>Baris 1</td>
                        <td class="pl-3">: Berat Badan</td>
                    </tr>
                    <tr>
                        <td>Baris 2</td>
                        <td class="pl-3">: Tinggi Badan</td>
                    </tr>
                    <tr>
                        <td>Baris 3</td>
                        <td class="pl-3">: Lingkar Kepala</td>
                    </tr>
                    <tr>
                        <td>Baris 4</td>
                        <td class="pl-3">: Lingkar Lengan Atas</td>
                    </tr>

                </table>
            </div>
        </div>

        {{-- table --}}
        <div class="w-full">
            <div
                class="w-full bg-white p-1 mt-5 rounded-sm drop-shadow-lg animate-fade-up animate-once animate-duration-1000 animate-ease-out">
                @php
                    $bulanNama = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sept', 'Okt', 'Nov', 'Des'];
                @endphp
                <table class="w-full text-sm border">
                    <thead>
                        <tr class="bg-cyan-800 text-white text-center">
                            <th rowspan="2">No</th>
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">Kelamin</th>
                            <th rowspan="2">Umur</th>
                            <th colspan="12">Hasil Pengukuran Tahun {{ $tahun }}</th>
                        </tr>
                        <tr class="bg-cyan-800 text-slate-300 text-center">
                            @foreach ($bulanNama as $bulan)
                                <th>{{ $bulan }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anakList as $i => $anak)
                            <tr class="border-b-2 border-slate-700">
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td class="text-center">{{ $anak->nama }}</td>
                                <td class="text-center">{{ $anak->kelamin }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->diffInMonths(now()) }} Bulan
                                </td>
                                @for ($m = 1; $m <= 12; $m++)
                                    @php
                                        $key = $anak->id . '-' . $m;
                                        $lap = $laporanAnak[$key][0] ?? null;
                                    @endphp
                                    <td class="text-xs font-light text-center">
                                        @if ($lap)
                                            {{ $lap->berat_badan }}<br>
                                            <span class="{{ $lap->status_stunting === 'Stunting' ? 'text-red-600 font-bold' : '' }}">{{ $lap->tinggi_badan }}</span><br>
                                            {{ $lap->lingkar_kepala }}<br>
                                            {{ $lap->lingkar_lengan_atas }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>


</body>

</html>
