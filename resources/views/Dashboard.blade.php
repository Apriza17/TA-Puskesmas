<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <title>Beranda|Admin</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}">
</head>
@include('Layout.Navbar')

<body class="bg-slate-200">
    {{-- Header --}}
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div
            class="lg:px-52 md:px-28 text-white -translate-y-24 flex justify-between animate-fade animate-once animate-ease-out">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Halo {{ $user->name }}!</h1>
                <p class="font-thin mb-4">Selamat datang di Web Pemantauan
                    stunting daerah Puskesmas <br> Gunung
                    Sari
                    Ulu.
                    Lakukan Pengecekan
                    sekarang?</p>
                <a href="/Laporan"
                    class="bg-cyan-400 hover:bg-cyan-600 outline outline-2 outline-white rounded-xl px-5 text-sm font-semibold">Klik
                    Disini</a>
            </div>
            <div>
                <img src="img/img1.png" alt="" class="w-36">
            </div>
        </div>
    </div>
    {{-- Section --}}
    <div class="lg:px-48 md:px-28 pt-5">
        <div class="flex justify-center gap-4">
            <div>
                <div class="flex flex-wrap gap-2">
                    {{-- Card --}}
                    <div
                        class="bg-white shadow-soft rounded-2xl p-5 max-w-52 animate-fade-up animate-once animate-duration-1000 animate-ease-out drop-shadow-lg">
                        <div class="flex items-start justify-between">
                            <p class="text-slate-500 font-semibold">Angka Stunting</p>
                            <span
                                class="inline-flex items-center justify-center size-8 rounded-xl bg-brand-50 text-brand-700">
                                <!-- icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13 13h7v2h-7zm0-4h7v2h-7zM3 17h17v2H3zm0-4h8v2H3zm0-4h8v2H3zm0-4h17v2H3z" />
                                </svg>
                            </span>
                        </div>
                        <div class="mt-5 text-3xl font-bold text-brand-800">
                            {{ $avgStunting !== null ? number_format($avgStunting, 2) . '%' : '–' }}</div>
                        <p class="text-slate-500 text-xs mt-1">Rata-rata stunting bulan
                            {{ now()->translatedFormat('F Y') }}</p>
                    </div>
                    {{-- belum lapor --}}
                    @if ($jumlahBelumMelapor > 0)
                        <a href="/Belum-Melapor"
                            class="group block bg-white shadow-soft rounded-2xl p-5 transition-all duration-100 hover:shadow-lg animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-[200ms]">
                            <div class="flex items-start justify-between">
                                <p class="text-slate-500 font-semibold">Status Bulanan</p>
                                <span
                                    class="inline-flex items-center justify-center size-8 rounded-xl bg-amber-50 text-amber-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M17.75 3A3.25 3.25 0 0 1 21 6.25v11.5A3.25 3.25 0 0 1 17.75 21H6.25A3.25 3.25 0 0 1 3 17.75V6.25A3.25 3.25 0 0 1 6.25 3zm-10 10.5a1.25 1.25 0 1 0 0 2.5a1.25 1.25 0 0 0 0-2.5m4.25 0a1.25 1.25 0 1 0 0 2.5a1.25 1.25 0 0 0 0-2.5m-4.25-5a1.25 1.25 0 1 0 0 2.5a1.25 1.25 0 0 0 0-2.5m4.25 0a1.25 1.25 0 1 0 0 2.5a1.25 1.25 0 0 0 0-2.5m4.25 0a1.25 1.25 0 1 0 0 2.5a1.25 1.25 0 0 0 0-2.5" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-5">
                                <div class="text-3xl font-bold text-amber-700">{{ $jumlahBelumMelapor }}</div>
                                <p class="text-slate-600 text-sm">Sartika belum melapor</p>
                                <span class="text-brand-700 text-sm font-semibold inline-flex items-center gap-1 mt-2">
                                    Lihat daftar
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="m10 17l5-5l-5-5v10z" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @else
                        <div
                            class="bg-white shadow-soft rounded-2xl p-5 animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-[200ms]">
                            <div class="flex items-start justify-between">
                                <p class="text-slate-500 text-sm">Status Bulanan</p>
                                <span
                                    class="inline-flex items-center justify-center size-8 rounded-xl bg-emerald-50 text-emerald-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="m9 16.17l-3.88-3.88L4 13.41L9 18.41L20.59 6.83L19.17 5.41z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-5 text-3xl font-bold text-emerald-700">Lengkap</div>
                            <p class="text-slate-500 text-xs mt-1">Semua posyandu sudah melapor</p>
                        </div>
                    @endif
                    {{-- notifikasi --}}
                    <a href="#" id="openModal"
                        class="group bg-white shadow-soft rounded-2xl p-5  hover:shadow-lg transition animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-[300ms]">
                        <div class="flex items-start justify-between">
                            <p class="text-slate-500 font-semibold">Notifikasi Masuk</p>
                            <span
                                class="inline-flex items-center justify-center size-8 rounded-xl bg-yellow-50 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12 22a2 2 0 0 0 2-2H10a2 2 0 0 0 2 2m6-6v-5a6 6 0 0 0-4-5.65V4a2 2 0 1 0-4 0v1.35A6 6 0 0 0 6 11v5l-2 2v1h16v-1z" />
                                </svg>
                            </span>
                        </div>

                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <div class="mt-5 flex items-center gap-3">

                                <div>
                                    <div class="text-2xl font-bold text-yellow-600">
                                        {{ auth()->user()->unreadNotifications->count() }}</div>
                                    <p class="text-slate-500 text-xs">belum dibaca</p>
                                </div>
                            </div>
                        @else
                            <p class="mt-6 text-slate-600">Notifikasi kosong</p>
                        @endif
                    </a>
                </div>
                {{-- top3 --}}
                <div class="mt-6">
                    <div
                        class="bg-white rounded-2xl shadow-md ring-1 ring-black/5 p-5 animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-[300ms]">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-slate-800 font-semibold">
                                Top 3 Posyandu Angka Stunting Terendah
                                <span class="text-slate-500 font-normal">
                                    ({{ now()->translatedFormat('F Y') }})
                                </span>
                            </h3>
                        </div>

                        @if (!empty($top3))
                            <ol class="divide-y divide-slate-100">
                                @foreach ($top3 as $i => $row)
                                    <li class="py-3 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="inline-flex size-8 items-center justify-center rounded-full text-white
                                    {{ [0 => 'bg-amber-500', 1 => 'bg-slate-400', 2 => 'bg-orange-600'][$i] ?? 'bg-slate-300' }}">
                                                {{ $i + 1 }}
                                            </span>
                                            <div>
                                                <div class="font-semibold text-slate-800">{{ $row['nama'] }}</div>
                                                <div class="text-xs text-slate-500">
                                                    Ditimbang: {{ $row['ditimbang'] }} &middot; Stunting:
                                                    {{ $row['stunted'] }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-lg font-bold text-emerald-600">
                                            {{ number_format($row['rate'], 2) }}%
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <p class="text-slate-500 text-sm">Belum ada data penimbangan pada bulan ini.</p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- kalender --}}
            <div
                class=" bg-white animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-[400ms] drop-shadow-lg rounded-2xl w-96">
                <div class="bg-white shadow-soft rounded-2xl p-5" x-data="miniCalendar()" x-init="init()">
                    <div class="flex items-center justify-between mb-3">
                        <button class="p-2 rounded-lg hover:bg-slate-100" @click="prevMonth()" aria-label="Prev">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m15 18l-6-6l6-6v12z" />
                            </svg>
                        </button>
                        <div class="text-sm font-semibold text-slate-800" x-text="title"></div>
                        <button class="p-2 rounded-lg hover:bg-slate-100" @click="nextMonth()" aria-label="Next">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m9 6l6 6l-6 6V6z" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-7 text-[11px] text-slate-500 mb-1">
                        <div class="text-center">Min</div>
                        <div class="text-center">Sen</div>
                        <div class="text-center">Sel</div>
                        <div class="text-center">Rab</div>
                        <div class="text-center">Kam</div>
                        <div class="text-center">Jum</div>
                        <div class="text-center">Sab</div>
                    </div>

                    <div class="grid grid-cols-7 gap-1">
                        <template x-for="(d,i) in days" :key="i">
                            <div class="aspect-square">
                                <div class="w-full h-full flex items-center justify-center text-sm rounded-lg"
                                    :class="{
                                        'text-slate-300': d.muted,
                                        'bg-brand-600 text-white font-semibold': d.isToday,
                                        'hover:bg-slate-100': !d.isToday && !d.muted
                                    }"
                                    x-text="d.num"></div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>


    </div>
    {{-- Modal --}}
    <div id="modal" class="fixed inset-0 flex  items-center justify-end bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-slate-200 w-72 h-full rounded-md relative animate-fade-left">
            <button class="absolute bg-slate-200 rounded-full -left-5 top-2" id="closeModal">
                <div class=" text-red-500 rounded-full p-1" id="">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-10">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
            <div class="p-3">
                <div class="px-4 flex justify-between items-center">
                    <p class="font-semibold mb-4 text-lg text-sky-900">Notifikasi</p>
                    <a href="{{ route('markAsRead') }}">
                        <div class=" text-sky-900 font-thin underline text-sm">
                            Bersihkan
                        </div>
                    </a>
                </div>
                @forelse (auth()->user()->unreadNotifications  as $notification)
                    <div class="bg-white rounded-md shadow-lg p-2 my-2">
                        <p class="text-sky-900 font-semibold">{{ $notification->data['title'] }}</p>
                        <p class="text-sm font-light">{{ $notification->data['message'] }}</p>
                        <small>({{ $notification->created_at->diffForHumans() }})</small>
                    </div>
                @empty
                    <div class="">
                        <div class=" flex items-center justify-center mt-56">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-20 text-slate-400">
                                <path fill-rule="evenodd"
                                    d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-center font-light text-slate-500">Belum ada notifikasi.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>

