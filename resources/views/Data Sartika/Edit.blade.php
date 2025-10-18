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

<body class="bg-slate-300">
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        <div class="flex justify-between invisible">
            <img src="img/edge dec1.png" alt="" class="size-40">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90">
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Edit Data Sartika</h1>
                <p class="font-thin mb-16">Anda memasuki halaman untuk mengubah data posyandu</p>
            </div>
            <div class="flex justify-end">
                <a href="/Data-Sartika">
                    <div
                        class="bg-red-600 hover:bg-red-700 p-1 px-3 text-center font-semibold text-sm outline outline-2 drop-shadow-md rounded-sm scale-100 hover:scale-105 transition ease-in-out duration-100">
                        Kembali
                    </div>
                </a>
            </div>
        </div>
    </div>
    {{-- form edit --}}
    <div class="lg:px-96 md:px-28">
        <div class="bg-white mt-5 animate-fade-up animate-once animate-duration-1000 animate-ease-out ">
            <div class="bg-gradient-to-r from-orange-600 to-orange-400 h-2 w-full"></div>
            <div class="p-2">
                <form action="/Data-Sartika/{{ $posyandu->id }}" class="flex-col" method="POST">
                    @method('put')
                    @csrf
                    <div class="mb-3">
                        <label for="" class="text-sky-900 font-semibold mb-2">Nama Posyandu</label>
                        <br>
                        <input type="text" name="nama" id="" class=""
                            value="{{ $posyandu->nama }}">
                        <div class="h-1 bg-cyan-600 w-52 rounded-lg "></div>

                    </div>
                    <div class="justify-center flex">
                        <button class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-700"
                            type="submit">Simpan
                            Perubahan</button>

                    </div>
                </form>
            </div>
        </div>

    </div>
</body>

</html>
