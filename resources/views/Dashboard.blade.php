<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
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
                <a href=""
                    class="bg-cyan-400 hover:bg-cyan-600 outline outline-2 outline-white rounded-xl px-5 text-sm font-semibold">Klik
                    Disini</a>
            </div>
            <div>
                <img src="img/img1.png" alt="" class="w-36">
            </div>
        </div>
    </div>
    {{-- Section --}}
    <div class="lg:px-52 md:px-28 pt-5">
        <div class="flex gap-4">
            <div
                class=" bg-white animate-fade-up animate-once animate-duration-1000 animate-ease-out drop-shadow-lg outline outline-4 rounded-sm outline-sky-900 lg:w-48 lg:h-48 md:w-40 md:h-40">
                <p class="text-center bg-sky-900 py-2 text-white font-bold">Angka Stunting</p>
                <p class="text-center py-10 text-sky-900 font-bold lg:text-4xl md:text-2xl ">15%</p>
            </div>
            @if ($jumlahBelumMelapor > 0)
                <a href="/Belum-Melapor" class="hover:scale-[1.04] transition-all ease-in-out duration-100">
                    <div
                        class="110 bg-white animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-[200ms] drop-shadow-lg outline outline-4 rounded-sm outline-sky-900 lg:w-48 lg:h-48 md:w-40 md:h-40">
                        <p class="text-center bg-sky-900 py-2 text-white font-bold">Belum Melapor</p>
                        <p class="text-center py-10 text-orange-600 font-bold lg:text-4xl md:text-2xl ">
                            {{ $jumlahBelumMelapor }} Sartika</p>
                    </div>
                </a>
            @else
                <div
                    class=" bg-white animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-[200ms] drop-shadow-lg outline outline-4 rounded-sm outline-sky-900 lg:w-48 lg:h-48 md:w-40 md:h-40">
                    <p class="text-center bg-sky-900 py-2 text-white font-bold">Laporan Lengkap</p>
                    <div class="flex justify-center mt-4">
                        <div class="text-green-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-16" width="24" height="24"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m10.6 16.2l7.05-7.05l-1.4-1.4l-5.65 5.65l-2.85-2.85l-1.4 1.4zM5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-center text-green-400 font-bold lg:text-2xl md:text-xl ">Lengkap</p>
                </div>
            @endif
            <a href="#" id="openModal" class="hover:scale-[1.04] transition-all ease-in-out duration-100">
                <div
                    class=" bg-white animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-[300ms] drop-shadow-lg outline outline-4 rounded-sm outline-sky-900 lg:w-48 lg:h-48 md:w-40 md:h-40">
                    <p class="text-center bg-sky-900 py-2 text-white font-bold">Notifikasi Masuk</p>
                    <div class="">
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <div class="flex justify-center items-center py-7 ">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-14 text-yellow-500 animate-wiggle-more animate-infinite">
                                        <path
                                            d="M5.85 3.5a.75.75 0 0 0-1.117-1 9.719 9.719 0 0 0-2.348 4.876.75.75 0 0 0 1.479.248A8.219 8.219 0 0 1 5.85 3.5ZM19.267 2.5a.75.75 0 1 0-1.118 1 8.22 8.22 0 0 1 1.987 4.124.75.75 0 0 0 1.48-.248A9.72 9.72 0 0 0 19.266 2.5Z" />
                                        <path fill-rule="evenodd"
                                            d="M12 2.25A6.75 6.75 0 0 0 5.25 9v.75a8.217 8.217 0 0 1-2.119 5.52.75.75 0 0 0 .298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 1 0 7.48 0 24.583 24.583 0 0 0 4.83-1.244.75.75 0 0 0 .298-1.205 8.217 8.217 0 0 1-2.118-5.52V9A6.75 6.75 0 0 0 12 2.25ZM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 0 0 4.496 0l.002.1a2.25 2.25 0 1 1-4.5 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-center font-semibold text-sky-900">
                                        {{ auth()->user()->unreadNotifications->count() }}</p>

                                </div>
                            </div>
                        @else
                            <p class="text-center text-sky-900 font-semibold py-14 ">Notifikasi Kosong</p>
                        @endif

                    </div>
                </div>
            </a>
            <div
                class=" bg-white animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-[400ms] drop-shadow-lg outline outline-4 rounded-sm outline-cyan-500 w-96 lg:h-48 md:h-40">
                <p class="text-center bg-cyan-500 py-2 text-white font-bold">Tanggal</p>
                <p class="text-center py-10 text-cyan-500 font-bold lg:text-4xl md:text-2xl ">1</p>
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

</html>
