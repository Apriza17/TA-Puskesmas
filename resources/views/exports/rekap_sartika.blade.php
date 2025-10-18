@vite(['resources/css/app.css'])
<table>
    <tr>
        <td colspan="10" class="text-sky-900 font-bold text-center text-lg">
            Rekap Sartika — {{ $tanggal->isoFormat('MMMM YYYY') }}
        </td>
    </tr>
</table>

<table class="border-2 border-slate-500">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Posyandu</th>
            <th>Jumlah Balita</th>
            <th>Sangat Pendek</th>
            <th>Pendek</th>
            <th>Normal</th>
            <th>Tinggi</th>
            <th>Balita Ditimbang</th>
            <th>Balita Tidak Ditimbang</th>
            <th>Angka Stunting (%)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $i => $r)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $r->posyandu }}</td>
                <td>{{ $r->total_balita }}</td>
                <td>{{ $r->sangat_pendek }}</td>
                <td>{{ $r->pendek }}</td>
                <td>{{ $r->normal }}</td>
                <td>{{ $r->tinggi }}</td>
                <td>{{ $r->ditimbang }}</td>
                <td>{{ $r->tdk_ditimbang }}</td>
                <td>{{ is_null($r->persen_stunting) ? '-' : $r->persen_stunting }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="9" style="text-align:right; font-weight:bold;">Rata-Rata Stunting</td>
            <td style="font-weight:bold;">
                {{ is_null($rataRata) ? '-' : $rataRata }}
            </td>
        </tr>
    </tbody>
</table>
