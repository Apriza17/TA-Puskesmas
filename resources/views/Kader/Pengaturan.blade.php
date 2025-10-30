{{-- resources/views/Kader/Pengaturan.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Pengaturan Kader</title>
</head>

<body class="bg-slate-100">
    <div class="bg-gradient-to-r relative from-cyan-800 to-cyan-600 h-28 drop-shadow-lg overflow-hidden">
        <img src="img/edge dec1.png" class="absolute z-0 size-56 right-0 rotate-90" alt="">
        <div class="text-white font-semibold flex justify-center items-center h-full">
            <div class="text-2xl">Pengaturan</div>
            <a href="/dashboard1" class="absolute left-4">
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-9">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </a>
        </div>
    </div>

    {{-- Toast sukses / gagal --}}
    @if (session('success'))
        <div class="bg-gray-900/70 fixed inset-0 flex items-center justify-center z-50 ">
            <div class="bg-white rounded-lg p-6 max-w-lg shadow-lg animate-jump-in duration-100">
                <p class="text-2xl font-bold text-center">Berhasil</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-24 mx-auto text-green-700" width="1024"
                    height="1024" viewBox="0 0 1024 1024">
                    <path fill="currentColor"
                        d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z" />
                </svg>
                <p class="mt-3 text-center">Password berhasil dirubah. Silahkan Login kembali</p>
                <a href="/Logout"
                    class="bg-gradient-to-r text-center max-w-28 from-sky-900 to-cyan-600 text-white px-4 py-2 mt-4 rounded-md mx-auto block hover:scale-105 transition transform duration-200 ease-in-out">Logout</a>

            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="rounded-lg bg-rose-50 text-rose-700 ring-1 ring-rose-200 px-4 py-3 mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="lg:flex justify-center gap-5 px-5 lg:px-0 pt-3 pb-10">
        <div class="mb-6 lg:mb-0 lg:w-1/2">
            <h1 class="text-2xl font-bold text-slate-800 mb-4">Ganti Password</h1>
            <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">

                <form method="POST" action="{{ route('kader.settings.password') }}" class="space-y-4"
                    x-data="{ show: false }">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Password saat ini</label>
                        <div class="relative mt-1">
                            <input type="password" name="current_password" placeholder="Masukan Password Lama anda!"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600 @error('current_password') ring-2 ring-rose-500 border-transparent @enderror"
                                required>
                        </div>
                        @error('current_password')
                            <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Password baru</label>
                        <div class="relative mt-1">
                            <input :type="show ? 'text' : 'password'" name="password" placeholder="Silahkan Buat Password Baru!"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600 @error('password') ring-2 ring-rose-500 border-transparent @enderror"
                                minlength="8" required>
                            <button type="button" @click="show=!show"
                                class="absolute inset-y-0 right-2 my-auto text-slate-500 text-sm">
                                <span x-show="!show">Tampilkan</span>
                                <span x-show="show">Sembunyikan</span>
                            </button>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Minimal 8 karakter. Disarankan kombinasi huruf besar,
                            kecil,
                            angka.</p>
                        @error('password')
                            <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Konfirmasi password baru</label>
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" placeholder="Konfirmasi Password Baru!"
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600 @error('password_confirmation') ring-2 ring-rose-500 border-transparent @enderror"
                            required>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full sm:w-auto bg-sky-700 hover:bg-sky-900 text-white font-semibold px-5 py-2 rounded-lg shadow">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800 mb-4">Unduh Template Excel</h1>
            <div class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
                <p class="text-lg font-bold text-sky-900">Unduh Template Import Laporan </p>
                <p class=" font-light mb-3 ">Klik tombol untuk mengunduh template</p>
                <div>
                    <a href="{{ route('kader.laporan.template') }}"
                        class="rounded-md bg-green-700 px-4 py-2 text-white hover:bg-green-900">
                        Unduh Template
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Alpine untuk toggle show/hide password (opsional) --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
