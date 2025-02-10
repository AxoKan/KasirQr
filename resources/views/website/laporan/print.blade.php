<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Sederhana</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-center text-xl font-bold">Restauran Bintang Satu</h1>
        <h2 class="text-center text-lg">Laporan Penjualan Sederhana</h2>
        <h3 class="text-center text-md">
    Periode {{ \Carbon\Carbon::parse($sa->first()->tanggal_transaksi)->translatedFormat('F Y') }}
</h3>

        <div class="overflow-x-auto mt-4">
            <table class="min-w-full border-collapse border border-gray-400">
                <thead>
                    <tr>
                        <th class="border border-gray-400 px-4 py-2 bg-blue-100">No</th>
                        <th class="border border-gray-400 px-4 py-2 bg-blue-100">ID</th>
                        <th class="border border-gray-400 px-4 py-2 bg-blue-100">Nama Pelanggan</th>
                        <th class="border border-gray-400 px-4 py-2 bg-blue-100">Total Penjualan</th>
                        <th class="border border-gray-400 px-4 py-2 bg-blue-100">Pembayaran</th>
                        <th class="border border-gray-400 px-4 py-2 bg-blue-100">Kembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalHarga = 0;
                        $totalBayar = 0;
                        $totalKembalian = 0;
                    @endphp

                    @foreach ($sa as $index => $user)
                    @if ($user->deleted_at === null || $user->status == 2)
                            @php
                                $totalHarga += $user->total_harga;
                                $totalBayar += $user->bayar;
                                $totalKembalian += $user->kembalian;
                            @endphp
                            <tr class="table-row" data-id-transaksi="{{ $user->id_transaksi }}" data-status="{{ $user->status }}">
                                <td class="text-center border border-gray-400 px-4 py-2">{{ $index + 1 }}</td>
                                <td class="text-center border border-gray-400 px-4 py-2">{{ $user->Nomor }}</td>
                                <td class="text-center border border-gray-400 px-4 py-2">{{ $user->nama_pelanggan}}</td>
                                <td class="text-center border border-gray-400 px-4 py-2">{{ number_format($user->total_harga, 0, ',', '.') }}</td>
                                <td class="text-center border border-gray-400 px-4 py-2">{{ number_format($user->bayar, 0, ',', '.') }}</td>
                                <td class="text-center border border-gray-400 px-4 py-2">{{ number_format($user->kembalian, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endforeach

                    <tr class="bg-gray-200">
                        <td class="border border-gray-400 px-4 py-2 text-center font-bold" colspan="3">Total</td>
                        <td class="border border-gray-400 px-4 py-2 text-right font-bold">{{ number_format($totalHarga, 0, ',', '.') }}</td>
                        <td class="border border-gray-400 px-4 py-2 text-right font-bold">{{ number_format($totalBayar, 0, ',', '.') }}</td>
                        <td class="border border-gray-400 px-4 py-2 text-right font-bold">{{ number_format($totalKembalian, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<script type="text/javascript"> window.print();</script>