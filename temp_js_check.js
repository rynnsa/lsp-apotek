
>     {{-- <script>
          document.getElementById('tambahAlamat').addEventListener('click', 
function() {
              const alamatBaru = document.createElement('div');
              alamatBaru.className = 'alamat-tambahan border p-3 mb-3';
              alamatBaru.innerHTML = `
                  <div class="d-flex justify-content-between mb-2">
                      <h6>Alamat Tambahan</h6>
                      <button type="button" class="btn btn-danger btn-sm 
hapusAlamat">
                          <i class="fas fa-times"></i>
                      </button>
                  </div>
                  <div class="form-item mb-2">
                      <label class="form-label">Alamat</label>
                      <input type="text" class="form-control" 
placeholder="Masukan Alamat">
                  </div>
                  <div class="form-item mb-2">
                      <label class="form-label">Kota</label>
                      <input type="text" class="form-control" 
placeholder="Masukan Kota">
                  </div>
                  <div class="form-item mb-2">
                      <label class="form-label">Provinsi</label>
                      <input type="text" class="form-control" 
placeholder="Masukan Provinsi">
                  </div>
                  <div class="form-item mb-2">
                      <label class="form-label">Kode Pos</label>
                      <input type="text" class="form-control" 
placeholder="Masukan Kode Pos">
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
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
data-client-key="{{ config('midtrans.client_key') }}"></script>
> <script>
  // Store user addresses and province data
  const userAddresses = @json($userAddresses);
  const provincesData = @json($provinces);
  const requiresPrescription = @json($requiresPrescription);
  
  // Helper function to find best province match
  function findBestProvinceMatch(userProvinceName) {
      if (!userProvinceName || !provincesData) return null;
  
      const userName = userProvinceName.trim().toLowerCase();
  
      // First try exact match
      let match = provincesData.find(p => {
          const name = (p.name || p.province || '').trim().toLowerCase();
          return name === userName;
      });
  
      if (match) return match;
  
      // Try partial match (contains)
      match = provincesData.find(p => {
          const name = (p.name || p.province || '').trim().toLowerCase();
          return name.includes(userName) || userName.includes(name);
      });
  
      if (match) return match;
  
      // Try common abbreviations
      const abbreviations = {
          'dki jakarta': ['daerah khusus ibukota jakarta', 'jakarta'],
          'jakarta': ['daerah khusus ibukota jakarta', 'dki jakarta'],
          'jawa barat': ['jabar'],
          'jawa tengah': ['jateng'],
          'jawa timur': ['jatim'],
          'di yogyakarta': ['diy', 'yogyakarta', 'daerah istimewa yogyakarta'],
          'nusa tenggara barat': ['ntb'],
          'nusa tenggara timur': ['ntt'],
          'kalimantan barat': ['kalbar'],
          'kalimantan selatan': ['kalsel'],
          'kalimantan tengah': ['kalteng'],
          'kalimantan timur': ['kaltim'],
          'kalimantan utara': ['kaltara'],
          'sulawesi barat': ['sulbar'],
          'sulawesi selatan': ['sulsel'],
          'sulawesi tengah': ['sulteng'],
          'sulawesi tenggara': ['sulteng'],
          'sulawesi utara': ['sulut'],
          'maluku utara': ['malut'],
          'papua barat': ['papbar'],
          'papua': ['papua'],
          'aceh': ['aceh'],
          'sumatera utara': ['sumut'],
          'sumatera barat': ['sumbar'],
          'riau': ['riau'],
          'jambi': ['jambi'],
          'sumatera selatan': ['sumsel'],
          'bengkulu': ['bengkulu'],
          'lampung': ['lampung'],
          'kepulauan bangka belitung': ['babel'],
          'kepulauan riau': ['kepri'],
          'banten': ['banten'],
          'bali': ['bali'],
          'gorontalo': ['gorontalo'],
          'maluku': ['maluku']
      };
  
      for (const [standard, variants] of Object.entries(abbreviations)) {
          if (userName === standard || variants.includes(userName)) {
              match = provincesData.find(p => {
                  const name = (p.name || p.province || 
'').trim().toLowerCase();
                  return name === standard || variants.some(v => 
name.includes(v));
              });
              if (match) return match;
          }
      }
  
      return null;
  }
  
  // Helper function to find best city match
  function findBestCityMatch(cities, userCityName) {
      if (!userCityName || !cities) return null;
  
      const userName = userCityName.trim().toLowerCase();
  
      // First try exact match
      let match = cities.find(c => {
          const name = (c.name || c.city_name || '').trim().toLowerCase();
          return name === userName;
      });
  
      if (match) return match;
  
      // Try partial match
      match = cities.find(c => {
          const name = (c.name || c.city_name || '').trim().toLowerCase();
          return name.includes(userName) || userName.includes(name);
      });
  
      if (match) return match;
  
      // Try removing common prefixes/suffixes
      const cleanUserName = 
userName.replace(/^(kabupaten|kota|kab\.|kota\.)\s+/i, '');
      match = cities.find(c => {
          const name = (c.name || c.city_name || 
'').trim().toLowerCase().replace(/^(kabupaten|kota|kab\.|kota\.)\s+/i, '');
          return name === cleanUserName || name.includes(cleanUserName) || 
cleanUserName.includes(name);
      });
  
      return match;
  }
  
  // Function to load cities for a specific province and optionally select a 
city
  function loadCitiesForProvince(provinceId, selectedCityName = '') {
      const citySelect = document.getElementById('city');
  
      if (!provinceId) {
          citySelect.innerHTML = '<option value="">Pilih 
Kota/Kabupaten</option>';
          return;
      }
  
      fetch(`{{ route('rajaongkir.cities', ':provinceId') 
}}`.replace(':provinceId', provinceId), {
          method: 'GET',
          headers: {
              'Accept': 'application/json'
          }
      })
      .then(response => response.json())
      .then(cities => {
          let html = '<option value="">Pilih Kota/Kabupaten</option>';
          cities.forEach(city => {
              const cityId = city.city_id || city.id || '';
              const cityName = city.city_name || city.name || '';
              const postalCode = city.postal_code || city.postal || '';
              html += `<option value="${cityId}" 
data-postal="${postalCode}">${cityName}</option>`;
          });
          citySelect.innerHTML = html;
  
          // If we have a city name to select, try to find and select it
          if (selectedCityName) {
              const matchedCity = findBestCityMatch(cities, selectedCityName);
              if (matchedCity) {
                  citySelect.value = matchedCity.city_id || matchedCity.id || 
'';
                  // Load districts for the selected city
                  loadDistricts();
              }
          }
      })
      .catch(error => {
          console.error('Error loading cities:', error);
          Swal.fire('Error', 'Gagal memuat data kota', 'error');
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
          // Reset all fields to empty when no address is selected
          document.getElementById('province').value = '';
          document.getElementById('city').innerHTML = '<option value="">Pilih 
Kota/Kabupaten</option>';
          document.getElementById('district').innerHTML = '<option 
value="">Pilih Kecamatan</option>';
          addressInfo.style.display = 'none';
          return;
      }
  
      const address = userAddresses[selectedIndex];
      document.getElementById('address-display').textContent =
          address.alamat + ', ' + address.kota + ', ' + address.propinsi + ' ' 
+ address.kodepos;
      addressInfo.style.display = 'block';
  
      const province = document.getElementById('province');
      const provinceName = (address.propinsi || '').trim();
      const cityName = (address.kota || '').trim();
  
      if (provinceName) {
          // More flexible province matching
          const matchedProvince = findBestProvinceMatch(provinceName);
  
          if (matchedProvince) {
              province.value = matchedProvince.id || 
matchedProvince.province_id || '';
              // Load cities for the matched province
              loadCitiesForProvince(matchedProvince.id || 
matchedProvince.province_id, cityName);
          } else {
              console.warn('Province not found:', provinceName);
              province.value = '';
              document.getElementById('city').innerHTML = '<option 
value="">Pilih Kota/Kabupaten</option>';
              document.getElementById('district').innerHTML = '<option 
value="">Pilih Kecamatan</option>';
          }
      } else {
          province.value = '';
          document.getElementById('city').innerHTML = '<option value="">Pilih 
Kota/Kabupaten</option>';
          document.getElementById('district').innerHTML = '<option 
value="">Pilih Kecamatan</option>';
      }
  
      calculateTotal();
  }
  
  function loadCities(selectedCityName = '', selectedDistrictName = '') {
      const provinceId = document.getElementById('province').value;
      const citySelect = document.getElementById('city');
  
      if (!provinceId) {
          citySelect.innerHTML = '<option value="">Pilih 
Kota/Kabupaten</option>';
          return;
      }
  
      fetch(`{{ route('rajaongkir.cities', ':provinceId') 
}}`.replace(':provinceId', provinceId), {
          method: 'GET',
          headers: {
              'Accept': 'application/json'
          }
      })
      .then(response => response.json())
      .then(cities => {
          let html = '<option value="">Pilih Kota/Kabupaten</option>';
          cities.forEach(city => {
              const cityId = city.city_id || city.id || '';
              const cityName = city.city_name || city.name || '';
              const postalCode = city.postal_code || city.postal || '';
              html += `<option value="${cityId}" 
data-postal="${postalCode}">${cityName}</option>`;
          });
          citySelect.innerHTML = html;
  
          if (selectedCityName) {
              const matchedCity = findBestCityMatch(cities, selectedCityName);
  
              if (matchedCity) {
                  citySelect.value = matchedCity.city_id || matchedCity.id || 
'';
                  loadDistricts(selectedDistrictName);
              }
          }
      })
      .catch(error => {
          console.error('Error loading cities:', error);
          Swal.fire('Error', 'Gagal memuat data kota', 'error');
      });
  }
  
  function loadDistricts(selectedDistrictName = '') {
      const cityId = document.getElementById('city').value;
      const districtSelect = document.getElementById('district');
  
      if (!cityId) {
          districtSelect.innerHTML = '<option value="">Pilih 
Kecamatan</option>';
          return;
      }
  
      fetch(`{{ route('rajaongkir.districts', ':cityId') 
}}`.replace(':cityId', cityId), {
          method: 'GET',
          headers: {
              'Accept': 'application/json'
          }
      })
      .then(response => response.json())
      .then(districts => {
          let html = '<option value="">Pilih Kecamatan</option>';
          districts.forEach(district => {
              const districtId = district.subdistrict_id || district.id || '';
              const districtName = district.subdistrict_name || district.name 
|| '';
              html += `<option value="${districtId}">${districtName}</option>`;
          });
          districtSelect.innerHTML = html;
  
          if (selectedDistrictName) {
              const matchedDistrict = districts.find(district => {
                  const name = (district.subdistrict_name || district.name || 
'').trim().toLowerCase();
                  return name === selectedDistrictName;
              });
              if (matchedDistrict) {
                  districtSelect.value = matchedDistrict.subdistrict_id || 
matchedDistrict.id || '';
                  calculateShipping();
              }
          }
      })
      .catch(error => {
          console.error('Error loading districts:', error);
          Swal.fire('Error', 'Gagal memuat data kecamatan', 'error');
      });
  }
  
  function calculateShipping() {
      const courier = document.getElementById('shipping').value;
      const districtId = document.getElementById('district').value;
      const weight = 1000; // Default weight in grams - adjust as needed
  
      if (!courier || !districtId) {
          document.getElementById('shipping-package').innerHTML = '<option 
value="">Pilih Paket</option>';
          return;
      }
  
      const cityId = document.getElementById('city').value;
  
      fetch('{{ route("rajaongkir.cost") }}', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': 
document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
              origin: 12, // Jakarta (default origin) - adjust based on your 
apotek location
              destination: districtId,
              weight: weight,
              courier: courier
          })
      })
      .then(response => response.json())
      .then(data => {
          const packageSelect = document.getElementById('shipping-package');
          let html = '<option value="">Pilih Paket</option>';
  
          // Handle different possible response structures
          let costs = [];
          if (data && Array.isArray(data)) {
              // Direct array response (current API structure)
              costs = data;
          } else if (data.results && data.results.costs) {
              // Standard RajaOngkir structure
              data.results.costs.forEach(cost => {
                  if (cost.costs) {
                      costs = costs.concat(cost.costs);
                  }
              });
          } else if (data.costs && Array.isArray(data.costs)) {
              // Alternative structure
              costs = data.costs;
          }
  
          costs.forEach(service => {
              if (service.cost && service.service) {
                  const value = `${service.service}|${service.cost}`;
                  const etd = service.etd || 'N/A';
                  const description = service.description || service.service;
                  html += `<option value="${value}">${description} - Rp 
${service.cost.toLocaleString('id-ID')} (${etd})</option>`;
              }
          });
  
          if (costs.length === 0) {
              html = '<option value="">Tidak ada paket tersedia</option>';
          }
  
          packageSelect.innerHTML = html;
          calculateTotal();
      })
      .catch(error => {
          console.error('Error calculating shipping:', error);
          document.getElementById('shipping-package').innerHTML = '<option 
value="">Error - coba lagi</option>';
      });
  }
  
  function calculateTotal() {
      const subtotal = {{ $subtotal }};
      const shippingPackage = 
document.getElementById('shipping-package').value;
      let ongkir = 0;
  
      if (shippingPackage) {
          const [service, cost] = shippingPackage.split('|');
          ongkir = parseInt(cost);
      }
  
      const biayaApp = subtotal * 0.1;
      const total = subtotal + ongkir + biayaApp;
  
      document.getElementById('ongkir-value').value = ongkir;
      document.getElementById('ongkirDisplay').textContent = 'Rp ' + 
ongkir.toLocaleString('id-ID');
      document.getElementById('biayaAppDisplay').textContent = 'Rp ' + 
biayaApp.toLocaleString('id-ID');
      document.getElementById('totalDisplay').textContent = 'Rp ' + 
total.toLocaleString('id-ID');
  }
  
  document.addEventListener('DOMContentLoaded', function() {
      const checkoutBtn = document.getElementById('checkout-btn');
      const shippingAddress = document.getElementById('shipping-address');
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
  
      // Update button style and warning text when required fields are 
incomplete
      function checkForm() {
          const prescriptionOk = !requiresPrescription || (resepInput && 
resepInput.files.length > 0);
          const allFilled = shippingAddress.value && shipping.value && 
shippingPackage.value && payment.value && prescriptionOk;
          const warningEl = document.getElementById('checkout-warning');
  
          if (!allFilled) {
              let message = 'Lengkapi semua data pengiriman dan pembayaran.';
              if (!shippingAddress.value) {
                  message = 'Pilih alamat pengiriman terlebih dahulu.';
              } else if (!shipping.value) {
                  message = 'Pilih kurir pengiriman terlebih dahulu.';
              } else if (!shippingPackage.value) {
                  message = 'Pilih paket pengiriman terlebih dahulu.';
              } else if (!payment.value) {
                  message = 'Pilih metode pembayaran terlebih dahulu.';
              } else if (requiresPrescription && (!resepInput || 
resepInput.files.length === 0)) {
                  message = 'Unggah resep obat keras sebelum melanjutkan 
pesanan.';
              }
              warningEl.textContent = message;
              warningEl.style.display = 'block';
          } else {
              warningEl.style.display = 'none';
          }
  
          setCheckoutButtonState(allFilled);
      }
  
      shippingAddress.addEventListener('change', checkForm);
      shipping.addEventListener('change', checkForm);
      shippingPackage.addEventListener('change', checkForm);
      payment.addEventListener('change', checkForm);
      if (resepInput) {
          resepInput.addEventListener('change', checkForm);
      }
  
      // Auto-select first address if user has addresses
      if (userAddresses && userAddresses.length > 0) {
          shippingAddress.value = '0'; // Select first address (index 0)
          updateAddressFields(); // This will populate province and city
      }
  
      checkForm();
  });
  
  function createOrder(event) {
      event.preventDefault();
  
      // Validate required fields
      const shippingAddress = 
document.getElementById('shipping-address').value;
      const shipping = document.getElementById('shipping').value;
      const shippingPackage = 
document.getElementById('shipping-package').value;
      const payment = document.getElementById('payment').value;
  
      if (!shippingAddress || !shipping || !shippingPackage || !payment) {
          Swal.fire('Error', 'Silakan lengkapi semua data pengiriman', 
'error');
          return;
      }
  
      const resepFile = 
document.querySelector('input[name="url_resep"]').files[0];
      if (requiresPrescription && !resepFile) {
          Swal.fire('Error', 'Mohon unggah resep obat keras sebelum 
melanjutkan pesanan.', 'error');
          return;
      }
  
      const formData = new FormData();
      formData.append('shipping_address', shippingAddress);
      formData.append('courier', shipping);
      formData.append('shipping_package', shippingPackage);
      formData.append('id_metode_bayar', payment);
      formData.append('catatan', 
document.querySelector('textarea[name="notes"]').value);
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
              'X-CSRF-TOKEN': 
document.querySelector('meta[name="csrf-token"]').content
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
  
  <style>
      /* Select Wrapper Styling */
      .select-wrapper {
          position: relative;
      }
  
      .select-wrapper select {
          appearance: none;
          -webkit-appearance: none;
          -moz-appearance: none;
          background: white;
          cursor: pointer;
          padding-right: 15px;
      }
  
      .select-wrapper select:focus {
          border-color: #007bff;
          box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
      }
  
      /* Mobile Responsiveness */
      @media (max-width: 768px) {
          .select-icon {
              right: 10px;
          }
      }
  </style>
  
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
      </body>
  
  </html>
  @yield('footer')
  @endsection


