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

    <div class=" relative bg-gradient-to-t from-gray-700 to-cyan-600 h-60 w-full shadow-md">
        {{-- <div
            class="absolute top-0 left-0 text-white bg-red-600/80 hover:bg-red-800 rounded-br-2xl px-5 py-3 font-semibold no-print z-10">
            <a href="/Data-Sartika">Kembali</a>
        </div> --}}
        <div class="flex justify-between">
            <img src="img/edge dec1.png" alt="" class="size-40 invisible">
            <img src="img/edge dec1.png" alt="" class="size-40 rotate-90 invisible">
        </div>
        <div class="lg:px-52 md:px-28 text-white -translate-y-24">
            <div>
                <h1 class="text-3xl font-bold mb-2 ">Detail Sartika</h1>
                <p class="font-thin mb-16">Berikut merupakan tabel yang berisikan Data anak tiap posyandu</p>
            </div>
        </div>
    </div>
    {{-- Section --}}

    <div class="mx-auto px-5 lg:px-10 xl:px-52 -mt-20 pb-10">
        <div
            class="w-full bg-white rounded-xl shadow-lg p-2 mt-5 animate-fade-up animate-once animate-duration-1000 animate-ease-out ">
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
                            <td class="text-center flex gap-2 justify-center">
                                {{-- BTN EDIT -> buka modal --}}
                                <button type="button"
                                    class="btn-edit bg-orange-300 hover:bg-orange-800 mt-2 p-1 rounded-sm text-orange-600 scale-100 peer hover:scale-105 transition ease-in-out duration-150"
                                    data-id="{{ $p->id }}" data-nama="{{ $p->nama }}"
                                    data-nik="{{ $p->nik }}" data-kelamin="{{ $p->kelamin }}"
                                    data-tanggal="{{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('Y-m-d') }}"
                                    title="Edit">
                                    {{-- icon pensil --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5">
                                        <path
                                            d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        <path
                                            d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                    </svg>
                                </button>

                                {{-- BTN DELETE --}}
                                <button type="button"
                                    class="btn-delete bg-red-300 hover:bg-red-800 mt-2 p-1 rounded-sm text-red-600 scale-100 peer hover:scale-105 transition ease-in-out duration-150"
                                    data-id="{{ $p->id }}" data-nama="{{ $p->nama }}" title="Hapus">
                                    {{-- icon trash --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
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
    {{-- modal --}}
    {{-- Modal Edit Anak --}}
    <div id="modalEdit" class="fixed inset-0 z-50 hidden">
        {{-- backdrop --}}
        <div class="absolute inset-0 bg-black/40" data-close></div>
        {{-- card --}}
        <div class="relative mx-auto mt-40 w-full max-w-md">
            <div
                class="rounded-xl bg-white shadow-lg ring-1 ring-black/5 p-5 animate-jump-in animate-once animate-duration-500">
                <div class="flex items-center gap-3 mb-3">
                    <div class="rounded-full bg-orange-100 text-orange-600 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                            <path
                                d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800">Edit Data Anak</h3>
                    <button class="ml-auto text-slate-400 hover:text-slate-600" data-close>&times;</button>
                </div>

                <form id="formEdit" method="POST" action="#">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="text-sm text-slate-600">Nama</label>
                        <input type="text" name="nama" id="edit-nama"
                            class="mt-1 w-full rounded border-slate-300 border-2 bg-slate-100 focus:ring-cyan-600 focus:border-cyan-600">
                    </div>

                    <div class="mb-3">
                        <label class="text-sm text-slate-600">NIK (opsional)</label>
                        <input type="text" name="nik" id="edit-nik"
                            class="mt-1 w-full rounded border-slate-300 border-2 bg-slate-100 focus:ring-cyan-600 focus:border-cyan-600">
                    </div>

                    <div class="mb-3">
                        <label class="text-sm text-slate-600">Kelamin</label>
                        <select name="kelamin" id="edit-kelamin"
                            class="mt-1 w-full rounded border-slate-300 border-2 bg-slate-100 focus:ring-cyan-600 focus:border-cyan-600">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="text-sm text-slate-600">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="edit-tanggal"
                            class="mt-1 w-full rounded border-slate-300 border-2 bg-slate-100 focus:ring-cyan-600 focus:border-cyan-600">
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" class="px-3 py-2 rounded bg-slate-100 text-slate-700" data-close>
                            Batal
                        </button>
                        <button type="submit" class="px-3 py-2 rounded bg-cyan-600 text-white hover:bg-cyan-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Delete Anak --}}
    <div id="modalDelete" class="fixed inset-0 z-50 hidden">
        {{-- backdrop --}}
        <div class="absolute inset-0 bg-black/40" data-close></div>

        <div class="relative mx-auto mt-52 w-full max-w-md">
            <div
                class="rounded-xl bg-white shadow-lg ring-1 ring-black/5 p-5 animate-jump-in animate-once animate-duration-500">
                <div class="flex items-center gap-3 mb-3">
                    <div class="rounded-full bg-rose-100 text-rose-600 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12.884 2.532c-.346-.654-1.422-.654-1.768 0l-9 17A1 1 0 0 0 3 21h18a.998.998 0 0 0 .883-1.467zM13 18h-2v-2h2zm-2-4V9h2l.001 5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800">Hapus Data Anak</h3>
                    <button class="ml-auto text-slate-400 hover:text-slate-600" data-close>&times;</button>
                </div>

                <p class="text-slate-600 text-sm">
                    Kamu akan menghapus data anak:
                    <span id="del-nama" class="font-semibold text-slate-800">-</span>.
                    Tindakan ini <span class="font-semibold text-rose-600">tidak dapat dibatalkan</span>.
                </p>

                <form id="formDelete" method="POST" action="#" class="mt-5">
                    @csrf
                    @method('DELETE')

                    {{-- Info tambahan: jika ada relasi laporan --}}


                    <div class="flex justify-end gap-2">
                        <button type="button" class="px-3 py-2 rounded bg-slate-100 text-slate-700" data-close>
                            Batal
                        </button>
                        <button type="submit" class="px-3 py-2 rounded bg-rose-600 text-white hover:bg-rose-700">
                            Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</body>

{{-- Script modal edit --}}
<script>
    const modal = document.getElementById('modalEdit');
    const form = document.getElementById('formEdit');
    const inNama = document.getElementById('edit-nama');
    const inNik = document.getElementById('edit-nik');
    const inKel = document.getElementById('edit-kelamin');
    const inTgl = document.getElementById('edit-tanggal');

    // open modal + set data
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            inNama.value = btn.dataset.nama || '';
            inNik.value = btn.dataset.nik || '';
            inKel.value = btn.dataset.kelamin || 'L';
            inTgl.value = btn.dataset.tanggal || '';

            // set action /anak/{id}
            form.action = "{{ route('anak.update', ':id') }}".replace(':id', id);

            modal.classList.remove('hidden');
        });
    });

    // close modal
    modal.querySelectorAll('[data-close]').forEach(el => {
        el.addEventListener('click', () => modal.classList.add('hidden'));
    });

    // close on ESC
    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') modal.classList.add('hidden');
    });
</script>

{{-- script delelte --}}
<script>
    // ===== Delete Modal =====
    const delModal = document.getElementById('modalDelete');
    const delForm = document.getElementById('formDelete');
    const delNamaEl = document.getElementById('del-nama');

    // open modal + set action/name
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const nama = btn.dataset.nama || '-';

            delNamaEl.textContent = nama;
            delForm.action = "{{ route('anak.destroy', ':id') }}".replace(':id', id);

            delModal.classList.remove('hidden');
        });
    });

    // close modal
    delModal.querySelectorAll('[data-close]').forEach(el => {
        el.addEventListener('click', () => delModal.classList.add('hidden'));
    });

    // close on ESC
    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') delModal.classList.add('hidden');
    });
</script>



</html>
