<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen bg-white">
    
    <!-- Container for PDF -->
    <div id="membership-card">
        <!-- Kartu Membership -->
        <div class="bg-black text-white w-[85.6mm] h-[54mm] rounded-lg flex flex-col items-center justify-center p-4">
            <div class="text-4xl font-bold mb-2">
                <img src="{{ asset('assets/img/custom/' . $satu->logos) }}" alt="Logo" width="60">
            </div>
            <div class="text-center">
                <div class="text-md font-semibold">{{ $satu->nama_Logo }}</div>
                <div class="text-xs">Restaurant TerBaik Bintang Satu</div>
            </div>
            <div class="mt-auto text-xs">MEMBERSHIP CARD</div>
        </div>

        <!-- Jarak antara dua kartu -->


        <!-- Kartu Terima Kasih -->
        <div class="bg-black text-white w-[85.6mm] h-[54mm] rounded-lg flex flex-col items-center justify-center p-4">
            <div class="text-center">
                <div class="text-md font-semibold">Terima Kasih Telah Membership Bersama Kami!</div>
                <div class="text-xs">Member</div>
                <div class="text-xs">{{ $member->nama }}</div>
                <div class="mt-auto text-lg font-bold">{{ $member->NoMember }}</div> <!-- Nomor member lebih besar -->
            </div>
        </div>
    </div>
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const element = document.getElementById('membership-card'); // Select the entire membership card container
            const opt = {
                margin: 0,
                filename: 'KartuMembership.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 3 },
                jsPDF: { unit: 'mm', format: [85.6, 54], orientation: 'landscape' } // Ukuran kartu PVC (CR80)
            };

            setTimeout(() => {
                html2pdf().set(opt).from(element).save().then(() => {
                    window.close(); // Close the tab after download
                });
            }, 1000); // Small delay to ensure rendering
        });
    </script>
</body>
</html>
