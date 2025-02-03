<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
  <title>Table Management with QR Code</title>
</head>
<body>

<main id="main" class="main">
  <div class="container">
    <div class="pagetitle">
      <h1>Table Management</h1>
      <div class="filter-container d-flex align-items-center gap-2">
        <a href="{{ url('TambahVoucher') }}">
          <button class="btn btn-success">+ Tambah</button>
        </a>
      </div>
    </div>

    <section class="section">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="search-container">
                  <label for="search">Search:</label>
                  <input type="text" id="search" placeholder="Enter keywords...">
                </div>
              </div>

              <table class="table datatable" id="mitraTable">
                <thead>
                  <tr style="font-weight: bold; color: black; font-size: larger;">
                    <td align="center" scope="col">No</td>
                    <td align="center" scope="col">No Voucher</td>
                    <td align="center" scope="col">Nama Voucher</td>
                    <td align="center" scope="col">diskon</td>
                    <td align="center" scope="col">Valid Until</td>
                    <td align="center" scope="col">action</td>
                  </tr>
                </thead>
                <tbody>
                @foreach ($sa as $index => $user)
                @if ($user->deleted_at === null) 
                  <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td align="center">{{ $user->No_Voucher }}</td>
                    <td align="center">{{ $user->Nama_Voucher }}</td>
                    <td align="center">{{ $user->Diskon }}%</td>
                    <td align="center">{{ $user->Valid }}</td>
                    <td align="center">
                    <div style="display: flex; gap: 10px; justify-content: center;">
                    <div style="display: flex; gap: 10px; justify-content: center;">
                    <a href="{{ url('VoucherPaper/' . $user->id_Voucher) }}" class="btn btn-success" target="_blank" rel="noopener noreferrer">Voucher</a>
                        <a href="{{ url('deleteVoucher/' . $user->id_Voucher) }}" class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this Voucher?');">Delete</a>
                        <a href="{{ url('EditVoucher/' . $user->id_Voucher) }}" class="btn btn-warning">Edit</a>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    
    </script>
  </div>
</main>

</body>
</html>
