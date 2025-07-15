<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('img/logo.png') }}">
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="text-center p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-red-500">Akses Ditolak</h1>
        <p class="text-gray-700 mt-2">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/') }}">
            <div class="mt-4 inline-block px-4 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-800">
                Kembali
            </div>
        </a>
    </div>
</body>

</html>
