                                                if (optional($item->obat->jenis_obat)->jenis === 'Obat Keras') {
                                                }
                                            }
                                                    <img src="{{ asset('storage/' . $item->obat->foto1) }}" class="img-fluid rounded-circle" 
                                            <td class="py-5">{{ $item->obat->nama_obat }}</td>
                                            <td class="py-5">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td class="py-5">{{ $item->jumlah_order }}</td>
                                            <td class="py-5">Rp {{ number_format($itemTotal, 0, ',', '.') }}</td>
                                                    <option value="{{ $index }}">
                                                        {{ $address['alamat'] }} - {{ $address['kota'] }}, {{ $address['propinsi'] }}
                                                        <option value="{{ $province['id'] ?? $province['province_id'] ?? '' }}">{{ $province['name'] ?? $province['province'] ?? '' }}</option>
                                        <label>Upload Resep Obat {{ $requiresPrescription ? '(Wajib untuk Obat Keras)' : '(Opsional)' }}</label>
                                        <textarea name="notes" class="form-control" style="height: 100px;" placeholder="Catatan Pesanan (Optional)">{{ old('notes') }}</textarea>
                                            <p class="mb-0 text-dark fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                            <p class="mb-0 text-dark fw-bold" id="biayaAppDisplay">Rp {{ number_format($subtotal * 0.1, 0, ',', '.') }}</p>
                                            <p class="mb-0 text-dark fw-bold fs-4" id="totalDisplay">Rp {{ number_format($subtotal + ($subtotal * 0.1), 0, ',', '.') }}</p>
                                                        <option value="{{ $mp->id }}">
                                                            {{ $mp->metode_pembayaran }}
            const alamatBaru = document.createElement('div');
            });
        });
    </script> --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
