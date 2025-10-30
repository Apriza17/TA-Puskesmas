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
    <div class="bg-gradient-to-r relative from-cyan-800 to-cyan-600 h-28 drop-shadow-lg overflow-hidden">
        <div class="text-white font-semibold flex justify-center items-center h-full">
            {{-- <img src="img/edge dec1.png" class="absolute z-0 size-56 right-0 rotate-90" alt=""> --}}
            <div class="text-2xl">Edit Data Anak</div>
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

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="bg-white rounded-lg shadow ring-1 ring-black/5 p-6">
            <h1 class="text-xl font-semibold text-sky-900 mb-4">Edit Data Anak</h1>

            <form method="POST" action="{{ route('kader.anak.update', $anak) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $anak->nik) }}"
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600 @error('nik') ring-2 ring-rose-500 border-transparent @enderror">
                    @error('nik')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $anak->nama) }}"
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600 @error('nama') ring-2 ring-rose-500 border-transparent @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="kelamin"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600 @error('kelamin') ring-2 ring-rose-500 border-transparent @enderror">
                            <option value="L" {{ old('kelamin', $anak->kelamin) === 'L' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="P" {{ old('kelamin', $anak->kelamin) === 'P' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                        @error('kelamin')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', \Carbon\Carbon::parse($anak->tanggal_lahir)->format('Y-m-d')) }}"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600 @error('tanggal_lahir') ring-2 ring-rose-500 border-transparent @enderror">
                        @error('tanggal_lahir')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Berat Lahir (kg)</label>
                        <input type="number" step="0.01" name="berat_lahir"
                            value="{{ old('berat_lahir', $anak->berat_lahir) }}"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600 @error('berat_lahir') ring-2 ring-rose-500 border-transparent @enderror">
                        @error('berat_lahir')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tinggi Lahir (cm)</label>
                        <input type="number" step="0.1" name="tinggi_lahir"
                            value="{{ old('tinggi_lahir', $anak->tinggi_lahir) }}"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-600 @error('tinggi_lahir') ring-2 ring-rose-500 border-transparent @enderror">
                        @error('tinggi_lahir')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
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
