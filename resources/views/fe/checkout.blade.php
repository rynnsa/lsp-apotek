<!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <!-- <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">123 Street, New York</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Email@Example.com</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                    </div>
                </div>
            </div> -->
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="javascript:history.back()" class="btn btn-secondary rounded-circle d-flex align-items-center justify-content-center ms-3" style="width: 40px; height: 40px;">
                        <i class="fas fa-arrow-left text-white"></i>
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

        <!-- Single Page Header start -->
        <div class="container-fluid py-3">
        </div>
        <!-- Single Page Header End -->


        <!-- Checkout Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-3">
                <h1 class="mb-3">Detail Pembelian</h1>
                <form id="order-form" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Obat</th>
                                            <th scope="col">Nama Obat</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Jumlah Beli</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $subtotal = 0; @endphp
                                        @forelse($keranjangItems as $item)
                                        @php
                                            $itemTotal = $item->harga * $item->jumlah_order;
                                            $subtotal += $itemTotal;
                                        @endphp
                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center mt-2">
                                                    <img src="{{ asset('storage/' . $item->obat->foto1) }}" class="img-fluid rounded-circle" 
                                                         style="width: 90px; height: 90px;" alt="">
                                                </div>
                                            </th>
                                            <td class="py-5">{{ $item->obat->nama_obat }}</td>
                                            <td class="py-5">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td class="py-5">{{ $item->jumlah_order }}</td>
                                            <td class="py-5">Rp {{ number_format($itemTotal, 0, ',', '.') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada item untuk checkout</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-7">
                                    <div class="form-item mb-3">
                                        <label>Upload Resep Obat (jika membeli obat keras)</label>
                                        <input type="file" name="url_resep" class="form-control" accept="image/*">
                                    </div>
                                    <div class="form-item">
                                        <textarea name="notes" class="form-control" style="height: 100px;" placeholder="Catatan Pesanan (Optional)">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row g-3">
                                        <div class="col-md-12 d-flex justify-content-between align-items-center border-bottom pb-2">
                                            <p class="mb-0 text-dark">Subtotal</p>
                                            <p class="mb-0 text-dark fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <p class="mb-0 text-dark">Pengiriman</p>
                                                <select class="form-select w-50" id="shipping" name="shipping" onchange="calculateTotal()">
                                                    <option value="">Pilih Pengiriman</option>
                                                    @foreach($jenisPengiriman as $jp)
                                                        <option value="{{ $jp->id }}" data-ongkir="{{ $jp->ongkos_kirim }}">
                                                            {{ $jp->jenis_kirim }} -
                                                            Rp {{ number_format($jp->ongkos_kirim, 0, ',', '.') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                                            <p class="mb-0 text-dark">Ongkos Kirim</p>
                                            <p class="mb-0 text-dark fw-bold" id="ongkirDisplay">Rp 0</p>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                                            <p class="mb-0 text-dark">Biaya Aplikasi (10%)</p>
                                            <p class="mb-0 text-dark fw-bold" id="biayaAppDisplay">Rp {{ number_format($subtotal * 0.1, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-between align-items-center border-top pt-3">
                                            <p class="mb-0 text-dark text-uppercase fw-bold">TOTAL</p>
                                            <p class="mb-0 text-dark fw-bold fs-4" id="totalDisplay">Rp {{ number_format($subtotal + ($subtotal * 0.1), 0, ',', '.') }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <p class="mb-0 text-dark">Metode Pembayaran</p>
                                                <select class="form-select w-50" id="payment" name="payment">
                                                    <option value="">Pilih Pembayaran</option>
                                                    @foreach($metodeBayar as $mp)
                                                        <option value="{{ $mp->id }}">
                                                            {{ $mp->metode_pembayaran }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-4 justify-content-end">
                                            <button onclick="createOrder(event)" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4" 
                                                type="button" id="checkout-btn"  >
                                                Buat Pesanan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Checkout Page End -->

    {{-- <script>
        document.getElementById('tambahAlamat').addEventListener('click', function() {
            const alamatBaru = document.createElement('div');
            alamatBaru.className = 'alamat-tambahan border p-3 mb-3';
            alamatBaru.innerHTML = `
                <div class="d-flex justify-content-between mb-2">
                    <h6>Alamat Tambahan</h6>
                    <button type="button" class="btn btn-danger btn-sm hapusAlamat">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="form-item mb-2">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" placeholder="Masukan Alamat">
                </div>
                <div class="form-item mb-2">
                    <label class="form-label">Kota</label>
                    <input type="text" class="form-control" placeholder="Masukan Kota">
                </div>
                <div class="form-item mb-2">
                    <label class="form-label">Provinsi</label>
                    <input type="text" class="form-control" placeholder="Masukan Provinsi">
                </div>
                <div class="form-item mb-2">
                    <label class="form-label">Kode Pos</label>
                    <input type="text" class="form-control" placeholder="Masukan Kode Pos">
                </div>
            `;

            document.getElementById('alamatTambahan').appendChild(alamatBaru);

            // Add event listener for delete button
            alamatBaru.querySelector('.hapusAlamat').addEventListener('click', function() {
                alamatBaru.remove();
            });
        });
    </script> --}}


    <script>
    $(document).ready(function() {
        $('#shipping').on('change', function() {
            let biaya = $(this).find(':selected').data('biaya') || 0;
            // Update shipping cost and total here
            updateTotals(biaya);
        });

        function updateTotals(shippingCost) {
            let subtotal = parseFloat('{{ $subtotal ?? 0 }}');
            let total = subtotal + parseFloat(shippingCost);
            
            $('.shipping-cost').text('Rp ' + numberFormat(shippingCost));
            $('.total-amount').text('Rp ' + numberFormat(total));
        }

        function numberFormat(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutBtn = document.getElementById('checkout-btn');
    const shipping = document.getElementById('shipping');
    const payment = document.getElementById('payment');

    // Enable button when shipping and payment are selected
    function checkForm() {
        checkoutBtn.disabled = !shipping.value || !payment.value;
    }

    shipping.addEventListener('change', checkForm);
    payment.addEventListener('change', checkForm);
});

function createOrder(event) {
    event.preventDefault();

    const formData = new FormData();
    formData.append('id_jenis_kirim', document.getElementById('shipping').value);
    formData.append('id_metode_bayar', document.getElementById('payment').value);
    formData.append('catatan', document.querySelector('textarea[name="notes"]').value);

    const resepFile = document.querySelector('input[name="url_resep"]').files[0];
    if (resepFile) {
        formData.append('url_resep', resepFile);
    }

    Swal.fire({
        title: 'Memproses Pesanan',
        text: 'Mohon tunggu sebentar...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('{{ route("order.process") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Pesanan Berhasil!',
                text: 'Pesanan Anda akan segera diproses',
                confirmButtonText: 'Lihat Status Pesanan'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = data.redirect_url;
                }
            });
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: error.message || 'Terjadi kesalahan saat memproses pesanan'
        });
    });
}
</script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
function calculateTotal() {
    const subtotal = {{ $subtotal }};
    const shipping = document.getElementById('shipping');
    const selectedOption = shipping.options[shipping.selectedIndex];
    const ongkir = selectedOption.dataset.ongkir ? parseInt(selectedOption.dataset.ongkir) : 0;
    const biayaApp = subtotal * 0.1; // Calculate 10% app fee

    document.getElementById('ongkirDisplay').textContent = 'Rp ' + ongkir.toLocaleString('id-ID');
    document.getElementById('biayaAppDisplay').textContent = 'Rp ' + biayaApp.toLocaleString('id-ID');
    
    const total = subtotal + ongkir + biayaApp;
    document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
</script>
    </body>

</html>