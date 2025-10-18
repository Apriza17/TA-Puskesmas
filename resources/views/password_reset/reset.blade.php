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
                        Silahkan masukan password yang baru!</p>

                    {{-- Form Lupa Password --}}
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <label class="block text-lg text-center font-medium text-slate-700">Password baru</label><br>
                        <input
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 pr-10 text-slate-900 placeholder-slate-400
                                           focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent"
                            type="password" name="password" required><br>

                        <label class="block text-lg text-center font-medium text-slate-700">Konfirmasi
                            password</label><br>
                        <input
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 pr-10 text-slate-900 placeholder-slate-400
                                           focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent"
                            type="password" name="password_confirmation" required><br>

                        @error('password')
                            <small class="text-red-600 text-center">{{ $message }}</small>
                        @enderror
                        <button
                            class="w-full rounded-2xl bg-gradient-to-r from-sky-900 to-cyan-600 text-white py-3 font-semibold
                                       shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5 mt-3"
                            type="submit">Reset Password</button>
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
