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
                        <a href="/"
                            class="mt-2 inline-flex w-full items-center justify-center rounded-2xl bg-white text-sky-900 font-semibold py-3
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
