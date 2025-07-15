<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Gizi</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
@include('Layout.Navbar')

<body class="bg-slate-200">
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Rekap Gizi</h1>
                <p class="font-thin mb-14">Berikut merupakan laporan gizi bulanan tiap posyandu</p>
            </div>
            <div class="flex justify-end">
                <div>
                    <div class="mr-1 py-1 bg-sky-900 px-2 rounded-sm border-2 border-white">
                        <p>Filter Posyandu</p>
                    </div>
                </div>
                <div>
                    <form method="GET" action="{{ route('Laporan-Gizi') }}"
                        class="flex items-center gap-4 mb-6 text-black">
                        <select name="posyandu_id" onchange="this.form.submit()" class="border rounded-sm py-1 px-2">
                            <option value="">Pilih Posyandu</option>
                            @foreach ($posyanduList as $posyandu)
                                <option value="{{ $posyandu->id }}"
                                    {{ $posyanduId == $posyandu->id ? 'selected' : '' }}>
                                    {{ $posyandu->nama }}
                                </option>
                            @endforeach
                        </select>

                        @if ($anakList->count())
                            <p class="text-white">Pilih Anak : </p>
                            <select name="anak_id" onchange="this.form.submit()" class="border rounded-sm  py-1 px-2">
                                <option value="">Pilih nama anak</option>
                                @foreach ($anakList as $anak)
                                    <option value="{{ $anak->id }}" {{ $anakId == $anak->id ? 'selected' : '' }}>
                                        {{ $anak->nama }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Pesan peringatan --}}
    @if (!$laporan->count())
        <div class="text-center mt-10">
            @if (!$posyanduId)
                <div class="flex justify-center mb-5 ">
                    <div class=" justify-items-center bg-white drop-shadow-lg rounded-b-sm animate-jump">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-1 w-full rounded-t-sm"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-14 text-blue-700">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                clip-rule="evenodd" />
                        </svg>

                        <p class="font-semibold text-blue-600 text-lg px-4">Info</p>
                        <p class="font-normal text-slate-600 text-sm px-4 mb-2">Silahkan memilih posyandu terlebih
                            dahulu</p>

                    </div>
                </div>
            @elseif (!$anakId)
                <div class="flex justify-center mb-5">
                    <div class=" justify-items-center bg-white drop-shadow-lg rounded-b-sm animate-jump">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-1 w-full rounded-t-sm"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-14 text-blue-700">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                clip-rule="evenodd" />
                        </svg>

                        <p class="font-semibold text-blue-600 text-lg px-4">Info</p>
                        <p class="font-normal text-slate-600 text-sm px-4 mb-2">Posyandu sudah dipilih. Silahkan memilih
                            nama anak</p>

                    </div>
                </div>
            @endif
        </div>
    @endif
    {{-- section --}}
    <div class="lg:px-52 md:px-28 py-2 flex">
        @if ($selectedAnak)
            <div
                class="bg-white rounded shadow p-4 mb-6 w-fit mr-5 max-h-40 animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-150">
                <h4 class="text-xl font-bold mb-2 text-sky-900">Data Anak</h4>
                <table class="font-normal">
                    <tr>
                        <td>Nama</td>
                        <td class="pl-3">: {{ $selectedAnak->nama }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td class="pl-3">:
                            {{ \Carbon\Carbon::parse($selectedAnak->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td class="pl-3">:
                            {{ \Carbon\Carbon::parse($selectedAnak->tanggal_lahir)->diffInMonths(now()) }} Bulan</td>
                    </tr>

                </table>
            </div>
        @endif

        {{-- Chart Containers --}}
        @if ($laporan->count())
            <div
                class="grid grid-cols-2 gap-4 animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-200">
                <div class="bg-white rounded shadow p-4">
                    <h4 class="text-center font-semibold mb-2">Berat Badan</h4>
                    <canvas id="chartBerat"></canvas>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <h4 class="text-center font-semibold mb-2">Tinggi Badan</h4>
                    <canvas id="chartTinggi"></canvas>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <h4 class="text-center font-semibold mb-2">Lingkar Kepala</h4>
                    <canvas id="chartKepala"></canvas>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <h4 class="text-center font-semibold mb-2">Lingkar Lengan Atas</h4>
                    <canvas id="chartLengan"></canvas>
                </div>
            </div>
        @endif
    </div>
    @if ($laporan->count())
        <script>
            const laporan = @json($laporan);

            const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sept', 'Okt', 'Nov', 'Des'];
            const bb = [],
                tb = [],
                lk = [],
                lla = [];

            for (let i = 1; i <= 12; i++) {
                const bulan = i.toString().padStart(2, '0');
                const laporanBulan = laporan[bulan] ? laporan[bulan][0] : null;

                bb.push(laporanBulan ? laporanBulan.berat_badan : null);
                tb.push(laporanBulan ? laporanBulan.tinggi_badan : null);
                lk.push(laporanBulan ? laporanBulan.lingkar_kepala : null);
                lla.push(laporanBulan ? laporanBulan.lingkar_lengan_atas : null);
            }

            const chartConfig = (ctx, label, data) => ({
                type: 'line',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: label,
                        data: data,
                        borderColor: 'blue',
                        backgroundColor: 'rgba(255,0,0,0.1)',
                        fill: false,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            new Chart(document.getElementById('chartBerat'), chartConfig(null, 'Berat Badan', bb));
            new Chart(document.getElementById('chartTinggi'), chartConfig(null, 'Tinggi Badan', tb));
            new Chart(document.getElementById('chartKepala'), chartConfig(null, 'Lingkar Kepala', lk));
            new Chart(document.getElementById('chartLengan'), chartConfig(null, 'Lingkar Lengan Atas', lla));
        </script>
    @endif
</body>


</html>
