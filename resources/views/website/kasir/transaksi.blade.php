<main id="main" class="main">
  <div class="container">
    <div class="pagetitle">
      <h1></h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="filter-container"></div>
              </div>
              <div class="filter-container d-flex align-items-center gap-2">
        <a href="{{ url('Laporan') }}">
          <button class="btn btn-success">Laporan</button>
        </a>
      </div>
              <table class="table datatable" id="mitraTable">
  <thead>
    <tr style="font-weight: bold; color: black; font-size: larger;">
      <td align="center" scope="col">No</td>
      <td align="center" scope="col">Nomor</td>
      <td align="center" scope="col">nama pelanggan</td>
      <td align="center" scope="col">Tanggal</td>
      <td align="center" scope="col">Total harga</td>
      <td align="center" scope="col">Pesanan</td>
      <td align="center" scope="col">Status</td>
      <td align="center" scope="col">Action</td>
    </tr>
  </thead>
  <tbody>
    @foreach ($sa as $index => $user)
      @if ($user->deleted_at === null)
        <tr class="table-row" data-id-transaksi="{{ $user->id_transaksi }}" data-status="{{ $user->status }}">
          <td class="text-center">{{ $index + 1 }}</td>
          <td class="text-center">{{ $user->Nomor }}</td>
          <td class="text-center">{{ $user->nama_pelanggan }}</td>
          <td class="text-center">{{ $user->tanggal_transaksi }}</td>
          <td class="text-center">{{ $user->total_harga }}</td>
          <td class="text-center">
            <button class="btn btn-success view-order" data-id="{{ $user->id_transaksi }}">Pesanan</button>
          </td>

          <td>
            @if ($user->status == 1)
              <span class="badge rounded-pill bg-primary">Masih Dalam Proses</span>
            @elseif ($user->status == 2)
              <span class="badge rounded-pill bg-success">Selesai</span>
            @endif
          </td>

          <td class="text-center">
          @if ($user->status != 1) <!-- Cek jika status bukan 2 -->
  <div style="display: flex; gap: 10px; justify-content: center;">
  <a href="{{ url('Nota/' . $user->id_transaksi) }}" class="btn btn-success" target="_blank" rel="noopener noreferrer">Nota</a>

    @endif
          @if ($user->status != 2) <!-- Cek jika status bukan 2 -->
  <div style="display: flex; gap: 10px; justify-content: center;">
    <a href="{{ url('status/' . $user->id_transaksi) }}" class="btn btn-warning">Selesai</a>
    
   
      <a href="{{ url('Cancel/' . $user->id_transaksi) }}" class="btn btn-danger" 
        onclick="return confirm('Are you sure you want to Cancel this order?');">Cancel</a>
    @endif
  </div>
  
</td>

        </tr>
      @endif
    @endforeach
  </tbody>
</table>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main><!-- End #main -->

<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderModalLabel">Detail Pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Foto</th>
              <th class="text-center">Menu</th>
              <th class="text-center">Harga Menu</th>
            </tr>
          </thead>
          <tbody id="modalBody">
            <!-- Data akan diisi oleh JavaScript -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const table = document.getElementById('mitraTable');
  const rows = Array.from(table.querySelectorAll('tbody tr'));

  // Mengurutkan berdasarkan status
  rows.sort((a, b) => {
    const statusA = a.getAttribute('data-status');
    const statusB = b.getAttribute('data-status');

    // Status 1 harus di atas (diurutkan terlebih dahulu)
    if (statusA == 1 && statusB != 1) return -1;
    if (statusA != 1 && statusB == 1) return 1;

    // Jika status sama, urutkan berdasarkan ID transaksi atau hal lainnya
    return 0;
  });

  // Menambahkan baris yang sudah diurutkan kembali ke tabel
  const tbody = table.querySelector('tbody');
  rows.forEach((row, index) => {
    // Update nomor urut berdasarkan urutan tabel
    row.querySelector('td').textContent = index + 1;
    tbody.appendChild(row);
  });
});
  document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.view-order');

    buttons.forEach(button => {
      button.addEventListener('click', function () {
        const idTransaksi = this.getAttribute('data-id'); // Ambil id_transaksi
        const modalBody = document.querySelector('#modalBody');
        let tableContent = '';

        // Filter data detail dari PHP yang sudah terpasang di halaman
        const details = @json($detail); // Data dikirimkan dari server
        const filteredDetails = details.filter(detail => detail.transaksi_id == idTransaksi);

        // Buat isi tabel modal berdasarkan data yang difilter
        filteredDetails.forEach((item, index) => {
          tableContent += `
            <tr>
              <td class="text-center">${index + 1}</td>
              <td class="text-center">
                <img src="/assets/img/Menu/${item.foto}" alt="Menu Foto" style="width: 200px; height: 200px; object-fit: cover;">
              </td>
                <td class="text-center">
    ${item.nama_menu} <br>
    <small style="color: gray;">${item.keterangan }</small>
</td>
              <td class="text-center">${item.harga_menu}</td>
            </tr>
          `;
        });

        // Masukkan data ke dalam modal
        modalBody.innerHTML = tableContent;

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('orderModal'));
        modal.show();
      });
    });
  });
</script>
