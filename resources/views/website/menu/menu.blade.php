<main id="main" class="main">
    <div class="container">
        <div class="pagetitle">
            <h1>Menu Management</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="filter-container d-flex align-items-center gap-2">
                                    <label for="dynamic-filter" class="mb-0">Filter:</label>
                                    <select id="dynamic-filter" class="form-select w-auto">
                                        <option value="">All</option>
                                    </select>
                                    <a href="{{ url('TambahMenu') }}">
                                        <button class="btn btn-success">+ Tambah</button>
                                    </a>
                                </div>
                            </div>
                            <!-- Table with stripped rows -->
                            <table class="table datatable" id="userTable">
                                <thead>
                                    <tr style="font-weight: bold; color: black; font-size: larger;">
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kategory</th>
                                        <th scope="col" class="text-center">Foto</th>
                                        <th scope="col" class="text-center">Menu</th>
                                        <th scope="col" class="text-center">Harga</th>
                                        <th scope="col" class="text-center">Stok</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
    @foreach ($sa as $index => $user)
        @if ($user->deleted_at === null) 
            <tr class="table-row" data-kategory="{{ $user->Kategory }}">
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $user->Kategory }}</td>
                <td class="text-center">
                    <img src="{{ asset('assets/img/Menu/' . $user->foto) }}" alt="Menu Foto" style="width: 200px; height: 200px; object-fit: cover;">
                </td>
                <td class="text-center">
    {{ $user->nama_menu }} <br>
    <small style="color: gray;">{{ $user->keterangan }}</small>
</td>
                <td class="text-center">{{ $user->harga_menu }}</td>
                <td class="text-center">{{ $user->Stok }}</td>
                <td class="text-center">
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <a href="{{ url('deleteMenu/' . $user->id_menu) }}" class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this Menu?');">Delete</a>
                        <a href="{{ url('EditMenu/' . $user->id_menu) }}" class="btn btn-warning">Edit</a>
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

<script>
    // Function to populate filters dynamically based on Kategory
    function updateDynamicFilter() {
        const table = document.getElementById('userTable');
        const rows = table.querySelectorAll('.table-row');
        const filterSet = new Set();

        // Collect unique values for Kategory
        rows.forEach(row => {
            const kategory = row.getAttribute('data-kategory');
            if (kategory) {
                filterSet.add(kategory);
            }
        });

        // Populate the dynamic filter dropdown
        const dynamicFilter = document.getElementById('dynamic-filter');
        dynamicFilter.innerHTML = '<option value="">All</option>';
        filterSet.forEach(kategory => {
            const option = document.createElement('option');
            option.value = kategory;
            option.textContent = kategory;
            dynamicFilter.appendChild(option);
        });
    }

    // Function to filter table rows based on selected filter option
    function filterTable() {
        const selectedFilter = document.getElementById('dynamic-filter').value;
        const rows = document.querySelectorAll('#userTable .table-row');

        rows.forEach(row => {
            const rowKategory = row.getAttribute('data-kategory');
            if (selectedFilter === "" || rowKategory === selectedFilter) {
                row.style.display = ''; // Show the row
            } else {
                row.style.display = 'none'; // Hide the row
            }
        });
    }

    // Event listeners for filter dropdown
    document.getElementById('dynamic-filter').addEventListener('change', filterTable);

    // Initialize dynamic filter on page load
    window.onload = function() {
        updateDynamicFilter();
    };
</script>
