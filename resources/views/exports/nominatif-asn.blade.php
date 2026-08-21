<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nominatif ASN Aktif</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        /* Excel specific formatting to force text representation */
        .text {
            mso-number-format: "\@"; 
        }
    </style>
</head>
<body>
    <h2>DATA BEZETTING / NOMINATIF ASN AKTIF</h2>
    <p>Tanggal Unduh: {{ date('d-m-Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA LENGKAP</th>
                <th>NIP</th>
                <th>TEMPAT, TANGGAL LAHIR</th>
                <th>PANGKAT / GOL. RUANG</th>
                <th>JABATAN</th>
                <th>UNIT KERJA</th>
                <th>PENDIDIKAN TERAKHIR</th>
                <th>MASA KERJA</th>
                <th>JENIS KELAMIN</th>
                <th>AGAMA</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($aktifList as $asn)
            <tr>
                <td style="text-align: center;">{{ $no++ }}</td>
                <td>{{ $asn->getNama() }}</td>
                <td class="text">{{ $asn->getNip() }}</td>
                <td>{{ $asn->getTempatLahir() }}{{ $asn->getTempatLahir() && $asn->getTanggalLahir() ? ', ' : '' }}{{ $asn->getTanggalLahir() }}</td>
                <td>{{ $asn->getPangkatGolongan() }}</td>
                <td>{{ $asn->getJabatan() }}</td>
                <td>{{ $asn->getUnitKerja() }}</td>
                <td>{{ $asn->getPendidikanTerakhir() }}</td>
                <td>{{ $asn->getMasaKerja() }}</td>
                <td>{{ $asn->getJenisKelamin() }}</td>
                <td>{{ $asn->getAgama() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
