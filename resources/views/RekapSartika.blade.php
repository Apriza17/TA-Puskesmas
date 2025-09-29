<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Sartika</title>
    @vite('resources/css/app.css')

</head>
@include('Layout.Navbar')

<body class="bg-slate-200">
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24 animate-fade animate-once animate-ease-out">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Rekap Sartika</h1>
                <p class="font-thin mb-14">Menu untuk mengatur akun, standar stunting dll</p>
            </div>

        </div>
    </div>
    {{-- Section --}}
    <div class="mx-auto px-5 lg:px-10 xl:px-52 -mt-24 pb-10">
        <div class="flex justify-end ">
            <form method="GET" action="{{ route('rekap.index') }}" class="mb-4 flex">
                <div class="mr-1 py-1 text-white bg-sky-900 px-2 rounded-sm border-2 border-white">
                    <p>Filter Bulan</p>
                </div>
                <input type="month" name="periode" id="bulan" placeholder="Pilih Bulan"
                    value="{{ request('periode') ?? date('Y-m') }}" onchange="this.form.submit()"
                    class="px-3 py-1 rounded-sm text-sm text-black border shadow-sm">
            </form>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full text-sm text-center">
                <thead class="bg-gray-100 font-bold text-gray-700 border-b border-gray-600">
                    <tr class="">
                        <th class="py-3">No</th>
                        <th>Posyandu</th>
                        <th>Sangat Pendek</th>
                        <th>Pendek</th>
                        <th>Normal</th>
                        <th>Tinggi</th>
                        <th>Total Balita</th>
                        <th>Balita Stunting</th>
                        <th>Angka Stunting (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekap as $i => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2">{{ $i + 1 }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['sangat_pendek'] }}</td>
                            <td>{{ $item['pendek'] }}</td>
                            <td>{{ $item['normal'] }}</td>
                            <td>{{ $item['tinggi'] }}</td>
                            <td>{{ $item['total_balita'] }}</td>
                            <td>{{ $item['balita_stunting'] }}</td>
                            <td class="text-red-600 font-bold">{{ $item['angka_stunting'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
