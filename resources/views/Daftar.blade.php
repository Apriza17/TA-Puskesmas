<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Daftar Akun</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}">
</head>

<body class="bg-cyan-600 lg:flex lg:h-screen">
    <div class="bg-gradient-to-t relative from-gray-700 to-cyan-600 h-28 lg:h-full lg:w-1/2">
        <div class="">
            <div class="">
                <img src="/img/edge dec1.png" class="w-64" alt="">
            </div>
            <div class="flex justify-center align-middle animate-fade-right animate-once animate-ease-in-out    ">
                <div>
                    <p class="font-bold text-3xl text-white text-center">Selamat Datang </p>
                    <img src="/img/logo.png" alt="" class="w-52 mx-auto my-4">
                    <p class="text-center text-white">Website ini merupakan sebuah media untuk mengetahui sebuah
                        informasi <br>
                        tentang
                        stunting daerah kerja puskesmas</p>
                </div>
            </div>
            <div class=" absolute bottom-0 right-0 invisible lg:visible">
                <img src="/img/edge dec2.png" class="w-64" alt="">
            </div>
        </div>
    </div>
    <div class="bg-white w-full lg:w-1/2 lg: py-16 lg:px-10 lg:content-center">
        <p class="text-3xl font-bold text-sky-900 text-center lg:text-left ">Daftar Akun</p>
        <p class="text-md text-sky-900 text-center lg:text-left ">Masukan Username dan Password anda !</p>
        <div class="">
            <form method="POST" action="{{ route('prosesDaftar') }}" class="font text-sky-900 mt-6 px-24 lg:px-0">
                @csrf
                <label for="" class="font-semibold">Username</label>
                <br>
                <input type="text" name="name" id="" class="w-full placeholder:italic font-thin"
                    placeholder="Masukan disini">
                <div class="h-1 bg-cyan-600 rounded-lg "></div>
                @error('name')
                    <p class="text-red-500 font-normal text-sm mb-3">{{ $message }}</p>
                @enderror
                <label for="" class="font-semibold">Email</label>
                <br>
                <input type="email" name="email" id="" class="w-full placeholder:italic font-thin"
                    placeholder="Masukan disini">
                <div class="h-1 bg-cyan-600 rounded-lg "></div>
                @error('name')
                    <p class="text-red-500 font-normal text-sm mb-3">{{ $message }}</p>
                @enderror
                <label for="" class="font-semibold">Password</label>
                <br>
                <input type="password" name="password" id="" class="w-full placeholder:italic font-thin"
                    placeholder="Masukan disini">
                <div class="h-1 bg-cyan-600 rounded-lg"></div>
                @error('password')
                    <p class="text-red-500 font-normal text-sm">{{ $message }}</p>
                @enderror
                <button type="submit"
                    class="w-full bg-sky-900 rounded-2xl text-white py-1 font-semibold mt-6 scale-100 hover:scale-105 transition ease-in-out duration-200">Daftar</button>
                <a href="/"
                    class="w-full block text-center invisible md:visible outline outline-sky-900 rounded-2xl text-sky-900 py-1 font-semibold mt-2 scale-100 hover:scale-105 transition ease-in-out duration-200">Kembali</a>
                <p class="text-xs mt-1 text-center opacity-70 invisible md:visible">Silahkan Klik "Daftar" untuk membuat
                    akun!</p>

            </form>
        </div>
    </div>
    <div class="bg-gradient-to-t from-cyan-600 to-gray-700 relative h-28 lg:hidden">
        <img src="/img/edge dec2.png" class="w-64 absolute right-0 bottom-0" alt="">
    </div>

</body>
{{-- <body class="bg-slate-300">
    <div class="bg-gradient-to-t from-gray-700 to-cyan-600 h-28">
        <img src="/img/edge dec1.png" class="w-64" alt="">
    </div>
    <div class="bg-white w-full py-16 ">
        <p class="text-3xl font-bold text-sky-900 text-center ">Daftar</p>
        <p class="text-md text-sky-900 text-center ">Masukan Username dan Password anda!</p>
        <div class="">
            <form method="POST" action="{{ route('prosesDaftar') }}" class="font text-sky-900 mt-6 px-24">
                @csrf
                <label for="" class="font-semibold">Username</label>
                <br>
                <input type="text" name="name" id="" class="w-full placeholder:italic font-thin"
                    placeholder="Masukan disini">
                <div class="h-1 bg-cyan-600 rounded-lg mb-3"></div>
                <label for="" class="font-semibold">Email</label>
                <br>
                <input type="email" name="email" id="" class="w-full placeholder:italic font-thin"
                    placeholder="Masukan disini">
                <div class="h-1 bg-cyan-600 rounded-lg mb-3"></div>
                <label for="" class="font-semibold">Password</label>
                <br>
                <input type="password" name="password" id="" class="w-full placeholder:italic font-thin"
                    placeholder="Masukan disini">
                <div class="h-1 bg-cyan-600 rounded-lg"></div>

                <button type="submit"
                    class="w-full bg-sky-900 rounded-2xl text-white py-1 font-semibold mt-6 scale-100 hover:scale-105 transition ease-in-out duration-200">Daftar</button>
                <a href="/Login"
                    class="w-full cursor-pointer block text-center outline outline-sky-900 rounded-2xl text-sky-900 py-1 font-semibold mt-2 scale-100 hover:scale-105 transition ease-in-out duration-200">Kembali</a>

            </form>
        </div>
    </div>
    <div class="bg-gradient-to-t from-cyan-600 to-gray-700 relative h-28">
        <img src="/img/edge dec2.png" class="w-64 absolute right-0 bottom-0" alt="">
    </div>

</body> --}}

</html>
