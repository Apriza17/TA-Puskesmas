<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Edit Data Anak</title>
</head>

<body class="bg-gray-100">

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <a href="{{ url('/dashboard1') }}" class="inline-flex items-center text-sm hover:underline mb-4">
            ← Kembali ke Dashboard
        </a>

        <div class="bg-white rounded-lg shadow ring-1 ring-black/5 p-6">
            <h1 class="text-xl font-semibold text-sky-900 mb-4">Edit Data Anak</h1>

            @if ($errors->any())
                <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-800">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('kader.anak.update', $anak) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $anak->nik) }}"
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $anak->nama) }}"
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="kelamin"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                            <option value="L" {{ old('kelamin', $anak->kelamin) === 'L' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="P" {{ old('kelamin', $anak->kelamin) === 'P' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', \Carbon\Carbon::parse($anak->tanggal_lahir)->format('Y-m-d')) }}"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Berat Lahir (kg)</label>
                        <input type="number" step="0.01" name="berat_lahir"
                            value="{{ old('berat_lahir', $anak->berat_lahir) }}"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tinggi Lahir (cm)</label>
                        <input type="number" step="0.1" name="tinggi_lahir"
                            value="{{ old('tinggi_lahir', $anak->tinggi_lahir) }}"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600">
                    </div>

                    <div class="pt-2 flex items-center gap-3">
                        <button type="submit"
                            class="inline-flex items-center rounded-md bg-cyan-600 px-4 py-2 text-white hover:bg-cyan-700">
                            Simpan Perubahan
                        </button>
                        <a href="{{ url('/dashboard1') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
            </form>
        </div>
    </div>
</body>

</html>
