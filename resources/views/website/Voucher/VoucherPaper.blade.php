<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Gift Voucher</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl w-full" id="membership-card">
    <div class="flex flex-col md:flex-row">
      <div class="bg-blue-900 text-white p-8 md:w-1/2 relative">
        <div class="absolute top-0 left-0 w-full h-full">
          <img alt="Decorative background pattern" class="w-full h-full object-cover opacity-10" height="400" src="{{ asset('assets/img/custom/sph.jpg') }}" width="600"/>
        </div>
        <div class="relative z-10">
          <div class="mb-4">
            <img src="{{ asset('assets/img/custom/iItX8oTrZqRsPIZg7kncSMThPlNmYyhoz5v84V7Z.png') }}" alt="Logo" width="100">
          </div>
          <h1 class="text-4xl font-bold mb-2 text-white">VOUCHER</h1>
          <p class="mb-8">{{ $satu->nama_Logo }}</p>
        </div>
      </div>

      <div class="bg-white p-8 md:w-1/2 flex flex-col justify-center items-center">
        <h2 class="text-orange-500 text-3xl font-bold mb-4">DISCOUNT</h2>
        <h1 class="text-blue-900 text-6xl font-bold mb-4">{{ $Voucher->Diskon }}%</h1>
        <p class="text-gray-600 mb-4">
          Masukkan Kode Di bawah ini saat pemesanan untuk meredeemnya
        </p>
        <h1 class="text-4xl font-bold mb-2 text-gray">{{ $Voucher->No_Voucher }}</h1>
        <p>Valid Until {{ $Voucher->Valid }}</p>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const element = document.getElementById('membership-card'); // Select the entire membership card container

      const opt = {
        margin: 0,
        filename: 'Voucher.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 3 },
        jsPDF: { unit: 'mm', format: [105, 148], orientation: 'landscape' } // A6 size (105mm x 148mm)
      };

      html2pdf().set(opt).from(element).save(); // Automatically triggers PDF download
    });
</script>


</body>
</html>
