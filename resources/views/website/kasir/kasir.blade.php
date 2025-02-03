<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kasir</title>
  <style>
    .table-container {
      margin-top: 30px; /* Memberi jarak antara tabel dan elemen sebelumnya */
    }
  </style>
</head>
<body>
  <div class="container-fluid content-inner mt-n5 py-0">

    <!-- Cari Barang -->
    <div class="row">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><i class="faj-button fa-solid fa-magnifying-glass"></i></h4>
        </div>
        <div class="card-body"></div>
      </div>

      <!-- Bagian Pembayaran -->
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><i class="faj-button fa-regular fa-cart-shopping"></i>Pembayaran</h4>

          <?php if (session()->has('errorKasir')): ?>
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="faj-button fa-regular fa-circle-exclamation fa-lg"></i>
            <?= session('errorKasir') ?></div>
          <?php endif; ?>
        </div>

        <div class="card-body">
        <form id="kasirForm" action="{{ url('aksi_kasir') }}" method="post">
            @csrf
            <div class="row">
              
              <div class="col-sm-6">
                <div class="form-group">
                <label class="control-label">Membership :</label>
                  <input type="text" class="form-control" id="membership_input" name="membership">
                  <button type="button" class="btn btn-secondary mt-2" id="cek_membership">Cek Membership</button>
                </div>
                
               
                
                <div class="form-group">
                  <label class="control-label">Menu :</label>
                  <select class="choices form-select" id="menu" name="menu">
                    <option disabled selected>- Pilih -</option>
                    <?php foreach ($t as $p): ?>
            @if ($p->deleted_at === null)
                <option 
               value="<?= $p->id_menu ?>" 
              data-harga="<?= $p->harga_menu ?>" 
              data-foto="<?= $p->foto ?>" 
              data-keterangan="<?= htmlspecialchars($p->keterangan ?? '', ENT_QUOTES, 'UTF-8') ?>"
              >
              <?= $p->nama_menu ?>
             </option>
           @endif
            <?php endforeach; ?>

                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">Tanggal :</label>
                  <input type="text" class="form-control" readonly="readonly" name="tanggal" value="<?= date('d M Y') ?>" disabled>
                </div>

                <div class="form-group">
                  <label class="control-label">Meja :</label>
                  <input type="text" class="form-control" readonly="readonly" name="meja" value="{{ $meja->No_meja }}">
                </div>
              </div>

              <div class="col-sm-6">
              <div class="form-group">
                  <label class="control-label">Voucher :</label>
                  <input type="text" class="form-control" id="voucher_input" name="membership">
                  <button type="button" class="btn btn-secondary mt-2" id="cek_voucher">Cek Voucher</button>
                </div>
                <div class="form-group">
                  <label class="control-label">Total :</label>
                  <input type="text" class="form-control" id="total_harga_input" name="total" readonly="readonly">
                </div>

                <div class="form-group">
                  <label class="control-label">Bayar :</label>
                  <input type="text" class="form-control" id="bayar_input" name="bayar" required>
                </div>

                <div class="form-group">
                  <label class="control-label">Kembalian :</label>
                  <input type="text" class="form-control" id="kembalian_input" name="kembalian" readonly="readonly">
                </div>
              </div>
            </div>
            <input type="hidden" name="id" value="{{ $meja->id_meja }}">
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
         

        
      

      <!-- Tabel -->
      <div class="card table-container">
        <table class="table datatable" id="userTable">
          <thead>
            <tr style="font-weight: bold; color: black; font-size: larger;">
              <th scope="col" class="text-center">No</th>
              <th scope="col" class="text-center">Foto</th>
              <th scope="col" class="text-center">Menu</th>
              <th scope="col" class="text-center">Harga</th>
              <th scope="col" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {
  const menuSelect = document.getElementById('menu');
  const totalHargaInput = document.getElementById('total_harga_input');
  const bayarInput = document.getElementById('bayar_input');
  const kembalianInput = document.getElementById('kembalian_input');
  const userTable = document.getElementById('userTable').querySelector('tbody');

  function hitungTotalHargaDariTabel() {
    let totalHarga = 0;

    const rows = Array.from(userTable.querySelectorAll('tr'));
    rows.forEach(row => {
      const hargaInput = row.querySelector('td:nth-child(4) input');
      if (hargaInput) {
        const harga = parseFloat(hargaInput.value);
        if (!isNaN(harga)) {
          totalHarga += harga;
        }
      }
    });

    const pajak = totalHarga * 0.1;
    totalHargaInput.value = (totalHarga + pajak).toFixed(0);
  }

  function hitungKembalian() {
    const totalHarga = parseFloat(totalHargaInput.value);
    const bayar = parseFloat(bayarInput.value);
    if (!isNaN(totalHarga) && !isNaN(bayar)) {
      const kembalian = Math.max(0, bayar - totalHarga);
      kembalianInput.value = kembalian.toFixed(0);
    } else {
      kembalianInput.value = '';
    }
  }

  function tambahKeTabel() {
    const selectedMenu = menuSelect.options[menuSelect.selectedIndex];
    if (selectedMenu.value === '- Pilih -') return;

    const idMenu = selectedMenu.value;
    const hargaMenu = selectedMenu.getAttribute('data-harga');
    const namaMenu = selectedMenu.textContent.trim();
    const fotoMenu = selectedMenu.getAttribute('data-foto');
    const keterangan = selectedMenu.getAttribute('data-keterangan'); // FIXED

    const existingRows = Array.from(userTable.querySelectorAll('tr'));
    if (existingRows.some(row => row.querySelector('td:nth-child(3)').textContent.includes(namaMenu))) {
    
      return;
    }

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
      <td class="text-center">${existingRows.length + 1}</td>
      <td class="text-center">
        <img src="/assets/img/Menu/${fotoMenu}" alt="Menu Foto" style="width: 100px; height: 100px; object-fit: cover;">
      </td>
      <td class="text-center">
      <input type="text" name="nama[]" value="${namaMenu}" readonly><br>
       <small style="color: gray;">${keterangan}</small>
        <input type="hidden" name="menu[]" value="${idMenu}" readonly>
      </td>
      <td class="text-center">
        <input type="text" name="harga[]" value="${parseFloat(hargaMenu).toFixed(0)}" readonly>
      </td>
      <td class="text-center">
        <button class="btn btn-danger btn-sm remove-row">Hapus</button>
      </td>
    `;
    userTable.appendChild(newRow);

    newRow.querySelector('.remove-row').addEventListener('click', function () {
      newRow.remove();
      updateRowNumbers();
      hitungTotalHargaDariTabel();
    });

    hitungTotalHargaDariTabel();
  }

  function updateRowNumbers() {
    Array.from(userTable.querySelectorAll('tr')).forEach((row, index) => {
      row.querySelector('td:first-child').textContent = index + 1;
    });
  }

  menuSelect.addEventListener('change', tambahKeTabel);
  bayarInput.addEventListener('input', hitungKembalian);

  hitungTotalHargaDariTabel();
});


   document.addEventListener('DOMContentLoaded', function () {
    const members = @json($member->pluck('NoMember'));

    // Hapus used_membership dari localStorage saat halaman dimuat ulang
    localStorage.removeItem('used_membership');

    document.getElementById('cek_membership').addEventListener('click', function () {
        const membershipInput = document.getElementById('membership_input').value.trim();
        const totalHargaInput = document.getElementById('total_harga_input');
        let totalHarga = parseFloat(totalHargaInput.value) || 0;

        console.log("Members:", members);
        console.log("Membership Input:", membershipInput);

        // Cek apakah membership sudah pernah digunakan dalam sesi ini
        if (localStorage.getItem('used_membership')) {
            alert("Membership sudah digunakan dan tidak bisa diganti!");
            return;
        }

        // Cek apakah membership valid
        if (members.includes(membershipInput)) {
            totalHarga *= 0.9; // Diskon 10%
            totalHargaInput.value = totalHarga.toFixed(0);

            // Tandai bahwa membership sudah digunakan
            localStorage.setItem('used_membership', membershipInput);

            alert("Membership berhasil diterapkan! Diskon 10% diberikan.");
        } else {
            alert("Membership tidak valid!");
        }
    });
});




  document.addEventListener('DOMContentLoaded', function () {
        const vouchers = @json($Voucher->pluck('Diskon', 'No_Voucher'));
        const voucherValidity = @json($Voucher->pluck('valid', 'No_Voucher'));

        document.getElementById('cek_voucher').addEventListener('click', function() {
            const voucherInput = document.getElementById('voucher_input').value.trim();
            const totalHargaInput = document.getElementById('total_harga_input');
            let totalHarga = parseFloat(totalHargaInput.value) || 0;

            console.log("Vouchers:", vouchers);
            console.log("Voucher Input:", voucherInput);

            // Cek apakah voucher sudah pernah digunakan
            if (localStorage.getItem(`used_voucher_${voucherInput}`)) {
                alert("Voucher sudah pernah digunakan!");
                return;
            }

            // Cek apakah voucher valid berdasarkan kolom "valid"
            if (voucherValidity[voucherInput] == 0) { // 0 berarti tidak valid
                alert("Voucher tidak valid!");
                return;
            }

            // Cek apakah voucher ada di daftar
            if (vouchers[voucherInput]) {
                const diskon = parseFloat(vouchers[voucherInput]);
                console.log("Diskon:", diskon);

                totalHarga -= (diskon / 100) * totalHarga;
                totalHargaInput.value = totalHarga.toFixed(0);
                
                // Simpan bahwa voucher sudah digunakan
                localStorage.setItem(`used_voucher_${voucherInput}`, true);

                alert("Voucher berhasil diterapkan! Diskon " + diskon + "%");
            } else {
                alert("Voucher tidak valid!");
            }
        });
    });



</script>

  </div>
  </form>
  </div>
  </div>
</body>
</html>
