<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <title>Beranda</title>
</head>

<body>
    {{-- head --}}
    <div class="bg-gradient-to-r relative from-cyan-800 to-cyan-600 h-28 drop-shadow-lg">
        <img src="img/edge dec1.png" class="absolute size-56 right-0 rotate-90 overflow-hidden" alt="">
        <div class="p-4 text-white font-semibold">
            <p class="">Selamat Datang</p>
            <p class="text-xl">Posyandu {{ $user->name }}</p>
        </div>
    </div>
    {{-- Section --}}
    <div class="p-4 flex flex-wrap justify-center gap-4">
        <a href="#" id="openModal">
            <div class="text-sky-900 bg-gray-200 w-48 h-48 rounded-md shadow-lg  justify-items-center py-10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16">
                    <path fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                        clip-rule="evenodd" />
                </svg>
                <p class=" text-lg">Buat Laporan</p>
            </div>
        </a>
        <a href="/Pesan">
            <div class="text-sky-900 bg-gray-200 w-48 h-48 rounded-md shadow-lg  justify-items-center py-10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16">
                    <path
                        d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                    <path
                        d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                </svg>

                <p class=" text-lg">Pesan</p>
            </div>
        </a>
        <a href="">
            <div class="text-sky-900 bg-gray-200 w-48 h-48 rounded-md shadow-lg  justify-items-center py-10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16">
                    <path fill-rule="evenodd"
                        d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z"
                        clip-rule="evenodd" />
                </svg>


                <p class=" text-lg">Riwayat Laporan</p>
            </div>
        </a>
        <a href="">
            <div class="text-sky-900 bg-gray-200 w-48 h-48 rounded-md shadow-lg  justify-items-center py-10">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16">
                    <path fill-rule="evenodd"
                        d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z"
                        clip-rule="evenodd" />
                </svg>


                <p class="text-lg">Pengaturan</p>
            </div>
        </a>
    </div>
    <a href="/Logout" class="">
        <div class="px-5 flex justify-center">
            <div
                class="bg-red-700 p-1 px-10 shadow-lg text-white text-xl font-semibold rounded-md outline outline-3 outline-red-700 text-center">
                Logout</div>
        </div>
    </a>
    {{-- Modal --}}
    <div id="modal" class="fixed inset-0 flex  items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-slate-200 w-72 rounded-md relative animate-jump-in">
            <button class="absolute -right-2 -top-2" id="closeModal">
                <div class=" bg-red-300 rounded-full p-1" id="">❌</div>
            </button>
            <div class="p-3">
                <p class="font-semibold text-center mb-4 text-sky-900">Pilih Jenis Laporan</p>
                <a href="/Regis-anak">
                    <div
                        class="bg-gradient-to-r items-center justify-center from-sky-900 to-cyan-600 h-10 rounded-md flex">
                        <p class="text-center text-white ">Registrasi</p>
                    </div>
                </a>
                <a href="/Laporan-anak">
                    <div
                        class="bg-gradient-to-r mt-2 items-center justify-center from-sky-900 to-cyan-600 h-10 rounded-md flex">
                        <p class="text-center text-white ">Laporan Gizi</p>
                    </div>
                </a>
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
