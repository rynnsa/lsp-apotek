<meta name="csrf-token" content="{{ csrf_token() }}">

        
        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h4 class="text-center text-white">Periksa kembali jumlah dan pilihan produk Anda sebelum melakukan pemesanan</h4>
            </div>

        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">
                                <input type="checkbox" id="select-all" class="form-check-input">
                            </th>
                            <th scope="col">Foto Obat</th>
                            <th scope="col">Nama Obat</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Kuantitas</th>
                            <th scope="col">Total</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse($keranjangs as $item)
                            <tr data-id="{{ $item->id_obat }}">
                                <td class="align-middle">
                                    <input type="checkbox" class="form-check-input item-checkbox" 
                                           name="selected_items[]" 
                                           value="{{ $item->id_obat }}"
                                           data-price="{{ $item->subtotal }}">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $item->obat->foto1) }}" class="img-fluid rounded-circle" style="width: 80px; height: 80px;" alt="">
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item->obat->nama_obat }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border" data-id="{{ $item->id_obat }}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0 quantity-input" 
                                            value="{{ $item->jumlah_order }}" data-id="{{ $item->id_obat }}" min="1">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border" data-id="{{ $item->id_obat }}">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="item-total">
                                    <p class="mb-0 mt-4">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </td>
                                <td>
                                    <button class="btn btn-md rounded-circle bg-light border btn-remove mt-4" data-id="{{ $item->id_obat }}">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Keranjang belanja kosong</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Subtotal: <span id="selected-total">Rp 0</span></h5>
                        </div>
                        <button onclick="proceedToCheckout()" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4" 
                                type="button" id="checkout-btn" disabled>
                            Checkout <span id="selected-count">0</span> items
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart Page End -->

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle quantity changes
    document.querySelectorAll('.btn-minus, .btn-plus').forEach(button => {
        button.addEventListener('click', function() {
            const obatId = this.getAttribute('data-id');
            const input = document.querySelector(`.quantity-input[data-id="${obatId}"]`);
            let quantity = parseInt(input.value);
            
            if (this.classList.contains('btn-minus')) {
                quantity = quantity > 1 ? quantity - 1 : 1;
            } else {
                quantity += 1;
            }
            
            input.value = quantity;
            updateQuantity(obatId, quantity);
        });
    });

    // Handle direct input changes
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const obatId = this.getAttribute('data-id');
            let quantity = parseInt(this.value) || 1;
            this.value = quantity;
            updateQuantity(obatId, quantity);
        });
    });

    // Handle remove item
    document.querySelectorAll('.btn-remove').forEach(button => {
        button.addEventListener('click', function() {
            const obatId = this.getAttribute('data-id');
            removeItem(obatId);
        });
    });

    // Handle select all checkbox
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    
    selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateCheckoutSummary();
    });

    // Handle individual checkboxes
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateCheckoutSummary();
            // Update select all checkbox
            selectAllCheckbox.checked = [...itemCheckboxes].every(cb => cb.checked);
        });
    });
});

function updateQuantity(obatId, quantity) {
    fetch('{{ route("cart.update-quantity") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            obat_id: obatId,
            jumlah: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update total price for this item
            const row = document.querySelector(`tr[data-id="${obatId}"]`);
            if (row) {
                const totalCell = row.querySelector('.item-total p');
                if (totalCell) {
                    totalCell.textContent = 'Rp ' + data.total_harga;
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate jumlah');
    });
}

function removeItem(obatId) {
    Swal.fire({
        title: 'Hapus Item?',
        html: '<span class="text-dark">Apakah Anda yakin ingin menghapus item ini dari keranjang?</span>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("cart.remove-item") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    obat_id: obatId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove row from table
                    const row = document.querySelector(`tr[data-id="${obatId}"]`);
                    if (row) {
                        row.remove();
                    }
                    
                    // Check if cart is empty
                    if (document.querySelectorAll('tbody tr').length <= 1) { // 1 for empty row
                        window.location.reload();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menghapus item',
                    confirmButtonColor: '#dc3545'
                });
            });
        }
    });
}

function updateCheckoutSummary() {
    const selectedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
    const checkoutBtn = document.getElementById('checkout-btn');
    const selectedCount = document.getElementById('selected-count');
    const selectedTotal = document.getElementById('selected-total');
    
    let total = 0;
    selectedCheckboxes.forEach(checkbox => {
        total += parseFloat(checkbox.dataset.price);
    });

    selectedCount.textContent = selectedCheckboxes.length;
    selectedTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
    checkoutBtn.disabled = selectedCheckboxes.length === 0;
}

function proceedToCheckout() {
    const selectedItems = [...document.querySelectorAll('.item-checkbox:checked')].map(cb => cb.value);
    if (selectedItems.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Pilih minimal satu item untuk checkout'
        });
        return;
    }

    fetch('{{ route("cart.process-checkout") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            selected_items: selectedItems
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '{{ route("checkout") }}';
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Terjadi kesalahan saat memproses checkout'
        });
    });
}
</script>