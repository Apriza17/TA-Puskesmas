<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Belum Lapor</title>
    @vite('resources/css/app.css')

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
    <div class="lg:px-52 md:px-28 py-5 mx-auto">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($belumMelapor->isEmpty())
            <div class="bg-blue-100 text-blue-700 p-4 rounded shadow">
                🎉 Semua posyandu telah melapor bulan ini.
            </div>
        @else
            <form method="POST" class="" action="{{ route('laporan.kirimPesanBelum') }}">
                @csrf
                <div class="flex justify-between">
                    <p class="text-xl font-bold ">List Sartika</p>
                    <button type="submit"
                        class="mb-4 px-4 py-1 bg-orange-500 text-white font-semibold rounded-sm shadow hover:bg-orange-600">
                        Kirim Pesan Pengingat
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-200 rounded shadow">
                    <thead class="bg-white text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Nama Posyandu</th>
                            <th class="px-4 py-2 text-left">Jumlah Anak</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white border-t-2 border-black">
                        @foreach ($belumMelapor as $index => $posyandu)
                            <tr class="">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $posyandu->nama }}</td>
                                <td class="px-4 py-2">{{ $posyandu->anak->count() }} anak</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>

</html>
