<table>
    {{-- Judul Laporan --}}
    <tr>
        <td colspan="10" style="text-align: center; font-weight: bold; font-size: 14pt;">
            Rekap Sartika — {{ $tanggal->isoFormat('MMMM YYYY') }}
        </td>
    </tr>
    <tr></tr> {{-- Baris kosong sebagai pemisah --}}
</table>

<table>
    <thead>
        {{-- Baris header utama --}}
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Posyandu</th>
            <th rowspan="2">Jumlah Balita</th>

            {{-- TB/U --}}
            <th colspan="4">TB/U</th>

            <th rowspan="2">Balita Ditimbang</th>
            <th rowspan="2">Balita Tidak Ditimbang</th>
            <th rowspan="2">Angka Stunting (%)</th>
        </tr>
        {{-- Baris header kedua --}}
        <tr>
            <th>Sangat Pendek</th>
            <th>Pendek</th>
            <th>Normal</th>
            <th>Tinggi</th>
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
        {{-- Footer Rata-rata --}}
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold;">Rata-Rata Stunting</td>
            <td style="font-weight: bold;">
                {{ is_null($rataRata) ? '-' : $rataRata }}
            </td>
        </tr>
    </tbody>
</table>
