<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Tailwind</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div x-data="{ open: false, closing: false }" @keydown.escape="open = false">
        <!-- Tombol Toggle Sidebar -->
        <button @click="open = true; closing = false"
            class="fixed top-7 left-7 bg-gradient-to-t from-sky-900 to-cyan-600 border-2 text-white p-2 rounded shadow-lg scale-100 hover:scale-105 transition-all ease-in-out duration-100">
            <i class="fas fa-bars size-6"></i>
        </button>

        <!-- Sidebar -->
        <div x-show="open" @click.away="closing = true; open = false"
            :class="closing ? 'animate-fade-left' : 'animate-fade-right'"
            class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transition-transform transform z-30">
            <button @click="closing = true; open = false"
                class="absolute top-7 right-4 text-gray-500 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <path d="M9 3v18" />
                    </g>
                </svg>
            </button>
            <div class=" border-b-4 border-slate-400 flex items-center p-2">
                <img src="img/logo.png" class=" size-16" alt="">
                <p class="text-center font-bold text-sky-900 text-xl">Menu</p>
            </div>
            <ul class="px-3 mt-3" x-data="{ openLaporan: false }">
                <li><a href="/dashboard"
                        class="flex py-2 px-4 text-lg text-gray-700 items-center hover:text-white hover:bg-sky-900 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="size-8">
                            <path fill="currentColor"
                                d="M4 13h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1m0 8h6c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1m10 0h6c.55 0 1-.45 1-1v-8c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1M13 4v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1" />
                        </svg>
                        <p class="ml-4">Beranda</p>
                    </a>
                </li>
                <li><a href="/Data-Sartika"
                        class="flex items-center py-2 px-4 text-gray-700 hover:text-white hover:bg-sky-900 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="size-8">
                            <g fill="none">
                                <path
                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                <path fill="currentColor"
                                    d="M18 2a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm-6 11H9a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2m3-5H9a1 1 0 0 0-.117 1.993L9 10h6a1 1 0 0 0 .117-1.993z" />
                            </g>
                        </svg>
                        <p class="ml-4">Data Sartika</p>
                    </a>
                </li>
                <li>
                    <button @click="openLaporan = !openLaporan"
                        class="w-full flex items-center justify-between py-2 px-4 text-gray-700 hover:text-white hover:bg-sky-900 rounded">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                class="size-8">
                                <path fill="currentColor"
                                    d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2M9 17H7v-7h2zm4 0h-2V7h2zm4 0h-2v-4h2z" />
                            </svg>
                            <p class="ml-4">Laporan</p>
                        </div>
                        <svg :class="{ 'rotate-180': openLaporan }" class="transition-transform duration-200 size-5"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.062l3.71-3.83a.75.75 0 111.08 1.04l-4.25 4.4a.75.75 0 01-1.08 0l-4.25-4.4a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <ul x-show="openLaporan" x-transition class="ml-12 mt-1 space-y-1 text-sm">
                        <li>
                            <a href="/Laporan"
                                class="block px-4 py-1 text-gray-700 hover:text-white hover:bg-sky-800 rounded">Rekap
                                Bulanan Anak</a>
                        </li>
                        <li>
                            <a href="/Laporan-Gizi"
                                class="block px-4 py-1 text-gray-700 hover:text-white hover:bg-sky-800 rounded">Rekap
                                Gizi Anak</a>
                        </li>
                        <li>
                            <a href="/Laporan-Sartika"
                                class="block px-4 py-1 text-gray-700 hover:text-white hover:bg-sky-800 rounded">Rekap
                                Sartika</a>
                        </li>
                    </ul>
                </li>
                <li><a href="/Pengguna"
                        class="flex items-center py-2 px-4 text-gray-700 hover:text-white hover:bg-sky-900 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="size-8">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M8 4a4 4 0 1 0 0 8a4 4 0 0 0 0-8m-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4zm7.25-2.095c.478-.86.75-1.85.75-2.905a6 6 0 0 0-.75-2.906a4 4 0 1 1 0 5.811M15.466 20c.34-.588.535-1.271.535-2v-1a5.98 5.98 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-4">Data Pengguna</p>
                    </a>
                </li>
                <li><a href="/Pengaturan-admin"
                        class="flex items-center py-2 px-4 text-gray-700 hover:text-white hover:bg-sky-900 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-8" width="1024" height="1024"
                            viewBox="0 0 1024 1024">
                            <path fill="currentColor"
                                d="M512.5 390.6c-29.9 0-57.9 11.6-79.1 32.8c-21.1 21.2-32.8 49.2-32.8 79.1s11.7 57.9 32.8 79.1c21.2 21.1 49.2 32.8 79.1 32.8s57.9-11.7 79.1-32.8c21.1-21.2 32.8-49.2 32.8-79.1s-11.7-57.9-32.8-79.1a110.96 110.96 0 0 0-79.1-32.8m412.3 235.5l-65.4-55.9c3.1-19 4.7-38.4 4.7-57.7s-1.6-38.8-4.7-57.7l65.4-55.9a32.03 32.03 0 0 0 9.3-35.2l-.9-2.6a442.5 442.5 0 0 0-79.6-137.7l-1.8-2.1a32.12 32.12 0 0 0-35.1-9.5l-81.2 28.9c-30-24.6-63.4-44-99.6-57.5l-15.7-84.9a32.05 32.05 0 0 0-25.8-25.7l-2.7-.5c-52-9.4-106.8-9.4-158.8 0l-2.7.5a32.05 32.05 0 0 0-25.8 25.7l-15.8 85.3a353.4 353.4 0 0 0-98.9 57.3l-81.8-29.1a32 32 0 0 0-35.1 9.5l-1.8 2.1a445.9 445.9 0 0 0-79.6 137.7l-.9 2.6c-4.5 12.5-.8 26.5 9.3 35.2l66.2 56.5c-3.1 18.8-4.6 38-4.6 57c0 19.2 1.5 38.4 4.6 57l-66 56.5a32.03 32.03 0 0 0-9.3 35.2l.9 2.6c18.1 50.3 44.8 96.8 79.6 137.7l1.8 2.1a32.12 32.12 0 0 0 35.1 9.5l81.8-29.1c29.8 24.5 63 43.9 98.9 57.3l15.8 85.3a32.05 32.05 0 0 0 25.8 25.7l2.7.5a448.3 448.3 0 0 0 158.8 0l2.7-.5a32.05 32.05 0 0 0 25.8-25.7l15.7-84.9c36.2-13.6 69.6-32.9 99.6-57.5l81.2 28.9a32 32 0 0 0 35.1-9.5l1.8-2.1c34.8-41.1 61.5-87.4 79.6-137.7l.9-2.6c4.3-12.4.6-26.3-9.5-35m-412.3 52.2c-97.1 0-175.8-78.7-175.8-175.8s78.7-175.8 175.8-175.8s175.8 78.7 175.8 175.8s-78.7 175.8-175.8 175.8" />
                        </svg>
                        <p class="ml-4">Pengaturan</p>
                    </a>
                </li>
                <li><a href="{{ url('/Logout') }}"
                        class="flex items-center py-2 px-4 text-gray-700 hover:text-white hover:bg-red-800 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="size-8">
                            <path fill="currentColor"
                                d="M5 2h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1m4 9V8l-5 4l5 4v-3h6v-2z" />
                        </svg>
                        <p class="ml-4">Keluar</p>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Konten -->

    </div>

</body>

</html>
