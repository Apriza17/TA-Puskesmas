<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pesan Masuk</title>
    @vite('resources/css/app.css')

</head>

<body class="bg-slate-200">
    {{-- head --}}
    <div class="bg-gradient-to-r relative from-cyan-800 to-cyan-600 h-28 drop-shadow-lg overflow-hidden">
        <div class="text-white font-semibold flex justify-center items-center h-full">
            <div class="text-2xl">Detail Pesan</div>
            <a href="{{ route('viewPesan') }}" class="absolute left-4">
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
    @if (session('success'))
        <div class="mb-3 p-5 rounded-md bg-green-50 text-green-800 px-4 py-2">{{ session('success') }}</div>
    @endif
    {{-- section --}}
    <div class="max-w-3xl mx-auto px-4 py-6">

        <div class="mt-3 rounded-xl bg-white ring-1 ring-black/5 shadow-sm p-5">
            <h1 class="text-xl font-bold text-slate-800">{{ $pesan->judul }}</h1>
            <div class="text-xs text-slate-500 mt-1">
                Dikirim: {{ $pesan->created_at->translatedFormat('d F Y, H:i') }}
                @if ($pesan->terbaca)
                    • Status: Terbaca
                @else
                    • Status: Belum terbaca
                @endif
            </div>

            <div class="mt-4 text-slate-700 whitespace-pre-line">{{ $pesan->isi }}</div>

            @unless ($pesan->terbaca)
                <form method="POST" action="{{ route('markRead', $pesan->id) }}" class="mt-5">
                    @csrf
                    <button class="rounded-lg bg-sky-700 hover:bg-sky-900 text-white px-4 py-2">
                        Pesan terbaca
                    </button>
                </form>
            @endunless
        </div>
    </div>
</body>

</html>
