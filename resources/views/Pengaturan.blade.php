<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengaturan | Admin</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
@include('Layout.Navbar')

<body class="bg-slate-300">
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div
            class="lg:px-52 md:px-28 text-white -translate-y-24 flex justify-between animate-fade animate-once animate-ease-out">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Menu Pengaturan</h1>
                <p class="font-thin mb-4">Menu untuk mengatur akun, standar stunting dll</p>
            </div>
            <div>
                <img src="img/img2.png" alt="" class="w-36">
            </div>
        </div>
    </div>
    {{-- section --}}
    <div class="lg:px-52 md:px-28 pt-5 lg:flex lg:justify-center gap-4">
        {{-- Reset pw --}}
        <div class="mb-6 lg:mb-0 lg:w-1/2">
            <div
                class="rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5 animate-fade-up animate-once animate-ease-out duration-200">
                <p class="text-lg font-bold text-sky-900">Ganti Password </p>

                <form method="POST" action="{{ route('admin.settings.password') }}" class="space-y-4"
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
                            <input :type="show ? 'text' : 'password'" name="password"
                                placeholder="Silahkan Buat Password Baru!"
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
                        <input :type="show ? 'text' : 'password'" name="password_confirmation"
                            placeholder="Konfirmasi Password Baru!"
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600 @error('password_confirmation') ring-2 ring-rose-500 border-transparent @enderror"
                            required>
                    </div>

                    {{-- <div class="flex items-center gap-2 pt-1">
                        <input id="logout_others" type="checkbox" name="logout_others" value="1"
                            class="rounded border-slate-300 text-cyan-600 focus:ring-cyan-600">
                        <label for="logout_others" class="text-sm text-slate-700">Keluar dari semua perangkat
                            lain</label>
                    </div> --}}

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full sm:w-auto bg-sky-700 hover:bg-sky-900 text-white font-semibold px-5 py-2 rounded-lg shadow">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="animate-fade-up animate-once animate-ease-out duration-200 animate-delay-200">
            {{-- donwload 1 --}}
            <div class="bg-white rounded-md drop-shadow-lg px-2 py-4 ">
                <p class="text-lg font-bold text-sky-900">Unduh Template IMT (tinggi badan)</p>
                <p class=" font-light mb-2 ">Klik tombol untuk mengunduh template</p>
                <div>
                    <a href="{{ route('stunting.template') }}"
                        class="rounded-md bg-green-700 px-4 py-2 text-white hover:bg-green-900">
                        Unduh Template
                    </a>
                </div>
            </div>
            {{-- donwload 2 --}}
            <div class="bg-white rounded-md drop-shadow-lg px-2 py-4 my-4">
                <p class="text-lg font-bold text-sky-900">Unduh Template Excel Data Posyandu & Anak</p>
                <p class=" font-light mb-2 ">Klik tombol untuk mengunduh template</p>
                <div>
                    <a href="{{ route('sartika.template') }}"
                        class="rounded-md bg-green-700 px-4 py-2 text-white hover:bg-green-900">
                        Unduh Template
                    </a>
                </div>
            </div>

            {{-- import standar stunting --}}
            <div class="bg-white rounded-md drop-shadow-lg px-2 py-4 ">
                <p class="text-lg font-bold text-sky-900">Masukan Standar Stunting </p>
                <p class=" font-light mb-2 ">Siapkan excel yang berisi tabel IMT Tinggi Badan (TB)</p>
                <div>
                    <form action="{{ route('stunting.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" accept=".xlsx,.xls" required class="border rounded-sm">
                        <button type="submit"
                            class="bg-cyan-600 hover:bg-cyan-800 text-white px-4 py-1 rounded-sm">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
