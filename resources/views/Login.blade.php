<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('img/favlogo.png') }}">
    <title>Selamat Datang | Masuk</title>
</head>

{{-- SweetAlert untuk login gagal --}}
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#0ea5e9',
            });
        });
    </script>
@endif


<body
    class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-300 to-cyan-900 flex items-center justify-center py-10">

    {{-- WRAPPER CARD --}}
    <div class="w-full max-w-6xl px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 rounded-3xl shadow-2xl overflow-hidden bg-white/90 backdrop-blur">
            {{-- LEFT: WELCOME PANEL --}}
            <div class="relative bg-gradient-to-br from-cyan-700 to-blue-800 text-white p-8 lg:p-12">
                {{-- subtle pattern --}}
                <div
                    class="pointer-events-none absolute inset-0 opacity-25
                    bg-[radial-gradient(ellipse_at_top_left,white_0%,transparent_35%),radial-gradient(ellipse_at_bottom_right,white_0%,transparent_35%)]">
                </div>

                <div class="relative z-10 h-full flex flex-col">
                    <div class="">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-40">
                        <div class="text-lg font-semibold tracking-wide">Puskesmas Gunung Sari Ulu</div>
                    </div>

                    <div class="mt-7">
                        <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight drop-shadow">
                            Halo, selamat datang!
                        </h1>
                        <p class="mt-4 text-white/85 leading-relaxed">
                            Website ini merupakan media monitoring dan pelaporan stunting wilayah kerja puskesmas.
                            Silakan masuk untuk melanjutkan.
                        </p>
                    </div>

                    <div class="mt-auto hidden lg:block">
                        <img src="{{ asset('img/img1.png') }}" alt="" class="w-40 opacity-95 drop-shadow-lg">
                    </div>

                    {{-- dekorasi lama tetap dipakai sebagai aksen --}}

                </div>
            </div>

            {{-- RIGHT: FORM PANEL --}}
            <div class="bg-white p-8 lg:p-12">
                <div class="max-w-md mx-auto">
                    <h2 class="text-2xl font-bold text-sky-900">Masuk</h2>
                    <p class="text-slate-600 mt-1">Masukkan username dan password Anda.</p>

                    <form method="POST" action="{{ route('prosesLogin') }}" class="mt-8 space-y-5">
                        @csrf

                        {{-- USERNAME --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700">Username</label>
                            <div class="mt-1 relative">
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 pr-10 text-slate-900 placeholder-slate-400
                                           focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent
                                           @error('name') ring-2 ring-rose-500 border-transparent @enderror"
                                    placeholder="Masukkan username">
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0V21H4.5v-.9Z" />
                                </svg>
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                            <div class="mt-1 relative">
                                <input type="password" id="password" name="password"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 pr-10 text-slate-900 placeholder-slate-400
                                           focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent
                                           @error('password') ring-2 ring-rose-500 border-transparent @enderror"
                                    placeholder="Masukkan password">
                                <button type="button" id="togglePass"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 rounded-md text-slate-400 hover:text-slate-600">
                                    {{-- eye icon --}}
                                    <svg id="eyeOpen" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M2.036 12.322a1 1 0 0 1 0-.644C3.423 7.51 7.36 5 12 5s8.577 2.51 9.964 6.678a1 1 0 0 1 0 .644C20.577 16.49 16.64 19 12 19s-8.577-2.51-9.964-6.678Z" />
                                        <circle cx="12" cy="12" r="3" stroke-width="1.5" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- OPTIONS --}}
                        <div class="flex items-center justify-between">
                            <div></div>
                            {{-- ganti href jika sudah ada route lupa password --}}
                            <a href="/Lupa-password" class="text-sm font-medium text-cyan-700 hover:text-cyan-800">Lupa
                                password?</a>
                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit"
                            class="w-full rounded-2xl bg-gradient-to-r from-sky-900 to-cyan-600 text-white py-3 font-semibold
                                       shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                            Masuk
                        </button>

                        {{-- SIGN UP --}}
                        {{-- <div class="text-center pt-2">
                            <p class="text-sm text-slate-600">Belum punya akun?</p>
                            <a href="/register"
                                class="mt-2 inline-flex w-full items-center justify-center rounded-2xl bg-white text-sky-900 font-semibold py-3
                                      ring-1 ring-sky-900/80 hover:bg-sky-50 transition">
                                Daftar
                            </a>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>

        {{-- small footer note --}}
        <p class="mt-6 text-center text-xs text-white/70">
            © {{ date('Y') }} Puskesmas Gunung Sari Ulu — Sistem Informasi Monitoring Stunting
        </p>
    </div>


    {{-- Toggle show/hide password --}}
    <script>
        const btn = document.getElementById('togglePass');
        const input = document.getElementById('password');
        btn?.addEventListener('click', () => {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
        });
    </script>
</body>

</html>
