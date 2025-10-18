<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('img/favlogo.png') }}">
    <title>Lupa Password</title>
</head>

{{-- SweetAlert untuk login gagal --}}
@if ($errors->any())
    <div class="bg-gray-900/70 fixed inset-0 flex items-center justify-center z-50 ">
        <div class="bg-white rounded-lg p-6 shadow-lg animate-jump-in duration-100">
            <p class="text-2xl font-bold text-center">Login Gagal</p>
            <svg xmlns="http://www.w3.org/2000/svg" class="size-24 mx-auto text-red-600" width="24" height="24"
                viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12.884 2.532c-.346-.654-1.422-.654-1.768 0l-9 17A1 1 0 0 0 3 21h18a.998.998 0 0 0 .883-1.467zM13 18h-2v-2h2zm-2-4V9h2l.001 5z" />
            </svg>
            <p class="mt-3 text-center">Silahkan Cek Kembali Username dan Password Anda</p>
            <a href="/"
                class="bg-gradient-to-r text-center max-w-28 from-sky-900 to-cyan-600 text-white px-4 py-2 mt-4 rounded-md mx-auto block hover:scale-105 transition transform duration-200 ease-in-out">Kembali</a>

        </div>
    </div>
@endif

<body
    class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-300 to-cyan-900 flex items-center justify-center py-10">

    {{-- WRAPPER CARD --}}
    <div class="w-full max-w-lg px-4">
        <div class="rounded-3xl shadow-2xl overflow-hidden bg-white/90 backdrop-blur">
            {{-- LEFT: WELCOME PANEL --}}

            {{-- RIGHT: FORM PANEL --}}
            <div class=" p-8 lg:p-12 bg-slate-200/40">
                <div class="mx-auto">
                    <h2 class="text-2xl font-bold text-sky-900 text-center">Lupa Password</h2>
                    <p class="text-slate-600 mt-1 text-sm bg-yellow-200/50 p-2 rounded-md"><span
                            class="font-bold text-yellow-800">Perhatian :</span>
                        Silahkan masukan email anda,
                        setelah
                        mengirimkan dimohon untuk memeriksa email!</p>

                    {{-- Form Lupa Password --}}
                    @if (session('status'))
                        <div class="bg-green-200/50 text-green-700 text-center">{{ session('status') }}</div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <label class="block text-lg text-center font-medium text-slate-700">Email</label><br>
                        <input
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 pr-10 text-slate-900 placeholder-slate-400
                                           focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent
                                           @error('email') ring-2 ring-rose-500 border-transparent @enderror"
                            type="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-red-600">{{ $message }}</small>
                        @enderror
                        <br>
                        <button type="submit"
                            class="w-full rounded-2xl bg-gradient-to-r from-sky-900 to-cyan-600 text-white py-3 font-semibold
                                       shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5 mt-3">Kirim
                            Link Reset</button>
                        <br>
                        <a href="/" class="mt-2 inline-flex w-full items-center justify-center rounded-2xl bg-white text-sky-900 font-semibold py-3
                                      ring-1 ring-sky-900/80 hover:bg-sky-50 transition">Kembali</a>
                    </form>

                </div>
            </div>
        </div>

        {{-- small footer note --}}
        <p class="mt-6 text-center text-xs text-white/70">
            © {{ date('Y') }} Puskesmas Gunung Sari Ulu — Sistem Informasi Monitoring Stunting
        </p>
    </div>

</body>

</html>
