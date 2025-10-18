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
        <img src="img/edge dec1.png" class="absolute z-0 size-56 right-0 rotate-90" alt="">
        <div class="text-white font-semibold flex justify-center items-center h-full">
            <div class="text-2xl">Pesan</div>
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
    @if (session('success'))
        <div class="mb-3 rounded-md bg-green-50 text-green-800 px-4 py-2">{{ session('success') }}</div>
    @endif
    {{-- section --}}
    <div class="p-2">
        @forelse ($items as $msg)
            @php $unread = (int)($msg->terbaca ?? 0) === 0; @endphp
            <a href="{{ route('showPesan', $msg->id) }}"
                class="block rounded-lg bg-white ring-1 ring-black/5 shadow-sm p-4 mb-3 hover:bg-slate-50 transition">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="{{ $unread ? 'font-bold text-slate-900' : 'font-semibold text-slate-600' }}">
                            {{ $msg->judul }}
                        </div>
                        <p
                            class="mt-1 line-clamp-2 {{ $unread ? 'text-slate-700 text-sm' : 'text-slate-500 text-sm' }}">
                            {{ $msg->isi }}
                        </p>
                    </div>
                    <div class="text-xs {{ $unread ? 'text-slate-500' : 'text-slate-400' }}">
                        {{ $msg->created_at->diffForHumans() }}
                    </div>
                </div>
                @if ($unread)
                    <span class="inline-flex mt-2 text-[11px] rounded-full bg-cyan-100 text-cyan-700 px-2 py-0.5">Belum
                        terbaca</span>
                @endif
            </a>
        @empty
            <div class="rounded-lg bg-white ring-1 ring-black/5 shadow p-6 text-slate-600">
                Belum ada pesan.
            </div>
        @endforelse

        <div class="mt-4">{{ $items->onEachSide(1)->links() }}</div>
    </div>
    </div>
</body>

</html>