// Store user addresses and province data
const userAddresses = @json($userAddresses);
const provincesData = @json($provinces);
const requiresPrescription = @json($requiresPrescription);
// Helper function to find best province match
function findBestProvinceMatch(userProvinceName) {
    if (!userProvinceName || !provincesData) return null;
    const userName = userProvinceName.trim().toLowerCase();
    let match = provincesData.find(p => {
        const name = (p.name || p.province || '').trim().toLowerCase();
    });
    if (match) return match;
        const name = (p.name || p.province || '').trim().toLowerCase();
    });
    if (match) return match;
    const abbreviations = {
    };
    for (const [standard, variants] of Object.entries(abbreviations)) {
        if (userName === standard || variants.includes(userName)) {
                const name = (p.name || p.province || '').trim().toLowerCase();
            });
            if (match) return match;
        }
    }
}
// Helper function to find best city match
function findBestCityMatch(cities, userCityName) {
    if (!userCityName || !cities) return null;
    const userName = userCityName.trim().toLowerCase();
    let match = cities.find(c => {
        const name = (c.name || c.city_name || '').trim().toLowerCase();
    });
    if (match) return match;
        const name = (c.name || c.city_name || '').trim().toLowerCase();
    });
    if (match) return match;
    const cleanUserName = userName.replace(/^(kabupaten|kota|kab\.|kota\.)\s+/i, '');
        const name = (c.name || c.city_name || '').trim().toLowerCase().replace(/^(kabupaten|kota|kab\.|kota\.)\s+/i, '');
    });
}
// Function to load cities for a specific province and optionally select a city
function loadCitiesForProvince(provinceId, selectedCityName = '') {
    const citySelect = document.getElementById('city');
    if (!provinceId) {
    }
    fetch(`{{ route('rajaongkir.cities', ':provinceId') }}`.replace(':provinceId', provinceId), {
        }
    })
    .then(response => response.json())
    .then(cities => {
        let html = '<option value="">Pilih Kota/Kabupaten</option>';
            const cityId = city.city_id || city.id || '';
            const cityName = city.city_name || city.name || '';
            const postalCode = city.postal_code || city.postal || '';
            html += `<option value="${cityId}" data-postal="${postalCode}">${cityName}</option>`;
        });
        if (selectedCityName) {
            const matchedCity = findBestCityMatch(cities, selectedCityName);
            if (matchedCity) {
            }
        }
    })
    .catch(error => {
    });
}
function updateAddressFields() {
    const addressSelect = document.getElementById('shipping-address');
    const selectedIndex = addressSelect.value;
    const provinceGroup = document.getElementById('province-group');
    const cityGroup = document.getElementById('city-group');
    const districtGroup = document.getElementById('district-group');
    const addressInfo = document.getElementById('address-info');
    if (selectedIndex === '') {
    }
    const address = userAddresses[selectedIndex];
    const province = document.getElementById('province');
    const provinceName = (address.propinsi || '').trim();
    const cityName = (address.kota || '').trim();
    if (provinceName) {
        const matchedProvince = findBestProvinceMatch(provinceName);
        if (matchedProvince) {
        } else {
        }
    } else {
    }
}
function loadCities(selectedCityName = '', selectedDistrictName = '') {
    const provinceId = document.getElementById('province').value;
    const citySelect = document.getElementById('city');
    if (!provinceId) {
    }
    fetch(`{{ route('rajaongkir.cities', ':provinceId') }}`.replace(':provinceId', provinceId), {
        }
    })
    .then(response => response.json())
    .then(cities => {
        let html = '<option value="">Pilih Kota/Kabupaten</option>';
            const cityId = city.city_id || city.id || '';
            const cityName = city.city_name || city.name || '';
            const postalCode = city.postal_code || city.postal || '';
            html += `<option value="${cityId}" data-postal="${postalCode}">${cityName}</option>`;
        });
        if (selectedCityName) {
            const matchedCity = findBestCityMatch(cities, selectedCityName);
            if (matchedCity) {
            }
        }
    })
    .catch(error => {
    });
}
function loadDistricts(selectedDistrictName = '') {
    const cityId = document.getElementById('city').value;
    const districtSelect = document.getElementById('district');
    if (!cityId) {
    }
    fetch(`{{ route('rajaongkir.districts', ':cityId') }}`.replace(':cityId', cityId), {
        }
    })
    .then(response => response.json())
    .then(districts => {
        let html = '<option value="">Pilih Kecamatan</option>';
            const districtId = district.subdistrict_id || district.id || '';
            const districtName = district.subdistrict_name || district.name || '';
            html += `<option value="${districtId}">${districtName}</option>`;
        });
        if (selectedDistrictName) {
            const matchedDistrict = districts.find(district => {
                const name = (district.subdistrict_name || district.name || '').trim().toLowerCase();
            });
            if (matchedDistrict) {
            }
        }
    })
    .catch(error => {
    });
}
function calculateShipping() {
    const courier = document.getElementById('shipping').value;
    const districtId = document.getElementById('district').value;
    const weight = 1000; // Default weight in grams - adjust as needed
    if (!courier || !districtId) {
    }
    const cityId = document.getElementById('city').value;
    fetch('{{ route("rajaongkir.cost") }}', {
        },
        })
    })
    .then(response => response.json())
    .then(data => {
        const packageSelect = document.getElementById('shipping-package');
        let html = '<option value="">Pilih Paket</option>';
        let costs = [];
        if (data && Array.isArray(data)) {
        } else if (data.results && data.results.costs) {
                if (cost.costs) {
                }
            });
        } else if (data.costs && Array.isArray(data.costs)) {
        }
            if (service.cost && service.service) {
                const value = `${service.service}|${service.cost}`;
                const etd = service.etd || 'N/A';
                const description = service.description || service.service;
                html += `<option value="${value}">${description} - Rp ${service.cost.toLocaleString('id-ID')} (${etd})</option>`;
            }
        });
        if (costs.length === 0) {
        }
    })
    .catch(error => {
    });
}
function calculateTotal() {
    const subtotal = {{ $subtotal }};
    const shippingPackage = document.getElementById('shipping-package').value;
    let ongkir = 0;
    if (shippingPackage) {
        const [service, cost] = shippingPackage.split('|');
    }
    const biayaApp = subtotal * 0.1;
    const total = subtotal + ongkir + biayaApp;
}
    const checkoutBtn = document.getElementById('checkout-btn');
    const shippingAddress = document.getElementById('shipping-address');
    const shipping = document.getElementById('shipping');
    const shippingPackage = document.getElementById('shipping-package');
    const payment = document.getElementById('payment');
    const resepInput = document.getElementById('url_resep');
    function setCheckoutButtonState(enabled) {
    }
    function checkForm() {
        const prescriptionOk = !requiresPrescription || (resepInput && resepInput.files.length > 0);
        const allFilled = shippingAddress.value && shipping.value && shippingPackage.value && payment.value && prescriptionOk;
        const warningEl = document.getElementById('checkout-warning');
        if (!allFilled) {
            let message = 'Lengkapi semua data pengiriman dan pembayaran.';
            if (!shippingAddress.value) {
            } else if (!shipping.value) {
            } else if (!shippingPackage.value) {
            } else if (!payment.value) {
            } else if (requiresPrescription && (!resepInput || resepInput.files.length === 0)) {
            }
        } else {
        }
    }
    if (resepInput) {
    }
    if (userAddresses && userAddresses.length > 0) {
    }
});
function createOrder(event) {
    const shippingAddress = document.getElementById('shipping-address').value;
    const shipping = document.getElementById('shipping').value;
    const shippingPackage = document.getElementById('shipping-package').value;
    const payment = document.getElementById('payment').value;
    if (!shippingAddress || !shipping || !shippingPackage || !payment) {
    }
    const resepFile = document.querySelector('input[name="url_resep"]').files[0];
    if (requiresPrescription && !resepFile) {
    }
    const formData = new FormData();
    if (resepFile) {
    }
        }
    });
    fetch('{{ route("order.process") }}', {
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            }).then((result) => {
                if (result.isConfirmed) {
                }
            });
        } else {
    }
    }
    }
        }
    }
        }
    })
    .catch(error => {
        });
    });
}
