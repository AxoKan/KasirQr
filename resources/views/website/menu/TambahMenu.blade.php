<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-4">
    <!-- Account -->
    <div class="card-body">
      <div class="d-flex align-items-start align-items-sm-center gap-4">
        <div style="text-align: center;">
          <!-- Placeholder for optional content -->
        </div>
        <div class="button-wrapper">
          <!-- Placeholder for optional buttons -->
        </div>
      </div>
    </div>
    <hr class="my-0" />
    <form action="{{ url('aksi_add_Menu') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="container">
        <div class="row mb-3">
          <label for="nama" class="col-sm-2 col-form-label">Kategory</label>
          <div class="col-sm-10">
            <select name="Kategory" class="form-control" id="kategory">
              <option value="">Pilih</option>
              <option value="Drink">Drink</option>
              <option value="Food">Food</option>
              <option value="Paket">Paket</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label id="dynamicLabel" for="menu" class="col-sm-2 col-form-label">Nama Menu</label>
          <div class="col-sm-10">
            <input 
              type="text" 
              class="form-control" 
              name="Menu" 
              id="menuInput" 
              placeholder="Ex: apple">
          </div>
        </div>

        <!-- Dynamic Content for Paket -->
        <div id="paketContent" style="display: none;">
          <div class="row mb-3">
            <label for="kategory" class="col-sm-2 col-form-label">Menu</label>
            <div class="col-sm-10">
              <select id="asade" name="asade" class="form-control">
                <option disabled selected>- Pilih -</option>
                <?php foreach ($t as $p): ?>
  @if ($p->deleted_at === null && $p->Kategory !== 'Paket')
    <option value="<?= $p->id_menu ?>" data-harga="<?= $p->harga_menu ?>" data-foto="<?= $p->foto ?>">
      <?= $p->nama_menu ?>
    </option>
  @endif
<?php endforeach; ?>

              </select>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <label for="image" class="col-sm-2 col-form-label">Foto</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" name="image" id="image">
          </div>
        </div>

        <div class="row mb-3" id="keteranganRow" style="display: none;">
          <label for="password" class="col-sm-2 col-form-label">Keterangan</label> 
          <div class="col-sm-10">
            <input 
              type="text" 
              class="form-control" 
              name="Keterangan" 
              id="keterangan" 
              placeholder="Ex: 10" readonly>
          </div>
        </div>

        <div class="row mb-3">
          <label for="password" class="col-sm-2 col-form-label">Harga</label>
          <div class="col-sm-10">
            <input 
              type="text" 
              class="form-control" 
              name="harga" 
              id="harga" 
              placeholder="Ex: 12000">
          </div>
        </div>
        <div class="row mb-3">
          <label for="password" class="col-sm-2 col-form-label">Stok</label>
          <div class="col-sm-10">
            <input 
              type="text" 
              class="form-control" 
              name="stok" 
              id="harga" 
              placeholder="Ex: 12000">
          </div>
        </div>
        <div class="mt-2">
          <button type="submit" class="btn btn-primary me-2">Save changes</button>
        </div>
      </div>
    </form>
  </div>
  <!-- /Account -->
</div>

<script>
  document.getElementById('kategory').addEventListener('change', function() {
    var paketContent = document.getElementById('paketContent');
    var menuInput = document.getElementById('menuInput');
    var dynamicLabel = document.getElementById('dynamicLabel');
    var keteranganRow = document.getElementById('keteranganRow');

    if (this.value === 'Paket') {
      paketContent.style.display = 'block';
      dynamicLabel.textContent = 'Nama Paket';
      menuInput.placeholder = 'Ex: Paket Hemat';
      keteranganRow.style.display = 'flex';
    } else {
      paketContent.style.display = 'none';
      dynamicLabel.textContent = 'Nama Menu';
      menuInput.placeholder = 'Ex: apple';
      keteranganRow.style.display = 'none';
    }
  });

  document.getElementById('asade').addEventListener('change', function() {
    var selectedMenu = this.options[this.selectedIndex].text;
    var keteranganField = document.getElementById('keterangan');
    if (selectedMenu) {
      if (keteranganField.value) {
        keteranganField.value += ' + ' + selectedMenu;
      } else {
        keteranganField.value = selectedMenu;
      }
    }
  });
</script>