{{-- script modal --}}
<script>
    const modal = document.getElementById("modal");
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");

    openModal.addEventListener("click", function(event) {
        event.preventDefault(); // Mencegah navigasi default
        modal.classList.remove("hidden");
    });

    closeModal.addEventListener("click", function() {
        modal.classList.add("hidden");
    });

    // Menutup modal saat klik di luar modal
    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.classList.add("hidden");
        }
    });
</script>

{{-- kalender --}}
<script>
    function miniCalendar() {
        return {
            current: new Date(),
            days: [],
            title: '',
            init() {
                this.build();
            },
            build() {
                const y = this.current.getFullYear();
                const m = this.current.getMonth();

                // judul
                this.title = this.current.toLocaleString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });

                // hari pertama & jumlah hari
                const first = new Date(y, m, 1);
                const last = new Date(y, m + 1, 0);
                const prevLast = new Date(y, m, 0);

                const startPad = (first.getDay() + 6) % 7; // Sen=0 … Min=6 → grid Min-Sab
                const total = last.getDate();

                const today = new Date();
                const isSameDay = (a, b) => a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a
                    .getDate() === b.getDate();

                this.days = [];

                // hari dari bulan sebelumnya (muted)
                for (let i = startPad; i > 0; i--) {
                    this.days.push({
                        num: prevLast.getDate() - i + 1,
                        muted: true,
                        isToday: false
                    });
                }

                // hari aktif bulan ini
                for (let d = 1; d <= total; d++) {
                    const cur = new Date(y, m, d);
                    this.days.push({
                        num: d,
                        muted: false,
                        isToday: isSameDay(cur, today)
                    });
                }

                // pad ke kelipatan 7
                while (this.days.length % 7 !== 0) {
                    const n = this.days.length - (startPad + total) + 1;
                    this.days.push({
                        num: n,
                        muted: true,
                        isToday: false
                    });
                }
            },
            prevMonth() {
                this.current.setMonth(this.current.getMonth() - 1);
                this.build();
            },
            nextMonth() {
                this.current.setMonth(this.current.getMonth() + 1);
                this.build();
            },
        }
    }
</script>


</html>
