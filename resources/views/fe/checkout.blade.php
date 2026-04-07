@extends('fe.master')

@section('checkout')
@yield('navbar')
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
                                        @php
                                            $subtotal = 0;
                                            $requiresPrescription = false;
                                            foreach ($keranjangItems as $item) {
                                                if (optional($item->obat->jenis_obat)->jenis === 'Obat Keras') {
                                                    $requiresPrescription = true;
                                                    break;
                                                }
                                            }
                                        @endphp
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
                                    @if(count($userAddresses) > 0)
                                        <div class="form-item mb-3">
                                            <label>Alamat Pengiriman</label>
                                            <div class="select-wrapper">
                                                <select class="form-control bg-white" id="shipping-address" name="shipping_address" onchange="updateAddressFields()">
                                                    <option value="">Pilih Alamat Pengiriman</option>
                                                    @foreach($userAddresses as $index => $address)
                                                        <option value="{{ $index }}">
                                                            {{ $address['alamat'] }} - {{ $address['kota'] }}, {{ $address['propinsi'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div id="address-info" class="mb-3" style="display: none;">
                                            <div class="alert alert-info">
                                                <small id="address-display"></small>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Form input alamat baru jika tidak ada alamat terdaftar -->
                                        <div class="alert alert-warning mb-3">
                                            <strong>Perhatian:</strong> Anda belum memiliki alamat pengiriman. Silakan isi alamat pengiriman di bawah.
                                        </div>

                                        <div class="form-item mb-3">
                                            <label>Nama Penerima</label>
                                            <input type="text" class="form-control" id="new-recipient-name" name="recipient_name" value="{{ Auth::guard('pelanggan')->user()->nama_pelanggan ?? '' }}" required>
                                        </div>

                                        <div class="form-item mb-3">
                                            <label>Alamat Lengkap</label>
                                            <textarea class="form-control" id="new-alamat" name="new_alamat" rows="3" placeholder="Jl. Contoh No. 123, RT/RW 01/02" required></textarea>
                                        </div>

                                        <div class="form-item mb-3">
                                            <label>No. Telepon</label>
                                            <input type="tel" class="form-control" id="new-phone" name="new_phone" placeholder="08xxxxxxxxxx" required>
                                        </div>

                                        <div id="new-address-info" class="mb-3">
                                            <small id="new-address-display" style="color: #666;"></small>
                                        </div>
                                    @endif

                                    @if(count($userAddresses) > 0)
                                    <div class="form-item mb-3" id="province-group">
                                        <label>Provinsi</label>
                                        <div class="select-wrapper">
                                            <select class="form-control bg-white" id="province" name="province" onchange="loadCities()">
                                                <option value="">Pilih Provinsi</option>
                                                @if(!empty($provinces))
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province['id'] ?? $province['province_id'] ?? '' }}">{{ $province['name'] ?? $province['province'] ?? '' }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled>Provinsi tidak tersedia</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-item mb-3" id="city-group">
                                        <label>Kota/Kabupaten</label>
                                        <div class="select-wrapper">
                                            <select class="form-control bg-white" id="city" name="city" onchange="loadDistricts()">
                                                <option value="">Pilih Kota/Kabupaten</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-item mb-3" id="district-group">
                                        <label>Kecamatan</label>
                                        <div class="select-wrapper">
                                            <select class="form-control bg-white" id="district" name="district" onchange="calculateShipping()">
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-item mb-3">
                                        <label>Upload Resep Obat {{ $requiresPrescription ? '(Wajib untuk Obat Keras)' : '(Opsional)' }}</label>
                                        <input type="file" name="url_resep" id="url_resep" class="form-control" accept="image/*">
                                        @if($requiresPrescription)
                                            <small class="text-danger">Harus menyertakan resep jika ada obat keras.</small>
                                        @else
                                            <small class="text-muted">Upload resep jika diperlukan.</small>
                                        @endif
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
                                                <p class="mb-0 text-dark">Kurir/Pengiriman</p>
                                                <select class="form-select w-50" id="shipping" name="shipping" onchange="calculateShipping()">
                                                    <option value="">Pilih Kurir</option>
                                                    <option value="jne">JNE</option>
                                                    <option value="pos">POS Indonesia</option>
                                                    <option value="tiki">TIKI</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <p class="mb-0 text-dark">Paket Pengiriman</p>
                                                <select class="form-select w-50" id="shipping-package" name="shipping_package" onchange="calculateTotal()">
                                                    <option value="">Pilih Paket</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                                            <p class="mb-0 text-dark">Ongkos Kirim</p>
                                            <p class="mb-0 text-dark fw-bold" id="ongkirDisplay">Rp 0</p>
                                            <input type="hidden" id="ongkir-value" value="0">
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
                                            <button onclick="createOrder(event)" class="btn btn-secondary rounded-pill px-4 py-3 text-light text-uppercase mb-4" 
                                                type="button" id="checkout-btn">
                                                Buat Pesanan
                                            </button>
                                            <div id="checkout-warning" class="text-danger small mt-2" style="display:none;"></div>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
// Store user addresses and province data
const userAddresses = @json($userAddresses);
const provincesData = @json($provinces);
const jenisPengirimanData = @json($jenisPengiriman);
const requiresPrescription = @json($requiresPrescription);

// Simple province matching function
function findProvinceMatch(provinceName) {
    if (!provinceName || !provincesData) return null;
    const name = provinceName.trim().toLowerCase();
    return provincesData.find(p => {
        const pName = (p.name || p.province || '').trim().toLowerCase();
        return pName === name || pName.includes(name) || name.includes(pName);
    });
}

// Simple city matching function
function findCityMatch(cities, cityName) {
    if (!cityName || !cities) return null;
    const name = cityName.trim().toLowerCase();
    return cities.find(c => {
        const cName = (c.name || c.city_name || '').trim().toLowerCase();
        return cName === name || cName.includes(name) || name.includes(cName);
    });
}

// Function to update address fields when address is selected
function updateAddressFields() {
    const addressSelect = document.getElementById('shipping-address');
    const selectedIndex = addressSelect.value;

    if (selectedIndex === '') {
        document.getElementById('province').value = '';
        document.getElementById('city').innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        document.getElementById('district').innerHTML = '<option value="">Pilih Kecamatan</option>';
        document.getElementById('address-info').style.display = 'none';
        return;
    }

    const address = userAddresses[selectedIndex];
    document.getElementById('address-display').textContent =
        address.alamat + ', ' + address.kota + ', ' + address.propinsi + ' ' + address.kodepos;
    document.getElementById('address-info').style.display = 'block';

    const provinceName = (address.propinsi || '').trim();
    const cityName = (address.kota || '').trim();

    if (provinceName) {
        const matchedProvince = findProvinceMatch(provinceName);
        if (matchedProvince) {
            document.getElementById('province').value = matchedProvince.id || matchedProvince.province_id || '';
            loadCitiesForAddress(matchedProvince.id || matchedProvince.province_id, cityName);
        } else {
            document.getElementById('province').value = '';
            document.getElementById('city').innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
            document.getElementById('district').innerHTML = '<option value="">Pilih Kecamatan</option>';
        }
    }
}

// Function to load cities for address selection
function loadCitiesForAddress(provinceId, selectedCityName) {
    if (!provinceId) return;

    fetch(`{{ route('rajaongkir.cities', ':provinceId') }}`.replace(':provinceId', provinceId), {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(cities => {
        let html = '<option value="">Pilih Kota/Kabupaten</option>';
        cities.forEach(city => {
            const cityId = city.city_id || city.id || '';
            const cityName = city.city_name || city.name || '';
            html += `<option value="${cityId}">${cityName}</option>`;
        });
        document.getElementById('city').innerHTML = html;

        if (selectedCityName) {
            const matchedCity = findCityMatch(cities, selectedCityName);
            if (matchedCity) {
                document.getElementById('city').value = matchedCity.city_id || matchedCity.id || '';
                // Load districts after city is selected
                loadDistricts();
            }
        }
    })
    .catch(error => {
        console.error('Error loading cities:', error);
    });
}

// Function to load cities when province is changed
function loadCities() {
    const provinceId = document.getElementById('province').value;
    const citySelect = document.getElementById('city');

    if (!provinceId) {
        citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        return;
    }

    fetch(`{{ route('rajaongkir.cities', ':provinceId') }}`.replace(':provinceId', provinceId), {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(cities => {
        let html = '<option value="">Pilih Kota/Kabupaten</option>';
        cities.forEach(city => {
            const cityId = city.city_id || city.id || '';
            const cityName = city.city_name || city.name || '';
            html += `<option value="${cityId}">${cityName}</option>`;
        });
        citySelect.innerHTML = html;
    })
    .catch(error => {
        console.error('Error loading cities:', error);
        Swal.fire('Error', 'Gagal memuat data kota', 'error');
    });
}

// Function to load districts when city is changed
function loadDistricts() {
    const cityId = document.getElementById('city').value;
    const districtSelect = document.getElementById('district');

    if (!cityId) {
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        return;
    }

    fetch(`{{ route('rajaongkir.districts', ':cityId') }}`.replace(':cityId', cityId), {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(districts => {
        let html = '<option value="">Pilih Kecamatan</option>';
        districts.forEach(district => {
            const districtId = district.subdistrict_id || district.id || '';
            const districtName = district.subdistrict_name || district.name || '';
            html += `<option value="${districtId}">${districtName}</option>`;
        });
        districtSelect.innerHTML = html;

        // Auto-calculate shipping if courier is selected
        if (document.getElementById('shipping').value) {
            calculateShipping();
        }
    })
    .catch(error => {
        console.error('Error loading districts:', error);
        Swal.fire('Error', 'Gagal memuat data kecamatan', 'error');
    });
}

// Function to calculate shipping cost
function calculateShipping() {
    const courier = document.getElementById('shipping').value;
    const districtId = document.getElementById('district').value;
    const weight = 1000;

    if (!courier || !districtId) {
        document.getElementById('shipping-package').innerHTML = '<option value="">Pilih Paket</option>';
        return;
    }

    fetch('{{ route("rajaongkir.cost") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: new URLSearchParams({
            origin: 3855,  // Diwek (ID kecamatan valid asal)
            destination: districtId,
            weight: weight,
            courier: courier
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Shipping data:', data); // Debug log
        let html = '<option value="">Pilih Paket</option>';
        let hasPackages = false;
        
        if (data && data.length > 0) {
            data.forEach(courierData => {
                if (courierData.costs && courierData.costs.length > 0) {
                    courierData.costs.forEach(cost => {
                        const service = cost.service;
                        const description = cost.description;
                        const costValue = cost.cost[0].value;
                        const etd = cost.cost[0].etd;
                        html += `<option value="${service}|${costValue}">${courierData.name} ${service} (${description}) - Rp ${costValue.toLocaleString('id-ID')} (${etd} hari)</option>`;
                        hasPackages = true;
                    });
                }
            });
        }
        
        // Paket standar - Manual atau dari jenis pengiriman
        if (!hasPackages) {
            html = '<option value="">Pilih Paket</option>';
            
            // Gunakan data jenis pengiriman sebagai fallback
            if (jenisPengirimanData && jenisPengirimanData.length > 0) {
                jenisPengirimanData.forEach(jenis => {
                    const ongkos = jenis.ongkos_kirim || 0;
                    html += `<option value="${jenis.jenis_kirim}|${ongkos}">${jenis.nama_expedisi} ${jenis.jenis_kirim} - Rp ${ongkos.toLocaleString('id-ID')} (2-3 hari)</option>`;
                });
            } else {
                // Fallback manual jika tidak ada data jenis pengiriman
                html += `<option value="Standar|50000">Standar (Manual) - Rp 50.000 (3-5 hari)</option>`;
            }
        }
        
        document.getElementById('shipping-package').innerHTML = html;
        calculateTotal();
    })
    .catch(error => {
        console.error('Error calculating shipping:', error);
        // Tampilkan paket dari jenis pengiriman jika ada error
        let html = '<option value="">Pilih Paket</option>';
        
        if (jenisPengirimanData && jenisPengirimanData.length > 0) {
            jenisPengirimanData.forEach(jenis => {
                const ongkos = jenis.ongkos_kirim || 0;
                html += `<option value="${jenis.jenis_kirim}|${ongkos}">${jenis.nama_expedisi} ${jenis.jenis_kirim} - Rp ${ongkos.toLocaleString('id-ID')} (2-3 hari)</option>`;
            });
        } else {
            // Fallback manual jika tidak ada data jenis pengiriman
            html += `<option value="Standar|50000">Standar (Manual) - Rp 50.000 (3-5 hari)</option>`;
        }
        
        document.getElementById('shipping-package').innerHTML = html;
    });
}

// Function to calculate total
function calculateTotal() {
    const subtotal = {{ $subtotal }};
    const shippingPackage = document.getElementById('shipping-package').value;
    let ongkir = 0;

    if (shippingPackage) {
        const [service, cost] = shippingPackage.split('|');
        ongkir = parseInt(cost);
    }

    const biayaApp = subtotal * 0.1;
    const total = subtotal + ongkir + biayaApp;

    document.getElementById('ongkir-value').value = ongkir;
    document.getElementById('ongkirDisplay').textContent = 'Rp ' + ongkir.toLocaleString('id-ID');
    document.getElementById('biayaAppDisplay').textContent = 'Rp ' + biayaApp.toLocaleString('id-ID');
    document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const checkoutBtn = document.getElementById('checkout-btn');
    const shippingAddress = document.getElementById('shipping-address');
    const newAlamat = document.getElementById('new-alamat');
    const newPhone = document.getElementById('new-phone');
    const shipping = document.getElementById('shipping');
    const shippingPackage = document.getElementById('shipping-package');
    const payment = document.getElementById('payment');
    const resepInput = document.getElementById('url_resep');

    function setCheckoutButtonState(enabled) {
        checkoutBtn.classList.toggle('btn-primary', enabled);
        checkoutBtn.classList.toggle('btn-secondary', !enabled);
        checkoutBtn.classList.toggle('text-white', enabled);
        checkoutBtn.classList.toggle('text-dark', !enabled);
    }

    function checkForm() {
        const prescriptionOk = !requiresPrescription || (resepInput && resepInput.files.length > 0);
        
        // Check if there are saved addresses
        const hasSavedAddresses = userAddresses && userAddresses.length > 0;
        
        // Address validation: either select saved address or fill new address
        let addressOk = false;
        if (hasSavedAddresses) {
            addressOk = shippingAddress && shippingAddress.value !== '';
        } else {
            addressOk = (newAlamat && newAlamat.value.trim() !== '') && 
                       (newPhone && newPhone.value.trim() !== '');
        }
        
        const allFilled = addressOk && shipping.value && shippingPackage.value && payment.value && prescriptionOk;
        const warningEl = document.getElementById('checkout-warning');

        if (!allFilled) {
            let message = 'Lengkapi semua data pengiriman dan pembayaran.';
            if (!addressOk) {
                if (hasSavedAddresses) {
                    message = 'Pilih alamat pengiriman terlebih dahulu.';
                } else {
                    message = 'Isi alamat lengkap dan nomor telepon.';
                }
            } else if (!shipping.value) {
                message = 'Pilih kurir pengiriman terlebih dahulu.';
            } else if (!shippingPackage.value) {
                message = 'Pilih paket pengiriman terlebih dahulu.';
            } else if (!payment.value) {
                message = 'Pilih metode pembayaran terlebih dahulu.';
            } else if (requiresPrescription && (!resepInput || resepInput.files.length === 0)) {
                message = 'Unggah resep obat keras sebelum melanjutkan pesanan.';
            }
            warningEl.textContent = message;
            warningEl.style.display = 'block';
        } else {
            warningEl.style.display = 'none';
        }

        setCheckoutButtonState(allFilled);
    }

    if (shippingAddress) {
        shippingAddress.addEventListener('change', () => {
            updateAddressFields();
            checkForm();
        });
    }
    
    if (newAlamat) newAlamat.addEventListener('change', checkForm);
    if (newPhone) newPhone.addEventListener('change', checkForm);
    shipping.addEventListener('change', checkForm);
    shippingPackage.addEventListener('change', checkForm);
    payment.addEventListener('change', checkForm);
    if (resepInput) {
        resepInput.addEventListener('change', checkForm);
    }

    // Auto-select first address if user has addresses
    if (userAddresses && userAddresses.length > 0) {
        shippingAddress.value = '0';
        updateAddressFields();
    }

    checkForm();
});

// Function to create order
function createOrder(event) {
    event.preventDefault();

    // Validate required fields
    const hasSavedAddresses = userAddresses && userAddresses.length > 0;
    let shippingAddressValue = '';
    let alamatValue = '';
    let kotaValue = '';
    let propinsiValue = '';
    let kodePosValue = '';
    let phoneValue = '';

    if (hasSavedAddresses) {
        shippingAddressValue = document.getElementById('shipping-address').value;
        if (!shippingAddressValue) {
            Swal.fire('Error', 'Silakan pilih alamat pengiriman', 'error');
            return;
        }
        const selectedAddress = userAddresses[parseInt(shippingAddressValue)];
        alamatValue = selectedAddress.alamat;
        kotaValue = selectedAddress.kota;
        propinsiValue = selectedAddress.propinsi;
        kodePosValue = selectedAddress.kodepos;
    } else {
        alamatValue = document.getElementById('new-alamat').value.trim();
        phoneValue = document.getElementById('new-phone').value.trim();
        
        if (!alamatValue) {
            Swal.fire('Error', 'Silakan isi alamat pengiriman', 'error');
            return;
        }
        if (!phoneValue) {
            Swal.fire('Error', 'Silakan isi nomor telepon', 'error');
            return;
        }
    }

    const shipping = document.getElementById('shipping').value;
    const shippingPackage = document.getElementById('shipping-package').value;
    const payment = document.getElementById('payment').value;

    if (!shipping || !shippingPackage || !payment) {
        Swal.fire('Error', 'Silakan lengkapi semua data pengiriman', 'error');
        return;
    }

    const resepFile = document.querySelector('input[name="url_resep"]').files[0];
    if (requiresPrescription && !resepFile) {
        Swal.fire('Error', 'Mohon unggah resep obat keras sebelum melanjutkan pesanan.', 'error');
        return;
    }

    const formData = new FormData();
    formData.append('shipping_address', shippingAddressValue || alamatValue);
    formData.append('alamat', alamatValue);
    formData.append('kota', kotaValue);
    formData.append('propinsi', propinsiValue);
    formData.append('kodepos', kodePosValue);
    formData.append('no_telp', phoneValue);
    formData.append('courier', shipping);
    formData.append('shipping_package', shippingPackage);
    formData.append('id_metode_bayar', payment);
    formData.append('catatan', document.querySelector('textarea[name="notes"]').value);
    formData.append('ongkir', document.getElementById('ongkir-value').value);

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
@endsection