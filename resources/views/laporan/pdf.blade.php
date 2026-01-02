<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h3>Laporan Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>No Invoice</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>User</th>
                <th>Metode</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $t)
            <tr>
                <td>{{ $t->no_invoice }}</td>
                <td>{{ $t->tanggal }}</td>
                <td>{{ $t->pelanggan->nama_pelanggan }}</td>
                <td>{{ $t->user->nama }}</td>
                <td>{{ $t->metode->nama_metode }}</td>
                <td>{{ $t->total_harga }}</td>
                <td>{{ $t->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
