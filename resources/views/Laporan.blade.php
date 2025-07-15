<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <title>Laporan</title>
</head>
@include('Layout.Navbar')

<body class="bg-slate-300">
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Data Laporan</h1>
                <p class="font-thin mb-14">Berikut merupakan laporan bulanan tiap posyandu</p>
            </div>
            <div class="flex justify-end">
                <div>
                    <div class="mr-1 py-1 bg-sky-900 px-2 rounded-sm border-2 border-white">
                        <p>Filter Bulan</p>
                    </div>
                </div>
                <div>
                    <form method="GET" class="mb-4" id="filterBulan">
                        <input type="month" name="tanggal" value="{{ $tanggal->format('Y-m') }}"
                            onchange="document.getElementById('filterBulan').submit();"
                            class="border px-1 text-center py-1 rounded-sm text-black">
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- section  --}}
    <div class="lg:px-52 md:px-28">
        <div class="w-full bg-white p-2 mt-5  animate-fade-up animate-once animate-duration-1000 animate-ease-out">
            <table class="w-full">
                <tr class="border-b-2 border-slate-500">
                    <th class="py-2">No.</th>
                    <th>Nama Posyandu</th>
                    <th>Tanggal Pemeriksaan</th>
                    <th>Status</th>
                    <th class="max-w-15">Aksi</th>
                </tr>
                @foreach ($posyanduList as $i => $pos)
                    @php
                        $dataLaporan = $laporan[$pos->id] ?? null;
                    @endphp
                    <tr class="text-center font-light text-slate-700">
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $pos->nama }}</td>
                        <td>{{ $dataLaporan ? \Carbon\Carbon::parse($dataLaporan->tanggal_laporan)->translatedFormat('d F Y') : '-' }}
                        </td>
                        <td>
                            @if ($dataLaporan)
                                <span class="text-cyan-600 font-semibold">Sudah Melapor</span>
                            @else
                                <span class="text-red-600 font-semibold">Belum Melapor</span>
                            @endif
                        </td>
                        <td class="flex justify-center gap-2">
                            <a href=""
                                class="bg-orange-300 hover:bg-orange-800 mt-2 p-1 rounded-sm text-orange-600 scale-100 peer hover:scale-105 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 20.077V3h18v14H6.077zM6.5 13.5h7v-1h-7zm0-3h11v-1h-11zm0-3h11v-1h-11z" />
                                </svg>
                            </a>
                            @if ($dataLaporan)
                                <a href="/Laporan/{{ $dataLaporan->id }}"
                                    class="bg-cyan-300 hover:bg-cyan-800 mt-2 p-1 rounded-sm text-cyan-600 scale-100 peer hover:scale-105 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5">
                                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        <path fill-rule="evenodd"
                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @else
                                <span></span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
