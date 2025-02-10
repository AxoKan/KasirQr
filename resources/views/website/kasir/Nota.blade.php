<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body { font-family: sans-serif; }
        .container { width: 100%; max-width: 320px; margin: auto; padding: 15px; border: 1px solid #ddd; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .border-dashed { border-top: 1px dashed #000; margin: 5px 0; }
        .flex { display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <div class="container" id="receipt">
        <div class="text-center">
            <img src="{{ asset('assets/img/custom/' . $satu->logos) }}" alt="Logo" width="100">
            <h2 class="font-bold">{{ $satu->nama_Logo }}</h2>
            <p>Indonesia</p>
        </div>

        <div class="text-center"><p class="font-bold">Dine in / Table {{ $sa->Nomor }}</p></div>

        <hr class="border-dashed"/>

        <div class="flex">
            <p>Date</p>
            <p class="font-bold">{{ $sa->tanggal_transaksi }}</p>
        </div>

        <p class="font-bold">Order Details</p>
        @foreach($detail as $detail)
            <div class="flex">
                <p>{{ $detail->nama_menu }}</p>
                <p class="font-bold">Rp{{ number_format($detail->harga_menu, 0, ',', '.') }}</p>
            </div>
        @endforeach

        <p class="font-bold">Payment Details</p>
        <div class="flex"><p>Subtotal</p><p class="font-bold">Rp{{ number_format($sa->total_harga, 0, ',', '.') }}</p></div>
        <div class="flex"><p>Paid</p><p class="font-bold">Rp{{ number_format($sa->bayar, 0, ',', '.') }}</p></div>
        <div class="flex"><p>Change</p><p class="font-bold">Rp{{ number_format($sa->kembalian, 0, ',', '.') }}</p></div>

        <div class="text-center font-bold">PAID</div>
        <div class="text-center"><p>Thank you for your order!</p></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        window.onload = function () {
            const element = document.getElementById('receipt'); // Select receipt container only
            const opt = {
                margin: 5,
                filename: 'Nota.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: [80, 200], orientation: 'portrait' } // Adjusted page size
            };

            html2pdf().set(opt).from(element).save().then(() => {
                window.close(); // Close the tab after download
            });
        };
    </script>
</body>
</html>
