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
    {{-- section --}}
    <div class="p-2">
        @foreach ($pesan as $item)
            <div class="w-full bg-white p-3 rounded-sm shadow-lg flex gap-2 my-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    class="size-10 {{ $item->terbaca ? 'text-amber-500' : 'text-gray-500' }}">
                    <path fill="currentColor" fill-rule="evenodd"
                        d="M3.013 9.151C3 9.691 3 10.302 3 11v2c0 2.828 0 4.243.879 5.121C4.757 19 6.172 19 9 19h6c2.828 0 4.243 0 5.121-.879C21 17.243 21 15.828 21 13v-2c0-.698 0-1.31-.013-1.849l-8.016 4.453a2 2 0 0 1-1.942 0zm.23-2.121q.125.03.243.096L12 11.856l8.514-4.73q.119-.065.243-.096c-.13-.474-.33-.845-.636-1.151C19.243 5 17.828 5 15 5H9c-2.828 0-4.243 0-5.121.879c-.307.306-.506.677-.636 1.15"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <h1 class="font-bold {{ $item->terbaca ? 'text-amber-500' : 'text-gray-500' }}">Pesan Pengingat</h1>
                    <p class="text-sm text-gray-500">{{ $item->isi }}</p>
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
