<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('img/logo.png') }}">
</head>
@include('Layout.Navbar')

<body class="bg-slate-300">
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40 invisible">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90 invisible">
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Detail Sartika</h1>
                <p class="font-thin mb-16">Berikut merupakan tabel yang berisikan Data anak dan ibu hamil Posyandu</p>
            </div>
            <div class="flex justify-between">
                <a href="/Data-Sartika">
                    <div
                        class="bg-cyan-600 hover:bg-cyan-700 p-1 px-3 text-center font-semibold text-sm outline outline-2 drop-shadow-md rounded-sm scale-100 hover:scale-105 transition ease-in-out duration-100">
                        Tambah
                    </div>
                </a>
                <a href="/Data-Sartika">
                    <div
                        class="bg-red-600 hover:bg-red-700 p-1 px-3 text-center font-semibold text-sm outline outline-2 drop-shadow-md rounded-sm scale-100 hover:scale-105 transition ease-in-out duration-100">
                        Kembali
                    </div>
                </a>
            </div>
        </div>
    </div>
    {{-- Section --}}

    <div class="lg:px-52 md:px-28">
        <div class="w-full bg-white p-2 mt-5 animate-fade-up animate-once animate-duration-1000 animate-ease-out ">
            <p class="mb-3 font-semibold text-xl text-sky-900">Data Anak</p>
            @if ($posyandu->anak->isEmpty())
                <div class="flex justify-center mb-5">
                    <div class=" justify-items-center bg-slate-200 drop-shadow-lg">
                        <div class="bg-gradient-to-r from-yellow-600 to-yellow-400 h-1 w-full"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-14 text-yellow-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                clip-rule="evenodd" />
                        </svg>

                        <p class="font-semibold text-lg px-4">Ooops...</p>
                        <p class="font-normal text-slate-500 text-sm px-4">Data masih kosong</p>

                    </div>
                </div>
            @else
                <table class="w-full">
                    <tr class="border-b-2 border-slate-500">
                        <th class="py-2">No.</th>
                        <th>Nama Anak</th>
                        <th>NIK</th>
                        <th>Tanggal Lahir</th>
                        <th class="max-w-15">Aksi</th>
                    </tr>
                    @foreach ($posyandu->anak as $p)
                        <tr class="text-center font-normal text-slate-500">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->nik }}</td>
                            <td>{{ $p->tanggal_lahir }}</td>
                            <td class="flex justify-center gap-2">
                                <a href=""
                                    class="bg-orange-300 hover:bg-orange-800 mt-2 p-1 rounded-sm text-orange-600 scale-100 peer hover:scale-105 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5">
                                        <path
                                            d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        <path
                                            d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                    </svg>

                                </a>
                                <button onclick=""
                                    class="bg-red-300 hover:bg-red-800 mt-2 p-1 rounded-sm text-red-500 scale-100 peer hover:scale-105 transition ease-in-out duration-150"><svg
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5">
                                        <path fill-rule="evenodd"
                                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
    {{-- bumil --}}
    <div class="lg:px-52 md:px-28">
        <div
            class="w-full bg-white p-2 mt-5  animate-fade-up animate-once animate-duration-1000 animate-ease-out animate-delay-150">
            <p class="mb-3 font-semibold text-xl text-sky-900">Data Ibu Hamil</p>
            @if ($posyandu->bumil->isEmpty())
                <div class="flex justify-center mb-5">
                    <div class=" justify-items-center bg-slate-200 drop-shadow-lg">
                        <div class="bg-gradient-to-r from-yellow-600 to-yellow-400 h-1 w-full"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-14 text-yellow-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                clip-rule="evenodd" />
                        </svg>

                        <p class="font-semibold text-lg px-4">Ooops...</p>
                        <p class="font-normal text-slate-500 text-sm px-4">Data masih kosong</p>

                    </div>
                </div>
            @else
                <table class="w-full">
                    <tr class="border-b-2 border-slate-500">
                        <th class="max-w-5 text-center py-2">No.</th>
                        <th>Nama Anak</th>
                        <th>NIK</th>
                        <th>Tanggal Lahir</th>
                        <th class="max-w-15">Aksi</th>
                    </tr>
                    @foreach ($posyandu->bumil as $p)
                        <tr class="text-center font-thin text-sky-900">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->nik }}</td>
                            <td>{{ $p->tanggal_lahir }}</td>
                            <td class="flex justify-center gap-2">
                                <a href=""
                                    class="bg-orange-300 hover:bg-orange-800 mt-2 p-1 rounded-sm text-orange-600 scale-100 peer hover:scale-105 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5">
                                        <path
                                            d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        <path
                                            d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                    </svg>

                                </a>
                                <button onclick=""
                                    class="bg-red-300 hover:bg-red-800 mt-2 p-1 rounded-sm text-red-500 scale-100 peer hover:scale-105 transition ease-in-out duration-150"><svg
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5">
                                        <path fill-rule="evenodd"
                                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
</body>

</html>
