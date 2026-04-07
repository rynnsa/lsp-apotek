<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Pembelian</h4>
                        </div>
                        <button class="btn btn-primary" >
                            <a href="{{route('pembelian.create')}}" class="text-white">Tambah +</a>
                        </button>
                    </div>
                    <div class="card-block py-2"> <!-- Changed padding -->
                        <!-- Add search and filter -->
                        <div class="row mb-2"> <!-- Reduced margin -->
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari pembelian...">
                                    <button class="btn" type="button" id="button-addon2">
                                        <i class="bi bi-search"></i>
                                    </button>   
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select id="filterPembelian" class="form-select form-control rounded-3 custom-select">
                                    <option value="">Semua Distributor</option>
                                    @php
                                        $addedDistributors = [];
                                    @endphp
                                    @foreach($distributors as $distributor)
                                        @if(!in_array($distributor->nama_distributor, $addedDistributors))
                                            <option value="{{ $distributor->nama_distributor }}">{{ $distributor->nama_distributor }}</option>
                                            @php
                                                $addedDistributors[] = $distributor->nama_distributor;
                                            @endphp
                                        @endif
                                    @endforeach
                                </select>
                            </div> 
                        </div>
                    </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nota</th> 
                                        <th>Tanggal Pembelian</th>
                                        <th>Total Bayar</th>
                                        <th>Distributor</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($pembelians as $pembelian)
                                    <tr>
                                        <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                                        <td class="align-middle">{{ $pembelian->no_nota }}</td>
                                        <td class="align-middle">{{ date('d/m/Y', strtotime($pembelian->tgl_pembelian)) }}</td>
                                        <td class="align-middle" data-total="{{ $pembelian->id }}">Rp {{ number_format($pembelian->total_bayar, 0, ',', '.') }}</td>
                                        <td class="align-middle">{{ $pembelian->distributor->nama_distributor }}</td>
                                        <td class="align-middle">
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-info btn-sm ti-info-alt" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pembelian->id }}">
                                            </button>
                                            <a href="{{ route('pembelian.edit', $pembelian->id) }}" class="btn btn-warning btn-sm ti-pencil">
                                            </a>
                                            <form action="{{ route('pembelian.destroy', $pembelian->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm ti-trash" onclick="return confirm('Yakin ingin menghapus?')">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pembelian</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Modal containers for each purchase -->
                        @foreach($pembelians as $pembelian)
                        <div class="modal fade" id="detailModal{{ $pembelian->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Pembelian - Nota ({{ $pembelian->no_nota }} )</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" style="all: unset;">
                                            <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Obat</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($pembelian->detail_pembelians as $detail)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $detail->obat->nama_obat }}</td>
                                                        <td>{{ $detail->jumlah_beli }}</td>
                                                        <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">Tidak ada detail pembelian</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4" class="text-end">Total:</th>
                                                        <th>Rp {{ number_format($pembelian->total_bayar, 0, ',', '.') }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Image preview functionality
    document.querySelectorAll('.img-thumbnail').forEach(image => {
        image.addEventListener('click', function() {
            document.getElementById('previewImage').src = this.src;
        });
    });

    // Function to recalculate total for each pembelian
    function recalculateTotals() {
        @foreach($pembelians as $pembelian)
            const subtotals{{ $pembelian->id }} = [
                @foreach($pembelian->detail_pembelians as $detail)
                    {{ $detail->subtotal }},
                @endforeach
            ];
            const total{{ $pembelian->id }} = subtotals{{ $pembelian->id }}.reduce((sum, val) => sum + val, 0);
            const totalCell{{ $pembelian->id }} = document.querySelector('[data-total="{{ $pembelian->id }}"]');
            if (totalCell{{ $pembelian->id }}) {
                totalCell{{ $pembelian->id }}.textContent = 'Rp ' + total{{ $pembelian->id }}.toLocaleString('id-ID');
            }
        @endforeach
    }

    // Soft refresh - check if data might have changed and reload if needed
    let lastFocusTime = Date.now();
    window.addEventListener('focus', function() {
        const currentTime = Date.now();
        // If more than 2 seconds have passed since last focus, likely user switched tabs/windows
        // In that case, reload to get fresh data
        if (currentTime - lastFocusTime > 2000) {
            location.reload();
        }
        lastFocusTime = currentTime;
    });

    // Search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterPembelian = document.getElementById('filterPembelian');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedDistributor = filterPembelian.value.toLowerCase();

            tableRows.forEach(row => {
                const nota = row.children[1].textContent.toLowerCase(); // Get nota from second column
                const distributor = row.children[4].textContent.toLowerCase(); // Get distributor from fifth column
                
                const matchSearch = nota.includes(searchTerm);
                const matchDistributor = selectedDistributor === '' || distributor === selectedDistributor;

                row.style.display = (matchSearch && matchDistributor) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterPembelian.addEventListener('change', filterTable);
        
        // Recalculate totals on page load
        recalculateTotals();
        
        // Add listeners to modals to recalculate when opened
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function() {
                recalculateTotals();
            });
        });
    });

    function addDetailForm() {
        const template = document.querySelector('.detail-form').cloneNode(true);
        template.querySelector('form').reset();
        template.querySelector('.btn-danger').style.display = 'block';
        document.getElementById('detailForms').appendChild(template);
    }

    function removeDetailForm(button) {
        const formDiv = button.closest('.detail-form');
        formDiv.remove();
        updateTotal(); // Update total after removing form
    }

    // Calculate subtotal for each form
    function calculateSubtotal(input) {
        const form = input.closest('form');
        const jumlah = form.querySelector('[name="jumlah_beli"]').value || 0;
        const harga = form.querySelector('[name="harga_beli"]').value || 0;
        const subtotal = jumlah * harga;
        form.querySelector('#subtotal').value = subtotal;
        
        // Update total
        updateTotal();
    }

    function updateTotal() {
        const subtotals = [...document.querySelectorAll('#subtotal')].map(input => Number(input.value) || 0);
        const total = subtotals.reduce((sum, current) => sum + current, 0);
        document.querySelector('[name="total_bayar"]').value = total;
    }

    // Add form submission handling
    document.getElementById('pembelianForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Gather all detail forms data
        const details = [];
        document.querySelectorAll('.detail-pembelian-form').forEach(form => {
            details.push({
                id_obat: form.querySelector('[name="id_obat"]').value,
                jumlah_beli: form.querySelector('[name="jumlah_beli"]').value,
                harga_beli: form.querySelector('[name="harga_beli"]').value,
                subtotal: form.querySelector('#subtotal').value
            });
        });

        // Add details to form data
        const formData = new FormData(this);
        formData.append('details', JSON.stringify(details));

        // Submit form
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                window.location.reload();
            }
        });
    });
</script>

