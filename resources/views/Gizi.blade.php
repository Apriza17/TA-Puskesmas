<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Gizi</title>
    @vite('resources/css/app.css')
    {{-- Chart.js v4 --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>

@include('Layout.Navbar')

<body class="bg-slate-200">
    {{-- HERO --}}
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="{{ asset('img/edge dec1.png') }}" alt="" class="size-40">
            <img src="{{ asset('img/edge dec1.png') }}" alt="" class="size-40 rotate-90">
        </div>
        <div class="lg:px-52 md:px-28 text-white -mt-20 mb-12">
            <h1 class="text-3xl font-bold mb-2">Rekap Gizi</h1>
            <p class="font-thin">Berikut merupakan laporan gizi bulanan tiap posyandu</p>
        </div>
        {{-- FILTER --}}
        <div class="flex flex-wrap justify-end gap-3 mr-52">
            <span class="py-1 px-2 rounded-md border-2 border-white bg-sky-900 text-white">Filter Posyandu</span>

            <form method="GET" action="{{ route('Laporan-Gizi') }}"
                class="flex flex-wrap items-center gap-3 text-black">
                <select name="posyandu_id" onchange="this.form.submit()"
                    class="border rounded-md py-1.5 px-2 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                    <option value="">Pilih Posyandu</option>
                    @foreach ($posyanduList as $posyandu)
                        <option value="{{ $posyandu->id }}" {{ $posyanduId == $posyandu->id ? 'selected' : '' }}>
                            {{ $posyandu->nama }}
                        </option>
                    @endforeach
                </select>

                @if ($anakList->count())
                    <span class="text-white">Pilih Anak :</span>
                    <select name="anak_id" onchange="this.form.submit()"
                        class="border rounded-md py-1.5 px-2 focus:outline-none focus:ring-2 focus:ring-cyan-600">
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

    {{-- INFO STATE --}}
    @if (!$laporan->count())
        <div class="text-center mt-10">
            @if (!$posyanduId)
                <div class="flex justify-center mb-5">
                    <div class="bg-white drop-shadow-lg rounded-b-sm">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-1 w-full rounded-t-sm"></div>
                        <div class="p-4">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="mx-auto size-12 text-blue-700">
                                <path fill-rule="evenodd"
                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="font-semibold text-blue-600 text-lg">Info</p>
                            <p class="text-slate-600 text-sm">Silakan memilih posyandu terlebih dahulu</p>
                        </div>
                    </div>
                </div>
            @elseif (!$anakId)
                <div class="flex justify-center mb-5">
                    <div class="bg-white drop-shadow-lg rounded-b-sm">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-400 h-1 w-full rounded-t-sm"></div>
                        <div class="p-4">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="mx-auto size-12 text-blue-700">
                                <path fill-rule="evenodd"
                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="font-semibold text-blue-600 text-lg">Info</p>
                            <p class="text-slate-600 text-sm">Posyandu sudah dipilih. Silakan memilih nama anak</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- CONTENT --}}
    <div class="mx-auto px-5 lg:px-10 xl:px-52 mt-2 pb-12">


        {{-- DATA ANAK --}}
        @if ($selectedAnak)
            <div class="bg-white rounded-2xl shadow-lg ring-1 ring-black/5 p-5 mb-6">
                <h4 class="text-xl font-bold mb-3 text-sky-900 text-center">Data Anak</h4>
                <div class="text-sm flex flex-wrap justify-around gap-6">
                    <div>
                        <label class="text-slate-500" for="">Nama :</label>
                        <p class="text-slate-900 text-lg font-semibold">{{ $selectedAnak->nama }}</p>
                    </div>
                    <div>
                        <label class="text-slate-500" for="">Kelamin :</label>
                        <p class="text-slate-900 text-lg font-semibold">{{ $selectedAnak->kelamin }}</p>
                    </div>
                    <div>
                        <label class="text-slate-500" for="">Tanggal Lahir :</label>
                        <p class="text-slate-900 text-lg font-semibold">
                            {{ \Carbon\Carbon::parse($selectedAnak->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <label class="text-slate-500" for="">Umur :</label>
                        <p class="text-slate-900 text-lg font-semibold">
                            {{ \Carbon\Carbon::parse($selectedAnak->tanggal_lahir)->diffInMonths(now()) }} bulan</p>
                    </div>
                    <div>
                        <label class="text-slate-500" for="">Berat Lahir :</label>
                        <p class="text-slate-900 text-lg font-semibold">{{ $selectedAnak->berat_lahir }}</p>
                    </div>
                    <div>
                        <label class="text-slate-500" for="">Tinggi Lahir :</label>
                        <p class="text-slate-900 text-lg font-semibold">{{ $selectedAnak->tinggi_lahir }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- CHARTS --}}
        @if ($laporan->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="bg-white rounded-2xl shadow-lg ring-1 ring-black/5 p-4">
                    <h4 class="text-center font-semibold mb-2">Berat Badan</h4>
                    <div class="relative" style="height:260px">
                        <canvas id="chartBerat" class="block"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg ring-1 ring-black/5 p-4">
                    <h4 class="text-center font-semibold mb-2">Tinggi Badan</h4>
                    <div class="relative" style="height:260px">
                        <canvas id="chartTinggi" class="block"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg ring-1 ring-black/5 p-4">
                    <h4 class="text-center font-semibold mb-2">Lingkar Kepala</h4>
                    <div class="relative" style="height:260px">
                        <canvas id="chartKepala" class="block"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg ring-1 ring-black/5 p-4">
                    <h4 class="text-center font-semibold mb-2">Lingkar Lengan Atas</h4>
                    <div class="relative" style="height:260px">
                        <canvas id="chartLengan" class="block"></canvas>
                    </div>
                </div>

            </div>
        @endif
    </div>

    @if ($laporan->count())
        <script>
            const laporan = @json($laporan);
            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sept', 'Okt', 'Nov', 'Des'];

            // siapkan data per bulan (null jika tidak ada)
            const bb = [],
                tb = [],
                lk = [],
                lla = [];
            for (let i = 1; i <= 12; i++) {
                const k = String(i).padStart(2, '0');
                const row = laporan[k] ? laporan[k][0] : null;
                bb.push(row ? Number(row.berat_badan) : null);
                tb.push(row ? Number(row.tinggi_badan) : null);
                lk.push(row ? Number(row.lingkar_kepala) : null);
                lla.push(row ? Number(row.lingkar_lengan_atas) : null);
            }

            // helper min/max (abaikan null), beri padding 10%
            function calcRange(arr) {
                const clean = arr.filter(v => v !== null && !isNaN(v));
                if (!clean.length) return {
                    min: 0,
                    max: 10
                };
                let min = Math.min(...clean),
                    max = Math.max(...clean);
                if (min === max) {
                    min -= 1;
                    max += 1;
                }
                const pad = (max - min) * 0.10;
                return {
                    min: Math.max(0, min - pad),
                    max: max + pad
                };
            }

            function makeGradient(ctx, color1, color2) {
                const g = ctx.createLinearGradient(0, 0, 0, 220);
                g.addColorStop(0, color1);
                g.addColorStop(1, color2);
                return g;
            }

            function buildChart(canvasId, data, unit, lineColor, fillTop, fillBottom) {
                const ctx = document.getElementById(canvasId).getContext('2d');
                const range = calcRange(data);
                const gradient = makeGradient(ctx, fillTop, fillBottom);

                return new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            data,
                            spanGaps: true,
                            label: unit,
                            borderColor: lineColor,
                            backgroundColor: gradient,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 5,
                            pointBorderWidth: 0,
                            tension: 0.3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        resizeDelay: 200,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => {
                                        const v = ctx.parsed.y;
                                        if (v == null) return '–';
                                        return `${v} ${unit}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(2, 132, 199, 0.08)'
                                } // cyan-600/10
                            },
                            y: {
                                suggestedMin: range.min,
                                suggestedMax: range.max,
                                grid: {
                                    color: 'rgba(2, 132, 199, 0.08)'
                                },
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            // warna tetap di spektrum biru–cyan
            buildChart('chartBerat', bb, 'kg', '#0ea5e9', 'rgba(14,165,233,0.25)', 'rgba(14,165,233,0.02)');
            buildChart('chartTinggi', tb, 'cm', '#2563eb', 'rgba(37,99,235,0.22)', 'rgba(37,99,235,0.02)');
            buildChart('chartKepala', lk, 'cm', '#1e40af', 'rgba(30,64,175,0.22)', 'rgba(30,64,175,0.02)');
            buildChart('chartLengan', lla, 'cm', '#0c4a6e', 'rgba(12,74,110,0.22)', 'rgba(12,74,110,0.02)');
        </script>
    @endif
</body>

</html>
